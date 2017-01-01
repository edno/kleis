<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Group;
use Auth;

class AdminController extends Controller
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

    public function showUsers(Request $request)
    {
        $users = User::orderBy('firstname', 'asc')->orderBy('lastname', 'asc');

        $results = $this->search($users, $request->input('type'), $request->input('search'));

        if (false === is_null($results)) {
            $request->session()->flash(
                'results',
                trans_choice(
                    'users.message.search',
                    $results,
                    ['number' => $results]
                )
            );
            $request->session()->flash('search', $request->input('search'));
            $request->session()->flash('type', $request->input('type'));
        }

        return view('user/users', ['users' => $users->paginate(20)]);
    }

    /**
     * Edit the given user
     *
     * @param  int  $id
     * @return Response
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $groups = Group::orderBy('name', 'asc')->get();
        return view('user/user',
            ['user' => $user, 'groups' => $groups]
        );
    }

    /**
     * Open a new user form.
     *
     * @return Response
     */
    public function newUser()
    {
        $groups = Group::orderBy('name', 'asc')->get();
        return view('user/user',
            ['user' => new User, 'groups' => $groups]
        );
    }

    /**
     * Add a new user.
     *
     * @return Response
     */
    public function addUser(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|alpha_num|max:100',
            'lastname' => 'required|alpha_num|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|alpha_dash|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'level' => 'required',
            'status' => 'required|boolean',
            'group' => 'required_if:level,1'
        ]);

        $user = new User;
        $user->email = strtolower($request->email);
        $user->password = bcrypt($request->password);
        $user->firstname = ucwords($request->firstname);
        $user->lastname = ucwords($request->lastname);
        $user->level = $request->level;
        $user->status = $request->status;
        if (false === empty($request->group)) {
            $user->group_id = $request->group;
        }
        $user->created_by = $request->user()->id;
        $user->save();
        return redirect('administrators')->with(
            'status',
            trans('users.message.add', ['user' => $user->email])
        );
    }

    /**
     * Update an user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updateUser(Request $request, $id = 0)
    {
        $this->validate($request, [
            'password' => 'alpha_dash|min:8|confirmed',
            'password_confirmation' => 'required_with:password|min:8',
            'status' => 'boolean',
            'group' => 'exists:groups,id'
        ]);

        if ($request->is('profile')) {
            $id = Auth::user()->id;
        }

        $user = User::findOrFail($id);
        $update = false;

        if (false === empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        if (false === empty($request->level)) {
            $user->level = $request->level;
        }
        if (false === empty($request->group)) {
            $user->group_id = $request->group;
        }

        // if not admin local then no group
        if ($user->level !== 1) {
            $user->group_id = 0;
        }

        if ($request->has('status')) {
            $user->status = $request->status;
        }

        $user->update();

        if ($request->is('profile')) {
            $redirect = 'profile';
        } else {
            $redirect = 'administrators';
        }

        return redirect($redirect)->with(
            'status',
            trans('users.message.update', ['user' => $user->email])
        );
    }

    /**
     * Enable an user.
     *
     * @param  int  $id
     * @return Response
     */
    public function enableUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 1;
        $user->update();
        return redirect()->back()->with(
            'status',
            trans('users.message.enable', ['user' => $user->email])
        );
    }

    /**
     * Disable an user.
     *
     * @param  int  $id
     * @return Response
     */
    public function disableUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 0;
        $user->update();
        return redirect()->back()->with(
            'status',
            trans('users.message.disable', ['user' => $user->email])
        );
    }

    /**
     * Remove an user.
     *
     * @param  int  $id
     * @return Response
     */
    public function removeUser($id)
    {
        $user = User::findOrFail($id);
        $email = $user->email;
        $user->delete();
        return redirect()->back()->with(
            'status',
            trans('users.message.delete', ['user' => $email])
        );
    }
}
