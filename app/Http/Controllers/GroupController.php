<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Account;

class GroupController extends Controller
{
    use SearchTrait;

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
            $request->session()->flash(
                'results',
                trans_choice(
                    'groups.message.search',
                    $results,
                    ['number' => $results]
                )
            );
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
            return redirect()->back()->with(
                'status',
                trans('groups.message.add', ['group' => $group->name])
            );
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
        return redirect()->back()->with(
            'status',
            trans(
                'groups.message.update',
                [
                    'old'   => $name,
                    'group' => $group->name,
                ]
            )
        );
    }

    public function removeGroup($id)
    {
        $group = Group::findOrFail($id);
        $name = $group->name;
        $group->delete();
        return redirect()->back()->with(
            'status',
            trans('groups.message.delete', ['group' => $name])
        );
    }

    public function purgeAccounts($id)
    {
        $group = Group::findOrFail($id);
        $accounts = Group::Find($id)->accounts()->where('status', Account::ACCOUNT_DISABLE);
        if (count($accounts) > 0 ) {
            $accounts->delete();
        }
        return redirect()->back()->with(
            'status',
            trans('groups.message.drop', ['group' => $group->name])
        );
    }

    public function disableAccounts($id)
    {
        $group = Group::findOrFail($id);
        $accounts = Group::Find($id)->accounts()->where('status', Account::ACCOUNT_ENABLE)->get();
        foreach ($accounts as $account) {
            $account->disable();
        }
        return redirect()->back()->with(
            'status',
            trans('groups.message.disable', ['group' => $group->name])
        );
    }
}
