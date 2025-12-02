<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termek Kezelő</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            font-size: 28px;
            margin-bottom: 15px;
        }
        .menu {
            background-color: #34495e;
            padding: 0;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        .menu a {
            color: white;
            text-decoration: none;
            padding: 15px 25px;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .menu a:hover {
            background-color: #2c3e50;
        }
        .menu a.active {
            background-color: #1abc9c;
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #34495e;
            color: white;
        }
        table tr:hover {
            background-color: #f5f5f5;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
            transition: opacity 0.3s;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .btn-primary {
            background-color: #3498db;
            color: white;
        }
        .btn-success {
            background-color: #2ecc71;
            color: white;
        }
        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }
        .btn-warning {
            background-color: #f39c12;
            color: white;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .checkbox-group input[type="checkbox"] {
            width: auto;
        }
        .detail-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-item:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #2c3e50;
            display: inline-block;
            width: 200px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Hevesi Tamás</h1>
        <div style="text-align: center; color: white; margin-bottom: 10px; font-size: 14px;">
            Bejelentkezve: <strong>{{ Auth::user()->name }}</strong>
            @if(Auth::user()->isAdmin())
                <span style="background: #e74c3c; padding: 3px 8px; border-radius: 3px; margin-left: 5px;">👑 Admin</span>
            @elseif(Auth::user()->canEdit())
                <span style="background: #f39c12; padding: 3px 8px; border-radius: 3px; margin-left: 5px;">✏️ Szerkesztő</span>
            @else
                <span style="background: #3498db; padding: 3px 8px; border-radius: 3px; margin-left: 5px;">👁️ Megtekintő</span>
            @endif
        </div>
        <nav class="menu">
            <a href="{{ route('termekek.index') }}" class="{{ request()->routeIs('termekek.index') ? 'active' : '' }}">Főoldal</a>
            <a href="{{ route('termekek.adatok') }}" class="{{ request()->routeIs('termekek.adatok') ? 'active' : '' }}">Adatok</a>
            <a href="{{ route('statisztikak.index') }}" class="{{ request()->routeIs('statisztikak.*') ? 'active' : '' }}">📊 Statisztikák</a>
            <a href="{{ route('export.page') }}" class="{{ request()->routeIs('export.*') ? 'active' : '' }}">📄 Export PDF</a>
            
            @if(Auth::user()->canEdit())
                <a href="{{ route('termekek.create') }}" class="{{ request()->routeIs('termekek.create') ? 'active' : '' }}">Create</a>
                <a href="{{ route('termekek.edit') }}" class="{{ request()->routeIs('termekek.edit*') ? 'active' : '' }}">Update</a>
                <a href="{{ route('termekek.delete') }}" class="{{ request()->routeIs('termekek.delete') ? 'active' : '' }}">Törlés</a>
            @endif
            
            <a href="{{ route('termekek.show-list') }}" class="{{ request()->routeIs('termekek.show*') ? 'active' : '' }}">Show</a>
            
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}" style="background-color: #e74c3c;">🔐 Admin Panel</a>
            @endif
            
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background: #95a5a6; color: white; border: none; padding: 15px 25px; cursor: pointer; font-size: 14px;">Kijelentkezés</button>
            </form>
        </nav>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>