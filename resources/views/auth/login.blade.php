@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Connexion</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">Adresse email</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">Mot de passe</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Rester connect&eacute;
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-sign-in"></i> Connexion
                        </button>

                        <a class="btn btn-link" href="{{ url('/password/reset') }}">Mot de passe oubli&eacute; ?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Article 323-1 du Code P&eacute;nal fran&ccedil;ais</div>
        <div class="panel-body">
            <ul>
                <li>Le fait d&apos;acc&eacute;der ou de se maintenir, frauduleusement, dans tout ou partie d'un syst&egrave;me de traitement automatis&eacute; de donn&eacute;es est puni de deux ans d&apos;emprisonnement et de 60 000 &euro; d&apos;amende.</li>
                <li>Lorsqu&apos;il en est r&eacute;sult&eacute; soit la suppression ou la modification de donn&eacute;es contenues dans le syst&egrave;me, soit une alt&eacute;ration du fonctionnement de ce syst&egrave;me, la peine est de trois ans d&apos;emprisonnement et de 100 000 &euro; d&apos;amende.</li>
            </ul>
        </div>
    </div>
@endsection
