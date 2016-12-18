@extends('installer.layouts.master')

@section('title', trans('installer.environment.title'))
@section('container')
    @if (session('message'))
        <p class="alert">{{ session('message') }}</p>
    @endif
    <form method="post" action="{{ route('KleisInstaller::saveEnvironment') }}">
        {!! csrf_field() !!}
        <textarea class="textarea" name="envConfig">{{ $envConfig }}</textarea>
    </form>
    @if( ! isset($environment['errors']))
        <div class="buttons">
            <a class="button" href="{{ route('KleisInstaller::stepCustomization') }}">
                {{ trans('installer.previous') }}
            </a>
            <a href="#" onclick="document.forms[0].submit();" class="button">
                {{ trans('installer.next') }}
            </a>
        </div>
    @endif
@stop
