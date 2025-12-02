<?php

namespace App\Http\Controllers;

use App\Models\Termek;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    // Export választó oldal megjelenítése
    public function exportPage()
    {
        return view('pdf.export');
    }

    // Összes termék exportálása
    public function exportAll()
    {
        $termekek = Termek::orderBy('tanterem')->get();
        
        $pdf = Pdf::loadView('pdf.termekek-all', compact('termekek'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('termekek_osszes_' . date('Y-m-d') . '.pdf');
    }

    // Kiválasztott termékek exportálása
    public function exportSelected(Request $request)
    {
        $selectedIds = $request->input('selected', []);
        
        if (empty($selectedIds)) {
            return back()->with('error', 'Nem választottál ki egyetlen termet sem!');
        }
        
        $termekek = Termek::whereIn('id', $selectedIds)->orderBy('tanterem')->get();
        
        $pdf = Pdf::loadView('pdf.termekek-selected', compact('termekek'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('termekek_kivalasztott_' . date('Y-m-d') . '.pdf');
    }

    // Statisztikák exportálása
    public function exportStatistics()
    {
        $osszesTermek = Termek::count();
        $atlagBefogadokepesseg = round(Termek::avg('befogadokepesseg'), 2);
        $atlagBerlet = round(Termek::avg('berbeadas_osszege'), 0);
        $osszesPC = Termek::sum('szamitogepek_szama');
        $projektorDarab = Termek::where('projektor', true)->count();
        $tvDarab = Termek::where('tv', true)->count();
        
        $berletiDijak = Termek::select('tanterem', 'berbeadas_osszege')
            ->orderBy('berbeadas_osszege', 'desc')
            ->get();
        
        $befogadokepessegek = Termek::select('tanterem', 'befogadokepesseg')
            ->orderBy('befogadokepesseg', 'desc')
            ->get();
        
        $pdf = Pdf::loadView('pdf.statisztikak', compact(
            'osszesTermek',
            'atlagBefogadokepesseg',
            'atlagBerlet',
            'osszesPC',
            'projektorDarab',
            'tvDarab',
            'berletiDijak',
            'befogadokepessegek'
        ))->setPaper('a4', 'portrait');
        
        return $pdf->download('statisztikak_' . date('Y-m-d') . '.pdf');
    }

    // Egyedi terem részletes report
    public function exportSingle($id)
    {
        $termek = Termek::findOrFail($id);
        
        $pdf = Pdf::loadView('pdf.termek-single', compact('termek'))
            ->setPaper('a4', 'portrait');
        
        return $pdf->download('terem_' . $termek->tanterem . '_' . date('Y-m-d') . '.pdf');
    }
}