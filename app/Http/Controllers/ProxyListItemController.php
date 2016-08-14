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

    protected function showList(Request $request, $type)
    {
        $items = ProxyListItem::where('type', $type)->orderBy('value', 'asc');
        $search = '%';
        $crit = 'value';

        if (isset(ProxyListItem::SEARCH_CRITERIA[$crit]) && !empty($request->input('search'))) {
            $search = str_replace('*', '%', $request->input('search'));
            $criterion = explode(' ', $search);
            $columns = ProxyListItem::SEARCH_CRITERIA[$crit];

            foreach ($columns as $idx => $column) {
                if (is_array($column)) {
                    $relation = $column;
                    foreach($relation as $table => $column)
                    $items = $items->whereHas($table, function($query) use ($column, $criterion) {
                        foreach($criterion as $value) {
                            $query->orWhere($column, 'LIKE', $value);
                        }
                    });
                } else {
                    $items = $items->where(function($query) use ($column, $criterion) {
                        foreach($criterion as $value) {
                            $query->orWhere($column, 'LIKE', $value);
                        }
                    });
                }
            }

            $results = count($items->get());
            $request->session()->flash('results', "{$results} résultats trouvés");
            $request->session()->flash('search', $request->input('search'));
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

    public function clearList($type)
    {
        $items = ProxyListItem::where('type', $type);
        $items->delete();
        return redirect("whitelist/{$type}s")->with('status', ucfirst("Liste '{$type}' a été vidée."));
    }
}
