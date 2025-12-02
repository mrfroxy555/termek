<?php
// ========================================
// app/Http/Controllers/AuthController.php
// ========================================

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Regisztrációs form megjelenítése
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Regisztráció kezelése
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'A név megadása kötelező!',
            'email.required' => 'Az email cím megadása kötelező!',
            'email.email' => 'Érvényes email címet adj meg!',
            'email.unique' => 'Ez az email cím már regisztrálva van!',
            'password.required' => 'A jelszó megadása kötelező!',
            'password.min' => 'A jelszónak legalább 6 karakter hosszúnak kell lennie!',
            'password.confirmed' => 'A jelszó megerősítése nem egyezik!',
        ]);

        // Automatikus admin jog hevesitamas7@gmail.com címhez
        $role = ($validated['email'] === 'hevesitamas7@gmail.com') ? 'admin' : 'viewer';

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
        ]);

        Auth::login($user);

        return redirect()->route('termekek.index')
            ->with('success', 'Sikeres regisztráció! Üdvözlünk, ' . $user->name . '!');
    }

    // Bejelentkezési form megjelenítése
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Bejelentkezés kezelése
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Az email cím megadása kötelező!',
            'email.email' => 'Érvényes email címet adj meg!',
            'password.required' => 'A jelszó megadása kötelező!',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('termekek.index'))
                ->with('success', 'Sikeres bejelentkezés! Üdvözlünk, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Hibás email cím vagy jelszó.',
        ])->onlyInput('email');
    }

    // Kijelentkezés
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Sikeres kijelentkezés!');
    }
}
