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

    public function showGroups()
    {
        $groups = Group::orderBy('name', 'asc')->get();
        return view('group/groups', ['groups' => $groups]);
    }

    public function addGroup(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
        ]);

        if (false === empty($request->id)) {
            return $this->updateGroup($request, $request->id);
        } else {
            $group = new Group;
            $group->name = $request->name;
            $group->created_by = $request->user()->id;
            $group->save();
            return redirect('groups')->with('status', "Groupe '{$group->name}' ajouté avec succès.");
        }
    }

    public function updateGroup(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
        ]);

        $group = Group::findOrFail($id);
        $name = $group->name;
        $group->name = $request->name;
        $group->update();
        return redirect('groups')->with('status', "Groupe '{$name}' renommé en '{$group->name}'.");
    }

    public function removeGroup($id)
    {
        $group = Group::findOrFail($id);
        $name = $group->name;
        $group->delete();
        return redirect('groups')->with('status', "Groupe '{$name}' a été supprimé.");
    }

    public function showAccounts($id)
    {
        $group = Group::findOrFail($id);
        return view('account/accounts', ['accounts' => Group::Find($id)->accounts, 'group' => $group]);
    }
}
