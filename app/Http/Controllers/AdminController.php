<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Group;

class AdminController extends Controller
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

    public function showUsers()
    {
        $users = User::orderBy('firstname', 'asc')->orderBy('lastname', 'asc')->get();
        return view('user/users', ['users' => $users]);
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
        return redirect('administrators')->with('status', "'{$user->email}' ajouté avec succès.");
    }

    /**
     * Update an user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updateUser(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'present|alpha_dash|min:8|confirmed',
            'password_confirmation' => 'required_with:password|min:8',
            'level' => 'required',
            'status' => 'required|boolean',
            'group' => 'required_if:level,1'
        ]);

        $user = User::findOrFail($id);
        if (false === empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->level = $request->level;
        if (false === empty($request->group)) {
            $user->group_id = $request->group;
        }
        $user->status = $request->status;
        $user->group_id = $request->group;
        $user->update();
        return redirect('administrators')->with('status', "'{$user->email}' mis à jour avec succès.");
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
        return redirect('administrators')->with('status', "'{$user->email}' est maintenant actif.");
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
        return redirect('administrators')->with('status', "'{$user->email}' a été désactivé.");
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
        return redirect('administrators')->with('status', "'{$email}' a été supprimé.");
    }
}
