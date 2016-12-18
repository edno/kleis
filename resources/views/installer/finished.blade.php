@extends('installer.layouts.master')

@section('title', trans('installer.final.title'))
@section('container')
    <p class="paragraph">{{ session('message')['message'] }}</p>
    <div class="buttons">
        <a href="{{ url('/') }}" class="button">{{ trans('installer.final.exit') }}</a>
    </div>
@stop
