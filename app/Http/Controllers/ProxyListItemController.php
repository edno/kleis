<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ProxyListItem;

class ProxyListItemController extends Controller
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

    public function showWhiteListDomains()
    {
        return $this->showList('domain');
    }

    public function showWhiteListUrls()
    {
        return $this->showList('url');
    }

    protected function showList($type)
    {
        $items = ProxyListItem::where('type', $type)->orderBy('value', 'asc')->paginate(20);
        return view("proxy/proxylist", ['items' => $items, 'type' => $type]);
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
            return redirect("whitelist/{$type}s")->with('status', ucfirst("{$type} ajouté avec succès."));
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
        return redirect("whitelist/{$type}s")->with('status', ucfirst("{$type} mis à jour avec succès."));
    }

    public function removeItem($type, $id)
    {
        $item = ProxyListItem::findOrFail($id);
        $value = $item->value;
        $item->delete();
        return redirect("whitelist/{$type}s")->with('status', ucfirst("{$type} '{$value}' a été supprimé."));
    }
}
