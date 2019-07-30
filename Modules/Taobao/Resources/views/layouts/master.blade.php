<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module Demo</title>
       {{-- Laravel Mix - CSS File --}}
        <link rel="stylesheet" href="{{ mix('css/taobao.css', 'modules/taobao') }}">
    </head>
    <body>
        @yield('content')
        {{-- Laravel Mix - JS File --}}
         <script src="{{ mix('js/taobao.js', 'modules/taobao') }}"></script>
    </body>
</html>
