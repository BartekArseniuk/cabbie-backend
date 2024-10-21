<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kod weryfikacyjny</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            color: #333333;
            background-color: #f7f7f7;
        }
        .container {
            width: 100%;
            max-width: 90%;
            margin: 20px auto;
            padding: 15px;
            color: #333333;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            font-size: 24px;
            color: #ffab00;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .code-box {
            display: inline-block;
            padding: 10px 20px;
            font-size: 20px;
            color: #ffffff;
            background-color: #ffab00;
            border-radius: 8px;
            letter-spacing: 4px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888888;
            text-align: center;
        }
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
            h1 {
                font-size: 20px;
            }
            p {
                font-size: 14px;
            }
            .code-box {
                padding: 8px 16px;
                font-size: 18px;
            }
            .footer {
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Twój kod weryfikacyjny</h1>
        <p>Wprowadź poniższy kod, aby zakończyć proces logowania:</p>
        <div class="code-box">{{ $code }}</div>
        <div class="footer">
            <p>&copy; 2024 Cabbie. Wszystkie prawa zastrzeżone.</p>
        </div>
    </div>
</body>
</html>
