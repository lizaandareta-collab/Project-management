<style>
html, body {
    height: 100%;
    margin: 0;
}

.nk-app-root {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.nk-main, .nk-wrap {
    display: flex;
    flex-direction: column;
    flex: 1;
}

.nk-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Footer selalu nempel di bawah */
.nk-footer {
    margin-top: auto;
    background: #f8f9fa;
    padding: 8px 0;
    text-align: center;
    border-top: 1px solid #e5e5e5;
}

/* Hapus padding default bawaan DashLite agar tidak terlalu longgar */
.nk-content > .container-fluid {
    padding-bottom: 0 !important;
    margin-bottom: 0 !important;
}

/* Pastikan body tidak double scroll */
body.nk-body {
    overflow-x: hidden;
}
</style>


<head>
    <base href="{{ url('/') }}/">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('images/favicon40w.ico') }}">
    <!-- Page Title  -->
    <title>
        @if(isset($title))
            {{ $title }}
        @else
            @yield('title', 'Dashboard') 
        @endif
    </title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css') }}?ver=3.2.0">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css') }}?ver=3.2.0">
</head>