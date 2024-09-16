<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resetuj hasło</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            color: #333333;
        }

        .container {
            width: 100%;
            max-width: 90%;
            margin: 20px auto;
            padding: 15px;
            color: #333333;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 20px;
            color: #ffab00;
            margin-bottom: 15px;
        }

        p {
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            color: #ffffff;
            background-color: #ffab00;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .cta-button:hover {
            background-color: #ffcd38;
            transform: translateY(-1px);
        }

        .fallback-link {
            display: block;
            margin-top: 15px;
            font-size: 14px;
            color: #ffab00;
            text-decoration: none;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #888888;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            h1 {
                font-size: 18px;
            }

            p {
                font-size: 12px;
            }

            .cta-button {
                padding: 8px 16px;
                font-size: 12px;
            }

            .footer {
                font-size: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Resetuj hasło</h1>
        <p>Kliknij poniższy przycisk, aby zresetować swoje hasło.</p>
        <a href="{{ $resetLink }}" class="cta-button">Resetuj hasło</a>
        <p>Jeśli przycisk nie działa, kliknij w poniższy link:</p>
        <a href="{{ $resetLink }}" class="fallback-link">{{ $resetLink }}</a>
        <div class="footer">
            <p>&copy; 2024 Cabbie. Wszystkie prawa zastrzeżone.</p>
        </div>
    </div>
</body>

</html>