<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Account;
use App\Group;
use App\ProxyListItem;
use App\User;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home',
            [
                'accounts' => $this->accountSummary(),
                'groups' => $this->groupSummary(),
                'items' => $this->listSummary(),
                'users' => $this->userSummary(),
            ]
        );
    }

    private function accountSummary()
    {
        $list = [ 'total' => 0, 'summary' => []];
        foreach (Account::ACCOUNT_CATEGORY as $id => $category) {
            $count = Account::where('category', $id)->count();
            if ($count) {
                $list['summary'][]= [
                    'count' => $count,
                    'text' => $category['text']
                ];
            }
        }
        $list['total'] = Account::count();
        return $list;
    }

    private function groupSummary()
    {
        $list = [ 'total' => 0, 'summary' => []];
        $groups = Group::get();
        foreach ($groups as $group) {
            $count = Account::where('group_id', $group->id)->count();
            $list['summary'][]= [
                'count' => $count,
                'text' => $group->name
            ];
        }
        $list['total'] = count($groups);
        return $list;
    }

    private function listSummary()
    {
        $list = [ 'total' => 0, 'summary' => [] ];
        $types = [ 'domain', 'url' ];
        foreach ($types as $type) {
            $count = ProxyListItem::where('type', $type)->count();
            if ($count) {
                $list['summary'][]= [
                    'count' => $count,
                    'text' => "{$type}s"
                ];
            }
        }
        $list['total'] = ProxyListItem::count();
        return $list;
    }

    private function userSummary()
    {
        $list = [ 'total' => 0, 'summary' => []];
        foreach (User::USER_LEVEL as $id => $level) {
            $count = User::where('level', $id)->count();
            if ($count) {
                $list['summary'][]= [
                    'count' => $count,
                    'text' => "{$level['text']}s"
                ];
            }
        }
        $list['total'] = User::count();
        return $list;
    }
}
