<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Group;
use Auth;

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

    public function showUsers(Request $request)
    {
        $users = User::orderBy('firstname', 'asc')->orderBy('lastname', 'asc');
        $search = '%';
        $crit = $request->input('type');

        if (array_key_exists($crit, User::SEARCH_CRITERIA) && !empty($request->input('search'))) {
            $search = str_replace('*', '%', $request->input('search'));
            $criterion = explode(' ', $search);
            $columns = User::SEARCH_CRITERIA[$crit];

            $users = $users->where( function($q) use ($columns, $criteria) {
                foreach ($columns as $column) {
                    if (is_array($column)) {
                        $relation = $column;
                        foreach($relation as $table => $column) {
                            $q->whereHas($table,
                                function($query) use ($column, $criteria) {
                                    foreach($criteria as $value) {
                                        $query->orWhere($column, 'LIKE', $value);
                                    }
                                }
                            );
                        }
                    } else {
                        $q->orWhere(
                            function($query) use ($column, $criteria) {
                                foreach($criteria as $value) {
                                    $query->orWhere($column, 'LIKE', $value);
                                }
                            }
                        );
                    }
                }
            });

            $results = count($users->get());
            $request->session()->flash('results', "{$results} résultats trouvés");
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
        return redirect('administrators')->with('status', "'{$user->email}' ajouté avec succès.");
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
        if (false === empty($request->status)) {
            $user->status = $request->status;
        }
        if (false === empty($request->group)) {
            $user->group_id = $request->group;
        }

        $user->update();

        if ($request->is('profile')) {
            $redirect = 'profile';
        } else {
            $redirect = 'administrators';
        }

        return redirect($redirect)->with('status', "'{$user->email}' mis à jour avec succès.");
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
        return redirect()->back()->with('status', "'{$user->email}' est maintenant actif.");
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
        return redirect()->back()->with('status', "'{$user->email}' a été désactivé.");
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
        return redirect()->back()->with('status', "'{$email}' a été supprimé.");
    }
}
