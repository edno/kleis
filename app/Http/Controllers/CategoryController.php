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
        $this->validate($request, [
            'name' => 'required|max:100|unique:groups,name',
        ]);

        if (false === empty($request->id)) {
            return $this->updateCategory($request, $request->id);
        } else {
            $category = new Category;
            $category->name = $request->name;
            $category->created_by = $request->user()->id;
            $category->save();
            return redirect('categories')->with('status', "Catégorie '{$category->name}' ajoutée avec succès.");
        }
    }

    public function updateCategory(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:100|unique:groups,name',
        ]);

        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->name = $request->name;
        $category->update();
        return redirect()->back()->with('status', "Catégorie '{$name}' renommée en '{$category->name}'.");
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
        // $category = Category::findOrFail($id);
        $accounts = $category->accounts()->where('status', 0);
        if (count($accounts) > 0 ) {
            $accounts->delete();
        }
        return redirect()->back()->with('status', "Délégation '{$category->name}': comptes inactifs supprimés.");
    }

    public function disableAccounts($id)
    {
        // $category = Category::findOrFail($id);
        $accounts = $category->accounts()->where('status', 1)->get();
        foreach ($accounts as $account) {
            $account->disable();
        }
        return redirect()->back()->with('status', "Délégation '{$category->name}': comptes désactivés.");
    }
}
