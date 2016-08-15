@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Bienvenue {{ Auth::user()->firstname }}</div>

        <div class="panel-body">
            En tant que <strong>{{ Auth::user()->getLevel()['text'] }}</strong>
            @if (Auth::user()->level == 1)
                de la d&eacute;l&eacute;gation <strong>{{ Auth::user()->group ? Auth::user()->group->name : '' }}</strong>
                , vous pouvez g&eacute;rer les <strong>comptes</strong> utilisateurs de la d&eacute;l&eacute;gation.
            @else
                , vous pouvez :
                <ul>
                    <li>Gerer les <strong>comptes</strong> utilisateurs</li>
                    <li>Gerer la liste des <strong>delegations</strong></li>
                    <li>Gerer les <strong>listes blanches</strong> internet</li>
                    @if (Auth::user()->level == 9)
                    <li>Gerer la liste des <strong>administrateurs</strong> Kleis</li>
                    @endif
                </ul>
            @endif
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Information</div>

        <div class="panel-body">
            <div class="row">
                <!-- Accounts -->
                <div class="col-xs-6 col-sm-3">
                    <a href="#" class="btn" data-toggle="collapse" data-target="#list-accounts" data-parent="#menu">
                        <h2><i class="fa fa-user fa-2x"></i> {{ $accounts['total'] }}</h2>
                    </a>
			        <blockquote id="list-accounts" class="sublinks collapse blockquote">
                        {{ $accounts['total'] }} comptes
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
                        {{ $groups['total'] }} d&eacute;l&eacute;gations
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
                        {{ $items['total'] }} r&eacute;f&eacute;rences en liste blanche
                        <ul class="list-unstyled small">
                            @foreach ($items['summary'] as $item)
                                <li><strong>{{ $item['count'] }}</strong> {{ $item['text'] }}</li>
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
                        {{ $users['total'] }} administrateurs
                        <ul class="list-unstyled small">
                            @foreach ($users['summary'] as $item)
                                <li><strong>{{ $item['count'] }}</strong> {{ $item['text'] }}</li>
                            @endforeach
                        </ul>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>

@endsection
