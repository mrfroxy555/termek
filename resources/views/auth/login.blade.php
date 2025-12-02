<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .auth-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .auth-header h1 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .auth-header p {
            color: #7f8c8d;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: bold;
            font-size: 14px;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
        }
        .checkbox-group label {
            margin: 0;
            font-size: 14px;
            color: #7f8c8d;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .auth-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #7f8c8d;
        }
        .auth-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }
        .auth-footer a:hover {
            text-decoration: underline;
        }
        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1>Bejelentkezés</h1>
            <p>Termek Kezelő Rendszer</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="email">Email cím</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Jelszó</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Emlékezz rám</label>
            </div>

            <button type="submit" class="btn">Bejelentkezés</button>
        </form>

        <div class="auth-footer">
            Nincs még fiókod? <a href="{{ route('register') }}">Regisztrálj itt</a>
        </div>
    </div>
</body>
</html>