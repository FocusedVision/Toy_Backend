<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $page->title }}</title>
    <link rel="stylesheet" href="/normalize.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap');

        body {
            font-size: 20px;
            font-family: "Montserrat";
            background-color: #f5f6fa;
        }

        .content {
            padding: 72pt 72pt 72pt 72pt;
            max-width: 600pt;
        }

        @media screen and (max-width: 900px) {
            body {
                font-size: 18px;
            }

            .content {
                padding: 40pt 40pt 40pt 40pt;
            }
        }

        @media screen and (max-width: 600px) {
            body {
                font-size: 16px;
            }

            .content {
                padding: 20pt 20pt 20pt 20pt;
            }
        }

        @media screen and (max-width: 500px) {
            .content {
                padding: 10pt 10pt 10pt 10pt;
            }
        }
    </style>
</head>
<body>
    <div class="content">
        {!! $page->content !!}
    </div>
</body>
</html>