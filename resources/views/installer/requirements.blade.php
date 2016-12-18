@extends('installer.layouts.master')

@section('title', trans('installer.requirements.title'))
@section('container')
    <ul class="list">
        @foreach($requirements['requirements'] as $extention => $enabled)
        <li class="list__item {{ $enabled ? 'success' : 'error' }}">{{ $extention }}</li>
        @endforeach
    </ul>

    @if ( ! isset($requirements['errors']))
        <div class="buttons">
            <a class="button" href="{{ route('KleisInstaller::stepEnvironment') }}">
                {{ trans('installer.previous') }}
            </a>
            <a class="button" href="{{ route('KleisInstaller::stepPermissions') }}">
                {{ trans('installer.next') }}
            </a>
        </div>
    @endif
@stop
