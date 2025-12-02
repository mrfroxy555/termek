<?php

namespace App\Http\Controllers;

use App\Models\Termek;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TermekController extends Controller
{
    public function index()
    {
        $termekek = Termek::all();
        return view('termekek.index', compact('termekek'));
    }
    
    public function adatok()
    {
        $termekek = Termek::select('tanterem', 'befogadokepesseg', 'szamitogepek_szama')->get();
        return view('termekek.adatok', compact('termekek'));
    }

    public function create()
    {
        return view('termekek.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanterem' => 'required|string|unique:termeks,tanterem',
            'befogadokepesseg' => 'required|integer|min:1',
            'projektor' => 'boolean',
            'tv' => 'boolean',
            'tv_meret' => 'nullable|integer|min:1',
            'berbeadas_osszege' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($value % 1000 !== 0 && $value % 1000 !== 500) {
                        $fail('A bérleti díjnak 500-ra vagy 1000-re kell végződnie.');
                    }
                },
            ],
            'szamitogepek_szama' => 'required|integer|min:0',
        ], [
            'tanterem.unique' => 'Ez a teremszám már létezik az adatbázisban!',
            'tanterem.required' => 'A tanterem megadása kötelező!',
            'befogadokepesseg.required' => 'A befogadóképesség megadása kötelező!',
            'berbeadas_osszege.required' => 'A bérleti díj megadása kötelező!',
            'szamitogepek_szama.required' => 'A számítógépek számának megadása kötelező!',
        ]);

        Termek::create($validated);

        return redirect()->route('termekek.index')
            ->with('success', 'Terem sikeresen létrehozva!');
    }

    public function edit()
    {
        $termekek = Termek::all();
        return view('termekek.edit', compact('termekek'));
    }

    public function editForm($id)
    {
        $termek = Termek::findOrFail($id);
        return view('termekek.edit-form', compact('termek'));
    }

    public function update(Request $request, $id)
    {
        $termek = Termek::findOrFail($id);

        $validated = $request->validate([
            'tanterem' => [
                'required',
                'string',
                Rule::unique('termeks', 'tanterem')->ignore($termek->id)
            ],
            'befogadokepesseg' => 'required|integer|min:1',
            'projektor' => 'boolean',
            'tv' => 'boolean',
            'tv_meret' => 'nullable|integer|min:1',
            'berbeadas_osszege' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($value % 1000 !== 0 && $value % 1000 !== 500) {
                        $fail('A bérleti díjnak 500-ra vagy 1000-re kell végződnie.');
                    }
                },
            ],
            'szamitogepek_szama' => 'required|integer|min:0',
        ]);

        $termek->update($validated);

        return redirect()->route('termekek.index')
            ->with('success', 'Termek sikeresen frissítve!');
    }

    public function deleteList()
    {
        $termekek = Termek::all();
        return view('termekek.delete', compact('termekek'));
    }

    public function destroy($id)
    {
        $termek = Termek::findOrFail($id);
        $termek->delete();

        return redirect()->route('termekek.index')
            ->with('success', 'Terem sikeresen törölve!');
    }

    public function showList()
    {
        $termekek = Termek::all();
        return view('termekek.show-list', compact('termekek'));
    }

    public function show($id)
    {
        $termek = Termek::findOrFail($id);
        return view('termekek.show', compact('termek'));
    }
}