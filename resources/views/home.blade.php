@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Bienvenue {{ Auth::user()->firstname }}</div>

        <div class="panel-body">
            Vous &ecirc;tes <strong>{{ Auth::user()->getLevel()['text'] }}</strong>
            @if (Auth::user()->level == 1)
                de la d&eacute;l&eacute;gation <strong>{{ Auth::user()->group ? Auth::user()->group->name : '' }}</strong>
            @endif
            .
        </div>
    </div>

@endsection
