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

    <!-- Current Users -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title pull-left">
                Administrateurs
            </div>
            <div class="panel-title pull-right">
                <a href="{{ url('/user') }}" class="btn btn-default" style="float: right;">
                    <i class="fa fa-plus"></i> Ajouter un administrateur
                </a>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            @if (count($users) > 0)
                <table class="table table table-hover admin-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Nom</th>
                        <th>Niveau</th>
                        <th>Email</th>
                        <th>Actif</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <!-- User Name -->
                                <td class="table-text">
                                    <div>{{ $user->firstname }} {{ $user->lastname }}</div>
                                </td>
                                <td class="table-text">
                                    <div><div><i class="fa {{ $user->getLevel()['icon'] }}" title="{{ $user->getLevel()['text'] }}"></i></div></div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $user->email }}</div>
                                </td>
                                <td class="table-text">
                                    <div><i class="fa {{ $user->getStatus()['icon'] }}" title="{{ $user->getStatus()['text'] }}"></i></div>
                                </td>
                                <td class="align-right col-xs-2">
                                    <div class="btn-toolbar">
                                        <div class="btn-group">
                                            <a href="/user/{{ $user->id }}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                            @if ($user->status == 1)
                                                <a href="/user/{{ $user->id }}/disable" class="btn btn-default"><i class="fa fa-ban"></i></a>
                                            @else
                                                <a href="/user/{{ $user->id }}/enable" class="btn btn-default"><i class="fa fa-check"></i></a>
                                            @endif
                                            @if ($user->status == 1)
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-trash"></i></a>
                                            @else
                                                <a href="/user/{{ $user->id }}/delete" class="btn btn-default"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                Aucun utilisateur.
            @endif
        </div>
    </div>

    <div class="text-center">
        {{ $users->links() }}
    </div>

@endsection
