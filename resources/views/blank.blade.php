<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>404 HTML</title>

        <style type="text/css">

            body
            {
                font-family: 'Rubik', sans-serif;
                overflow: hidden;
            }

            h1,h2,h3,h4,h5,h6,p
            {
                margin: 0px;
                padding: 0px;
            }

            .errorContainer
            {
                width: 100%;
                min-height: 100vh;
            }

            .errorBlock
            {
                width: 40%;
                min-width: 400px;
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%,-50%);
                text-align: center;
            }

            .errorBlock h1
            {
                font-size: 80px;
                color: #3f3a64;
            }

            .errorBlock h3
            {
                margin-bottom: 20px;
                font-size: 40px;
                color: #3f3a64;
            }

            .errorBlock p {
                padding: 0 25px;
            }

        </style>


    </head>
    <body>
        <div class="errorContainer">
            <div class="errorBlock">
                <h1>Error 405</h1>
                <h3>Oops... This is an API Microservice!</h3>
                <p>Try again by accessing the API endpoints via cURL / postman!</p>
            </div>
        </div>
    </body>
</html>
