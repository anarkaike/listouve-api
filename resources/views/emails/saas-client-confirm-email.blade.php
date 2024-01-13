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
<body style="background-image: url('https://listouve.junio.cc/imgs/img-abstract.jpg'); background-size: cover; background-position: center center; text-align: center; box-radius: 10px; padding: 50px;">
<div style="display:inline-block; border-radius: 5px; background-color: rgba(255,255,255,0.7); width: 300px; padding: 50px 20px; text-align: center;">

    <img src="https://listouve.junio.cc/imgs/logo.png" style="width: 70%;" />
    <br><br>
    Para confirmar seu email clique no botão abaixo.
    <br><br><br>

    <a href="{{config(key: 'app.url')}}/login?code={{$codeEmailValidation}}&id={{$saasClient['id']}}" style="display: inline-block;background-color: #6F239D; color: #FFF; padding: 20px; box-radius: 5px; text-decoration: none;">
        Confirmar email
    </a>
</div>
</body>
</html>
