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

    <!-- Current Accounts -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title pull-left">
                @if (isset($group))
                    {{ $group->name }}
                @else
                    Comptes
                @endif
            </div>
            <div class="panel-title pull-right">
                <a href="{{ url('/account') }}" class="btn btn-default" style="float: right;">
                    <i class="fa fa-plus"></i> Cr&eacute;er un compte
                </a>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            @if (count($accounts) > 0)
                <table class="table table table-hover accounts-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>&nbsp;</th>
                        <th>Nom</th>
                        <th>Compte</th>
                        <th>Expire</th>
                        <th>Statut</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($accounts as $account)
                            @if ($account->status == 1)
                                @if ($account->expire <= date_create('+7 day')->format('Y-m-d'))
                                    <tr class="warning">
                                @else
                                    <tr>
                                @endif
                            @else
                                <tr class="text-muted">
                            @endif
                                <td class="table-text">
                                    <div><i class="fa {{ $account->getEmployment()['icon'] }}" title="{{ ucfirst($account->getEmployment()['text']) }}"></i></div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $account->firstname }} {{ $account->lastname }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $account->netlogin }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $account->expire }}</div>
                                </td>
                                <td class="table-text">
                                    <div><i class="fa {{ $account->getStatus()['icon'] }}" title="{{ $account->getStatus()['text'] }}"></i></div>
                                </td>
                                <td class="align-right">
                                    <div class="btn-toolbar">
                                        <div class="btn-group">
                                            <a href="/account/{{ $account->id }}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                            @if ($account->status == 1)
                                                <a href="/account/{{ $account->id }}/disable" class="btn btn-default"><i class="fa fa-ban"></i></a>
                                            @else
                                                <a href="/account/{{ $account->id }}/enable" class="btn btn-default"><i class="fa fa-globe"></i></a>
                                            @endif
                                            @if ($account->status == 1)
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-trash"></i></a>
                                            @else
                                                <a href="/account/{{ $account->id }}/delete" class="btn btn-default"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                Aucun compte utilisateur.
            @endif
        </div>
    </div>

@endsection
