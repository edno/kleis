@extends('layouts.app')

@section('content')

<script type="text/javascript" language="javascript">
    var kleisPassword = new KleisPassword();
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
                <label for="password" class="col-md-4 control-label">Mot de passe</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input id="password" class="form-control" name="password" value="" disabled="true">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="copy-button"
                                data-toggle="tooltip" data-placement="button"
                                title="Copier dans le presse-papier">
                                Copier
                            </button>
                        </span>
                    </div>
                    @if ($errors->has('netpass'))
                        <span class="help-block">
                            <strong>{{ $errors->first('netpass') }}</strong>
                        </span>
                    @else
                        <span class="help-block hidden-print">
                            <strong>notez le mot de passe ou imprimer cette page avant d&apos;enregistrer</strong>
                        </span>
                    @endif
                </div>
            </div>
            <input id="netpass" type="hidden" class="form-control" name="netpass" value="">


            <script type="text/javascript" language="javascript">
                document.addEventListener("DOMContentLoaded", function(event) {
                    $('#copy-button').tooltip();
                    $('#copy-button').bind('click', function() {
                        var accountinfo = "Compte: " + $('#netlogin').val()
                            + "\r\n" + "Mot de passe: " + $('#netpass').val();
                        try {
                            var success = copyToClipboard(accountinfo);
                            if (success) {
                                $('#copy-button').trigger('copied', ['Copié']);
                            } else {
                                $('#copy-button').trigger('copied', ['Copier avec Ctrl-c']);
                            }
                        } catch (err) {
                            $('#copy-button').trigger('copied', ['Copier avec Ctrl-c']);
                        }
                    });
                    $('#copy-button').bind('copied', function(event, message) {
                        $(this).attr('title', message)
                            .tooltip('fixTitle')
                            .tooltip('show')
                            .attr('title', "Copier dans le presse-papier")
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
                <label for="firstname" class="col-md-4 control-label">Pr&eacute;nom</label>
                <div class="col-md-6">
                    <input id="firstname" class="form-control" name="firstname" value="{{ $account->firstname }}"{{ empty($account->id) ? ' disabled="true"' : '' }}>
                    @if ($errors->has('firstname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('firstname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group generator-kleis{{ $errors->has('lastname') ? ' has-error' : '' }}">
                <label for="lastname" class="col-md-4 control-label">Nom</label>
                <div class="col-md-6">
                    <input id="lastname" class="form-control" name="lastname" value="{{ $account->lastname }}"{{ empty($account->id) ? ' disabled="true"' : '' }}>
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
                            var account = AccountGenerator($('#firstname').val(), $('#lastname').val());
                            $('#account').val(account);
                            $('#netlogin').val(account);
                        });
                    });
                </script>
            @endif

            <div class="form-group">
                <label for="category" class="col-md-4 control-label">Cat&eacute;gorie</label>
                <div class="col-md-6">
                    <select id="category" class="form-control" name="category" style="font-family:'FontAwesome', Arial;">
                        <option value="0" {{ ($account->category == 0) ? 'selected="true"' : null }}>&#xf1e5; B&eacute;n&eacute;ficiaire en recherche d&apos;emploi</option>
                        <option value="1" {{ ($account->category == 1) ? 'selected="true"' : null }}>&#xf19c; B&eacute;n&eacute;ficiaire avec emploi</option>
                        <option value="2" {{ ($account->category == 2) ? 'selected="true"' : null }}>&#xf19d; Etudiant</option>
                        <option value="10" {{ ($account->category == 10) ? 'selected="true"' : null }}>&#xf004; B&eacute;n&eacute;vole</option>
                        <option value="11" {{ ($account->category == 11) ? 'selected="true"' : null }}>&#xf1cd; Salari&eacute;</option>
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
                        <a href="#" class="btn" onclick="$('#password').val(kleisPassword.generate()); $('#netpass').val($('#password').val()); $('#divpass').removeClass('hidden');">
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
