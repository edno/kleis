@extends('installer.layouts.master')

@section('title', trans('installer.database.title'))
@section('container')
    <form method="post" action="{{ route('KleisInstaller::saveDatabase') }}">
        {!! csrf_field() !!}
        <div>
            <label for="dbtype" class="col-md-4 control-label">@lang('installer.database.type')</label>
            <select id="dbtype" name="dbtype">
                <option value="mysql">MySQL</option>
                <option value="pgsql">PostgreSQL</option>
            </select>
        </div>
        <div>
            <label for="dbhost" class="col-md-4 control-label">@lang('installer.database.host')</label>
            <input id="dbhost" type="text" class="form-control" name="dbhost" value="{{ config('database.connections.mysql.host') }}">
        </div>
        <div>
            <label for="dbport" class="col-md-4 control-label">@lang('installer.database.port')</label>
            <input id="dbport" type="text" class="form-control" name="dbport" value="{{ config('database.connections.mysql.port') }}">
        </div>
        <div>
            <label for="dbname" class="col-md-4 control-label">@lang('installer.database.schema')</label>
            <input id="dbname" type="text" class="form-control" name="dbname" value="{{ config('database.connections.mysql.database') }}">
        </div>
        <div>
            <label for="dbuser" class="col-md-4 control-label">@lang('installer.database.user')</label>
            <input id="dbuser" type="text" class="form-control" name="dbuser" value="{{ config('database.connections.mysql.username') }}">
        </div>
        <div>
            <label for="dbpassword" class="col-md-4 control-label">@lang('installer.database.password')</label>
            <input id="dbpassword" type="password" class="form-control" name="dbpassword" value="{{ config('database.connections.mysql.password') }}">
        </div>
    </form>
    <div class="buttons">
        <a class="button" href="{{ route('KleisInstaller::stepApplication') }}">
            {{ trans('installer.previous') }}
        </a>
        <a href="#" onclick="document.forms[0].submit();" class="button">
            {{ trans('installer.next') }}
        </a>
    </div>
@stop
