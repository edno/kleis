<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Kle&#720;s</title>
        <link href="/css/app.css" rel="stylesheet">
        <link href="/css/welcome.css" rel="stylesheet">
        <script src="/js/vendor.js" type="text/javascript" language="javascript"></script>
    </head>
    <body>
        <div class="container">
            <div class="col-xs-4 col-xs-offset-4">
                <div class="panel panel-default">
                <div class="panel-body text-center">

                    <div style="font-size:36px;">
                        <img src="/images/kleis.png" alt="K" style="max-height:40px;vertical-align:middle;position:relative;top:-2px;">le&#720;s
                    </div>
                    <br>

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-xs-8 col-xs-offset-2">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="@lang('auth.email')">
                                </div>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-xs-8 col-xs-offset-2">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                    <input id="password" type="password" class="form-control" name="password" placeholder="@lang('auth.password')">
                                </div>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-8 col-xs-offset-2">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> @lang('auth.remember')
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-8 col-xs-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> @lang('auth.login')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (config('kleis.legal_notice'))
                @include('auth.legal.modal')
            @endif
        </div>
    </div>
    </body>
</html>
