<!doctype html>
<html lang="pt-BR">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="supported-color-schemes" content="light only">
    <meta name="color-scheme" content="light only">
    <title>{{ $subject }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
    </style>
</head>
<body>

{{json_encode($user)}}
<br><br>
@yield('content')

</body>
</html>
