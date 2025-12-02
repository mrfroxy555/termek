@extends('layouts.app')

@section('content')
    <div style="margin-bottom: 30px;">
        <h2 style="color: #3498db; font-size: 32px; margin-bottom: 10px;">📊 Statisztikák és Diagramok</h2>
        <p style="color: #7f8c8d; font-size: 14px;">Vizuális áttekintés a termekről</p>
    </div>

    <!-- Alapstatisztikák -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 25px; border-radius: 10px; color: white; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 40px; font-weight: bold; margin-bottom: 10px;">{{ $osszesTermek }}</div>
            <div style="font-size: 14px; opacity: 0.9;">Összes terem</div>
        </div>
        
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 25px; border-radius: 10px; color: white; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 40px; font-weight: bold; margin-bottom: 10px;">{{ $atlagBefogadokepesseg }}</div>
            <div style="font-size: 14px; opacity: 0.9;">Átlag befogadóképesség (fő)</div>
        </div>
        
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 25px; border-radius: 10px; color: white; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 40px; font-weight: bold; margin-bottom: 10px;">{{ number_format($atlagBerlet, 0, ',', ' ') }} Ft</div>
            <div style="font-size: 14px; opacity: 0.9;">Átlag bérleti díj</div>
        </div>
        
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); padding: 25px; border-radius: 10px; color: white; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 40px; font-weight: bold; margin-bottom: 10px;">{{ $osszesPC }}</div>
            <div style="font-size: 14px; opacity: 0.9;">Összes számítógép</div>
        </div>
    </div>

    <!-- Diagramok választó -->
    <div style="margin-bottom: 30px;">
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <button onclick="showChart('berlet')" class="chart-btn active" id="btn-berlet">💰 Bérleti díjak</button>
            <button onclick="showChart('befogado')" class="chart-btn" id="btn-befogado">👥 Befogadóképesség</button>
            <button onclick="showChart('pc')" class="chart-btn" id="btn-pc">💻 Számítógépek</button>
            <button onclick="showChart('felszereltseg')" class="chart-btn" id="btn-felszereltseg">🔧 Felszereltség</button>
            <button onclick="showChart('tv')" class="chart-btn" id="btn-tv">📺 TV méretek</button>
        </div>
    </div>

    <!-- Bérleti díjak diagram -->
    <div id="chart-berlet" class="chart-container">
        <h3 style="color: #2c3e50; margin-bottom: 20px;">💰 Bérleti díjak terem szerint</h3>
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            @foreach($berletiDijak as $termek)
                @php
                    $maxBerlet = $berletiDijak->max('berbeadas_osszege');
                    $szazalek = ($termek->berbeadas_osszege / $maxBerlet) * 100;
                    $szin = $termek->berbeadas_osszege >= 7000 ? '#e74c3c' : ($termek->berbeadas_osszege >= 4000 ? '#f39c12' : '#2ecc71');
                @endphp
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-weight: bold;">Terem {{ $termek->tanterem }}</span>
                        <span style="color: #7f8c8d;">{{ number_format($termek->berbeadas_osszege, 0, ',', ' ') }} Ft</span>
                    </div>
                    <div style="background: #ecf0f1; border-radius: 10px; height: 25px; overflow: hidden;">
                        <div style="background: {{ $szin }}; height: 100%; width: {{ $szazalek }}%; transition: width 0.5s; border-radius: 10px;"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Befogadóképesség diagram -->
    <div id="chart-befogado" class="chart-container" style="display: none;">
        <h3 style="color: #2c3e50; margin-bottom: 20px;">👥 Befogadóképesség terem szerint</h3>
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            @foreach($befogadokepessegek as $termek)
                @php
                    $maxBefogado = $befogadokepessegek->max('befogadokepesseg');
                    $szazalek = ($termek->befogadokepesseg / $maxBefogado) * 100;
                    $szin = $termek->befogadokepesseg >= 40 ? '#9b59b6' : ($termek->befogadokepesseg >= 25 ? '#3498db' : '#1abc9c');
                @endphp
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-weight: bold;">Terem {{ $termek->tanterem }}</span>
                        <span style="color: #7f8c8d;">{{ $termek->befogadokepesseg }} fő</span>
                    </div>
                    <div style="background: #ecf0f1; border-radius: 10px; height: 25px; overflow: hidden;">
                        <div style="background: {{ $szin }}; height: 100%; width: {{ $szazalek }}%; transition: width 0.5s; border-radius: 10px;"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Számítógépek diagram -->
    <div id="chart-pc" class="chart-container" style="display: none;">
        <h3 style="color: #2c3e50; margin-bottom: 20px;">💻 Számítógépek száma terem szerint</h3>
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            @foreach($szamitogepek as $termek)
                @php
                    $maxPC = $szamitogepek->max('szamitogepek_szama');
                    $szazalek = ($termek->szamitogepek_szama / $maxPC) * 100;
                    $szin = $termek->szamitogepek_szama >= 20 ? '#e67e22' : ($termek->szamitogepek_szama >= 12 ? '#f39c12' : '#16a085');
                @endphp
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-weight: bold;">Terem {{ $termek->tanterem }}</span>
                        <span style="color: #7f8c8d;">{{ $termek->szamitogepek_szama }} db</span>
                    </div>
                    <div style="background: #ecf0f1; border-radius: 10px; height: 25px; overflow: hidden;">
                        <div style="background: {{ $szin }}; height: 100%; width: {{ $szazalek }}%; transition: width 0.5s; border-radius: 10px;"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Felszereltség kördiagram -->
    <div id="chart-felszereltseg" class="chart-container" style="display: none;">
        <h3 style="color: #2c3e50; margin-bottom: 20px;">🔧 Termek felszereltsége</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div style="position: relative; width: 250px; height: 250px; margin: 0 auto;">
                    @php
                        $osszes = $teljesenFelszerelt + $reszbenFelszerelt + $nincsFelszereles;
                        $teljesSzazalek = $osszes > 0 ? ($teljesenFelszerelt / $osszes) * 100 : 0;
                        $reszbenSzazalek = $osszes > 0 ? ($reszbenFelszerelt / $osszes) * 100 : 0;
                        $nincsSzazalek = $osszes > 0 ? ($nincsFelszereles / $osszes) * 100 : 0;
                    @endphp
                    <svg viewBox="0 0 100 100" style="transform: rotate(-90deg);">
                        <!-- Teljesen felszerelt -->
                        <circle cx="50" cy="50" r="40" fill="none" stroke="#2ecc71" stroke-width="20" 
                                stroke-dasharray="{{ $teljesSzazalek * 2.51 }} 251.2" stroke-dashoffset="0"></circle>
                        <!-- Részben felszerelt -->
                        <circle cx="50" cy="50" r="40" fill="none" stroke="#f39c12" stroke-width="20" 
                                stroke-dasharray="{{ $reszbenSzazalek * 2.51 }} 251.2" 
                                stroke-dashoffset="-{{ $teljesSzazalek * 2.51 }}"></circle>
                        <!-- Nincs felszerelés -->
                        <circle cx="50" cy="50" r="40" fill="none" stroke="#e74c3c" stroke-width="20" 
                                stroke-dasharray="{{ $nincsSzazalek * 2.51 }} 251.2" 
                                stroke-dashoffset="-{{ ($teljesSzazalek + $reszbenSzazalek) * 2.51 }}"></circle>
                    </svg>
                </div>
            </div>
            
            <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; flex-direction: column; justify-content: center;">
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <div style="width: 20px; height: 20px; background: #2ecc71; border-radius: 3px; margin-right: 10px;"></div>
                        <span style="flex: 1;">Teljesen felszerelt (Projektor + TV)</span>
                        <strong>{{ $teljesenFelszerelt }} db ({{ round($teljesSzazalek, 1) }}%)</strong>
                    </div>
                </div>
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <div style="width: 20px; height: 20px; background: #f39c12; border-radius: 3px; margin-right: 10px;"></div>
                        <span style="flex: 1;">Részben felszerelt</span>
                        <strong>{{ $reszbenFelszerelt }} db ({{ round($reszbenSzazalek, 1) }}%)</strong>
                    </div>
                </div>
                <div>
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <div style="width: 20px; height: 20px; background: #e74c3c; border-radius: 3px; margin-right: 10px;"></div>
                        <span style="flex: 1;">Nincs felszerelés</span>
                        <strong>{{ $nincsFelszereles }} db ({{ round($nincsSzazalek, 1) }}%)</strong>
                    </div>
                </div>
                
                <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #ecf0f1;">
                    <div style="display: flex; justify-content: space-between;">
                        <span>📽️ Projektor:</span>
                        <strong>{{ $projektorDarab }} / {{ $osszesTermek }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                        <span>📺 TV:</span>
                        <strong>{{ $tvDarab }} / {{ $osszesTermek }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TV méretek diagram -->
    <div id="chart-tv" class="chart-container" style="display: none;">
        <h3 style="color: #2c3e50; margin-bottom: 20px;">📺 TV méretek terem szerint</h3>
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            @if($tvMeretek->count() > 0)
                @foreach($tvMeretek as $termek)
                    @php
                        $maxMeret = $tvMeretek->max('tv_meret');
                        $szazalek = ($termek->tv_meret / $maxMeret) * 100;
                        $szin = $termek->tv_meret >= 70 ? '#8e44ad' : ($termek->tv_meret >= 60 ? '#3498db' : '#1abc9c');
                    @endphp
                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span style="font-weight: bold;">Terem {{ $termek->tanterem }}</span>
                            <span style="color: #7f8c8d;">{{ $termek->tv_meret }} col</span>
                        </div>
                        <div style="background: #ecf0f1; border-radius: 10px; height: 25px; overflow: hidden;">
                            <div style="background: {{ $szin }}; height: 100%; width: {{ $szazalek }}%; transition: width 0.5s; border-radius: 10px;"></div>
                        </div>
                    </div>
                @endforeach
            @else
                <p style="text-align: center; color: #7f8c8d; padding: 40px;">Nincs TV-vel felszerelt terem.</p>
            @endif
        </div>
    </div>

    <style>
        .chart-btn {
            padding: 12px 24px;
            border: 2px solid #3498db;
            background: white;
            color: #3498db;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s;
        }
        .chart-btn:hover {
            background: #3498db;
            color: white;
            transform: translateY(-2px);
        }
        .chart-btn.active {
            background: #3498db;
            color: white;
        }
    </style>

    <script>
        function showChart(chartType) {
            // Összes diagram elrejtése
            document.querySelectorAll('.chart-container').forEach(el => {
                el.style.display = 'none';
            });
            
            // Összes gomb inaktiválása
            document.querySelectorAll('.chart-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Kiválasztott diagram megjelenítése
            document.getElementById('chart-' + chartType).style.display = 'block';
            document.getElementById('btn-' + chartType).classList.add('active');
        }
    </script>
@endsection