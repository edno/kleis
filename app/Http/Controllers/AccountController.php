<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Account;
use App\Group;
use Auth;

class AccountController extends Controller
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

    /**
     * List existing accounts
     *
     * @return Response
     */
    public function showAccounts()
    {
        if (Auth::user()->level == 1) {
            return redirect()->action('GroupController@showAccounts', [Auth::user()->group_id]);
        } else {
            $accounts = Account::orderBy('netlogin', 'asc')->get();
            return view('account/accounts', ['accounts' => $accounts]);
        }
    }

    /**
     * Edit the given account.
     *
     * @param  int  $id
     * @return Response
     */
    public function editAccount($id)
    {
        $account = Account::findOrFail($id);
        $groups = Group::orderBy('name', 'asc')->get();
        return view('account/account',
            ['account' => $account, 'groups' => $groups]
        );
    }

    /**
     * Open a new account.
     *
     * @return Response
     */
    public function newAccount()
    {
        $groups = Group::orderBy('name', 'asc')->get();
        return view('account/account',
            ['account' => new Account, 'groups' => $groups]
        );
    }

    /**
     * Add a new account.
     *
     * @return Response
     */
    public function addAccount(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|alpha_num|min:3|max:100',
            'lastname' => 'required|alpha_num|min:3|max:100',
            'netlogin' => 'required|unique:accounts,netlogin',
            'netpass' => 'required|min:8|different:netlogin',
            'expirydate' => 'required_if:status,1|date|after:today',
            'category' => 'required',
            'status' => 'required|boolean',
            'group' => 'required|exists:groups,id'
        ]);

        $account = new Account;
        $account->netlogin = $request->netlogin;
        $account->netpass = Account::generateHash($request->netpass);
        $account->firstname = ucwords($request->firstname);
        $account->lastname = ucwords($request->lastname);
        $account->category = $request->category;
        if (empty($account->expire)) {
            $account->expire = date_create('+90 day')->format('Y-m-d');
        }
        $account->status = $request->status;
        $account->group_id = $request->group;
        $account->created_by = $request->user()->id;
        $account->save();
        return redirect('accounts')->with('status', "Compte '{$account->netlogin}' ajouté avec succès.");
    }

    /**
     * Update an account.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updateAccount(Request $request, $id)
    {
        $this->validate($request, [
            'firstname' => 'required|alpha_num|min:3|max:100',
            'lastname' => 'required|alpha_num|min:3|max:100',
            'netlogin' => 'required|unique:accounts,netlogin',
            'expirydate' => 'required_if:status,1|date|after:today',
            'category' => 'required',
            'status' => 'required|boolean',
            'group' => 'required|exists:groups,id'
        ]);

        $account = Account::findOrFail($id);
        $account->netlogin = $request->netlogin;
        if (false === empty($request->netpass)) {
            $account->netpass = Account::generateHash($request->netpass);
        }
        $account->firstname = $request->firstname;
        $account->lastname = $request->lastname;
        $account->category = $request->category;
        if (false === empty($request->expirydate)) {
            $account->expire = $request->expirydate;
        }
        $account->status = $request->status;
        $account->group_id = $request->group;
        $account->update();
        return redirect('accounts')->with('status', "Compte '{$account->netlogin}' mis à jour avec succès.");
    }

    /**
     * Enable an account.
     *
     * @param  int  $id
     * @return Response
     */
    public function enableAccount($id)
    {
        $account = Account::findOrFail($id);
        $account->status = 1;
        if (empty($account->expire) || $account->expire <= date('Y-m-d')) {
            $account->expire = date_create('+90 day')->format('Y-m-d');
        }
        $account->update();
        return redirect('accounts')->with('status', "Compte '{$account->netlogin}' est maintenant actif et expirera le {$account->expire}.");
    }

    /**
     * Disable an account.
     *
     * @param  int  $id
     * @return Response
     */
    public function disableAccount($id)
    {
        $account = Account::findOrFail($id);
        $account->status = 0;
        $account->update();
        return redirect('accounts')->with('status', "Compte '{$account->netlogin}' a été désactivé.");
    }

    /**
     * Remove an account.
     *
     * @param  int  $id
     * @return Response
     */
    public function removeAccount($id)
    {
        $account = Account::findOrFail($id);
        $netlogin = $account->netlogin;
        $account->delete();
        return redirect('accounts')->with('status', "Compte '{$netlogin}' a été supprimé.");
    }
}
