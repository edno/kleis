<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Kleis</title>
        <link href="/css/app.css" rel="stylesheet">
        <link href="/css/welcome.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title"><img src="/images/kleis.png" alt="K" style="max-height:100px;vertical-align:middle;position:relative;top:-10px;">le&#720;s</div>
                <div><a href="/home">@lang('welcome.click_here')</a></div>
            </div>
        </div>
        @if (file_exists(public_path('images/'.config('kleis.logo_org')) ))
        <div class="logo-brand">
            <img src="{{ '/images/'.config('kleis.logo_org') }}" style="max-height:200px;">
        </div>
        @endif
    </body>
</html>
