@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">@lang('home.section.permissions', ['user' => Auth::user()->firstname])</div>

        <div class="panel-body">
            {{ trans_choice('home.permissions.intro', Auth::user()->level, ['level' => trans_choice(Auth::user()->getLevel()['text'], 1), 'group' => Auth::user()->group ? Auth::user()->group->name : '']) }}
            @unless (Auth::user()->level >= 5)
                {{ trans('home.permissions.accounts', ['context' => trans_choice('home.permissions.accounts.groups', Auth::user()->level)]) }}.
            @endunless
            @if (Auth::user()->level >= 5)
                :
                <ul>
                    <li>@lang('home.permissions.accounts', ['context' => ''])</li>
                    @if (Auth::user()->level >= 5)
                    <li>@lang('home.permissions.groups')</li>
                    @if (Auth::user()->level == 9)
                    <li>@lang('home.permissions.categories')</li>
                    @endif
                    <li>@lang('home.permissions.whitelist')</li>
                    @endif
                    @if (Auth::user()->level == 9)
                    <li>@lang('home.permissions.admin')</li>
                    @endif
                </ul>
            @endif
        </div>
    </div>

    @if ($announce)
    <div class="panel panel-default">
        <div class="panel-heading">@lang('home.section.announce')</div>
        <div class="panel-body">
            {!! $announce !!}
        </div>
    </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading">@lang('home.section.info')</div>

        <div class="panel-body">
            <div class="row">
                <!-- Accounts -->
                <div class="col-xs-6 col-sm-3">
                    <a href="#" class="btn" data-toggle="collapse" data-target="#list-accounts" data-parent="#menu">
                        <h2><i class="fa fa-user fa-2x"></i> {{ $accounts['total'] }}</h2>
                    </a>
			        <blockquote id="list-accounts" class="sublinks collapse blockquote">
                        {{ $accounts['total'] }} {{ trans_choice('home.info.accounts', $accounts['total']) }}
                        <ul class="list-unstyled small">
                            @foreach ($accounts['summary'] as $item)
                                <li><strong>{{ $item['count'] }}</strong> {{ $item['text'] }}</li>
                            @endforeach
                        </ul>
                    </blockquote>
                </div>
                <!-- Groups -->
                <div class="col-xs-6 col-sm-3">
                    <a href="#" class="btn" data-toggle="collapse" data-target="#list-groups" data-parent="#menu">
                        <h2><i class="fa fa-group fa-2x"></i> {{ $groups['total'] }}</h2>
                    </a>
			        <blockquote id="list-groups" class="sublinks collapse blockquote">
                        {{ $groups['total'] }} {{ trans_choice('home.info.groups', $groups['total']) }}
                        <ul class="list-unstyled small">
                            @foreach ($groups['summary'] as $item)
                                <li>{{ $item['text'] }} (<strong>{{ $item['count'] }}</strong>)</li>
                            @endforeach
                        </ul>
                    </blockquote>
                </div>
                <!-- Lists -->
                <div class="col-xs-6 col-sm-3">
                    <a href="#" class="btn" data-toggle="collapse" data-target="#list-items" data-parent="#menu">
                        <h2><i class="fa fa-globe fa-2x"></i> {{ $items['total'] }}</h2>
                    </a>
			        <blockquote id="list-items" class="sublinks collapse blockquote">
                        {{ $items['total'] }} {{ trans_choice('home.info.items', $items['total']) }} @lang('home.info.items.whitelist')
                        <ul class="list-unstyled small">
                            @foreach ($items['summary'] as $item)
                                <li><strong>{{ $item['count'] }}</strong> {{ trans_choice('home.info.'.$item['text'], $item['count']) }}</li>
                            @endforeach
                        </ul>
                    </blockquote>
                </div>
                <!-- Admins -->
                <div class="col-xs-6 col-sm-3">
                    <a href="#" class="btn" data-toggle="collapse" data-target="#list-users" data-parent="#menu">
                        <h2><i class="fa fa-user-secret fa-2x"></i> {{ $users['total'] }}</h2>
                    </a>
                    <blockquote id="list-users" class="sublinks collapse blockquote">
                        {{ $users['total'] }} {{ trans_choice('home.info.admin', $users['total']) }}
                        <ul class="list-unstyled small">
                            @foreach ($users['summary'] as $item)
                                <li><strong>{{ $item['count'] }}</strong> {{ trans_choice($item['text'], $item['count']) }}</li>
                            @endforeach
                        </ul>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>

@endsection
