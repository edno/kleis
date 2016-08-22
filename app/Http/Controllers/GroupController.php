<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Group;

class GroupController extends Controller
{
    use searchTrait;

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

        $results = $this->search($groups, $request->input('type'), $request->input('search'));

        if (false === is_null($results)) {
            $request->session()->flash('results', "{$results} résultats trouvés");
            $request->session()->flash('search', $request->input('search'));
            $request->session()->flash('type', $request->input('type'));
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
