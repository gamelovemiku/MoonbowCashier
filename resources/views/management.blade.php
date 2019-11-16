<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/app.js"></script>
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Pridi:400" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
        <style>
            html, div, button {
                font-family: 'Segoe UI', 'Pridi', sans-serif;
            }
        </style>
    </head>
    <body>
        <div id="app">

            <Navbar></Navbar>
            <section class="section">
                <Managepage></Managepage>
            </section>

            <script type="text/javascript" src="js/app.js"></script>
        </div>
    </body>
</html>
