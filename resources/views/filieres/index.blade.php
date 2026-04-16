@extends('layouts.app')

@section('title', 'Filières — OrientaBac')

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

    /* HERO */
    .hero { background: linear-gradient(135deg, #1E3A5F 0%, #2d5f8a 100%); padding: 50px 80px; position: relative; overflow: hidden; }
    .hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 5px; background: linear-gradient(to right, #008751 33%, #FCD116 33% 66%, #E8112D 66%); }
    .hero h1 { color: white; font-size: 34px; font-weight: bold; margin-bottom: 10px; }
    .hero p { color: rgba(255,255,255,0.8); font-size: 15px; margin-bottom: 30px; }
    .search-bar { display: flex; gap: 12px; max-width: 700px; }
    .search-bar input { flex: 1; padding: 14px 18px; border: none; border-radius: 10px; font-size: 15px; outline: none; }
    .search-bar button { padding: 14px 28px; background-color: #008751; color: white; border: none; border-radius: 10px; font-size: 15px; font-weight: bold; cursor: pointer; }
    .search-bar button:hover { background-color: #006b40; }

    /* LAYOUT */
    .main-content { display: grid; grid-template-columns: 280px 1fr; gap: 30px; padding: 40px 80px; }

    /* SIDEBAR FILTRES */
    .sidebar { display: flex; flex-direction: column; gap: 20px; }
    .filter-card { background: white; border-radius: 12px; padding: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
    .filter-card h3 { font-size: 14px; font-weight: bold; color: #1E3A5F; margin-bottom: 14px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0; }
    .filter-group { display: flex; flex-direction: column; gap: 8px; }
    .filter-item { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #555; cursor: pointer; }
    .filter-item input[type="checkbox"] { accent-color: #008751; width: 15px; height: 15px; }
    .filter-item:hover { color: #008751; }
    .filter-select { width: 100%; padding: 10px 12px; border: 1.5px solid #ddd; border-radius: 8px; font-size: 13px; color: #555; outline: none; }
    .filter-select:focus { border-color: #008751; }
    .btn-reset { width: 100%; padding: 10px; background: transparent; border: 2px solid #E8112D; color: #E8112D; border-radius: 8px; font-size: 13px; font-weight: bold; cursor: pointer; transition: all 0.2s; margin-top: 5px; text-decoration: none; display: block; text-align: center; }
    .btn-reset:hover { background-color: #E8112D; color: white; }

    /* LISTE */
    .filieres-section { display: flex; flex-direction: column; gap: 20px; }
    .filieres-top { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
    .filieres-top h2 { font-size: 20px; font-weight: bold; color: #1E3A5F; }
    .filieres-count { font-size: 13px; color: #777; }
    .sort-bar { display: flex; gap: 10px; align-items: center; }
    .sort-bar label { font-size: 13px; color: #777; }
    .sort-bar select { padding: 8px 12px; border: 1.5px solid #ddd; border-radius: 8px; font-size: 13px; outline: none; }

    .filieres-list { display: flex; flex-direction: column; gap: 14px; }
    .filiere-item { background: white; border-radius: 12px; padding: 22px 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 18px; transition: transform 0.2s; border-left: 4px solid #008751; cursor: pointer; }
    .filiere-item:hover { transform: translateX(4px); }
    .filiere-item:nth-child(3n+2) { border-left-color: #FCD116; }
    .filiere-item:nth-child(3n+3) { border-left-color: #E8112D; }
    .filiere-icon { font-size: 32px; flex-shrink: 0; }
    .filiere-info { flex: 1; }
    .filiere-nom { font-size: 16px; font-weight: bold; color: #1E3A5F; margin-bottom: 4px; }
    .filiere-uni { font-size: 13px; color: #777; margin-bottom: 8px; }
    .filiere-tags { display: flex; gap: 8px; flex-wrap: wrap; }
    .tag { font-size: 11px; font-weight: bold; padding: 3px 10px; border-radius: 20px; }
    .tag-serie { background-color: rgba(30,58,95,0.08); color: #1E3A5F; }
    .tag-mode { background-color: rgba(0,135,81,0.1); color: #008751; }
    .tag-duree { background-color: #f0f0f0; color: #666; }
    .tag-bourse { background-color: rgba(252,209,22,0.2); color: #c9a000; }
    .filiere-actions { display: flex; flex-direction: column; gap: 8px; flex-shrink: 0; }
    .btn-detail { padding: 9px 18px; background-color: #1E3A5F; color: white; border: none; border-radius: 8px; font-size: 13px; font-weight: bold; cursor: pointer; text-decoration: none; text-align: center; transition: background-color 0.2s; }
    .btn-detail:hover { background-color: #152c47; }

    /* EMPTY STATE */
    .empty-state { text-align: center; padding: 60px 20px; color: #777; }
    .empty-state h3 { font-size: 18px; margin-bottom: 10px; color: #1E3A5F; }

    /* PAGINATION */
    .pagination { display: flex; justify-content: center; gap: 10px; margin-top: 30px; }
    .pagination a { padding: 8px 16px; border-radius: 6px; background-color: white; color: #1E3A5F; font-size: 14px; text-decoration: none; border: 1px solid #ddd; transition: all 0.2s; }
    .pagination a.active, .pagination a:hover { background-color: #008751; color: white; border-color: #008751; }

    footer { background-color: #12253d; padding: 50px 80px 30px; }
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
      .main-content { grid-template-columns: 1fr; padding: 20px; }
      .search-bar { flex-direction: column; }
      footer { padding: 30px 20px; }
    }
</style>
@endsection

@section('content')

  <!-- HERO -->
  <div class="hero">
    <h1>🔍 Rechercher une filière</h1>
    <p>Explore toutes les formations disponibles dans les universités publiques et privées du Bénin</p>
    <form method="GET" action="{{ route('filieres.index') }}">
      <div class="search-bar">
        <input type="text" name="search" placeholder="Ex: Génie Logiciel, Médecine, Droit..."
               value="{{ request('search') }}" />
        <button type="submit">Rechercher</button>
      </div>
    </form>
  </div>

  <div class="main-content">

    <!-- SIDEBAR FILTRES -->
    <form method="GET" action="{{ route('filieres.index') }}" id="filter-form">
      <input type="hidden" name="search" value="{{ request('search') }}">
      <div class="sidebar">

        <div class="filter-card">
          <h3>🎓 Série du bac</h3>
          <div class="filter-group">
            @foreach($series as $serie)
              <label class="filter-item">
                <input type="checkbox" name="series[]" value="{{ $serie->id_serie }}"
                  {{ in_array($serie->id_serie, request('series', [])) ? 'checked' : '' }}
                  onchange="document.getElementById('filter-form').submit()" />
                Série {{ $serie->code }} — {{ Str::limit($serie->libelle, 25) }}
              </label>
            @endforeach
          </div>
        </div>

        <div class="filter-card">
          <h3>🏛️ Université</h3>
          <select class="filter-select" name="universite"
                  onchange="document.getElementById('filter-form').submit()">
            <option value="">Toutes les universités</option>
            @foreach($universites as $universite)
              <option value="{{ $universite->id_universite }}"
                {{ request('universite') == $universite->id_universite ? 'selected' : '' }}>
                {{ $universite->sigle }} — {{ $universite->ville }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="filter-card">
          <h3>📋 Mode d'entrée</h3>
          <div class="filter-group">
            @foreach(['classement' => 'Classement', 'concours' => 'Concours', 'direct' => 'Direct'] as $val => $label)
              <label class="filter-item">
                <input type="checkbox" name="mode[]" value="{{ $val }}"
                  {{ in_array($val, request('mode', [])) ? 'checked' : '' }}
                  onchange="document.getElementById('filter-form').submit()" />
                {{ $label }}
              </label>
            @endforeach
          </div>
        </div>

        <div class="filter-card">
          <h3>⏱ Durée</h3>
          <div class="filter-group">
            @foreach([3 => '3 ans (Licence)', 5 => '5 ans (Master)', 7 => '7 ans et plus'] as $val => $label)
              <label class="filter-item">
                <input type="checkbox" name="duree[]" value="{{ $val }}"
                  {{ in_array($val, request('duree', [])) ? 'checked' : '' }}
                  onchange="document.getElementById('filter-form').submit()" />
                {{ $label }}
              </label>
            @endforeach
          </div>
        </div>

        <div class="filter-card">
          <h3>💰 Allocation</h3>
          <div class="filter-group">
            <label class="filter-item">
              <input type="checkbox" name="bourse" value="1"
                {{ request('bourse') ? 'checked' : '' }}
                onchange="document.getElementById('filter-form').submit()" />
              Bourse disponible
            </label>
            <label class="filter-item">
              <input type="checkbox" name="fpp" value="1"
                {{ request('fpp') ? 'checked' : '' }}
                onchange="document.getElementById('filter-form').submit()" />
              FPP disponible
            </label>
          </div>
          <a href="{{ route('filieres.index') }}" class="btn-reset">Réinitialiser</a>
        </div>

      </div>
    </form>

    <!-- LISTE -->
    <div class="filieres-section">
      <div class="filieres-top">
        <div>
          <h2>Résultats</h2>
          <span class="filieres-count">{{ $filieres->total() }} filières trouvées</span>
        </div>
        <div class="sort-bar">
          <label>Trier par :</label>
          <select onchange="window.location='{{ route('filieres.index') }}?sort='+this.value+'&search={{ request('search') }}'">
            <option value="alpha" {{ request('sort') == 'alpha' ? 'selected' : '' }}>Alphabétique</option>
            <option value="bourse" {{ request('sort') == 'bourse' ? 'selected' : '' }}>Quota bourse ↓</option>
            <option value="duree" {{ request('sort') == 'duree' ? 'selected' : '' }}>Durée</option>
          </select>
        </div>
      </div>

      <div class="filieres-list">
        @forelse($filieres as $filiere)
          <div class="filiere-item"
               onclick="window.location='{{ route('filieres.show', $filiere->id_filiere) }}'">
            <div class="filiere-icon">🎓</div>
            <div class="filiere-info">
              <div class="filiere-nom">{{ $filiere->nom }}</div>
              <div class="filiere-uni">
                🏛️ {{ $filiere->campus->first()?->nom ?? 'N/A' }} —
                {{ $filiere->campus->first()?->universite?->sigle ?? '' }}
              </div>
              <div class="filiere-tags">
                <span class="tag tag-serie">
                  {{ $filiere->series->pluck('code')->implode(', ') ?: 'Toutes séries' }}
                </span>
                <span class="tag tag-mode">{{ ucfirst($filiere->mode_entree) }}</span>
                <span class="tag tag-duree">{{ $filiere->duree_annees }} ans</span>
                @if($filiere->quota_bourse > 0)
                  <span class="tag tag-bourse">{{ $filiere->quota_bourse }} bourses</span>
                @endif
              </div>
            </div>
            <div class="filiere-actions">
              <a href="{{ route('filieres.show', $filiere->id_filiere) }}" class="btn-detail"
                 onclick="event.stopPropagation()">
                Détails
              </a>
            </div>
          </div>
        @empty
          <div class="empty-state">
            <h3>😕 Aucune filière trouvée</h3>
            <p>Essayez d'autres critères de recherche.</p>
            <a href="{{ route('filieres.index') }}" style="color:#008751;font-weight:bold;">
              Réinitialiser la recherche
            </a>
          </div>
        @endforelse
      </div>

      <!-- PAGINATION -->
      <div class="pagination">
        {{ $filieres->appends(request()->query())->links('vendor.pagination.custom') }}
      </div>

    </div>
  </div>

@endsection