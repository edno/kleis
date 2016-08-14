<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Group;

class GroupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showGroups(Request $request)
    {
        $groups = Group::orderBy('name', 'asc');
        $search = '%';
        $type = $request->input('type');

        if (isset(Group::SEARCH_CRITERIA[$type]) && !empty($request->input('search'))) {
            $search = str_replace('*', '%', $request->input('search'));
            $criteria = explode(' ', $search);
            $columns = Group::SEARCH_CRITERIA[$type];

            foreach ($columns as $idx => $column) {
                if (is_array($column)) {
                    $relation = $column;
                    foreach($relation as $table => $column)
                    $groups = $groups->whereHas($table, function($query) use ($column, $criteria) {
                        foreach($criteria as $value) {
                            $query->orWhere($column, 'LIKE', $value);
                        }
                    });
                } else {
                    foreach($criteria as $value) {
                        $groups = $groups->orWhere($column, 'LIKE', $value);
                    }
                }
            }

            $results = count($groups->get());
            $request->session()->flash('results', "{$results} résultats trouvés");
            $request->session()->flash('search', $request->input('search'));
        }

        return view('group/groups', ['groups' => $groups->paginate(20)]);
    }

    public function addGroup(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100|unique:groups,name',
        ]);

        if (false === empty($request->id)) {
            return $this->updateGroup($request, $request->id);
        } else {
            $group = new Group;
            $group->name = $request->name;
            $group->created_by = $request->user()->id;
            $group->save();
            return redirect('groups')->with('status', "Délégation '{$group->name}' ajoutée avec succès.");
        }
    }

    public function updateGroup(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:100|unique:groups,name',
        ]);

        $group = Group::findOrFail($id);
        $name = $group->name;
        $group->name = $request->name;
        $group->update();
        return redirect()->back()->with('status', "Délégation '{$name}' renommée en '{$group->name}'.");
    }

    public function removeGroup($id)
    {
        $group = Group::findOrFail($id);
        $name = $group->name;
        $group->delete();
        return redirect()->back()->with('status', "Délégation '{$name}' a été supprimée.");
    }

    public function showAccounts($id, $category = null)
    {
        $group = Group::findOrFail($id);
        if (false === empty($category)) {
            $accounts = Group::find($id)->accounts()->where('category', $category)->paginate(20);
        } else {
            $accounts = Group::find($id)->accounts()->paginate(20);
        }
        return view('account/accounts', ['accounts' => $accounts, 'group' => $group]);
    }

    public function purgeAccounts($id)
    {
        $group = Group::findOrFail($id);
        $accounts = Group::Find($id)->accounts()->where('status', 0);
        if (count($accounts) > 0 ) {
            $accounts->delete();
        }
        return redirect()->back()->with('status', "Délégation '{$group->name}': comptes inactifs supprimés.");
    }

    public function disableAccounts($id)
    {
        $group = Group::findOrFail($id);
        $accounts = Group::Find($id)->accounts()->where('status', 1)->get();
        foreach ($accounts as $account) {
            $account->disable();
        }
        return redirect()->back()->with('status', "Délégation '{$group->name}': comptes désactivés.");
    }
}
