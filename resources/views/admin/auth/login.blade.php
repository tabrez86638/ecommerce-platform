<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Ecommerce Platform</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 35px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-bottom: 8px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ddd;
            border-radius: 7px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: 0;
            border-radius: 7px;
            cursor: pointer;
            background: #111827;
            color: white;
            font-size: 16px;
        }

        .error {
            color: #dc2626;
            margin-bottom: 15px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
        }

        .remember input {
            width: auto;
            margin: 0;
        }
    </style>
</head>

<body>

<div class="login-card">

    <h1>Admin Login</h1>

    <div class="subtitle">
        Sign in to manage your ecommerce store.
    </div>

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ url('/admin/login') }}">
        @csrf

        <label for="email">Email</label>

        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            required
            autofocus
        >

        <label for="password">Password</label>

        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <div class="remember">
            <input type="checkbox" id="remember" name="remember" value="1">
            <label for="remember">Remember me</label>
        </div>

        <button type="submit">
            Login
        </button>
    </form>

</div>

</body>
</html>