@extends('layouts.app')

@section('content')

<script type="text/javascript" language="javascript">
    var randomPassword = new RandomPassword();
</script>

<div class="visible-print">
    <h1>Information compte utilisateur</h1>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title pull-left">
            @if (!empty($account->id))
                {{ $account->firstname }} {{ $account->lastname }}
            @else
                Nouveau compte
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
                <label for="account" class="col-md-4 control-label">Compte</label>
                <div class="col-md-6">
                    <input id="account" class="form-control" name="account" value="{{ $account->netlogin }}" disabled="true">
                </div>
            </div>
            <input id="netlogin" type="hidden" class="form-control" name="netlogin" value="{{ $account->netlogin }}">

            @if (!empty($account->id))
                <div id="divpass" class="form-group hidden">
            @else
                <div id="divpass" class="form-group">
            @endif
                <label for="password" class="col-md-4 control-label">Mot de passe</label>
                <div class="col-md-6">
                    <input id="password" class="form-control" name="password" value="" disabled="true">
                    <span class="help-block hidden-print">
                        <strong>notez le mot de passe ou imprimer cette page avant d&apos;enregistrer</strong>
                    </span>
                </div>
            </div>
            <input id="netpass" type="hidden" class="form-control" name="netpass" value="">
            @if (empty($account->id))
                <script type="text/javascript" language="javascript">
                    document.addEventListener("DOMContentLoaded", function(event) {
                        $('#password').val(randomPassword.create(8, randomPassword.chrLower+randomPassword.chrNumbers));
                        $('#netpass').val($('#password').val());
                    });
                </script>
            @endif

            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                <label for="firstname" class="col-md-4 control-label">Pr&eacute;nom</label>
                <div class="col-md-6">
                    <input id="firstname" class="form-control" name="firstname" value="{{ $account->firstname }}">
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
                    <input id="lastname" class="form-control" name="lastname" value="{{ $account->lastname }}">
                    @if ($errors->has('lastname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('lastname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            @if (empty($account->id))
                <script type="text/javascript" language="javascript">
                    var randomSalt = new RandomPassword();
                    var accountSalt = randomSalt.create(4, randomSalt.chrNumbers);
                    document.addEventListener("DOMContentLoaded", function(event) {
                        function AccountGenerator () {
                            var account = $('#firstname').val().substr(0, 3) + ''
                                + $('#lastname').val().substr(0, 3) + ''
                                + accountSalt;
                            $('#account').val(account.toLowerCase());
                            $('#netlogin').val($('#account').val());
                        };
                        $('#firstname').change(function() { AccountGenerator()});
                        $('#lastname').change(function() { AccountGenerator()});
                    });
                </script>
            @endif

            <div class="form-group">
                <label for="employment" class="col-md-4 control-label">Emploi</label>
                <div class="col-md-6">
                    <select id="employment" class="form-control" name="employment" style="font-family:'FontAwesome', Arial;">
                        <option value="0" {{ ($account->employment == 0) ? 'selected="true"' : null }}>&#xf1e5; Recherche d&apos;emploi</option>
                        <option value="1" {{ ($account->employment == 1) ? 'selected="true"' : null }}>&#xf19c; Salari&eacute;</option>
                    {{--<!-- Example of additional options
                        <option value="2" {{ ($account->employment == 2) ? 'selected="true"' : null }}>&#xf19d; Student</option>
                        <option value="9" {{ ($account->employment == 9) ? 'selected="true"' : null }}>&#xf1cd; Volunteer</option>
                    -->--}}
                    </select>
                </div>
            </div>

            @if (Auth::user()->level > 1)
            <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                <label for="group" class="col-md-4 control-label">D&eacute;l&eacute;gation</label>
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
                <label for="expirydate" class="col-md-4 control-label">Date d&apos;expiration</label>
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
                <label for="status" class="col-md-4 control-label">Statut du compte</label>
                <div class="col-md-6">
                    <select id="status" class="form-control" name="status" style="font-family:'FontAwesome', Arial;">
                        <option value="1" {{ ($account->status == 1 || empty($account->id)) ? 'selected="true"' : null }}>&#xf0ac; Actif</option>
                        <option value="0" {{ ($account->status == 0 && empty($account->id) === false) ? 'selected="true"' : null }}>&#xf05e; Inactif</option>
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
                        <i class="fa fa-btn fa-save"></i> Enregistrer
                    </button>
                    @if (!empty($account->id))
                        <a href="#" class="btn" onclick="$('#password').val(randomPassword.create(8, randomPassword.chrLower+randomPassword.chrNumbers)); $('#divpass').removeClass('hidden');">
                            <i class="fa fa-btn fa-key"></i> Mot de passe
                        </a>
                    @endif
                    <a href="#" class="btn" onclick="window.print();">
                        <i class="fa fa-btn fa-print"></i> Imprimer
                    </a>
                    <a href="/accounts" class="btn" type="button">
                        <i class="fa fa-btn fa-undo"></i> Annuler
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
                    Historique
                </div>
            </div>
            <div class="panel-body">
                <li>Cr&eacute;e par : {{ empty($account->getCreator()) ? 'inconnu' : $account->getCreator()->firstname.' '.$account->getCreator()->lastname }}</li>
                <li>Cr&eacute;e le : {{ $account->created_at }}</li>
                <li>Mis &agrave; jour le : {{ $account->updated_at }}</li>
            </div>
        </div>
    @endif

@endsection
