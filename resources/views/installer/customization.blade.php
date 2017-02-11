@extends('installer.layouts.master')

@section('title', trans('installer.customization.title'))
@section('container')
    @if (session('message'))
        <p class="alert">{{ session('message') }}</p>
    @endif
    <form method="post" action="{{ route('KleisInstaller::saveCustomization') }}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <label for="logo">@lang('installer.customization.logo')</label>
        <input type="file" accept=".jpg,.png" name="logo" id="logo"><br><br>
        <label for="announce">
            @lang('installer.customization.message')
            <sup>[<a href="https://en.wikipedia.org/wiki/Markdown" target="_blank">Markdown</a>]</sup>
        </label>
        <textarea class="textarea" name="announce" id="announce"></textarea>
    </form>
    @if( ! isset($environment['errors']))
        <div class="buttons">
            <a class="button" href="{{ route('KleisInstaller::stepDatabase') }}">
                {{ trans('installer.previous') }}
            </a>
            <a href="#" onclick="document.forms[0].submit();" class="button">
                {{ trans('installer.next') }}
            </a>
        </div>
    @endif
@stop
