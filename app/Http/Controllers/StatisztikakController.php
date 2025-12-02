<?php
// ========================================
// app/Http/Controllers/StatisztikakController.php
// ========================================

namespace App\Http\Controllers;

use App\Models\Termek;
use Illuminate\Http\Request;

class StatisztikakController extends Controller
{
    public function index()
    {
        // Alapstatisztikák
        $osszesTermek = Termek::count();
        $atlagBefogadokepesseg = round(Termek::avg('befogadokepesseg'), 2);
        $atlagBerlet = round(Termek::avg('berbeadas_osszege'), 0);
        $osszesPC = Termek::sum('szamitogepek_szama');
        
        // Projektor és TV statisztikák
        $projektorDarab = Termek::where('projektor', true)->count();
        $tvDarab = Termek::where('tv', true)->count();
        
        // Bérleti díj szerinti csoportosítás
        $berletiDijak = Termek::select('tanterem', 'berbeadas_osszege')
            ->orderBy('berbeadas_osszege', 'desc')
            ->get();
        
        // Befogadóképesség szerinti csoportosítás
        $befogadokepessegek = Termek::select('tanterem', 'befogadokepesseg')
            ->orderBy('befogadokepesseg', 'desc')
            ->get();
        
        // Számítógépek szerinti csoportosítás
        $szamitogepek = Termek::select('tanterem', 'szamitogepek_szama')
            ->orderBy('szamitogepek_szama', 'desc')
            ->get();
        
        // Felszereltség szerinti csoportosítás
        $teljesenFelszerelt = Termek::where('projektor', true)
            ->where('tv', true)
            ->count();
        $reszbenFelszerelt = Termek::where(function($query) {
            $query->where('projektor', true)->orWhere('tv', true);
        })->where(function($query) {
            $query->where('projektor', false)->orWhere('tv', false);
        })->count();
        $nincsFelszereles = Termek::where('projektor', false)
            ->where('tv', false)
            ->count();
        
        // TV méretek
        $tvMeretek = Termek::whereNotNull('tv_meret')
            ->select('tanterem', 'tv_meret')
            ->orderBy('tv_meret', 'desc')
            ->get();
        
        return view('statisztikak.index', compact(
            'osszesTermek',
            'atlagBefogadokepesseg',
            'atlagBerlet',
            'osszesPC',
            'projektorDarab',
            'tvDarab',
            'berletiDijak',
            'befogadokepessegek',
            'szamitogepek',
            'teljesenFelszerelt',
            'reszbenFelszerelt',
            'nincsFelszereles',
            'tvMeretek'
        ));
    }
}