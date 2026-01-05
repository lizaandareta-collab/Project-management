<!DOCTYPE html>
<html lang="zxx" class="js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Project Management 4W</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon40w.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=3.2.0') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=3.2.0') }}">
</head>

<body class="nk-body ui-rounder npc-default pg-auth">
<div class="nk-app-root">
    <div class="nk-main ">
        <div class="nk-wrap nk-wrap-nosidebar">
            <div class="nk-content ">
                <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                    <div class="brand-logo pb-4 text-center">
                        <a href="#" class="logo-link">
                            <img class="logo-light logo-img logo-img-lg" src="{{ asset('images/logo.png') }}" alt="logo">
                        </a>
                    </div>
                    <div class="card card-bordered">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h4 class="nk-block-title">Sign In</h4>
                                    <div class="nk-block-des">
                                        <p>Access your dashboard using your npk and password.</p>
                                    </div>
                                </div>
                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger">{{ $errors->first() }}</div>
                            @endif

                            <form method="POST" action="{{ url('/pm') }}">
                                @csrf
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label">NPK</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <input type="text" name="npk" class="form-control form-control-lg" placeholder="Enter your npk" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label">Password</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                            <!-- <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em> -->
                                        </a>
                                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter your password" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-lg btn-primary btn-block">Sign in</button>
                                </div>
                            </form>

                            <!-- <div class="form-note-s2 text-center pt-4">
                                New here? <a href="#">Create an account</a>
                            </div> -->
                        </div>
                    </div>
                </div>

                <div class="nk-footer nk-auth-footer-full">
                    <div class="text-center">
                        <p class="text-soft">&copy; {{ date('Y') }} 4.0 PAKO All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/bundle.js?ver=3.2.0') }}"></script>
<script src="{{ asset('assets/js/scripts.js?ver=3.2.0') }}"></script>
</body>
</html>
