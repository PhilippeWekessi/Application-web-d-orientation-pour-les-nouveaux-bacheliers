@extends('layouts.app')

@section('title', 'Universités — OrientaBac')

@section('styles')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background-color: #F4F6F9; color: #333; }

    .drapeau-bande { height: 8px; position: relative; display: flex; }
    .drapeau-bande::before { content: ''; position: absolute; left: 0; top: 0; width: 33%; height: 100%; background-color: #008751; }
    .drapeau-bande::after { content: ''; position: absolute; left: 33%; top: 0; width: 67%; height: 50%; background-color: #FCD116; box-shadow: 0 4px 0 0 #E8112D; }

    nav { background-color: #1E3A5F; height: 70px; display: flex; align-items: center; justify-content: space-between; padding: 0 60px; position: sticky; top: 0; z-index: 100; }
    nav .logo { color: white; font-size: 22px; font-weight: bold; display: flex; align-items: center; gap: 8px; }
    .logo-flag { display: grid; grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr; width: 22px; height: 16px; border-radius: 2px; overflow: hidden; }
    .logo-flag .f1 { background-color: #008751; grid-column: 1; grid-row: 1 / 3; }
    .logo-flag .f2 { background-color: #FCD116; grid-column: 2; grid-row: 1; }
    .logo-flag .f3 { background-color: #E8112D; grid-column: 2; grid-row: 2; }
    nav .logo span { color: #FCD116; }
    nav ul { list-style: none; display: flex; gap: 30px; }
    nav ul li a { color: white; text-decoration: none; font-size: 15px; transition: color 0.2s; }
    nav ul li a:hover { color: #FCD116; }
    nav ul li a.active { color: #FCD116; font-weight: bold; }
    .nav-btn { background-color: #008751; color: white !important; padding: 8px 20px; border-radius: 6px; font-weight: bold !important; }
    .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
    .hamburger span { width: 25px; height: 3px; background-color: white; border-radius: 2px; }

    .hero { background: linear-gradient(135deg, #1E3A5F 0%, #2d5f8a 100%); padding: 50px 80px; position: relative; overflow: hidden; }
    .hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 5px; background: linear-gradient(to right, #008751 33%, #FCD116 33% 66%, #E8112D 66%); }
    .hero h1 { color: white; font-size: 34px; font-weight: bold; margin-bottom: 10px; }
    .hero p { color: rgba(255,255,255,0.8); font-size: 15px; margin-bottom: 30px; max-width: 600px; }
    .search-bar { display: flex; gap: 12px; max-width: 600px; }
    .search-bar input { flex: 1; padding: 14px 18px; border: none; border-radius: 10px; font-size: 15px; outline: none; }
    .search-bar button { padding: 14px 28px; background-color: #008751; color: white; border: none; border-radius: 10px; font-size: 15px; font-weight: bold; cursor: pointer; }
    .search-bar button:hover { background-color: #006b40; }

    .stats-bar { background: white; padding: 20px 80px; display: flex; gap: 40px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); flex-wrap: wrap; }
    .stat-item { text-align: center; }
    .stat-item h3 { font-size: 26px; font-weight: bold; color: #008751; }
    .stat-item p { font-size: 12px; color: #777; }

    .filtres-bar { padding: 20px 80px; display: flex; gap: 12px; flex-wrap: wrap; background: white; border-bottom: 1px solid #eee; }
    .filtre-btn { padding: 8px 18px; border-radius: 20px; border: 2px solid #ddd; background: white; font-size: 13px; font-weight: bold; color: #777; cursor: pointer; transition: all 0.2s; text-decoration: none; }
    .filtre-btn.active, .filtre-btn:hover { border-color: #008751; color: #008751; background-color: rgba(0,135,81,0.08); }
    .filtre-btn.yellow.active, .filtre-btn.yellow:hover { border-color: #c9a000; color: #c9a000; background-color: rgba(252,209,22,0.1); }

    .main { padding: 40px 80px; }

    .unis-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 40px; }
    .uni-card { background: white; border-radius: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); overflow: hidden; transition: transform 0.2s; cursor: pointer; }
    .uni-card:hover { transform: translateY(-5px); }
    .uni-card-top { height: 100px; display: flex; align-items: center; justify-content: center; font-size: 50px; position: relative; }
    .uni-card:nth-child(3n+1) .uni-card-top { background: linear-gradient(135deg, #1E3A5F, #2d5f8a); }
    .uni-card:nth-child(3n+2) .uni-card-top { background: linear-gradient(135deg, #006b40, #008751); }
    .uni-card:nth-child(3n+3) .uni-card-top { background: linear-gradient(135deg, #c9a000, #FCD116); }
    .uni-type-badge { position: absolute; top: 10px; right: 10px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; }
    .badge-public { background-color: rgba(0,135,81,0.15); color: #008751; }
    .badge-prive { background-color: rgba(232,17,45,0.1); color: #E8112D; }
    .badge-agree { background-color: rgba(252,209,22,0.2); color: #c9a000; }
    .uni-card-body { padding: 20px; }
    .uni-sigle { font-size: 13px; font-weight: bold; color: #008751; margin-bottom: 4px; }
    .uni-nom { font-size: 15px; font-weight: bold; color: #1E3A5F; margin-bottom: 8px; line-height: 1.4; }
    .uni-ville { font-size: 13px; color: #777; margin-bottom: 12px; display: flex; align-items: center; gap: 5px; }
    .uni-stats { display: flex; gap: 16px; margin-bottom: 14px; }
    .uni-stat { text-align: center; }
    .uni-stat h4 { font-size: 18px; font-weight: bold; color: #1E3A5F; }
    .uni-stat p { font-size: 11px; color: #999; }
    .uni-tags { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 14px; }
    .uni-tag { font-size: 11px; padding: 3px 10px; border-radius: 20px; background-color: rgba(30,58,95,0.08); color: #1E3A5F; font-weight: bold; }
    .btn-voir-uni { width: 100%; padding: 10px; background-color: #1E3A5F; color: white; border: none; border-radius: 8px; font-size: 13px; font-weight: bold; cursor: pointer; text-align: center; text-decoration: none; display: block; transition: background-color 0.2s; }
    .btn-voir-uni:hover { background-color: #152c47; }

    .pagination { display: flex; justify-content: center; gap: 10px; margin-top: 20px; }
    .pagination a { padding: 8px 16px; border-radius: 6px; background-color: white; color: #1E3A5F; font-size: 14px; text-decoration: none; border: 1px solid #ddd; transition: all 0.2s; }
    .pagination a.active, .pagination a:hover { background-color: #008751; color: white; border-color: #008751; }

    footer { background-color: #12253d; padding: 50px 80px 30px; margin-top: 40px; }
    .footer-top-band { height: 8px; position: relative; margin-bottom: 40px; border-radius: 2px; overflow: hidden; }
    .footer-top-band::before { content: ''; position: absolute; left: 0; top: 0; width: 33%; height: 100%; background-color: #008751; }
    .footer-top-band::after { content: ''; position: absolute; left: 33%; top: 0; width: 67%; height: 50%; background-color: #FCD116; box-shadow: 0 4px 0 0 #E8112D; }
    .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 40px; }
    .footer-brand .logo { color: white; font-size: 20px; font-weight: bold; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
    .footer-brand .logo span { color: #FCD116; }
    .footer-brand p { color: rgba(255,255,255,0.5); font-size: 13px; line-height: 1.7; }
    .footer-col h4 { color: white; font-size: 14px; font-weight: bold; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 2px solid #008751; display: inline-block; }
    .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
    .footer-col ul li a { color: rgba(255,255,255,0.5); text-decoration: none; font-size: 13px; transition: color 0.2s; }
    .footer-col ul li a:hover { color: #FCD116; }
    .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 25px; text-align: center; }
    .footer-bottom p { color: rgba(255,255,255,0.4); font-size: 12px; }

    @media (max-width: 768px) {
      nav { padding: 0 20px; }
      nav ul { display: none; }
      .hamburger { display: flex; }
      .hero { padding: 30px 20px; }
      .stats-bar { padding: 20px; gap: 20px; }
      .filtres-bar { padding: 15px 20px; }
      .main { padding: 30px 20px; }
      .unis-grid { grid-template-columns: 1fr; }
      footer { padding: 40px 20px 20px; }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 30px; }
    }
</style>
@endsection

@section('content')

  <!-- HERO -->
  <div class="hero">
    <h1>🏛️ Universités & Établissements</h1>
    <p>Explore toutes les institutions d'enseignement supérieur disponibles au Bénin</p>
    <form method="GET" action="{{ route('universites.index') }}">
      <div class="search-bar">
        <input type="text" name="search" placeholder="Rechercher une université, une école..."
               value="{{ request('search') }}" />
        <button type="submit">Rechercher</button>
      </div>
    </form>
  </div>

  <!-- STATS -->
  <div class="stats-bar">
    <div class="stat-item"><h3>{{ $totalUniversites }}</h3><p>Établissements</p></div>
    <div class="stat-item"><h3>{{ $totalPublics }}</h3><p>Universités publiques</p></div>
    <div class="stat-item"><h3>{{ $totalFilieres }}</h3><p>Filières disponibles</p></div>
    <div class="stat-item"><h3>{{ $totalVilles }}</h3><p>Villes universitaires</p></div>
  </div>

  <!-- FILTRES -->
  <div class="filtres-bar">
    <a href="{{ route('universites.index', request()->except('type', 'ville')) }}"
       class="filtre-btn {{ !request('type') && !request('ville') ? 'active' : '' }}">Tous</a>
    <a href="{{ route('universites.index', array_merge(request()->query(), ['type' => 'public'])) }}"
       class="filtre-btn {{ request('type') == 'public' ? 'active' : '' }}">🟢 Public</a>
    <a href="{{ route('universites.index', array_merge(request()->query(), ['type' => 'prive'])) }}"
       class="filtre-btn yellow {{ request('type') == 'prive' ? 'active' : '' }}">🟡 Privé agréé</a>
  </div>

  <!-- MAIN -->
  <div class="main">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
      <h2 style="font-size:20px; font-weight:bold; color:#1E3A5F;">
        Résultats <span style="font-size:14px; color:#999; font-weight:normal;">— {{ $universites->total() }} établissements</span>
      </h2>
      <select onchange="window.location='{{ route('universites.index') }}?sort='+this.value+'&search={{ request('search') }}'"
              style="padding:8px 14px; border:1.5px solid #ddd; border-radius:8px; font-size:13px; outline:none; color:#555;">
        <option value="pertinence" {{ request('sort') == 'pertinence' ? 'selected' : '' }}>Trier par : Alphabétique</option>
      </select>
    </div>

    <div class="unis-grid">
      @forelse($universites as $universite)
        <div class="uni-card" onclick="window.location='{{ route('universites.show', $universite->id_universite) }}'">
          <div class="uni-card-top">
            🏛️
            <span class="uni-type-badge {{ $universite->type == 'public' ? 'badge-public' : 'badge-agree' }}">
              {{ $universite->type == 'public' ? 'Public' : 'Agréé' }}
            </span>
          </div>
          <div class="uni-card-body">
            <div class="uni-sigle">{{ $universite->sigle }}</div>
            <div class="uni-nom">{{ $universite->nom }}</div>
            <div class="uni-ville">📍 {{ $universite->ville }}</div>
            <div class="uni-stats">
              <div class="uni-stat">
                <h4>{{ $universite->campus->count() }}</h4>
                <p>Établissements</p>
              </div>
              <div class="uni-stat">
                <h4>{{ $universite->campus->sum(fn($c) => $c->filieres->count()) }}+</h4>
                <p>Filières</p>
              </div>
            </div>
            <div class="uni-tags">
              @foreach($universite->campus->take(1) as $campus)
                @foreach($campus->filieres->take(3) as $filiere)
                  <span class="uni-tag">{{ Str::limit($filiere->nom, 15) }}</span>
                @endforeach
              @endforeach
            </div>
            <a href="{{ route('universites.show', $universite->id_universite) }}" class="btn-voir-uni">
              Voir les filières →
            </a>
          </div>
        </div>
      @empty
        <div style="grid-column: 1/-1; text-align:center; padding:40px; color:#777;">
          <p>Aucune université trouvée.</p>
          <a href="{{ route('universites.index') }}" style="color:#008751;">Réinitialiser</a>
        </div>
      @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="pagination">
      {{ $universites->appends(request()->query())->links('vendor.pagination.custom') }}
    </div>

  </div>
@endsection