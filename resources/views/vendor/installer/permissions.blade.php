@extends('vendor.installer.layouts.master')

@section('title', trans('messages.permissions.title'))
@section('container')
    <ul class="list">
        @foreach($permissions['permissions'] as $permission)
        <li class="list__item list__item--permissions {{ $permission['isSet'] ? 'success' : 'error' }}">
            {{ $permission['folder'] }}<span>{{ $permission['permission'] }}</span>
        </li>
        @endforeach
    </ul>

    @if ( ! isset($permissions['errors']))
        <div class="buttons">
            <a class="button" href="{{ route('LaravelInstaller::requirements') }}">
                {{ trans('messages.previous') }}
            </a>
            <a class="button" href="{{ route('LaravelInstaller::database') }}">
                {{ trans('messages.finish') }}
            </a>
        </div>
    @endif
@stop
