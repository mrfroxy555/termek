<?php

namespace App\Http\Controllers;

use App\Models\autok;
use App\Models\Szemelyek;
use Illuminate\Http\Request;

class AutokController extends Controller
{
    public function index()
    {
        $adatok = autok::with('tulajdonosok')->get();
        $osszeg = $adatok->sum('ar');

        return view('autok.index', compact('adatok', 'osszeg'));
    }

    public function index2()
    {
        $adatok = autok::with('tulajdonosok')->where('ar', '<', 3000000)->get();
        $osszeg = $adatok->sum('ar');
    
        return view('autok.index', compact('adatok', 'osszeg'));
    }

    public function index3(Request $request)
    {
        $tipusok = autok::select('tipus')->distinct()->pluck('tipus');
        $kivalasztottTipus = $request->input('tipus', []);

        $adatok = autok::with('tulajdonosok')->when(!empty($kivalasztottTipus), function ($query) use ($kivalasztottTipus) {
            return $query->whereIn('tipus', $kivalasztottTipus);
        })->get();

        $osszeg = $adatok->sum('ar');
        $szemelyek = Szemelyek::all();

        return view('autok.tipusvalaszto', compact('adatok', 'osszeg', 'tipusok', 'kivalasztottTipus', 'szemelyek'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rendszam' => 'required|string|max:255',
            'tipus' => 'required|string|max:255',
            'ar' => 'required|integer|min:0',
            'forgalom' => 'required|date',
        ]);

        autok::create([
            'rendszam' => $validated['rendszam'],
            'tipus' => $validated['tipus'],
            'ar' => $validated['ar'],
            'forgalom' => $validated['forgalom'],
        ]);

        return redirect()->back()->with('success', 'Az autó sikeresen hozzáadva!');
    }

    public function destroy($id)
    {
        $auto = autok::findOrFail($id);
        $auto->delete();

        return redirect()->back()->with('success', 'Az autó sikeresen törölve!');
    }

    public function edit($id)
    {
        $auto = autok::findOrFail($id);
        return view('autok.edit', compact('auto'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'rendszam' => 'required|string|max:255',
            'tipus' => 'required|string|max:255',
            'ar' => 'required|integer|min:0',
            'forgalom' => 'required|date',
        ]);

        $auto = autok::findOrFail($id);
        $auto->update($validated);

        return redirect('/tipusvalaszto')->with('success', 'Az autó adatai frissítve lettek!');
    }

    public function create()
    {
        //
    }

    public function show(autok $autok)
    {
        //
    }
}