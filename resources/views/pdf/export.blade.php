@extends('layouts.app')

@section('content')
    <div style="margin-bottom: 30px;">
        <h2 style="color: #e74c3c; font-size: 32px; margin-bottom: 10px;">📄 PDF Export</h2>
        <p style="color: #7f8c8d; font-size: 14px;">Válaszd ki, mit szeretnél exportálni PDF formátumban</p>
    </div>

    <!-- Export opciók -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 40px;">
        
        <!-- Összes termék -->
        <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 5px solid #3498db;">
            <div style="display: flex; align-items: center; margin-bottom: 15px;">
                <div style="font-size: 40px; margin-right: 15px;">📋</div>
                <div>
                    <h3 style="color: #2c3e50; margin-bottom: 5px;">Összes termék</h3>
                    <p style="color: #7f8c8d; font-size: 13px; margin: 0;">Teljes adatbázis exportálása</p>
                </div>
            </div>
            <a href="{{ route('export.all') }}" class="btn btn-primary" style="width: 100%; text-align: center;">
                📥 Letöltés PDF-ben
            </a>
        </div>

        <!-- Statisztikák -->
        <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 5px solid #9b59b6;">
            <div style="display: flex; align-items: center; margin-bottom: 15px;">
                <div style="font-size: 40px; margin-right: 15px;">📊</div>
                <div>
                    <h3 style="color: #2c3e50; margin-bottom: 5px;">Statisztikák</h3>
                    <p style="color: #7f8c8d; font-size: 13px; margin: 0;">Összefoglaló grafikonokkal</p>
                </div>
            </div>
            <a href="{{ route('export.statistics') }}" class="btn btn-primary" style="width: 100%; text-align: center; background-color: #9b59b6;">
                📥 Letöltés PDF-ben
            </a>
        </div>

        <!-- Kiválasztott termékek -->
        <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 5px solid #2ecc71;">
            <div style="display: flex; align-items: center; margin-bottom: 15px;">
                <div style="font-size: 40px; margin-right: 15px;">✅</div>
                <div>
                    <h3 style="color: #2c3e50; margin-bottom: 5px;">Kiválasztott termékek</h3>
                    <p style="color: #7f8c8d; font-size: 13px; margin: 0;">Válassz termeket a listából</p>
                </div>
            </div>
            <button onclick="document.getElementById('selected-form').style.display='block'; this.style.display='none';" class="btn btn-success" style="width: 100%;">
                🎯 Termékek kiválasztása
            </button>
        </div>
    </div>

    <!-- Kiválasztott termékek form -->
    <div id="selected-form" style="display: none; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <h3 style="color: #2c3e50; margin-bottom: 20px;">Válaszd ki az exportálandó termeket:</h3>
        
        <form action="{{ route('export.selected') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 20px;">
                <button type="button" onclick="selectAll()" class="btn" style="background: #3498db; color: white; margin-right: 10px;">Összes kijelölése</button>
                <button type="button" onclick="deselectAll()" class="btn" style="background: #95a5a6; color: white;">Kijelölések törlése</button>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
                @foreach(App\Models\Termek::orderBy('tanterem')->get() as $termek)
                    <label style="display: flex; align-items: center; padding: 12px; background: #f8f9fa; border-radius: 5px; cursor: pointer; border: 2px solid transparent; transition: all 0.3s;" 
                           onmouseover="this.style.borderColor='#3498db'" 
                           onmouseout="if(!this.querySelector('input').checked) this.style.borderColor='transparent'">
                        <input type="checkbox" name="selected[]" value="{{ $termek->id }}" 
                               style="margin-right: 10px; width: 18px; height: 18px; cursor: pointer;"
                               onchange="this.parentElement.style.borderColor = this.checked ? '#3498db' : 'transparent'; this.parentElement.style.background = this.checked ? '#e3f2fd' : '#f8f9fa';">
                        <span style="font-weight: 500;">Terem {{ $termek->tanterem }}</span>
                    </label>
                @endforeach
            </div>

            <button type="submit" class="btn btn-success" style="font-size: 16px; padding: 15px 30px;">
                📥 Kiválasztottak letöltése PDF-ben
            </button>
        </form>
    </div>

    <!-- Egyedi termék export -->
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h3 style="color: #2c3e50; margin-bottom: 20px;">📄 Egyedi terem részletes riport</h3>
        <p style="color: #7f8c8d; margin-bottom: 20px;">Egy adott terem összes adatának exportálása részletes formázással.</p>
        
        <table>
            <thead>
                <tr>
                    <th>Tanterem</th>
                    <th>Befogadóképesség</th>
                    <th>Bérleti díj</th>
                    <th>Művelet</th>
                </tr>
            </thead>
            <tbody>
                @foreach(App\Models\Termek::orderBy('tanterem')->get() as $termek)
                    <tr>
                        <td><strong>Terem {{ $termek->tanterem }}</strong></td>
                        <td>{{ $termek->befogadokepesseg }} fő</td>
                        <td>{{ number_format($termek->berbeadas_osszege, 0, ',', ' ') }} Ft</td>
                        <td>
                            <a href="{{ route('export.single', $termek->id) }}" class="btn btn-primary">
                                📥 PDF letöltés
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function selectAll() {
            document.querySelectorAll('input[name="selected[]"]').forEach(cb => {
                cb.checked = true;
                cb.parentElement.style.borderColor = '#3498db';
                cb.parentElement.style.background = '#e3f2fd';
            });
        }

        function deselectAll() {
            document.querySelectorAll('input[name="selected[]"]').forEach(cb => {
                cb.checked = false;
                cb.parentElement.style.borderColor = 'transparent';
                cb.parentElement.style.background = '#f8f9fa';
            });
        }
    </script>
@endsection
