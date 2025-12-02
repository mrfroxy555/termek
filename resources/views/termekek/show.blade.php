@extends('layouts.app')

@section('content')
    <h2>Termék részletei: {{ $termek->tanterem }}</h2>
    
    <div style="background-color: #f9f9f9; padding: 20px; border-radius: 5px;">
        <div class="detail-item">
            <span class="detail-label">ID:</span>
            <span>{{ $termek->id }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Tanterem:</span>
            <span>{{ $termek->tanterem }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Befogadóképesség:</span>
            <span>{{ $termek->befogadokepesseg }} fő</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Projektor:</span>
            <span>{{ $termek->projektor ? 'Igen' : 'Nem' }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">TV:</span>
            <span>{{ $termek->tv ? 'Igen' : 'Nem' }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">TV méret:</span>
            <span>{{ $termek->tv_meret ? $termek->tv_meret . ' col' : 'Nincs' }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Bérleti díj:</span>
            <span>{{ number_format($termek->berbeadas_osszege, 0, ',', ' ') }} Ft</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Számítógépek száma:</span>
            <span>{{ $termek->szamitogepek_szama }} db</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Létrehozva:</span>
            <span>{{ $termek->created_at->format('Y-m-d H:i:s') }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Utoljára módosítva:</span>
            <span>{{ $termek->updated_at->format('Y-m-d H:i:s') }}</span>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="{{ route('termekek.show-list') }}" class="btn btn-primary">Vissza a listához</a>
        <a href="{{ route('termekek.index') }}" class="btn btn-success">Főoldalra</a>
    </div>
@endsection