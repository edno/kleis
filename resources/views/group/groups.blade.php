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
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/groups') }}">
                {{ csrf_field() }}
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" class="form-control" name="name" id="groupname" placeholder="Nom de la d&eacute;l&eacute;gation">
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
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <input type="hidden" name="id" id="groupid" value="">
            </form>
        </div>
    </div>

    <!-- Current Groups -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                D&eacute;l&eacute;gations
            </div>
        </div>

        <div class="panel-body">
            @if (count($groups) > 0)
                <table class="table table table-hover groups-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>D&eacute;l&eacute;gation</th>
                        <th>Comptes utilisateurs</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($groups as $group)
                            <tr>
                                <td class="table-text">
                                    <div id="group{{ $group->id }}">{{ $group->name }}</div>
                                </td>
                                <td class="table-text">
                                    <div><span class="badge">{{ $group->countAccounts() }}</span></div>
                                </td>
                                <td class="align-right col-xs-2">
                                    <div class="btn-toolbar">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-default edit-link" id="edit{{ $group->id }}"><i class="fa fa-pencil"></i></a>
                                            <a href="/group/{{ $group->id }}/accounts" class="btn btn-default"><i class="fa fa-list-alt"></i></a>
                                            @if ($group->countAccounts() > 0)
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-trash"></i></a>
                                            @else
                                                <a href="/group/{{ $group->id }}/delete" class="btn btn-default"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                Aucune d&eacute;l&eacute;gation.
            @endif
        </div>
    </div>

    <div class="text-center">
        {{ $groups->links() }}
    </div>

    <script type="text/javascript" language="javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            $('.edit-link').click(function () {
                var groupid = $(this).attr('id').substr(4);
                var groupname = document.getElementById( 'group' + groupid ).innerText;
                $('#groupid').val(groupid);
                $('#groupname').val(groupname);
                $('#button-cancel').removeClass('hidden');
                $('#button-save').removeClass('hidden');
                $('#button-add').addClass('hidden');
                $("#groupname").focus();
            });
            $('#button-cancel').click(function () {
                $('#groupid').val('');
                $('#groupname').val('');
                $('#button-cancel').addClass('hidden');
                $('#button-save').addClass('hidden');
                $('#button-add').removeClass('hidden');
            });
        });
    </script>

@endsection
