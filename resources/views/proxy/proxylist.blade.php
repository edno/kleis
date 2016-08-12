@extends('layouts.app')

@section('content')

@if (session('status'))
    <div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session('status') }}
    </div>
    <script type="text/javascript" language="javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            $(".alert-dismissable").fadeTo(2000, 500).slideUp(500, function(){
                $(".alert-dismissable").alert('close');
            });
        });
    </script>
@endif

    <!-- Add/Edit Group -->
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="/whitelist/{{ $type }}">
                {{ csrf_field() }}
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" class="form-control" name="value"
                            id="itemname"
                            placeholder="{{ ($type == 'url') ? 'http://serveur/url/precise/et/complete' : 'domaine.ext ou sousdomaine.domaine.ext' }}">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default hidden" type="button" id="button-save">
                                <i class="fa fa-save"></i> Enregister
                            </button>
                            <a href="#" class="btn btn-default hidden" type="button" id="button-cancel">
                                <i class="fa fa-undo"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-default" type="button" id="button-add">
                                <i class="fa fa-plus"></i> Ajouter
                            </button>
                        </span>
                    </div>
                    @if ($errors->has('value'))
                        <span class="help-block">
                            <strong>{{ $errors->first('value') }}</strong>
                        </span>
                    @endif
                </div>
                <input type="hidden" name="id" id="itemid" value="">
            </form>
        </div>
    </div>

    <!-- Current Groups -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                {{ ucfirst($type) }}s en Liste Blanche
            </div>
        </div>

        <div class="panel-body">
            @if (count($items) > 0)
                <table class="table table table-hover items-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>{{ ucfirst($type) }}</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td class="table-text">
                                    <div id="item{{ $item->id }}">{{ $item->value }}</div>
                                </td>
                                <td class="align-right col-xs-2">
                                    <div class="btn-toolbar">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-default edit-link" id="edit{{ $item->id }}"><i class="fa fa-pencil"></i></a>
                                            <a href="/whitelist/{{ $type }}/{{ $item->id }}/delete" class="btn btn-default"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                Aucun {{ $type }}.
            @endif
        </div>
    </div>

    <div class="text-center">
        {{ $items->links() }}
    </div>

    <script type="text/javascript" language="javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            $('.edit-link').click(function () {
                var itemid = $(this).attr('id').substr(4);
                var itemname = document.getElementById( 'item' + itemid ).innerText;
                $('#itemid').val(itemid);
                $('#itemname').val(itemname);
                $('#button-cancel').removeClass('hidden');
                $('#button-save').removeClass('hidden');
                $('#button-add').addClass('hidden');
                $("#itemname").focus();
            });
            $('#button-cancel').click(function () {
                $('#itemid').val('');
                $('#itemname').val('');
                $('#button-cancel').addClass('hidden');
                $('#button-save').addClass('hidden');
                $('#button-add').removeClass('hidden');
            });
        });
    </script>

@endsection
