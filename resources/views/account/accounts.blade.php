@extends('layouts.app')

@section('content')

@if (session('status') || session('results'))
    <div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session('status') }}{{ session('results') }}
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
    <ul class="nav nav-tabs" style="border-bottom: 0px;">
        <li class="{{ Request::is("*/category/*") ? 'has-tooltip' : 'active' }}"
            data-toggle="tooltip"
            data-placement="bottom"
            title="@lang('accounts.all')">
        <a href="{{ preg_replace('/(.*\/?accounts)(?:\/category.*)?/', '$1', Request::url()) }}">
            <i class="fa fa-asterisk"></i>
            {{ Request::is("*/category/*") ? '' : ' ' . trans('accounts.all') }}
        </a></li>
        @if (isset($categories))
            @foreach ($categories as $category)
                <li class="{{ Request::is('*/category/'.$category->id) ? 'active' : 'has-tooltip' }}"
                data-toggle="tooltip"
                data-placement="bottom"
                title="{{ $category->name }}">
                <a href="{{ preg_replace('/(.*\/?accounts)(?:\/category.*)?/', '$1/category/', Request::url()) . $category->id }}">
                    <i class="fa {{ $category->icon }}"></i>
                    {{ Request::is('*/category/'.$category->id) ? ' ' . $category->name : '' }}</a></li>
            @endforeach
        @endif
    </ul>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title pull-left">
                @if (isset($group))
                    {{ $group->name }}
                @else
                    {{ trans_choice('accounts.accounts', 2) }}
                @endif
            </div>
            <div class="panel-title pull-right">
                <div class="btn-toolbar pull-right" style="float: right;">
                    <form class="form-inline pull-right" role="form">
                        <input id="search-type" type="hidden" name="type" value="account">
                        <div class="btn-toolbar">
                            <div class="input-group">
                                <div class="search-box input-group-btn{{ session('results') ? '' : ' hidden' }}">
                                    <button id="search-option-button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span id="search-option">{{ trans_choice('accounts.accounts', 1) }}</span>&nbsp;<span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li class="search-option{{ session('type') == 'account' ? ' option-selected' : '' }}" value="account"><a href="#">{{ trans_choice('accounts.accounts', 1) }}</a></li>
                                        <li class="search-option{{ session('type') == 'fullname' ? ' option-selected' : '' }}" value="fullname"><a href="#">@lang('accounts.fullname')</a></li>
                                    @if (Auth::user()->level >= 3)
                                        <li class="search-option{{ session('type') == 'group' ? ' option-selected' : '' }}" value="group"><a href="#">@lang('accounts.group')</a></li>
                                    @endif
                                    </ul>
                                </div>
                                <span class="search-box{{ session('results') ? '' : ' hidden' }}">
                                    <input id="search" class="form-control" name="search" value="{{ session('search') }}" placeholder="@lang('accounts.tooltip.search')">
                                </span>
                                <div id="search-button"
                                    class="search-button{{ session('results') ? ' input-group-btn' : '' }}">
                                    <a href="#"
                                        class="btn btn-default has-tooltip"
                                        role="button"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="@lang('accounts.actions.search')">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </div>
                            </div>

                            <a href="{{ url('/account') }}" class="btn btn-default" role="button">
                                <i class="fa fa-plus"></i> @lang('accounts.actions.add')
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
                        <th>@lang('accounts.fullname')</th>
                        <th>{{ trans_choice('accounts.accounts', 1) }}</th>
                        <th>@lang('accounts.expire')</th>
                        <th>@lang('accounts.status')</th>
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
                                    <div><i class="fa {{ $account->category->icon }} has-tooltip"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="{{ $account->category->name }}"></i></div>
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
                                    <div><i class="fa {{ $account->getStatus()['icon'] }} has-tooltip"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="{{ ucfirst(trans($account->getStatus()['text'])) }}"></i></div>
                                </td>
                                <td class="align-right col-xs-2">
                                    <div class="btn-toolbar">
                                        <div class="btn-group">
                                            <a href="/account/{{ $account->id }}"
                                                class="btn btn-default has-tooltip"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="@lang('accounts.actions.edit')"><i class="fa fa-pencil"></i></a>
                                            @if ($account->status == 1)
                                                <a href="/account/{{ $account->id }}/disable"
                                                    class="btn btn-default has-tooltip"
                                                    data-toggle="tooltip"
                                                    data-placement="bottom"
                                                    title="@lang('accounts.actions.disable')"><i class="fa fa-ban"></i></a>
                                            @else
                                                <a href="/account/{{ $account->id }}/enable"
                                                    class="btn btn-default has-tooltip"
                                                    data-toggle="tooltip"
                                                    data-placement="bottom"
                                                    title="@lang('accounts.actions.enable')"><i class="fa fa-globe"></i></a>
                                            @endif
                                            @if ($account->status == 1)
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-trash"></i></a>
                                            @else
                                                <a href="/account/{{ $account->id }}/delete"
                                                    class="btn btn-default has-tooltip"
                                                    data-toggle="tooltip"
                                                    data-placement="bottom"
                                                    title="@lang('accounts.actions.delete')"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                @lang('accounts.message.empty.accounts').
            @endif
        </div>
    </div>

    <div class="text-center">
        {{ $accounts->links() }}
    </div>

    <script type="text/javascript" language="javascript">
        document.addEventListener("DOMContentLoaded", function() {
            $('.has-tooltip').tooltip();
        });
    </script>

{{ session()->forget(['results', 'search', 'type']) }}

@endsection
