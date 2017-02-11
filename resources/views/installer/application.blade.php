@extends('installer.layouts.master')

@section('title', trans('installer.application.title'))
@section('container')
    <form method="post" action="{{ route('KleisInstaller::saveApplication') }}">
        {!! csrf_field() !!}
        <div>
            <label for="url" class="col-md-4 control-label">@lang('installer.application.url')</label>
            <input id="url" type="url" class="form-control" name="url" value="{{ Request::root() }}">
        </div>
        <div>
            <label for="locale" class="col-md-4 control-label">@lang('installer.application.locale')</label>
            <select id="locale" name="locale">
                <option value="en">English</option>
                <option value="fr">Fran&ccedil;ais</option>
                <option value="de">Deutsch</option>
            </select>
        </div>
        <div>
            <label for="env" class="col-md-4 control-label">@lang('installer.application.environment')</label>
            <select id="env" name="env">
                <option value="production">Production</option>
                <option value="staging">Staging</option>
                <option value="local">Local</option>
            </select>
        </div>
    </form>
    <div class="buttons">
        <a class="button" href="{{ route('KleisInstaller::stepWelcome') }}">
            {{ trans('installer.previous') }}
        </a>
        <a href="#" onclick="document.forms[0].submit();" class="button">
            {{ trans('installer.next') }}
        </a>
    </div>
@stop
