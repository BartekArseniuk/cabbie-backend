<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nowa wiadomość</title>
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
            text-align: left;
        }
        .message-content {
            padding: 15px;
            border: 1px solid #f0f0f0;
            background-color: #f9f9f9;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.6;
            color: #333333;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #888888;
            text-align: center;
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
            .footer {
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nowa wiadomość z formularza kontaktowego</h1>
        <p><strong>Imię:</strong> {{ $details['first_name'] }}</p>
        <p><strong>Nazwisko:</strong> {{ $details['last_name'] }}</p>
        <p><strong>Email:</strong> {{ $details['email'] }}</p>
        <p><strong>Wiadomość:</strong></p>
        <div class="message-content">
            <p>{{ $details['message'] }}</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 Cabbie. Wszystkie prawa zastrzeżone.</p>
        </div>
    </div>
</body>
</html>
