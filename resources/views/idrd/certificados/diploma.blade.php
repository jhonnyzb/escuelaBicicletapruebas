<?php
    function mes($mes)
    {
        switch (+$mes)
        {
            case 1:
                return 'Enero';
            case 2:
                return 'Febrero';
            case 3:
                return 'Marzo';
            case 4:
                return 'Abril';
            case 5:
                return 'Mayo';
            case 6:
                return 'Junio';
            case 7:
                return 'Julio';
            case 8:
                return 'Agosto';
            case 9:
                return 'Septiembre';
            case 10:
                return 'Octubre';
            case 11:
                return 'Noviembre';
            case 12:
                return 'Diciembre';
        }
    }
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type="text/css">
        *{margin:0;padding:0}
        .back {
            width: 100%;
            height: 100%;
            position:absolute;
            margin-top: -20px;
        }
        h4, .dia, .mes, .anio {
            font-family: Verdana, Helvetica, "Gill Sans", sans-serif;
            font-weight: 300;
            position: absolute;
            top: 400px;
            width: 100%;
            text-align: center;
            z-index: 10;
            font-size: 30px;
        }
        .dia {
            font-size: 20px;
            top: 510px;
            left: -150px;
        }
        .mes {
            text-align: left;
            font-size: 20px;
            top: 510px;
            left: 570px;
        }
        .anio {
            text-align: left;
            font-size: 20px;
            top: 510px;
            left: 710px;
        }
    </style>
</head>
<body>
    <img src="{{ asset('public/Img/diploma.jpg') }}" alt="" class="back">
    <h4>{{ $nombre }}</h4>
    <span class="dia">{{ date('d') }}</span>
    <span class="mes">{{ mes(date('m')) }}</span>
    <span class="anio">{{ date('Y') }}</span>
</body>
</html>
