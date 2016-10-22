<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator as Url;

use App\Http\Requests;
use App\Account;
use App\Group;
use App\Category;
use Auth;

class AccountController extends Controller
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

    /**
     * List existing accounts
     *
     * @return Response
     */
    public function showAccounts(Request $request, $group_id = null, $category_id = null)
    {
        $accounts = Account::orderBy('netlogin', 'asc');
        $group = null;

        // because request routing is not smart
        if ($request->is('accounts/category/*')) {
            $category_id = $group_id;
            $group_id = null;
        }

        // case when admin can only manager its own group§
        if (Auth::user()->level == 1) {
            $group_id = Auth::user()->group->id;
        }

        // if a group filter is set
        if (false === is_null($group_id)) {
            $group = Group::find($group_id);
            $accounts = $accounts->where('group_id', $group_id);
        }

        // if a category filter is set
        if (false === is_null($category_id)) {
            $accounts = $accounts->where('category_id', $category_id);
        }

        $results = $this->search($accounts, $request->input('type'), $request->input('search'));

        // store search criteria
        if (false === is_null($results)) {
            $request->session()->flash(
                'results',
                trans_choice(
                    'accounts.message.search',
                    $results,
                    ['number' => $results]
                )
            );
            $request->session()->flash('search', $request->input('search'));
            $request->session()->flash('type', $request->input('type'));
        }

        return view('account/accounts',
            [
                'accounts' => $accounts->paginate(20),
                'group' => $group,
                'categories' => Category::orderBy('name', 'asc')->get()
            ]
        );
    }

    /**
     * Edit the given account.
     *
     * @param  int  $id
     * @return Response
     */
    public function editAccount($id = null)
    {
        // if no ID then new account
        if (empty($id)) {
            $account = new Account;
        } else {
            $account = Account::findOrFail($id);
        }
        return view('account/account',
            [
                'account' => $account,
                'groups' => Group::orderBy('name', 'asc')->get(),
                'categories' => Category::orderBy('name', 'asc')->get()
            ]
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
            'firstname' => 'required|alpha_num|max:100',
            'lastname' => 'required|alpha_num|max:100',
            'netlogin' => 'required|unique:accounts,netlogin',
            'netpass' => 'required|min:8|different:netlogin',
            'expirydate' => 'required_if:status,1|date|after:today',
            'category' => 'required|exists:categories,id',
            'status' => 'required|boolean',
            'group' => 'required|exists:groups,id'
        ]);

        $account = new Account;
        $account->netlogin = $request->netlogin;
        $account->netpass = Account::generateHash($request->netpass);
        $account->firstname = ucwords($request->firstname);
        $account->lastname = ucwords($request->lastname);
        $account->category_id = $request->category;
        if (empty($account->expire)) {
            $account->expire = date_create('+90 day')->format('Y-m-d');
        }
        $account->status = $request->status;
        $account->group_id = $request->group;
        $account->created_by = $request->user()->id;
        $account->save();
        return redirect('accounts')->with(
            'status',
            trans('accounts.message.add', ['account' => $account->netlogin])
        );
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
            'netlogin' => 'required|exists:accounts,netlogin',
            'expirydate' => 'required_if:status,1|date|after:today',
            'category' => 'required|exists:categories,id',
            'status' => 'required|boolean',
            'group' => 'required|exists:groups,id'
        ]);

        $account = Account::findOrFail($id);
        if (false === empty($request->netpass)) {
            $account->netpass = Account::generateHash($request->netpass);
        }
        if (false === empty($request->expirydate)) {
            $account->expire = $request->expirydate;
        }
        $account->category_id = $request->category;
        $account->status = $request->status;
        $account->group_id = $request->group;
        $account->update();
        return redirect('accounts')->with(
            'status',
            trans('accounts.message.update', ['account' => $account->netlogin])
        );
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
        $account->enable();
        return redirect()->back()->with(
            'status',
            trans(
                'accounts.message.enable',
                [
                    'account' => $account->netlogin,
                    'date'    => $account->expire
                ]
            )
        );
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
        $account->disable();
        return redirect()->back()->with(
            'status',
            trans('accounts.message.disable', ['account' => $account->netlogin])
        );
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
        return redirect()->back()->with(
            'status',
            trans('accounts.message.delete', ['account' => $netlogin])
        );
    }
}
