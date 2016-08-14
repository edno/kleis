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
    <ul class="nav nav-tabs">
        <li{{ Request::is("accounts/category/*") ? '' : ' class=active' }}><a href="{{ url('/accounts') }}"><i class="fa fa-asterisk"></i> Tous</a></li>
        @foreach (App\Account::ACCOUNT_CATEGORY as $id => $category)
            <li{{ Request::is("accounts/category/$id") ? ' class=active' : '' }}><a href="{{ url('/accounts/category') . '/' . $id }}"><i class="fa {{ $category['icon'] }}"></i> {{ mb_strtoupper(mb_substr($category['text'], 0, 1)).mb_substr($category['text'], 1) }}</a></li>
        @endforeach
    </ul>
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
                <div class="btn-toolbar pull-right" style="float: right;">
                    <form class="form-inline pull-right" role="form">
                        <input id="search-type" type="hidden" name="type" value="account">
                        <div class="btn-toolbar">
                            <div class="input-group">
                                <div class="search-box input-group-btn hidden">
                                    <button id="search-option-button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span id="search-option">Compte</span>&nbsp;<span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li class="search-option" value="account"><a href="#">Compte</a></li>
                                        <li class="search-option" value="fullname"><a href="#">Nom</a></li>
                                        <li class="search-option" value="group"><a href="#">D&eacute;l&eacute;gation</a></li>
                                    </ul>
                                </div>
                                <span class="search-box hidden">
                                    <input id="search" class="form-control" name="search" value="" placeholder="Jokers: * et %">
                                </span>
                                <div id="search-button" class="search-button">
                                    <a href="#" class="btn btn-default" role="button">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </div>
                            </div>

                            <a href="{{ url('/account') }}" class="btn btn-default" role="button">
                                <i class="fa fa-plus"></i> Cr&eacute;er un compte
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <script type="text/javascript" language="javascript">
            document.addEventListener("DOMContentLoaded", function() {
                $("#search-button").click(function() {
                    if ($(this).hasClass('input-group-btn')) {
                        $(this).parents('form:first').submit();
                    } else {
                        $(this).addClass('input-group-btn');
                        $(".search-box").removeClass('hidden');
                        $("#search").focus();
                    }
                });
                $(".search-option").click(function() {
                    $("#search-option").text($(this).text());
                    $("#search-type").val($(this).attr('value'));
                });
            });
        </script>


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
                                    <div><i class="fa {{ $account->getCategory()['icon'] }}" title="{{ ucfirst($account->getCategory()['text']) }}"></i></div>
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
                                <td class="align-right col-xs-2">
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

    <div class="text-center">
        {{ $accounts->links() }}
    </div>

@endsection
