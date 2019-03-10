<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProxyListItem;

class ProxyListItemController extends Controller
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

    protected function showList(Request $request, $type)
    {
        $items = ProxyListItem::where('type', $type)->orderBy('value', 'asc');

        $results = $this->search($items, 'value', $request->input('search'));

        if (false === is_null($results)) {
            $request->session()->flash(
                'results',
                trans_choice(
                    'proxylist.message.search',
                    $results,
                    ['number' => $results]
                )
            );
            $request->session()->flash('search', $request->input('search'));
            $request->session()->flash('type', $request->input('type'));
        }

        return view("proxy/proxylist", ['items' => $items->paginate(20), 'type' => $type]);
    }

    public function addItem(Request $request, $type)
    {
        $urlRule = ($type == 'url') ? '|url' : '';
        $this->validate($request, [
            'value' => "required|unique:proxylistitems,value{$urlRule}",
        ]);

        if (false === empty($request->id)) {
            return $this->updateItem($request, $type, $request->id);
        } else {
            $item = new ProxyListItem;
            $item->value = $request->value;
            $item->type = $type;
            $item->whitelist = true;
            $item->created_by = $request->user()->id;
            $item->save();
            return redirect()->back()->with(
                'status',
                trans('proxylist.message.add', ['type' => trans_choice("proxylist.{$type}", 1)])
            );
        }
    }

    public function updateItem(Request $request, $type, $id)
    {
        $urlRule = ($type == 'url') ? '|url' : '';
        $this->validate($request, [
            'value' => "required|unique:proxylistitems,value{$urlRule}",
        ]);

        $item = ProxyListItem::findOrFail($id);
        $item->value = $request->value;
        $item->update();
        return redirect()->back()->with(
            'status',
            trans('proxylist.message.update', ['type' => trans_choice("proxylist.{$type}", 1)])
        );
    }

    public function removeItem($type, $id)
    {
        $item = ProxyListItem::findOrFail($id);
        $value = $item->value;
        $item->delete();
        return redirect()->back()->with(
            'status',
            trans(
                'proxylist.message.delete',
                [
                    'type'  => trans_choice("proxylist.{$type}", 1),
                    'value' => $value,
                ]
            )
        );
    }

    public function clearList($type)
    {
        $items = ProxyListItem::where('type', $type);
        $items->delete();
        return redirect()->back()->with(
            'status',
            trans('proxylist.message.drop', ['type' => trans_choice("proxylist.{$type}", 1)])
        );
    }
}
