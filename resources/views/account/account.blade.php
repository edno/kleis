@extends('layouts.app')

@section('content')

@if (count($groups) > 0 && count($categories) > 0)
<script type="text/javascript" language="javascript">
    var kleisAccount = new KleisAccount();
    var kleisPassword = new KleisPassword();
</script>

<div class="visible-print">
    <h1>@lang('accounts.message.print')</h1>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title pull-left">
            @if (!empty($account->id))
                {{ $account->firstname }} {{ $account->lastname }}
            @else
                @lang('accounts.actions.new')
            @endif
        </div>
        @if (isset($account))
            <div class="panel-title pull-right hidden-print"><span class="badge">{{ $account->id }}</span></div>
        @endif
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        @if (!empty($account->id))
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/account') }}/{{ $account->id }}">
        @else
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/account') }}">
        @endif
            {{ csrf_field() }}

            <div class="form-group">
                <label for="account" class="col-md-4 control-label">{{ trans_choice('accounts.accounts', 1) }}</label>
                <div class="col-md-6">
                    <input id="account" class="form-control" name="account" value="{{ $account->netlogin }}" disabled="true">
                    @if ($errors->has('netlogin'))
                        <span class="help-block">
                            <strong>{{ $errors->first('netlogin') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <input id="netlogin" type="hidden" class="form-control" name="netlogin" value="{{ $account->netlogin }}">

            @if (!empty($account->id) && false === $errors->has('netpass'))
                <div id="divpass" class="form-group hidden">
            @else
                <div id="divpass" class="form-group">
            @endif
                <label for="password" class="col-md-4 control-label">@lang('accounts.password')</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input id="password" class="form-control" name="password" value="" disabled="true">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="copy-button"
                                data-toggle="tooltip" data-placement="button"
                                title="@lang('accounts.tooltip.copy')">
                                @lang('accounts.actions.copy')
                            </button>
                        </span>
                    </div>
                    @if ($errors->has('netpass'))
                        <span class="help-block">
                            <strong>{{ $errors->first('netpass') }}</strong>
                        </span>
                    @else
                        <span class="help-block hidden-print">
                            <strong>@lang('accounts.message.password')</strong>
                        </span>
                    @endif
                </div>
            </div>
            <input id="netpass" type="hidden" class="form-control" name="netpass" value="">


            <script type="text/javascript" language="javascript">
                document.addEventListener("DOMContentLoaded", function(event) {
                    $('#copy-button').tooltip();
                    $('#copy-button').bind('click', function() {
                        var accountinfo = "{{ trans_choice('accounts.accounts', 1) }}: " + $('#netlogin').val()
                            + "\r\n" + "@lang('accounts.password'): " + $('#netpass').val();
                        try {
                            var success = copyToClipboard(accountinfo);
                            if (success) {
                                $('#copy-button').trigger('copied', ['@lang("accounts.tooltip.copied")']);
                            } else {
                                $('#copy-button').trigger('copied', ['@lang("accounts.tooltip.copy-shortcut")']);
                            }
                        } catch (err) {
                            $('#copy-button').trigger('copied', ['@lang("accounts.tooltip.copy-shortcut")']);
                        }
                    });
                    $('#copy-button').bind('copied', function(event, message) {
                        $(this).attr('title', message)
                            .tooltip('fixTitle')
                            .tooltip('show')
                            .attr('title', "@lang('accounts.tooltip.copy')")
                            .tooltip('fixTitle');
                    });
                });
            </script>

            @if (empty($account->id))
                <script type="text/javascript" language="javascript">
                    document.addEventListener("DOMContentLoaded", function(event) {
                        var password = kleisPassword.generate();
                        $('#password').val(password);
                        $('#netpass').val(password);
                    });
                </script>
            @endif

            <div class="form-group generator-kleis{{ $errors->has('firstname') ? ' has-error' : '' }}">
                <label for="firstname" class="col-md-4 control-label">@lang('accounts.firstname')</label>
                <div class="col-md-6">
                    <input id="firstname" class="form-control" name="firstname" value="{{ $account->firstname }}"{{ empty($account->id) ? '' : ' disabled="true"' }}>
                    @if ($errors->has('firstname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('firstname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group generator-kleis{{ $errors->has('lastname') ? ' has-error' : '' }}">
                <label for="lastname" class="col-md-4 control-label">@lang('accounts.lastname')</label>
                <div class="col-md-6">
                    <input id="lastname" class="form-control" name="lastname" value="{{ $account->lastname }}"{{ empty($account->id) ? '' : ' disabled="true"' }}>
                    @if ($errors->has('lastname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('lastname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            @if (empty($account->id))
                <script type="text/javascript" language="javascript">
                    document.addEventListener("DOMContentLoaded", function(event) {
                        $('.generator-kleis').change(function() {
                            var account = kleisAccount.generate($('#firstname').val(), $('#lastname').val());
                            $('#account').val(account);
                            $('#netlogin').val(account);
                        });
                    });
                </script>
            @endif

            <div class="form-group">
                <label for="category" class="col-md-4 control-label">@lang('accounts.category')</label>
                <div class="col-md-6">
                    <select id="category" class="form-control" name="category" style="font-family:'FontAwesome', Arial;">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ ($account->category_id == $category->id) ? 'selected="true"' : null }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if (Auth::user()->level > 1)
            <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                <label for="group" class="col-md-4 control-label">@lang('accounts.group')</label>
                <div class="col-md-6">
                    <select id="group" class="form-control" name="group">
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}" {{ ($group->id == $account->group_id) ? 'selected="true"' : null }}>{{ $group->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('group'))
                        <span class="help-block">
                            <strong>{{ $errors->first('group') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            @else
                <input type="hidden" class="form-control" name="group" value="{{ Auth::user()->group_id }}">
            @endif

            <div class="form-group{{ $errors->has('expirydate') ? ' has-error' : '' }}">
                <label for="expirydate" class="col-md-4 control-label">@lang('accounts.expirydate')</label>
                <div class="col-md-6">
                    <input type="date" id="expirydate" class="form-control" name="expirydate" min="{{ date_create('tomorrow')->format('Y-m-d') }}" max="{{ date_create('+1 year')->format('Y-m-d') }}" value="{{ empty($account->expire) ? date_create('+90 day')->format('Y-m-d') : $account->expire }}" {{ ($account->status == 0 && empty($account->id) === false) ? 'disabled="true"' : null }}">
                    @if ($errors->has('expirydate'))
                        <span class="help-block">
                            <strong>{{ $errors->first('expirydate') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group hidden-print">
                <label for="status" class="col-md-4 control-label">@lang('accounts.status')</label>
                <div class="col-md-6">
                    <select id="status" class="form-control" name="status" style="font-family:'FontAwesome', Arial;">
                        <option value="1" {{ ($account->status == 1 || empty($account->id)) ? 'selected="true"' : null }}>&#xf0ac; @lang('accounts.enabled')</option>
                        <option value="0" {{ ($account->status == 0 && empty($account->id) === false) ? 'selected="true"' : null }}>&#xf05e; @lang('accounts.disabled')</option>
                    </select>
                </div>
            </div>
            <script type="text/javascript" language="javascript">
                document.addEventListener("DOMContentLoaded", function(event) {
                    $('#status').change(function() {
                        $('#expirydate').prop('disabled', ($('#status').val() == 0));
                    });
                });
            </script>

            <div class="form-group hidden-print">
                <div class="col-md-10 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-save"></i> @lang('accounts.actions.save')
                    </button>
                    @if (!empty($account->id))
                        <a href="#" class="btn" onclick="$('#password').val(kleisPassword.generate()); $('#netpass').val($('#password').val()); $('#divpass').removeClass('hidden');">
                            <i class="fa fa-btn fa-key"></i> @lang('accounts.actions.reset')
                        </a>
                    @endif
                    <a href="#" class="btn" onclick="window.print();">
                        <i class="fa fa-btn fa-print"></i> @lang('accounts.actions.print')
                    </a>
                    <a href="/accounts" class="btn" type="button">
                        <i class="fa fa-btn fa-undo"></i> @lang('accounts.actions.cancel')
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

    @if (!empty($account->id))
        <div class="panel panel-default hidden-print">
            <div class="panel-heading">
                <div class="panel-title">
                    @lang('accounts.history')
                </div>
            </div>
            <div class="panel-body">
                <li>@lang('accounts.created-by'): {{ empty($account->creator) ? trans('accounts.unknown') : $account->creator->firstname.' '.$account->creator->lastname }}</li>
                <li>@lang('accounts.created-at'): {{ $account->created_at }}</li>
                <li>@lang('accounts.updated-at'): {{ $account->updated_at }}</li>
            </div>
        </div>
    @endif

@elseif (count($groups) == 0 )
    <div class="alert alert-warning">
        @lang('accounts.message.empty.groups')
    </div>

@elseif (count($categories) == 0 )
    <div class="alert alert-warning">
        @lang('accounts.message.empty.categories')
    </div>

@endif

@endsection
