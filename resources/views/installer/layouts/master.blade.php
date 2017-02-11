<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ trans('installer.title') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/favicon-16x16.png') }}" sizes="16x16"/>
        <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}" sizes="32x32"/>
        <link rel="icon" type="image/png" href="{{ asset('images/favicon-96x96.png') }}" sizes="96x96"/>
        <link href="{{ asset('installer/css/installer.css') }}" rel="stylesheet"/>
    </head>
    <body>
        <div class="master">
            <div class="box">
                <div class="header">
                    <h1 class="header__title">@yield('title')</h1>
                </div>
                <ul class="step">
                    <li class="step__divider"></li>
                    <li class="step__item{{ Route::current()->getName() == 'KleisInstaller::stepFinal' ? ' active' : '' }}"><i class="step__icon ion-ios-pint"></i></li>
                    <li class="step__divider"></li>
                    <li class="step__item{{ Route::current()->getName() == 'KleisInstaller::stepPermissions' ? ' active' : '' }}"><i class="step__icon ion-unlocked"></i></li>
                    <li class="step__divider"></li>
                    <li class="step__item{{ Route::current()->getName() == 'KleisInstaller::stepRequirements' ? ' active' : '' }}"><i class="step__icon requirements"></i></li>
                    <li class="step__divider"></li>
                    <li class="step__item{{ Route::current()->getName() == 'KleisInstaller::stepEnvironment' ? ' active' : '' }}"><i class="step__icon ion-settings"></i></li>
                    <li class="step__divider"></li>
                    <li class="step__item{{ Route::current()->getName() == 'KleisInstaller::stepCustomization' ? ' active' : '' }}"><i class="step__icon ion-gear-b"></i></li>
                    <li class="step__divider"></li>
                    <li class="step__item{{ Route::current()->getName() == 'KleisInstaller::stepDatabase' ? ' active' : '' }}"><i class="step__icon ion-soup-can"></i></li>
                    <li class="step__divider"></li>
                    <li class="step__item{{ Route::current()->getName() == 'KleisInstaller::stepApplication' ? ' active' : '' }}"><i class="step__icon ion-android-create"></i></li>
                    <li class="step__divider"></li>
                    <li class="step__item{{ Route::current()->getName() == 'KleisInstaller::stepWelcome' ? ' active' : '' }}"><i class="step__icon welcome"></i></li>
                    <li class="step__divider"></li>
                </ul>
                <div class="main">
                    @yield('container')
                </div>
            </div>
        </div>
    </body>
</html>
