@extends('layouts.app')

@section('title', $filiere->nom . ' — OrientaBac')

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
    .nav-btn { background-color: #008751; color: white !important; padding: 8px 20px; border-radius: 6px; font-weight: bold !important; }
    .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
    .hamburger span { width: 25px; height: 3px; background-color: white; border-radius: 2px; }

    .breadcrumb { padding: 14px 80px; background: white; border-bottom: 1px solid #eee; font-size: 13px; color: #777; }
    .breadcrumb a { color: #008751; text-decoration: none; }
    .breadcrumb span { margin: 0 6px; }

    .hero-fiche { background: linear-gradient(135deg, #1E3A5F 0%, #2d5f8a 100%); padding: 50px 80px; display: flex; align-items: flex-start; justify-content: space-between; gap: 30px; position: relative; overflow: hidden; }
    .hero-fiche::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 5px; background: linear-gradient(to right, #008751 33%, #FCD116 33% 66%, #E8112D 66%); }
    .hero-fiche-left { flex: 1; }
    .hero-fiche-icon { font-size: 50px; margin-bottom: 16px; }
    .hero-fiche h1 { color: white; font-size: 34px; font-weight: bold; margin-bottom: 8px; }
    .hero-fiche-uni { color: rgba(255,255,255,0.75); font-size: 15px; margin-bottom: 18px; }
    .hero-tags { display: flex; gap: 10px; flex-wrap: wrap; }
    .htag { padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: bold; }
    .htag-green { background-color: rgba(0,135,81,0.3); color: #4cff9f; }
    .htag-yellow { background-color: rgba(252,209,22,0.2); color: #FCD116; }
    .htag-white { background-color: rgba(255,255,255,0.15); color: white; }
    .hero-fiche-right { display: flex; flex-direction: column; gap: 12px; flex-shrink: 0; }
    .btn-simuler { padding: 13px 28px; background-color: #FCD116; color: #1E3A5F; border: none; border-radius: 10px; font-size: 15px; font-weight: bold; cursor: pointer; transition: background-color 0.2s; text-decoration: none; display: block; text-align: center; }
    .btn-simuler:hover { background-color: #e6be00; }

    .fiche-content { display: grid; grid-template-columns: 1fr 340px; gap: 30px; padding: 40px 80px; }
    .fiche-main { display: flex; flex-direction: column; gap: 24px; }

    .info-card { background: white; border-radius: 12px; padding: 28px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
    .info-card h2 { font-size: 18px; font-weight: bold; color: #1E3A5F; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 2px solid #f0f0f0; display: flex; align-items: center; gap: 8px; }
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .info-item label { font-size: 12px; font-weight: bold; color: #999; text-transform: uppercase; display: block; margin-bottom: 4px; }
    .info-item span { font-size: 15px; font-weight: bold; color: #1E3A5F; }
    .desc-text { font-size: 14px; color: #555; line-height: 1.8; }

    .matieres-list { display: flex; flex-direction: column; gap: 10px; }
    .matiere-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background-color: #F4F6F9; border-radius: 8px; }
    .matiere-nom { font-size: 14px; font-weight: bold; color: #333; }
    .matiere-coef { background-color: #1E3A5F; color: white; font-size: 12px; font-weight: bold; padding: 3px 10px; border-radius: 20px; }
    .formule-display { margin-top: 16px; padding: 14px; background: #F4F6F9; border-radius: 8px; font-size: 13px; color: #555; }

    .debouches-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .debouche-item { padding: 12px 16px; background-color: rgba(0,135,81,0.07); border-left: 3px solid #008751; border-radius: 0 8px 8px 0; font-size: 13px; color: #333; }

    .series-list { display: flex; flex-wrap: wrap; gap: 8px; }
    .serie-badge { padding: 6px 14px; background-color: rgba(30,58,95,0.08); color: #1E3A5F; border-radius: 20px; font-size: 13px; font-weight: bold; }

    .fiche-sidebar { display: flex; flex-direction: column; gap: 20px; }
    .quota-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
    .quota-card h3 { font-size: 15px; font-weight: bold; color: #1E3A5F; margin-bottom: 16px; }
    .quota-item { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
    .quota-item:last-child { border-bottom: none; }
    .quota-label { font-size: 13px; color: #555; }
    .quota-val { font-size: 18px; font-weight: bold; color: #008751; }
    .quota-val.yellow { color: #c9a000; }

    .campus-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
    .campus-card h3 { font-size: 15px; font-weight: bold; color: #1E3A5F; margin-bottom: 14px; }
    .campus-item { display: flex; align-items: flex-start; gap: 10px; padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
    .campus-item:last-child { border-bottom: none; }
    .campus-nom { font-size: 13px; font-weight: bold; color: #1E3A5F; }
    .campus-ville { font-size: 12px; color: #999; }

    .sim-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
    .sim-card h3 { font-size: 15px; font-weight: bold; color: #1E3A5F; margin-bottom: 8px; }
    .sim-card p { font-size: 13px; color: #777; margin-bottom: 16px; }
    .sim-input-group { display: flex; flex-direction: column; gap: 10px; }
    .sim-input-group label { font-size: 12px; font-weight: bold; color: #555; display: block; margin-bottom: 4px; }
    .sim-input-group input { width: 100%; padding: 10px; border: 1.5px solid #ddd; border-radius: 8px; font-size: 14px; outline: none; transition: border-color 0.2s; }
    .sim-input-group input:focus { border-color: #008751; }
    .btn-calculer { width: 100%; padding: 12px; background-color: #008751; color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: bold; cursor: pointer; margin-top: 10px; transition: background-color 0.2s; }
    .btn-calculer:hover { background-color: #006b40; }
    .resultat-sim { display: none; padding: 14px; border-radius: 8px; text-align: center; font-weight: bold; font-size: 14px; margin-top: 10px; }

    .tem-list { display: flex; flex-direction: column; gap: 14px; }
    .tem-item { background: #F4F6F9; border-radius: 10px; padding: 16px; border-left: 3px solid #008751; }
    .tem-stars { color: #FCD116; font-size: 13px; margin-bottom: 6px; }
    .tem-text { font-size: 13px; color: #555; font-style: italic; line-height: 1.6; margin-bottom: 10px; }
    .tem-auteur { display: flex; align-items: center; gap: 8px; }
    .tem-avatar { width: 30px; height: 30px; border-radius: 50%; background-color: #008751; color: white; font-size: 11px; font-weight: bold; display: flex; align-items: center; justify-content: center; }
    .tem-name { font-size: 12px; font-weight: bold; color: #1E3A5F; }

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
      .breadcrumb { padding: 12px 20px; }
      .hero-fiche { flex-direction: column; padding: 30px 20px; }
      .fiche-content { grid-template-columns: 1fr; padding: 20px; }
      .info-grid { grid-template-columns: 1fr; }
      .debouches-grid { grid-template-columns: 1fr; }
      footer { padding: 30px 20px; }
    }
</style>
@endsection

@section('content')

  <!-- BREADCRUMB -->
  <div class="breadcrumb">
    <a href="{{ route('accueil') }}">Accueil</a><span>›</span>
    <a href="{{ route('filieres.index') }}">Filières</a><span>›</span>
    {{ $filiere->nom }}
  </div>

  <!-- HERO -->
  <div class="hero-fiche">
    <div class="hero-fiche-left">
      <div class="hero-fiche-icon">🎓</div>
      <h1>{{ $filiere->nom }}</h1>
      <div class="hero-fiche-uni">
        🏛️ {{ $filiere->campus->first()?->nom ?? 'N/A' }} —
        {{ $filiere->campus->first()?->universite?->nom ?? '' }}
      </div>
      <div class="hero-tags">
        @if($filiere->quota_bourse > 0)
          <span class="htag htag-green">🟢 Bourse disponible</span>
        @endif
        <span class="htag htag-yellow">⏱ {{ $filiere->duree_annees }} ans</span>
        <span class="htag htag-white">📋 {{ ucfirst($filiere->mode_entree) }}</span>
        @foreach($filiere->series->take(4) as $serie)
          <span class="htag htag-white">Série {{ $serie->code }}</span>
        @endforeach
      </div>
    </div>
    <div class="hero-fiche-right">
      <a href="{{ route('questionnaire') }}" class="btn-simuler">🎯 Simuler mon admissibilité</a>
    </div>
  </div>

  <!-- CONTENU -->
  <div class="fiche-content">

    <div class="fiche-main">

      <!-- DESCRIPTION -->
      <div class="info-card">
        <h2>📖 Description</h2>
        <p class="desc-text">{{ $filiere->description ?? 'Description non disponible.' }}</p>
      </div>

      <!-- INFOS GENERALES -->
      <div class="info-card">
        <h2>📋 Informations générales</h2>
        <div class="info-grid">
          <div class="info-item">
            <label>Établissement</label>
            <span>{{ $filiere->campus->first()?->nom ?? 'N/A' }} — {{ $filiere->campus->first()?->universite?->sigle ?? '' }}</span>
          </div>
          <div class="info-item">
            <label>Durée</label>
            <span>{{ $filiere->duree_annees }} ans</span>
          </div>
          <div class="info-item">
            <label>Mode d'entrée</label>
            <span>{{ ucfirst($filiere->mode_entree) }}</span>
          </div>
          <div class="info-item">
            <label>Ville</label>
            <span>{{ $filiere->campus->first()?->ville ?? 'N/A' }}</span>
          </div>
          <div class="info-item">
            <label>Quota bourse</label>
            <span style="color:#008751;">{{ $filiere->quota_bourse }} places</span>
          </div>
          <div class="info-item">
            <label>Quota FPP</label>
            <span style="color:#c9a000;">{{ $filiere->quota_aide_fpp }} places</span>
          </div>
        </div>
      </div>

      <!-- MATIERES FONDAMENTALES -->
      <div class="info-card">
        <h2>📐 Matières fondamentales et coefficients</h2>
        @if($matieres->isNotEmpty())
          <div class="matieres-list">
            @foreach($matieres as $matiere)
              <div class="matiere-item">
                <span class="matiere-nom">{{ $matiere->nom }}</span>
                <span class="matiere-coef">Coef. {{ $matiere->pivot->coefficient }}</span>
              </div>
            @endforeach
          </div>
          <div class="formule-display">
            <strong style="color:#1E3A5F;">Formule MESRS :</strong>
            M = ({{ $matieres->map(fn($m) => $m->nom . '×' . $m->pivot->coefficient)->implode(' + ') }})
            / {{ $matieres->sum('pivot.coefficient') }}
          </div>
        @else
          <p style="color:#999;font-size:14px;">Matières non encore renseignées pour cette filière.</p>
        @endif
      </div>

      <!-- SERIES RECOMMANDEES -->
      <div class="info-card">
        <h2>🎓 Séries recommandées</h2>
        <div class="series-list">
          @forelse($filiere->series->unique('id_serie') as $serie)
            <span class="serie-badge">Série {{ $serie->code }}</span>
          @empty
            <p style="color:#999;font-size:14px;">Séries non renseignées.</p>
          @endforelse
        </div>
      </div>

      <!-- DEBOUCHES -->
      <div class="info-card">
        <h2>💼 Débouchés et métiers</h2>
        @if($filiere->debouches->isNotEmpty())
          <div class="debouches-grid">
            @foreach($filiere->debouches as $debouche)
              <div class="debouche-item">{{ $debouche->intitule }}</div>
            @endforeach
          </div>
        @else
          <p style="color:#999;font-size:14px;">Débouchés non encore renseignés.</p>
        @endif
      </div>

      <!-- TEMOIGNAGES -->
      <div class="info-card">
        <h2>💬 Témoignages d'étudiants</h2>
        @if($temoignages->isNotEmpty())
          <div class="tem-list">
            @foreach($temoignages as $temoignage)
              <div class="tem-item">
                <div class="tem-stars">{{ str_repeat('★', $temoignage->note) }}{{ str_repeat('☆', 5 - $temoignage->note) }}</div>
                <div class="tem-text">"{{ $temoignage->contenu }}"</div>
                <div class="tem-auteur">
                  <div class="tem-avatar">
                    {{ strtoupper(substr($temoignage->user->nom, 0, 1) . substr($temoignage->user->prenom, 0, 1)) }}
                  </div>
                  <div>
                    <div class="tem-name">{{ $temoignage->user->prenom }} {{ $temoignage->user->nom }}</div>
                    <span style="font-size:11px;color:#999;">Série {{ $temoignage->user->serie?->code ?? 'N/A' }}</span>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <p style="color:#999;font-size:14px;">Aucun témoignage pour cette filière pour l'instant.</p>
        @endif
      </div>

    </div>

    <!-- SIDEBAR -->
    <div class="fiche-sidebar">

      <!-- QUOTAS -->
      <div class="quota-card">
        <h3>📊 Quotas {{ date('Y') }}</h3>
        <div class="quota-item">
          <span class="quota-label">🟢 Bourses</span>
          <span class="quota-val">{{ $filiere->quota_bourse }}</span>
        </div>
        <div class="quota-item">
          <span class="quota-label">🟡 FPP</span>
          <span class="quota-val yellow">{{ $filiere->quota_aide_fpp }}</span>
        </div>
        @if($uniFiliere)
          <div class="quota-item">
            <span class="quota-label">Seuil bourse estimé</span>
            <span class="quota-val" style="font-size:14px;color:#555;">≥ {{ $uniFiliere->seuil_bourse }} / 20</span>
          </div>
        @endif
      </div>

      <!-- CAMPUS -->
      <div class="campus-card">
        <h3>🏛️ Campus proposant cette filière</h3>
        @forelse($filiere->campus as $campus)
          <div class="campus-item">
            <div style="font-size:20px;">🏫</div>
            <div class="campus-info" style="flex:1;">
              <div class="campus-nom">{{ $campus->nom }}</div>
              <div class="campus-ville">📍 {{ $campus->ville }}</div>
            </div>
          </div>
        @empty
          <p style="font-size:13px;color:#999;">Aucun campus renseigné.</p>
        @endforelse
      </div>

      <!-- SIMULATEUR -->
      <div class="sim-card">
        <h3>🎯 Simuler mon admissibilité</h3>
        <p>Entre tes notes pour voir si tu es éligible à une bourse dans cette filière.</p>
        <div class="sim-input-group" id="simInputs">
          @foreach($matieres as $i => $matiere)
            <div>
              <label>Note en {{ $matiere->nom }} /20</label>
              <input type="number" min="0" max="20" step="0.25"
                     placeholder="ex: 14"
                     data-coef="{{ $matiere->pivot->coefficient }}"
                     class="sim-note" />
            </div>
          @endforeach
          @if($matieres->isEmpty())
            <p style="font-size:13px;color:#999;">Simulateur non disponible — matières non renseignées.</p>
          @endif
        </div>
        @if($matieres->isNotEmpty())
          <button class="btn-calculer" onclick="simuler({{ $uniFiliere?->seuil_bourse ?? 12 }})">
            Calculer mon score
          </button>
          <div class="resultat-sim" id="resultatSim"></div>
        @endif
      </div>

    </div>
  </div>

@endsection

@section('scripts')
<script>
  function simuler(seuilBourse) {
    const inputs  = document.querySelectorAll('.sim-note');
    let somme     = 0;
    let totalCoef = 0;

    inputs.forEach(input => {
      const note = parseFloat(input.value) || 0;
      const coef = parseInt(input.dataset.coef) || 1;
      somme     += note * coef;
      totalCoef += coef;
    });

    if (totalCoef === 0) return;

    const moyenne  = somme / totalCoef;
    const seuilFpp = seuilBourse - 1.5;
    const div      = document.getElementById('resultatSim');

    div.style.display = 'block';

    if (moyenne >= seuilBourse) {
      div.style.backgroundColor = 'rgba(0,135,81,0.1)';
      div.style.color  = '#008751';
      div.style.border = '1px solid #008751';
      div.innerHTML    = '🟢 Moyenne : <strong>' + moyenne.toFixed(2) + '/20</strong><br>Éligible à une <strong>bourse</strong> !';
    } else if (moyenne >= seuilFpp) {
      div.style.backgroundColor = 'rgba(252,209,22,0.15)';
      div.style.color  = '#c9a000';
      div.style.border = '1px solid #FCD116';
      div.innerHTML    = '🟡 Moyenne : <strong>' + moyenne.toFixed(2) + '/20</strong><br>Éligible en <strong>FPP</strong>';
    } else {
      div.style.backgroundColor = 'rgba(232,17,45,0.08)';
      div.style.color  = '#E8112D';
      div.style.border = '1px solid #E8112D';
      div.innerHTML    = '🔴 Moyenne : <strong>' + moyenne.toFixed(2) + '/20</strong><br><strong>Score insuffisant</strong>';
    }
  }
</script>
@endsection