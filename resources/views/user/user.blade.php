@extends('layouts.app')

@section('content')

<div class="panel panel-default hidden-print">
    <div class="panel-heading">
        <div class="panel-title pull-left">
            @if (!empty($user->id))
                {{ $user->firstname }} {{ $user->lastname }}
            @else
                Nouvel administrateur
            @endif
        </div>
        @if (isset($user))
            <div class="panel-title pull-right"><span class="badge">{{ $user->id }}</span></div>
        @endif
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        @if (!empty($user->id))
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/user') }}/{{ $user->id }}">
        @else
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/user') }}">
        @endif
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">Email</label>
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ empty($user->email) ? old('email') : $user->email }}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div id="divpass" class="form-group{{ !empty($user->id) ? ' hidden' : ''}}">
                <label for="password" class="col-md-4 control-label">Mot de passe</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" value="">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <label for="password_confirmation" class="col-md-4 control-label">Confirmation</label>
                <div class="col-md-6">
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="">
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                <label for="firstname" class="col-md-4 control-label">Pr&eacute;nom</label>
                <div class="col-md-6">
                    <input id="firstname" class="form-control" name="firstname" value="{{ empty($user->firstname) ? old('firstname') : $user->firstname }}">
                    @if ($errors->has('firstname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('firstname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                <label for="lastname" class="col-md-4 control-label">Nom</label>
                <div class="col-md-6">
                    <input id="lastname" class="form-control" name="lastname" value="{{ empty($user->lastname) ? old('lastname') : $user->lastname }}">
                    @if ($errors->has('lastname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('lastname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="form-group">
                <label for="level" class="col-md-4 control-label">Niveau</label>
                <div class="col-md-6">
                    <select id="level" class="form-control" name="level" style="font-family:'FontAwesome', Arial;">
                        <option value="1" {{ ($user->level == 1 || old('level') == 1) ? 'selected="true"' : null }}>&#xf1cd; Gestionnaire</option>
                        <option value="2" {{ ($user->level == 2 || old('level') == 2) ? 'selected="true"' : null }}>&#xf132; Administrateur</option>
                        @if ($user->level >= 9)
                            <option value="9" {{ ($user->level == 9 || old('level') == 9) ? 'selected="true"' : null }}>&#xf135; Super Administrateur</option>
                        @endif
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
                            case '2':
                                $('#divgroup').addClass('hidden');
                                $('#group').val(0)
                                break;
                            case '9':
                                $('#divgroup').addClass('hidden');
                                $('#group').val(0)
                                break;
                        }
                    });
                });
            </script>


            <div id="divgroup" class="form-group{{ $errors->has('group') ? ' has-error' : '' }}{{ $user->level > 1 ? ' hidden' : '' }}">
                <label for="group" class="col-md-4 control-label">D&eacute;l&eacute;gation</label>
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

            <div class="form-group">
                <label for="status" class="col-md-4 control-label">Statut</label>
                <div class="col-md-6">
                    <select id="status" class="form-control" name="status">
                        <option value="1" {{ ($user->status == 1 || empty($user->id) || old('status') == 1) ? 'selected="true"' : null }}>Actif</option>
                        <option value="0" {{ ($user->status == 0 && empty($user->id) === false) ? 'selected="true"' : null }}>Inactif</option>
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

            <div class="form-group">
                <div class="col-md-10 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-save"></i> Enregistrer
                    </button>
                    @if (!empty($user->id))
                        <a href="#" class="btn" onclick="$('#divpass').removeClass('hidden');">
                            <i class="fa fa-btn fa-key"></i> Changer mot de passe
                        </a>
                    @endif
                    <a href="/administrators" class="btn" type="button">
                        <i class="fa fa-btn fa-undo"></i> Annuler
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
                    Historique
                </div>
            </div>
            <div class="panel-body">
                <li>Cr&eacute;er par : {{ empty($user->getCreator()) ? 'inconnu' : $user->getCreator()->firstname.' '.$user->getCreator()->lastname }}</li>
                <li>Cr&eacute;er le : {{ $user->created_at }}</li>
                <li>Mis &agrave; jour le : {{ $user->updated_at }}</li>
            </div>
        </div>
    @endif

@endsection
