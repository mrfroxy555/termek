@extends('layouts.app')

@section('content')
    <h2>Termék módosítása: {{ $termek->tanterem }}</h2>
    
    <form action="{{ route('termekek.update', $termek->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="tanterem">Tanterem *</label>
            <input type="text" id="tanterem" name="tanterem" value="{{ old('tanterem', $termek->tanterem) }}" required>
        </div>

        <div class="form-group">
            <label for="befogadokepesseg">Befogadóképesség (fő) *</label>
            <input type="number" id="befogadokepesseg" name="befogadokepesseg" value="{{ old('befogadokepesseg', $termek->befogadokepesseg) }}" min="1" required>
        </div>

        <div class="form-group">
            <label>Projektor</label>
            <div class="checkbox-group">
                <input type="hidden" name="projektor" value="0">
                <input type="checkbox" id="projektor" name="projektor" value="1" {{ old('projektor', $termek->projektor) ? 'checked' : '' }}>
                <label for="projektor" style="margin: 0;">Van projektor</label>
            </div>
        </div>

        <div class="form-group">
            <label>TV</label>
            <div class="checkbox-group">
                <input type="hidden" name="tv" value="0">
                <input type="checkbox" id="tv" name="tv" value="1" {{ old('tv', $termek->tv) ? 'checked' : '' }} onchange="toggleTvMeret()">
                <label for="tv" style="margin: 0;">Van TV</label>
            </div>
        </div>

        <div class="form-group" id="tv_meret_group" style="display: {{ old('tv', $termek->tv) ? 'block' : 'none' }};">
            <label for="tv_meret">TV méret (col)</label>
            <input type="number" id="tv_meret" name="tv_meret" value="{{ old('tv_meret', $termek->tv_meret) }}" min="1">
        </div>

        <div class="form-group">
            <label for="berbeadas_osszege">Bérleti díj (Ft) * - 500-ra vagy 1000-re kell végződnie</label>
            <input type="number" id="berbeadas_osszege" name="berbeadas_osszege" value="{{ old('berbeadas_osszege', $termek->berbeadas_osszege) }}" min="0" step="500" required>
        </div>

        <div class="form-group">
            <label for="szamitogepek_szama">Számítógépek száma (db) *</label>
            <input type="number" id="szamitogepek_szama" name="szamitogepek_szama" value="{{ old('szamitogepek_szama', $termek->szamitogepek_szama) }}" min="0" required>
        </div>

        <button type="submit" class="btn btn-success">Frissítés</button>
        <a href="{{ route('termekek.edit') }}" class="btn btn-primary">Vissza</a>
    </form>

    <script>
        function toggleTvMeret() {
            const tvCheckbox = document.getElementById('tv');
            const tvMeretGroup = document.getElementById('tv_meret_group');
            tvMeretGroup.style.display = tvCheckbox.checked ? 'block' : 'none';
        }
    </script>
@endsection