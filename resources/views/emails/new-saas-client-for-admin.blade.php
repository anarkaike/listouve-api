<!doctype html>
<html lang="pt-BR">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="supported-color-schemes" content="light only">
    <meta name="color-scheme" content="light only">
    <title>{{ $subject }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap');
    </style>
</head>
<body>

    {{json_encode($saasClient)}}
    <br><br>
    @yield('content')

</body>
</html>
