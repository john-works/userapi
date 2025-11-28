<!DOCTYPE html>
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>{{config('app.name')}} | Internal Error</title>

        <link href="{{ URL::asset('internalerror/css/screen.css')}}" rel="stylesheet" type="text/css" media="screen" />

        <script type="text/javascript" src="{{ URL::asset('internalerror/js/lib.min.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('internalerror/js/internal_error.js')}}"></script>

    </head>
    <body>
        <div style="margin: 5px auto;text-align: center" class="hoverButton">
            <a href="{{ url('/') }}">
                <img src="{{ URL::asset('images/ppda-logo.png')}}" />
            </a>
        </div>
        <div id="mWrapper">
            <img class="fullScreen" src="{{ URL::asset('internalerror/img/internal_error.jpg')}}" width="1200" height="800" alt="error 500 - internal error">
        </div>
        <div>
            <a class="p"  href="{{ url('/') }}"><strong>Error 500</strong> - Something went wrong on our side. Try again later.
                @if(isset($error))
                    <br><span class="error" style="font-size: 15px">{{$error}}</span>
                @endif
            </a>
        </div>
    </body>
</html>