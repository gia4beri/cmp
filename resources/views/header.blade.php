<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            {{ $title }} @if(env('APP_NAME')) - {{ env('APP_NAME') }} @endif
        </title>
        @vite("resources/css/app.css")
    </head>
    <body>
