<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;

class CategoryController extends Controller
{
    use SearchTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showCategories(Request $request)
    {
        $categories = Category::orderBy('name', 'asc');

        $results = $this->search($categories, $request->input('type'), $request->input('search'));

        if (false === is_null($results)) {
            $request->session()->flash('results', "{$results} résultats trouvés");
            $request->session()->flash('search', $request->input('search'));
            $request->session()->flash('type', $request->input('type'));
        }

        return view('category/categories', ['categories' => $categories->paginate(20)]);
    }

    public function addCategory(Request $request)
    {
        if (false === empty($request->id)) {
            return $this->updateCategory($request, $request->id);
        } else {
            $this->validate($request, [
                'name' => 'required|max:100|unique:categories,name',
                'icon' => 'required',
                'validity' => 'required|integer|min:1|max:1000',
            ]);
            $category = new Category;
            $category->name = mb_strtoupper(mb_substr($request->name, 0, 1)).mb_substr($request->name, 1);
            $category->icon = $request->icon;
            $category->validity = $request->validity;
            $category->created_by = $request->user()->id;
            $category->save();
            return redirect('categories')->with('status', "Catégorie '{$category->name}' ajoutée avec succès.");
        }
    }

    public function updateCategory(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'icon' => 'required',
            'validity' => 'required|digits_between:1,1000',
        ]);

        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->name = mb_strtoupper(mb_substr($request->name, 0, 1)).mb_substr($request->name, 1);
        $category->icon = $request->icon;
        $category->validity = $request->validity;
        $category->update();
        return redirect()->back()->with('status', "Catégorie '{$category->name}' mise à jour.");
    }

    public function removeCategory($id)
    {
        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->delete();
        return redirect()->back()->with('status', "Catégorie '{$name}' a été supprimée.");
    }

    public function purgeAccounts($id)
    {
        $category = Category::findOrFail($id);
        $accounts = $category->accounts()->where('status', 0);
        if (count($accounts) > 0 ) {
            $accounts->delete();
        }
        return redirect()->back()->with('status', "Délégation '{$category->name}': comptes inactifs supprimés.");
    }

    public function disableAccounts($id)
    {
        $category = Category::findOrFail($id);
        $accounts = $category->accounts()->where('status', 1)->get();
        foreach ($accounts as $account) {
            $account->disable();
        }
        return redirect()->back()->with('status', "Délégation '{$category->name}': comptes désactivés.");
    }
}
