<?php

namespace App\Http\Controllers;

use App\Account;
use App\Group;
use App\ProxyListItem;
use App\User;
use App\Category;

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
        $categories = Category::orderBy('name', 'asc')->get();
        foreach ($categories as $category) {
            $count = Account::where('category_id', $category->id)->count();
            if ($count) {
                $list['summary'][]= [
                    'count' => $count,
                    'text' => $category->name
                ];
            }
        }
        $list['total'] = Account::count();
        return $list;
    }

    private function groupSummary()
    {
        $list = [ 'total' => 0, 'summary' => []];
        $groups = Group::orderBy('name', 'asc')->get();
        foreach ($groups as $group) {
            $count = Account::where('group_id', $group->id)->count();
            $list['summary'][]= [
                'count' => $count,
                'text' => $group->name
            ];
        }
        $list['total'] = Group::count();
        return $list;
    }

    private function categorySummary()
    {
        $list = [ 'total' => 0, 'summary' => []];
        $categories = Category::get();
        foreach ($categories as $category) {
            $count = Account::where('category_id', $category->id)->count();
            $list['summary'][]= [
                'count' => $count,
                'text' => $category->name
            ];
        }
        $list['total'] = Category::count();
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
                    'text' => $level['text']
                ];
            }
        }
        $list['total'] = User::count();
        return $list;
    }
}
