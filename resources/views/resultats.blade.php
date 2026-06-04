@extends('layouts.app')

@section('title', 'Mes Résultats — OrientaBac')

@section('styles')
<style>
    nav { background-color: #1E3A5F; height: 70px; display: flex; align-items: center; justify-content: space-between; padding: 0 60px; position: sticky; top: 0; z-index: 100; }
    nav .logo { color: white; font-size: 22px; font-weight: bold; letter-spacing: 1px; display: flex; align-items: center; gap: 8px; }
    .logo-flag { display: grid; grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr; width: 22px; height: 16px; border-radius: 2px; overflow: hidden; }
    .logo-flag .f1 { background-color: #008751; grid-column: 1; grid-row: 1 / 3; }
    .logo-flag .f2 { background-color: #FCD116; grid-column: 2; grid-row: 1; }
    .logo-flag .f3 { background-color: #E8112D; grid-column: 2; grid-row: 2; }
    nav .logo span { color: #FCD116; }
    nav ul { list-style: none; display: flex; gap: 30px; }
    nav ul li a { color: white; text-decoration: none; font-size: 15px; transition: color 0.2s; }
    nav ul li a:hover { color: #FCD116; }
    .nav-btn { background-color: #008751; color: white !important; padding: 8px 20px; border-radius: 6px; font-weight: bold !important; }
    .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
    .hamburger span { width: 25px; height: 3px; background-color: white; border-radius: 2px; }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background-color: #F4F6F9; color: #333; }

    /* ===== HERO VERT ===== */
    .hero-resultat {
        background: linear-gradient(135deg, #006b40 0%, #008751 100%);
        padding: 50px 80px;
        position: relative;
        overflow: hidden;
    }
    .hero-resultat::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 5px;
        background: linear-gradient(to right, #008751 33%, #FCD116 33% 66%, #E8112D 66%);
    }
    .hero-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 30px; flex-wrap: wrap; }
    .hero-title h1 { color: white; font-size: 32px; font-weight: bold; margin-bottom: 8px; }
    .hero-title p { color: rgba(255,255,255,0.8); font-size: 14px; max-width: 500px; }

    /* BADGE PROFIL */
    .profil-badge {
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 16px;
        padding: 24px 32px;
        text-align: center;
        flex-shrink: 0;
        min-width: 200px;
    }
    .profil-badge .serie-label { color: #FCD116; font-size: 12px; font-weight: bold; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 1px; }
    .profil-badge .score-big { color: white; font-size: 52px; font-weight: bold; line-height: 1; margin-bottom: 4px; }
    .profil-badge .score-sub { color: rgba(255,255,255,0.6); font-size: 12px; }
    .profil-badge .mention-badge {
        display: inline-block;
        margin-top: 10px;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        background: rgba(252,209,22,0.25);
        color: #FCD116;
    }

    /* STATS RAPIDES */
    .stats-rapides {
        display: flex;
        gap: 20px;
        margin-top: 30px;
        flex-wrap: wrap;
    }
    .stat-r {
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 14px 20px;
        text-align: center;
        flex: 1;
        min-width: 120px;
    }
    .stat-r h3 { color: white; font-size: 26px; font-weight: bold; }
    .stat-r p { color: rgba(255,255,255,0.7); font-size: 11px; margin-top: 2px; }
    .stat-r.vert h3 { color: #4cff9f; }
    .stat-r.jaune h3 { color: #FCD116; }
    .stat-r.rouge h3 { color: #ff6b6b; }

    /* ===== SECTION RESULTATS ===== */
    .section-resultats { padding: 40px 80px; }

    /* LEGENDE */
    .legende {
        display: flex;
        gap: 20px;
        align-items: center;
        flex-wrap: wrap;
        background: white;
        border-radius: 12px;
        padding: 16px 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 24px;
    }
    .legende-titre { font-size: 13px; font-weight: bold; color: #555; }
    .legende-item { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #555; }
    .legende-dot { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; }

    /* FILTRES */
    .filtres-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .filtre-btn {
        padding: 9px 20px;
        border-radius: 25px;
        border: 2px solid #ddd;
        background: white;
        font-size: 13px;
        font-weight: bold;
        color: #777;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .filtre-btn .count {
        background: #eee;
        color: #777;
        font-size: 11px;
        padding: 1px 7px;
        border-radius: 10px;
    }
    .filtre-btn.active-vert { border-color: #008751; color: #008751; background: rgba(0,135,81,0.08); }
    .filtre-btn.active-vert .count { background: rgba(0,135,81,0.15); color: #008751; }
    .filtre-btn.active-jaune { border-color: #c9a000; color: #c9a000; background: rgba(252,209,22,0.1); }
    .filtre-btn.active-jaune .count { background: rgba(252,209,22,0.2); color: #c9a000; }
    .filtre-btn.active-rouge { border-color: #E8112D; color: #E8112D; background: rgba(232,17,45,0.08); }
    .filtre-btn.active-rouge .count { background: rgba(232,17,45,0.1); color: #E8112D; }
    .filtre-btn.active-tous { border-color: #1E3A5F; color: #1E3A5F; background: rgba(30,58,95,0.06); }

    /* GRILLE RESULTATS */
    .resultats-grid { display: flex; flex-direction: column; gap: 14px; }

    /* CARTE RESULTAT */
    .result-card {
        background: white;
        border-radius: 14px;
        padding: 0;
        box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        display: flex;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .result-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.12); }

    /* BANDE GAUCHE COLOREE */
    .result-band {
        width: 8px;
        flex-shrink: 0;
        background: #008751;
    }
    .result-card.payant .result-band { background: #FCD116; }
    .result-card.non-admis .result-band { background: #E8112D; }

    .result-body {
        flex: 1;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    /* RANG */
    .result-rang {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(0,135,81,0.1);
        color: #008751;
        font-size: 18px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 2px solid rgba(0,135,81,0.2);
    }
    .result-card.payant .result-rang { background: rgba(252,209,22,0.15); color: #c9a000; border-color: rgba(252,209,22,0.3); }
    .result-card.non-admis .result-rang { background: rgba(232,17,45,0.08); color: #E8112D; border-color: rgba(232,17,45,0.15); }

    /* INFOS FILIERE */
    .result-info { flex: 1; }
    .result-filiere-nom { font-size: 17px; font-weight: bold; color: #1E3A5F; margin-bottom: 3px; }
    .result-etablissement { font-size: 13px; color: #888; margin-bottom: 10px; }
    .result-tags { display: flex; gap: 8px; flex-wrap: wrap; }
    .rtag { font-size: 11px; font-weight: bold; padding: 4px 12px; border-radius: 20px; }
    .rtag-diagnostic-boursier { background: rgba(0,135,81,0.12); color: #006b40; }
    .rtag-diagnostic-fpp { background: rgba(252,209,22,0.2); color: #c9a000; }
    .rtag-diagnostic-non { background: rgba(232,17,45,0.1); color: #c0001a; }
    .rtag-duree { background: #f0f0f0; color: #666; }
    .rtag-seuil { background: rgba(30,58,95,0.07); color: #1E3A5F; }

    /* SCORE */
    .result-score-bloc {
        text-align: center;
        padding: 12px 20px;
        background: #F8F9FA;
        border-radius: 10px;
        flex-shrink: 0;
        min-width: 100px;
    }
    .result-score-val { font-size: 30px; font-weight: bold; color: #008751; line-height: 1; }
    .result-card.payant .result-score-val { color: #c9a000; }
    .result-card.non-admis .result-score-val { color: #E8112D; }
    .result-score-label { font-size: 10px; color: #aaa; margin-top: 3px; text-transform: uppercase; letter-spacing: 0.5px; }

    /* BOUTON */
    .result-action { flex-shrink: 0; }
    .btn-details {
        padding: 10px 20px;
        background: #1E3A5F;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        display: block;
        text-align: center;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .btn-details:hover { background: #152c47; }

    /* EMPTY STATE */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .empty-state .empty-icon { font-size: 60px; margin-bottom: 16px; }
    .empty-state h3 { font-size: 20px; font-weight: bold; color: #1E3A5F; margin-bottom: 10px; }
    .empty-state p { font-size: 14px; color: #777; margin-bottom: 20px; }
    .empty-state a { color: #008751; font-weight: bold; text-decoration: none; }

    /* CTA SAVE */
    .cta-save {
        background: linear-gradient(135deg, #1E3A5F, #2d5f8a);
        border-radius: 16px;
        padding: 35px 40px;
        text-align: center;
        margin-top: 40px;
        position: relative;
        overflow: hidden;
    }
    .cta-save::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(to right, #008751 33%, #FCD116 33% 66%, #E8112D 66%);
    }
    .cta-save h3 { color: white; font-size: 20px; font-weight: bold; margin-bottom: 8px; }
    .cta-save p { color: rgba(255,255,255,0.7); font-size: 14px; margin-bottom: 24px; max-width: 500px; margin-left: auto; margin-right: auto; }
    .cta-save-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
    .btn-save { padding: 12px 28px; background: #008751; color: white; border: none; border-radius: 10px; font-size: 14px; font-weight: bold; text-decoration: none; transition: background 0.2s; }
    .btn-save:hover { background: #006b40; }
    .btn-retry { padding: 12px 28px; background: transparent; color: white; border: 2px solid rgba(255,255,255,0.4); border-radius: 10px; font-size: 14px; font-weight: bold; text-decoration: none; transition: all 0.2s; }
    .btn-retry:hover { background: rgba(255,255,255,0.1); }

    /* ===== FOOTER ===== */
    footer { background-color: #12253d; padding: 50px 80px 30px; }
    .footer-top-band {
      height: 8px;
      position: relative;
      margin-bottom: 40px;
      border-radius: 2px;
      overflow: hidden;
    }
    .footer-top-band::before {
      content: '';
      position: absolute;
      left: 0; top: 0;
      width: 33%; height: 100%;
      background-color: #008751;
    }
    .footer-top-band::after {
      content: '';
      position: absolute;
      left: 33%; top: 0;
      width: 67%; height: 50%;
      background-color: #FCD116;
      box-shadow: 0 4px 0 0 #E8112D;
    }
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
        .hero-resultat { padding: 30px 20px; }
        .hero-top { flex-direction: column; }
        .section-resultats { padding: 30px 20px; }
        .result-body { flex-wrap: wrap; gap: 14px; }
        .result-score-bloc { min-width: 80px; }
        footer { padding: 30px 20px; }
    }

    @media (max-width: 768px) {
      nav { padding: 0 20px; }
      nav ul { display: none; }
      .hamburger { display: flex; }
      .progress-section { padding: 20px; }
      .form-card { padding: 25px 20px; }
      .interets-grid { grid-template-columns: repeat(2, 1fr); }
      .form-actions { flex-direction: column; gap: 12px; }
      .btn-retour, .btn-suivant, .btn-soumettre { width: 100%; text-align: center; }
      footer { padding: 40px 20px 20px; }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 30px; }
    }
</style>
@endsection

@section('content')

  <!-- HERO -->
  <div class="hero-resultat">
    <div class="hero-top">
      <div class="hero-title">
        <h1>Tes recommandations personnalisées</h1>
        <p>Basées sur ta moyenne de classement MESRS, ta série et ta filière choisie. Consulte chaque filière pour voir les détails et simuler ton admissibilité.</p>

        <!-- STATS RAPIDES -->
        <div class="stats-rapides">
          @php
            $nbBoursier  = collect($resultats)->where('diagnostic', 'boursier')->count();
            $nbFpp       = collect($resultats)->where('diagnostic', 'fpp')->count();
            $nbNonAdmis  = collect($resultats)->where('diagnostic', 'non_admissible')->count();
          @endphp
          <div class="stat-r vert">
            <h3>{{ $nbBoursier }}</h3>
            <p>Boursier potentiel</p>
          </div>
          <div class="stat-r jaune">
            <h3>{{ $nbFpp }}</h3>
            <p>FPP disponible</p>
          </div>
          <div class="stat-r rouge">
            <h3>{{ $nbNonAdmis }}</h3>
            <p>Score insuffisant</p>
          </div>
          <div class="stat-r">
            <h3 style="color:white;">{{ count($resultats) }}</h3>
            <p>Total filières</p>
          </div>
        </div>
      </div>

      <!-- BADGE PROFIL -->
      <div class="profil-badge">
        <div class="serie-label">Série {{ $questionnaire['serie'] }}</div>
        <div class="score-big">{{ number_format($questionnaire['score'], 2) }}</div>
        <div class="score-sub">Moyenne de classement / 20</div>
        <div class="mention-badge">Mention {{ $questionnaire['mention'] }}</div>
      </div>
    </div>
  </div>

  <!-- SECTION RESULTATS -->
  <section class="section-resultats">

    <!-- LEGENDE -->
    <div class="legende">
      <span class="legende-titre">Légende :</span>
      <div class="legende-item">
        <div class="legende-dot" style="background:#008751;"></div>
        Boursier potentiel — Moyenne ≥ seuil bourse
      </div>
      <div class="legende-item">
        <div class="legende-dot" style="background:#FCD116;"></div>
        FPP (partiellement payant) — Moyenne ≥ seuil FPP
      </div>
      <div class="legende-item">
        <div class="legende-dot" style="background:#E8112D;"></div>
        Non admissible — Moyenne insuffisante
      </div>
    </div>

    <!-- FILTRES -->
    <div class="filtres-bar">
      <button class="filtre-btn active-tous" onclick="filtrer('tous', this)">
        Tout afficher <span class="count">{{ count($resultats) }}</span>
      </button>
      <button class="filtre-btn" onclick="filtrer('boursier', this)">
        Boursier <span class="count">{{ $nbBoursier }}</span>
      </button>
      <button class="filtre-btn" onclick="filtrer('fpp', this)">
        FPP <span class="count">{{ $nbFpp }}</span>
      </button>
      <button class="filtre-btn" onclick="filtrer('non_admis', this)">
        Non admis <span class="count">{{ $nbNonAdmis }}</span>
      </button>
    </div>

    <!-- GRILLE RESULTATS -->
    <div class="resultats-grid" id="resultatsGrid">
      @forelse($resultats as $index => $item)
        @php
          $diagnostic = $item['diagnostic'];
          $cardClass  = $diagnostic === 'fpp' ? 'payant' : ($diagnostic === 'non_admissible' ? 'non-admis' : '');
        @endphp

        <div class="result-card {{ $cardClass }}" data-diagnostic="{{ $diagnostic }}">
          <div class="result-band"></div>
          <div class="result-body">

            <!-- RANG -->
            <div class="result-rang">{{ $index + 1 }}</div>

            <!-- INFOS -->
            <div class="result-info">
              <div class="result-filiere-nom">{{ $item['filiere']->nom }}</div>
              <div class="result-etablissement">
                {{ $item['filiere']->campus->first()?->nom ?? 'N/A' }}
                — {{ $item['filiere']->campus->first()?->universite?->nom ?? '' }}
              </div>
              <div class="result-tags">
                @if($diagnostic === 'boursier')
                  <span class="rtag rtag-diagnostic-boursier">Boursier potentiel</span>
                @elseif($diagnostic === 'fpp')
                  <span class="rtag rtag-diagnostic-fpp">FPP disponible</span>
                @else
                  <span class="rtag rtag-diagnostic-non">Score insuffisant</span>
                @endif
                <span class="rtag rtag-duree">⏱ {{ $item['filiere']->duree_annees }} ans</span>
                <span class="rtag rtag-seuil">
                  Seuil bourse : {{ $item['seuil_bourse'] }}/20
                </span>
                <span class="rtag rtag-seuil">
                  Seuil FPP : {{ $item['seuil_fpp'] }}/20
                </span>
              </div>
            </div>

            <!-- SCORE -->
            <div class="result-score-bloc">
              <div class="result-score-val">{{ number_format($item['moyenne'], 2) }}</div>
              <div class="result-score-label">Ton score</div>
            </div>

            <!-- BOUTON -->
            <div class="result-action">
              <a href="{{ route('filieres.show', $item['filiere']->id_filiere) }}"
                 class="btn-details">
                Voir les détails
              </a>
            </div>

          </div>
        </div>
      @empty
        <div class="empty-state">
          <div class="empty-icon"></div>
          <h3>Aucune filière trouvée</h3>
          <p>Aucune filière ne correspond à ta série pour l'instant.<br>La base de données est en cours d'alimentation.</p>
          <a href="{{ route('questionnaire') }}">← Refaire le questionnaire</a>
        </div>
      @endforelse
    </div>

    <!-- CTA SAVE -->
    <div class="cta-save">
      <h3>Sauvegarde tes résultats</h3>
      <p>Crée un compte gratuit pour retrouver tes recommandations à tout moment et les partager avec tes parents ou conseillers.</p>
      <div class="cta-save-btns">
        <a href="{{ route('register') }}" class="btn-save">Créer un compte gratuit</a>
        <a href="{{ route('questionnaire') }}" class="btn-retry">Refaire le questionnaire</a>
      </div>
    </div>

  </section>

@endsection

@section('scripts')
<script>
  const activeClasses = {
    'tous': 'active-tous',
    'boursier': 'active-vert',
    'fpp': 'active-jaune',
    'non_admis': 'active-rouge'
  };

  function filtrer(type, btn) {
    // Réinitialiser tous les boutons
    document.querySelectorAll('.filtre-btn').forEach(b => {
      b.className = 'filtre-btn';
      // Remettre le count en style neutre
      const count = b.querySelector('.count');
      if (count) { count.style.background = '#eee'; count.style.color = '#777'; }
    });

    // Activer le bouton cliqué
    btn.classList.add(activeClasses[type]);

    // Filtrer les cartes
    document.querySelectorAll('.result-card').forEach(card => {
      if (type === 'tous') {
        card.style.display = 'flex';
      } else if (type === 'boursier') {
        card.style.display = card.dataset.diagnostic === 'boursier' ? 'flex' : 'none';
      } else if (type === 'fpp') {
        card.style.display = card.dataset.diagnostic === 'fpp' ? 'flex' : 'none';
      } else if (type === 'non_admis') {
        card.style.display = card.dataset.diagnostic === 'non_admissible' ? 'flex' : 'none';
      }
    });
  }
</script>
@endsection