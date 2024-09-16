<!-- resources/views/auth/reset-password.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <form method="POST" action="{{ route('password.reset') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div>
            <label for="email">E-Mail Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
