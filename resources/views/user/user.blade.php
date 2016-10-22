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

<div class="panel panel-default hidden-print">
    <div class="panel-heading">
        <div class="panel-title pull-left">
            @if (!empty($user->id))
                {{ $user->firstname }} {{ $user->lastname }}
            @else
                @lang('users.actions.new')
            @endif
        </div>
        @if (isset($user))
            <div class="panel-title pull-right"><span class="badge">{{ $user->id }}</span></div>
        @endif
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        @if ( Auth::user()->id != $user->id || Request::url() != url('/profile'))
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/user') }}{{ empty($user->id) ? '' : '/'.$user->id }}">
        @else
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/profile') }}">
        @endif
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">@lang('users.email')</label>
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ empty($user->email) ? old('email') : $user->email }}"{{ empty($user->id) ?  '' : ' disabled="true"' }}>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div id="divpass" class="form-group{{ !empty($user->id) ? ' hidden' : ''}}{{ ($errors->has('password') || $errors->has('password_confirmation')) ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">@lang('users.password')</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input id="password" type="password" class="form-control" name="password" value="">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="copy-button"
                                data-toggle="tooltip" data-placement="button"
                                title="@lang('users.tooltip.copy')">
                                @lang('users.actions.copy')
                            </button>
                        </span>
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <label for="password_confirmation" class="col-md-4 control-label">@lang('users.password_confirmation')</label>
                <div class="col-md-6">
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="">
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <script type="text/javascript" language="javascript">
                document.addEventListener("DOMContentLoaded", function(event) {
                    $('#copy-button').tooltip();
                    $('#copy-button').bind('click', function() {
                        var accountinfo = "@lang('users.user'): " + $('#email').val()
                            + "\r\n" + "@lang('users.password'): " + $('#password').val();
                        try {
                            var success = copyToClipboard(accountinfo);
                            if (success) {
                                $('#copy-button').trigger('copied', ['@lang("users.tooltip.copied")']);
                            } else {
                                $('#copy-button').trigger('copied', ['@lang("users.tooltip.copy-shortcut")']);
                            }
                        } catch (err) {
                            $('#copy-button').trigger('copied', ['@lang("users.tooltip.copy-shortcut")']);
                        }
                    });
                    $('#copy-button').bind('copied', function(event, message) {
                        $(this).attr('title', message)
                            .tooltip('fixTitle')
                            .tooltip('show')
                            .attr('title', "@lang('users.tooltip.copy')")
                            .tooltip('fixTitle');
                    });
                });
            </script>

            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                <label for="firstname" class="col-md-4 control-label">@lang('users.firstname')</label>
                <div class="col-md-6">
                    <input id="firstname" class="form-control" name="firstname" value="{{ empty($user->firstname) ? old('firstname') : $user->firstname }}"{{ empty($user->id) ? '' : ' disabled="true"' }}>
                    @if ($errors->has('firstname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('firstname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                <label for="lastname" class="col-md-4 control-label">@lang('users.lastname')</label>
                <div class="col-md-6">
                    <input id="lastname" class="form-control" name="lastname" value="{{ empty($user->lastname) ? old('lastname') : $user->lastname }}"{{ empty($user->id) ? '' : ' disabled="true"' }}>
                    @if ($errors->has('lastname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('lastname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            @if ( Auth::user()->id != $user->id )
            <div class="form-group">
                <label for="level" class="col-md-4 control-label">@lang('users.level')</label>
                <div class="col-md-6">
                    <select id="level" class="form-control" name="level" style="font-family:'FontAwesome', Arial;">
                        @foreach(App\User::USER_LEVEL as $key => $level)
                            @if (Auth::user()->level >= $key)
                                <option value="{{ $key }}" {{ ($user->level == $key || old('level') == $key) ? 'selected="true"' : null }}>{{ ucfirst($level['unicon']) }} {{ ucfirst(trans_choice($level['text'], 1)) }}</option>
                            @endif
                        @endforeach
                    </select>
                    @if ($errors->has('level'))
                        <span class="help-block">
                            <strong>{{ $errors->first('level') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <script type="text/javascript" language="javascript">
                document.addEventListener("DOMContentLoaded", function(event) {
                    $('#level').change(function() {
                        switch ($('#level').val()) {
                            case '1':
                                $('#divgroup').removeClass('hidden');
                                break;
                            case '3':
                            case '5':
                            case '9':
                                $('#divgroup').addClass('hidden');
                                $('#group').val(0)
                                break;
                        }
                    });
                });
            </script>
            @else
            <div class="form-group">
                <label for="level" class="col-md-4 control-label">@lang('users.level')</label>
                <div class="col-md-6">
                    <input class="form-control" value="{{ ucfirst($user->getLevel()['text']) }}" disabled="true">
                </div>
            </div>
            @endif

            @if ( Auth::user()->id != $user->id )
            <div id="divgroup" class="form-group{{ $errors->has('group') ? ' has-error' : '' }}{{ $user->level > 1 ? ' hidden' : '' }}">
                <label for="group" class="col-md-4 control-label">@lang('users.group')</label>
                <div class="col-md-6">
                    <select id="group" class="form-control" name="group">
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}" {{ ($group->id == $user->group_id  || old('group') == $user->group_id) ? 'selected="true"' : null }}>{{ $group->name }}</option>
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
            <div class="form-group">
                <label for="level" class="col-md-4 control-label">@lang('users.group')</label>
                <div class="col-md-6">
                    <input class="form-control" value="{{ $user->group ? $user->group->name : '&#9679;' }}" disabled="true">
                </div>
            </div>
            @endif

            @if ( Auth::user()->id != $user->id )
            <div class="form-group">
                <label for="status" class="col-md-4 control-label">@lang('users.status')</label>
                <div class="col-md-6">
                    <select id="status" class="form-control" name="status">
                        <option value="1" {{ ($user->status == 1 || empty($user->id) || old('status') == 1) ? 'selected="true"' : null }}>@lang('users.enabled')</option>
                        <option value="0" {{ ($user->status == 0 && empty($user->id) === false) ? 'selected="true"' : null }}>@lang('users.disabled')</option>
                    </select>
                </div>
            </div>
            @endif

            <div class="form-group">
                <div class="col-md-10 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-save"></i> @lang('users.actions.save')
                    </button>
                    @if (!empty($user->id))
                        <a href="#" class="btn" onclick="$('#divpass').removeClass('hidden');">
                            <i class="fa fa-btn fa-key"></i> @lang('users.actions.reset')
                        </a>
                    @endif
                    <a href="{{ (Auth::user()->id == $user->id  && Request::url() == url('/profile')) ? '/home' : '/administrators' }}" class="btn" type="button">
                        <i class="fa fa-btn fa-undo"></i> @lang('users.actions.cancel')
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

    @if (!empty($user->id))
        <div class="panel panel-default hidden-print">
            <div class="panel-heading">
                <div class="panel-title">
                    @lang('users.history')
                </div>
            </div>
            <div class="panel-body">
                <li>@lang('users.created-by'): {{ empty($user->creator) ? trans("users.unknown") : $user->creator->firstname.' '.$user->creator->lastname }}</li>
                <li>@lang('users.created-at'): {{ $user->created_at }}</li>
                <li>@lang('users.updated-at'): {{ $user->updated_at }}</li>
            </div>
        </div>
    @endif

@endsection
