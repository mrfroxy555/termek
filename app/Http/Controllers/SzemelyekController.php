<?php

namespace App\Http\Controllers;

use App\Models\Szemelyek;
use App\Models\autok;
use App\Models\Tulajdonos;
use Illuminate\Http\Request;

class SzemelyekController extends Controller
{
    // Személyek listázása
    public function index()
    {
        $szemelyek = Szemelyek::withCount('autok')->get();
        return view('szemelyek.index', compact('szemelyek'));
    }

    // Új személy létrehozása
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nev' => 'required|string|max:255',
            'tel' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        Szemelyek::create($validated);

        return redirect()->back()->with('success', 'Személy sikeresen hozzáadva!');
    }

    // Személy törlése
    public function destroy($id)
    {
        $szemely = Szemelyek::findOrFail($id);
        
        // A tulajdonos tábla kapcsolatokat töröljük
        Tulajdonos::where('szemely_id', $id)->delete();
        
        $szemely->delete();

        return redirect()->back()->with('success', 'Személy sikeresen törölve!');
    }

    // Személy szerkesztő oldal
    public function edit($id)
    {
        $szemely = Szemelyek::findOrFail($id);
        return view('szemelyek.edit', compact('szemely'));
    }

    // Személy frissítése
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nev' => 'required|string|max:255',
            'tel' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        $szemely = Szemelyek::findOrFail($id);
        $szemely->update($validated);

        return redirect('/szemelyek')->with('success', 'Személy adatai frissítve!');
    }

    // Személy autói
    public function autok($id)
    {
        $szemely = Szemelyek::with('autok')->findOrFail($id);
        
        // Az autók, amiknek még nincs tulajdonosa vagy nem ennek a személynek tulajdonosai
        $marFoglaltAutoIdk = $szemely->autok->pluck('id')->toArray();
        $szabadAutok = autok::whereNotIn('id', $marFoglaltAutoIdk)->get();
        
        return view('szemelyek.autok', compact('szemely', 'szabadAutok'));
    }

    // Autó hozzárendelése személyhez (Tulajdonos tábla)
    public function hozzarendelAuto(Request $request, $id)
    {
        $validated = $request->validate([
            'auto_id' => 'required|exists:autoks,id',
        ]);

        // Ellenőrizzük, hogy nincs-e már ilyen kapcsolat
        $letezik = Tulajdonos::where('szemely_id', $id)
                             ->where('auto_id', $validated['auto_id'])
                             ->exists();

        if ($letezik) {
            return redirect()->back()->with('error', 'Ez az autó már hozzá van rendelve ehhez a személyhez!');
        }

        // Új tulajdonos kapcsolat létrehozása
        Tulajdonos::create([
            'szemely_id' => $id,
            'auto_id' => $validated['auto_id']
        ]);

        return redirect()->back()->with('success', 'Autó sikeresen hozzárendelve!');
    }

    // Autó eltávolítása személytől (Tulajdonos tábla törlés)
    public function eltavolitAuto($szemelyId, $autoId)
    {
        Tulajdonos::where('szemely_id', $szemelyId)
                  ->where('auto_id', $autoId)
                  ->delete();

        return redirect()->back()->with('success', 'Autó eltávolítva a személytől!');
    }
}