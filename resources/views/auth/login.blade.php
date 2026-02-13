<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title id="app_name"><?php echo @$_COOKIE['meta_title']; ?></title>
    <link rel="icon" id="favicon" type="image/x-icon" href="<?php echo str_replace('images/','images%2F',@$_COOKIE['favicon']); ?>">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body>
<style type="text/css">
    :root {
        --primary-color: #6366f1;
        --primary-hover: #4f46e5;
        --secondary-color: #8b5cf6;
        --accent-color: #ec4899;
        --bg-primary: #0f172a;
        --bg-secondary: #1e293b;
        --bg-card: #334155;
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --border-color: #475569;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        --gradient-secondary: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    }

    body {
        background: var(--bg-primary);
        color: var(--text-primary);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-group.default-admin {
        padding: 10px;
        font-size: 14px;
        color: var(--text-primary);
        font-weight: 600;
        border-radius: 10px;
        box-shadow: 0 0px 6px 0px rgba(0, 0, 0, 0.5);
        margin: 20px 10px 10px 10px;
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
    }

    .form-group.default-admin .crediantials-field {
        position: relative;
        padding-right: 15px;
        text-align: left;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .form-group.default-admin .crediantials-field > a {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        margin: auto;
        height: 20px;
        color: var(--primary-color);
    }

    .login-register {
        background: var(--gradient-primary);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    <?php if(isset($_COOKIE['admin_panel_color'])){ ?>
    a, a:hover, a:focus {
        color: <?php echo $_COOKIE['admin_panel_color']; ?>;
    }

    .btn-primary, .btn-primary.disabled, .btn-primary:hover, .btn-primary.disabled:hover {
        background: var(--gradient-primary);
        border: none;
        color: white;
        border-radius: 10px;
        padding: 12px 25px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
    }

    [type="checkbox"]:checked + label::before {
        border-right: 2px solid<?php echo $_COOKIE['admin_panel_color']; ?>;
        border-bottom: 2px solid<?php echo $_COOKIE['admin_panel_color']; ?>;
    }

    .form-material .form-control, .form-material .form-control.focus, .form-material .form-control:focus {
        background-image: linear-gradient(<?php echo $_COOKIE['admin_panel_color']; ?>, <?php echo $_COOKIE['admin_panel_color']; ?>), linear-gradient(rgba(120, 130, 140, 0.13), rgba(120, 130, 140, 0.13));
    }

    .btn-primary.active, .btn-primary:active, .btn-primary:focus, .btn-primary.disabled.active, .btn-primary.disabled:active, .btn-primary.disabled:focus, .btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary.focus:active, .btn-primary:active:focus, .btn-primary:active:hover, .open > .dropdown-toggle.btn-primary.focus, .open > .dropdown-toggle.btn-primary:focus, .open > .dropdown-toggle.btn-primary:hover, .btn-primary.focus, .btn-primary:focus, .btn-primary:not(:disabled):not(.disabled).active:focus, .btn-primary:not(:disabled):not(.disabled):active:focus, .show > .btn-primary.dropdown-toggle:focus {
        background: var(--gradient-secondary);
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.5);
    }

    .login-register {
        background: var(--gradient-primary);
    }
    <?php } else { ?>
    a, a:hover, a:focus {
        color: var(--primary-color);
    }

    .btn-primary, .btn-primary.disabled, .btn-primary:hover, .btn-primary.disabled:hover {
        background: var(--gradient-primary);
        border: none;
        color: white;
        border-radius: 10px;
        padding: 12px 25px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
    }

    [type="checkbox"]:checked + label::before {
        border-right: 2px solid var(--primary-color);
        border-bottom: 2px solid var(--primary-color);
    }

    .form-material .form-control, .form-material .form-control.focus, .form-material .form-control:focus {
        background-image: linear-gradient(var(--primary-color), var(--primary-color)), linear-gradient(rgba(120, 130, 140, 0.13), rgba(120, 130, 140, 0.13));
    }

    .btn-primary.active, .btn-primary:active, .btn-primary:focus, .btn-primary.disabled.active, .btn-primary.disabled:active, .btn-primary.disabled:focus, .btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary.focus:active, .btn-primary:active:focus, .btn-primary:active:hover, .open > .dropdown-toggle.btn-primary.focus, .open > .dropdown-toggle.btn-primary:focus, .open > .dropdown-toggle.btn-primary:hover, .btn-primary.focus, .btn-primary:focus, .btn-primary:not(:disabled):not(.disabled).active:focus, .btn-primary:not(:disabled):not(.disabled):active:focus, .show > .btn-primary.dropdown-toggle:focus {
        background: var(--gradient-secondary);
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.5);
    }
    <?php } ?>

    .login-box.card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        max-width: 420px;
        width: 100%;
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-body {
        padding: 30px;
    }

    .login-logo.text-center.py-3 a {
        background: var(--bg-secondary);
        padding: 15px;
        border-radius: 12px;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .login-logo.text-center.py-3 a:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
    }

    .box-title {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 24px;
        margin-bottom: 25px;
        text-align: center;
    }

    .form-control {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 10px;
        padding: 12px 15px;
        transition: all 0.3s ease;
        font-size: 15px;
    }

    .form-control:focus {
        background: var(--bg-card);
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.3);
        color: var(--text-primary);
        transform: translateY(-1px);
    }

    .alert-danger {
        background-color: rgba(239, 68, 68, 0.2);
        border: 1px solid var(--danger-color);
        color: var(--danger-color);
    }

    .alert-danger .close {
        color: var(--danger-color);
        opacity: 0.8;
    }

    @media (max-width: 767px) {
        .login-register {
            padding: 10px;
        }

        .card-body {
            padding: 20px;
        }

        .box-title {
            font-size: 20px;
            margin-bottom: 20px;
        }
    }
</style>
<section id="wrapper">
    <div class="login-register">
        <div class="login-logo text-center py-3">
            <a href="#" style="display: inline-block;background: #fff;padding: 10px;border-radius: 5px;"><img
                        src="{{ asset('images/logo.png') }}"> </a>
        </div>
        <div class="login-box card" style="margin-bottom:0%;">
            <div class="card-body">
                @if(count($errors) > 0)
                    @foreach( $errors->all() as $message )
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            <span>{{ $message }}</span>
                        </div>
                    @endforeach
                @endif
                <form class="form-horizontal form-material" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="box-title m-b-20">{{ __('Login') }}</div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" placeholder="{{ __('Email Address') }}" id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror" name="email"
                                   value="{{ old('email') }}" required autocomplete="email" autofocus></div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input id="password" placeholder="{{ __('Password') }}" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password" required
                                   autocomplete="current-password"></div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                        @enderror
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember')
                            ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20 mb-0">
                        <div class="col-xs-12">
                            <button type="submit"
                                    class="btn btn-dark btn-lg btn-block text-uppercase waves-effect waves-light btn btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-storage.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-database.js"></script>
<script src="https://unpkg.com/geofirestore/dist/geofirestore.js"></script>
<script src="https://cdn.firebase.com/libs/geofire/5.0.1/geofire.min.js"></script>
<script src="{{ asset('js/crypto-js.js') }}"></script>
<script src="{{ asset('js/jquery.cookie.js') }}"></script>
<script src="{{ asset('js/jquery.validate.js') }}"></script>
<script type="text/javascript">
    // Firebase Configuration
    var firebaseConfig = {
        apiKey: "<?php echo env('FIREBASE_APIKEY'); ?>",
        authDomain: "<?php echo env('FIREBASE_AUTH_DOMAIN'); ?>",
        databaseURL: "<?php echo env('FIREBASE_DATABASE_URL'); ?>",
        projectId: "<?php echo env('FIREBASE_PROJECT_ID'); ?>",
        storageBucket: "<?php echo env('FIREBASE_STORAGE_BUCKET'); ?>",
        messagingSenderId: "<?php echo env('FIREBASE_MESSAAGING_SENDER_ID'); ?>",
        appId: "<?php echo env('FIREBASE_APP_ID'); ?>",
        measurementId: "<?php echo env('FIREBASE_MEASUREMENT_ID'); ?>"
    };
    // Initialize Firebase
    if (!firebase.apps.length) {
        firebase.initializeApp(firebaseConfig);
    }
</script>
<script type="text/javascript">
    function copyToClipboard(text) {
        const elem = document.createElement('textarea');
        elem.value = text;
        document.body.appendChild(elem);
        elem.select();
        document.execCommand('copy');
        document.body.removeChild(elem);
    }
    var database = firebase.firestore();
    var ref = database.collection('settings').doc("globalSettings");
    $(document).ready(function () {
        ref.get().then(async function (snapshots) {
            var globalSettings = snapshots.data();
            setCookie('application_name', globalSettings.applicationName, 365);
            setCookie('meta_title', globalSettings.meta_title, 365);
            setCookie('favicon', globalSettings.favicon, 365);
            admin_panel_color = globalSettings.admin_panel_color;
            setCookie('admin_panel_color', admin_panel_color, 365);
            $('.login-register').css({'background-color': admin_panel_color});
            document.title = globalSettings.meta_title;
            var favicon = '<?php echo @$_COOKIE['favicon'] ?>';
        })
    });
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
</script>
</body>
</html>
