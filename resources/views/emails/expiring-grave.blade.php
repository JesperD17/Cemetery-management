<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Graf verloopt binnenkort</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: #fff !important;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Graf verloopt binnenkort</h2>

    <p>
        Het graf van <strong>{{ $grave->grave_name }}</strong>
        verloopt op <strong>{{ $grave->end_date }}</strong>.
    </p>

    <p>
        U ontvangt deze herinnering omdat het graf
        over <strong>{{ $days }}</strong> dagen verloopt.
    </p>

    <p>
        U kunt de details bekijken door op onderstaande knop te klikken:
    </p>

    <p>
        <a href="{{ $link }}" class="button">Bekijk graf</a>
    </p>

    <p>
        Met vriendelijke groet,<br>
        Begraafplaats Beheer
    </p>
</body>
</html>
