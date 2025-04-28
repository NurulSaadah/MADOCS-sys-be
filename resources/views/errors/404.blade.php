<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f4f4f4;
        }
        h1 {
            font-size: 72px;
            color: #ff6b6b;
        }
        p {
            font-size: 24px;
            color: #555;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>404</h1>
    <p>Oops! The page you are looking for does not exist.</p>
    <p>
        <a href="{{ env('APP_WEB_REDIRECT') }}">Go back to homepage</a>
    </p>
</body>
</html>
