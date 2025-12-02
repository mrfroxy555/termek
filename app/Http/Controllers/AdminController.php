<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Admin panel főoldal
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.index', compact('users'));
    }

    // Jogosultság módosítása
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Ne lehessen az admin saját jogát módosítani
        if ($user->email === 'hevesitamas7@gmail.com') {
            return back()->with('error', 'Az admin fiók jogosultságát nem lehet módosítani!');
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,editor,viewer',
        ]);

        $user->update(['role' => $validated['role']]);

        return back()->with('success', $user->name . ' jogosultsága frissítve: ' . $this->getRoleName($validated['role']));
    }

    // Felhasználó törlése
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Ne lehessen az admint törölni
        if ($user->email === 'hevesitamas7@gmail.com') {
            return back()->with('error', 'Az admin fiókot nem lehet törölni!');
        }

        $userName = $user->name;
        $user->delete();

        return back()->with('success', $userName . ' felhasználó törölve!');
    }

    private function getRoleName($role)
    {
        return match($role) {
            'admin' => 'Adminisztrátor',
            'editor' => 'Szerkesztő',
            'viewer' => 'Megtekintő',
            default => 'Ismeretlen',
        };
    }
}