@extends('layouts.app')

@section('content')
    <div style="margin-bottom: 30px;">
        <h2 style="color: #e74c3c; font-size: 32px; margin-bottom: 10px;">🔐 Admin Panel</h2>
        <p style="color: #7f8c8d; font-size: 14px;">Felhasználók és jogosultságok kezelése</p>
    </div>

    <div style="background: #fff3cd; border: 2px solid #ffc107; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <strong>ℹ️ Jogosultsági szintek:</strong><br>
        <ul style="margin-top: 10px; margin-left: 20px;">
            <li><strong>Adminisztrátor:</strong> Teljes hozzáférés + felhasználók kezelése</li>
            <li><strong>Szerkesztő:</strong> Adatok megtekintése, létrehozása, módosítása, törlése</li>
            <li><strong>Megtekintő:</strong> Csak adatok megtekintése (nincs szerkesztési jog)</li>
        </ul>
    </div>

    @if($users->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Név</th>
                    <th>Email</th>
                    <th>Jogosultság</th>
                    <th>Regisztráció dátuma</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            {{ $user->name }}
                            @if($user->email === 'hevesitamas7@gmail.com')
                                <span style="background: #e74c3c; color: white; padding: 2px 8px; border-radius: 3px; font-size: 11px; margin-left: 5px;">TE</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->email === 'hevesitamas7@gmail.com')
                                <span style="background: #e74c3c; color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold;">
                                    👑 Adminisztrátor
                                </span>
                            @else
                                <form action="{{ route('admin.users.update-role', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" onchange="this.form.submit()" style="padding: 8px; border: 2px solid #ddd; border-radius: 5px; cursor: pointer;">
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>👑 Adminisztrátor</option>
                                        <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>✏️ Szerkesztő</option>
                                        <option value="viewer" {{ $user->role === 'viewer' ? 'selected' : '' }}>👁️ Megtekintő</option>
                                    </select>
                                </form>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($user->email !== 'hevesitamas7@gmail.com')
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Biztosan törölni szeretnéd {{ $user->name }} felhasználót?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Törlés</button>
                                </form>
                            @else
                                <span style="color: #95a5a6; font-style: italic;">Védett fiók</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Még nincsenek felhasználók.</p>
    @endif

    <div style="margin-top: 30px; padding: 20px; background: #e8f5e9; border-radius: 5px; border-left: 5px solid #4caf50;">
        <strong>📊 Statisztika:</strong><br>
        Összes felhasználó: <strong>{{ $users->count() }}</strong><br>
        Adminisztrátorok: <strong>{{ $users->where('role', 'admin')->count() }}</strong><br>
        Szerkesztők: <strong>{{ $users->where('role', 'editor')->count() }}</strong><br>
        Megtekintők: <strong>{{ $users->where('role', 'viewer')->count() }}</strong>
    </div>
@endsection