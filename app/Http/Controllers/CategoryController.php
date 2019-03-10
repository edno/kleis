<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Account;

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
            $request->session()->flash(
                'results',
                trans_choice(
                    'categories.message.search',
                    $results,
                    ['number' => $results]
                )
            );
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
            $category->name = mb_convert_case($request->name, MB_CASE_TITLE, 'UTF-8');
            $category->icon = $request->icon;
            $category->validity = $request->validity;
            $category->created_by = $request->user()->id;
            $category->save();
            return redirect()->back()->with(
                'status',
                trans('categories.message.add', ['category' => $category->name])
            );
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
        $category->name = mb_convert_case($request->name, MB_CASE_TITLE, 'UTF-8');
        $category->icon = $request->icon;
        $category->validity = $request->validity;
        $category->update();
        return redirect()->back()->with(
            'status',
            trans('categories.message.update', ['category' => $category->name])
        );
    }

    public function removeCategory($id)
    {
        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->delete();
        return redirect()->back()->with(
            'status',
            trans('categories.message.delete', ['category' => $name])
        );
    }

    public function purgeAccounts($id)
    {
        $category = Category::findOrFail($id);
        $accounts = $category->accounts()->where('status', Account::ACCOUNT_DISABLE);
        if (count($accounts) > 0 ) {
            $accounts->delete();
        }
        return redirect()->back()->with(
            'status',
            trans('categories.message.drop', ['category' => $category->name])
        );
    }

    public function disableAccounts($id)
    {
        $category = Category::findOrFail($id);
        $accounts = $category->accounts()->where('status', Account::ACCOUNT_ENABLE)->get();
        foreach ($accounts as $account) {
            $account->disable();
        }
        return redirect()->back()->with(
            'status',
            trans('categories.message.disable', ['category' => $category->name])
        );
    }
}
