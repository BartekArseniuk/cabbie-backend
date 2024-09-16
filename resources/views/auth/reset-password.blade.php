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
            background-color: #f4f4f4;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            color: #333333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            color: #ffab00;
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #555555;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #dddddd;
            border-radius: 4px;
            font-size: 14px;
            color: #333333;
            box-sizing: border-box;
        }
        .error {
            color: #ff0000;
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 15px;
        }
        button {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            color: #ffffff;
            background-color: #ffab00;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        button:hover {
            background-color: #ffcd38;
            transform: translateY(-1px);
        }
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            h1 {
                font-size: 20px;
            }
            input[type="email"],
            input[type="password"] {
                font-size: 14px;
                padding: 10px;
            }
            button {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resetuj hasło</h1>
        <form id="resetForm" method="POST" action="{{ route('password.reset') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div>
                <label for="email">Adres e-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password">Nowe hasło</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password_confirmation">Potwierdź nowe hasło</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>
            <button type="submit">Resetuj hasło</button>
        </form>
    </div>

    <script>
        document.getElementById('resetForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var passwordConfirmation = document.getElementById('password_confirmation').value;

            if (!validateEmail(email)) {
                alert('Adres e-mail jest niepoprawny.');
                return;
            }

            if (password.length < 12) {
                alert('Hasło musi mieć co najmniej 12 znaków.');
                return;
            }

            if (!/[A-Z]/.test(password)) {
                alert('Hasło musi zawierać przynajmniej jedną wielką literę.');
                return;
            }

            if (!/[a-z]/.test(password)) {
                alert('Hasło musi zawierać przynajmniej jedną małą literę.');
                return;
            }

            if (!/[0-9]/.test(password)) {
                alert('Hasło musi zawierać przynajmniej jedną cyfrę.');
                return;
            }

            if (!/[\W_]/.test(password)) {
                alert('Hasło musi zawierać przynajmniej jeden znak specjalny.');
                return;
            }

            if (password !== passwordConfirmation) {
                alert('Hasła nie pasują do siebie.');
                return;
            }

            this.submit(); // Jeśli wszystko jest w porządku, wysyła formularz
        });

        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    </script>
</body>
</html>