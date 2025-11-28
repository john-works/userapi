<!DOCTYPE html>
<html manifest="{{route('offline.manifest')}}">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Offline test page</title>
        <link rel="manifest" href="{{asset('offline/manifest.json')}}" />
        {{-- <link rel="stylesheet" type="text/css" media="all" href="styles.css" /> --}}
    </head>
    <body>
        <p id="status">Online</p>
        <h1>Offline test page</h1>

        <button id="install" hidden>Install</button>

        jkl;k'lk;l

        <p><a href="{{route('offline.index')}}">Refresh the page</a> in offline mode to reload data from store.</p>

        <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
        <script type="text/javascript" src="{{asset('offline/app.js')}}"></script>

    </body>
</html>