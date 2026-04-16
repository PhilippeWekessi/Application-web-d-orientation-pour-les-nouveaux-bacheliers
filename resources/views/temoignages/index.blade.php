@extends('layouts.app')

@section('title', 'Témoignages — OrientaBac')

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
    .btn-soumettre { display: inline-block; padding: 13px 28px; background-color: #FCD116; color: #1E3A5F; border: none; border-radius: 10px; font-size: 15px; font-weight: bold; cursor: pointer; text-decoration: none; transition: background-color 0.2s; }
    .btn-soumettre:hover { background-color: #e6be00; }

    .stats-bar { background: white; padding: 25px 80px; display: flex; gap: 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); flex-wrap: wrap; }
    .stat-item { text-align: center; }
    .stat-item h3 { font-size: 28px; font-weight: bold; color: #008751; }
    .stat-item p { font-size: 13px; color: #777; }

    .section-tem { padding: 50px 80px; }
    .section-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .section-top h2 { font-size: 22px; font-weight: bold; color: #1E3A5F; }

    .filtres { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 30px; }
    .filtre-btn { padding: 8px 18px; border-radius: 20px; border: 2px solid #ddd; background: white; font-size: 13px; font-weight: bold; color: #777; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-block; }
    .filtre-btn.active, .filtre-btn:hover { border-color: #008751; color: #008751; background-color: rgba(0,135,81,0.08); }

    .tem-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; }
    .tem-card { background: white; border-radius: 14px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); display: flex; flex-direction: column; gap: 12px; transition: transform 0.2s; }
    .tem-card:hover { transform: translateY(-4px); }
    .tem-card:nth-child(3n+1) { border-top: 4px solid #008751; }
    .tem-card:nth-child(3n+2) { border-top: 4px solid #FCD116; }
    .tem-card:nth-child(3n+3) { border-top: 4px solid #E8112D; }
    .tem-header { display: flex; align-items: center; justify-content: space-between; }
    .stars { color: #FCD116; font-size: 15px; }
    .tem-filiere-tag { font-size: 11px; font-weight: bold; padding: 3px 10px; background-color: rgba(30,58,95,0.08); color: #1E3A5F; border-radius: 20px; }
    .tem-text { font-size: 14px; color: #555; line-height: 1.7; font-style: italic; flex: 1; }
    .tem-auteur { display: flex; align-items: center; gap: 12px; padding-top: 12px; border-top: 1px solid #f0f0f0; }
    .avatar { width: 42px; height: 42px; border-radius: 50%; color: white; font-weight: bold; font-size: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .tem-card:nth-child(3n+1) .avatar { background-color: #008751; }
    .tem-card:nth-child(3n+2) .avatar { background-color: #c9a000; }
    .tem-card:nth-child(3n+3) .avatar { background-color: #E8112D; }
    .tem-auteur-info h5 { font-size: 14px; font-weight: bold; color: #1E3A5F; }
    .tem-auteur-info span { font-size: 12px; color: #999; }

    .form-section { background: white; border-radius: 16px; padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-top: 50px; }
    .form-section h2 { font-size: 22px; font-weight: bold; color: #1E3A5F; margin-bottom: 8px; }
    .form-section p { font-size: 14px; color: #777; margin-bottom: 28px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group label { font-size: 13px; font-weight: bold; color: #555; }
    .form-group input, .form-group select, .form-group textarea { padding: 11px 14px; border: 1.5px solid #ddd; border-radius: 8px; font-size: 14px; color: #333; outline: none; transition: border-color 0.2s; background-color: #fafafa; font-family: 'Segoe UI', sans-serif; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #008751; background-color: white; }
    .form-group textarea { resize: vertical; min-height: 120px; }
    .stars-input { display: flex; gap: 8px; }
    .star-btn { font-size: 24px; cursor: pointer; color: #ddd; transition: color 0.2s; background: none; border: none; }
    .star-btn.active { color: #FCD116; }
    .btn-envoyer { padding: 13px 35px; background-color: #008751; color: white; border: none; border-radius: 10px; font-size: 15px; font-weight: bold; cursor: pointer; transition: background-color 0.2s; margin-top: 8px; }
    .btn-envoyer:hover { background-color: #006b40; }

    .alert-success { background-color: rgba(0,135,81,0.1); border: 1px solid #008751; color: #008751; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: bold; }
    .alert-error { background-color: rgba(232,17,45,0.1); border: 1px solid #E8112D; color: #E8112D; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }

    .pagination { display: flex; justify-content: center; gap: 10px; margin-top: 40px; }
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
      .stats-bar { padding: 20px; gap: 20px; }
      .section-tem { padding: 30px 20px; }
      .tem-grid { grid-template-columns: 1fr; }
      .form-grid { grid-template-columns: 1fr; }
      footer { padding: 30px 20px; }
    }
</style>
@endsection

@section('content')

  <!-- HERO -->
  <div class="hero">
    <h1>💬 Témoignages d'étudiants</h1>
    <p>Découvre les expériences de ceux qui ont choisi leur filière grâce à OrientaBac. Partage aussi la tienne !</p>
    <a href="#soumettre" class="btn-soumettre">✍️ Soumettre mon témoignage</a>
  </div>

  <!-- STATS -->
  <div class="stats-bar">
    <div class="stat-item"><h3>{{ $totalTemoignages }}+</h3><p>Témoignages publiés</p></div>
    <div class="stat-item"><h3>{{ number_format($moyenneNotes, 1) }}/5</h3><p>Note moyenne</p></div>
    <div class="stat-item"><h3>{{ $totalFilieres }}+</h3><p>Filières représentées</p></div>
    <div class="stat-item"><h3>{{ $totalUniversites }}</h3><p>Universités</p></div>
  </div>

  <section class="section-tem">
    <div class="section-top">
      <h2>Tous les témoignages</h2>
      <span style="font-size:13px;color:#777;">{{ $temoignages->total() }} témoignages</span>
    </div>

    <!-- FILTRES PAR FILIERE -->
    <div class="filtres">
      <a href="{{ route('temoignages.index') }}"
         class="filtre-btn {{ !request('filiere') ? 'active' : '' }}">Tous</a>
      @foreach($filieres as $filiere)
        <a href="{{ route('temoignages.index', ['filiere' => $filiere->id_filiere]) }}"
           class="filtre-btn {{ request('filiere') == $filiere->id_filiere ? 'active' : '' }}">
          {{ Str::limit($filiere->nom, 20) }}
        </a>
      @endforeach
      <a href="{{ route('temoignages.index', ['note' => 5]) }}"
         class="filtre-btn {{ request('note') == 5 ? 'active' : '' }}">★★★★★ 5 étoiles</a>
    </div>

    <!-- GRILLE TEMOIGNAGES -->
    <div class="tem-grid">
      @forelse($temoignages as $temoignage)
        <div class="tem-card">
          <div class="tem-header">
            <div class="stars">
              {{ str_repeat('★', $temoignage->note) }}{{ str_repeat('☆', 5 - $temoignage->note) }}
            </div>
            <span class="tem-filiere-tag">{{ Str::limit($temoignage->filiere->nom, 20) }}</span>
          </div>
          <p class="tem-text">"{{ $temoignage->contenu }}"</p>
          <div class="tem-auteur">
            <div class="avatar">
              {{ strtoupper(substr($temoignage->user->nom, 0, 1) . substr($temoignage->user->prenom, 0, 1)) }}
            </div>
            <div class="tem-auteur-info">
              <h5>{{ $temoignage->user->prenom }} {{ $temoignage->user->nom }}</h5>
              <span>Série {{ $temoignage->user->serie->code ?? 'N/A' }}</span>
            </div>
          </div>
        </div>
      @empty
        <!-- Données statiques si BDD vide -->
        <div class="tem-card">
          <div class="tem-header">
            <div class="stars">★★★★★</div>
            <span class="tem-filiere-tag">Génie Logiciel — IFRI</span>
          </div>
          <p class="tem-text">"Grâce à OrientaBac, j'ai découvert la filière Génie Logiciel qui correspondait parfaitement à mon profil."</p>
          <div class="tem-auteur">
            <div class="avatar">KA</div>
            <div class="tem-auteur-info"><h5>Kolade Ahounou</h5><span>2ème année — Série D</span></div>
          </div>
        </div>
        <div class="tem-card">
          <div class="tem-header">
            <div class="stars">★★★★★</div>
            <span class="tem-filiere-tag">Médecine — FSS</span>
          </div>
          <p class="tem-text">"Le questionnaire m'a aidé à comprendre que j'avais les notes pour être boursière en Médecine."</p>
          <div class="tem-auteur">
            <div class="avatar">SF</div>
            <div class="tem-auteur-info"><h5>Salimata Fassinou</h5><span>3ème année — Série C</span></div>
          </div>
        </div>
        <div class="tem-card">
          <div class="tem-header">
            <div class="stars">★★★★☆</div>
            <span class="tem-filiere-tag">Finance & Comptabilité — FASEG</span>
          </div>
          <p class="tem-text">"J'ai apprécié avoir les informations sur les quotas et les débouchés directement sur la plateforme."</p>
          <div class="tem-auteur">
            <div class="avatar">MB</div>
            <div class="tem-auteur-info"><h5>Marius Biaou</h5><span>2ème année — Série G2</span></div>
          </div>
        </div>
      @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="pagination">
      {{ $temoignages->appends(request()->query())->links('vendor.pagination.custom') }}
    </div>

    <!-- FORMULAIRE -->
    <div class="form-section" id="soumettre">
      <h2>✍️ Soumettre mon témoignage</h2>
      <p>Partage ton expérience pour aider les futurs bacheliers dans leur choix d'orientation.</p>

      @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
      @endif
      @if($errors->any())
        <div class="alert-error">
          @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif

      <form method="POST" action="{{ route('temoignages.store') }}">
        @csrf
        <div class="form-grid">
          <div class="form-group">
            <label>Nom et prénom *</label>
            <input type="text" name="nom_prenom" placeholder="Ex: Kolade Ahounou"
                   value="{{ old('nom_prenom') }}" required />
          </div>
          <div class="form-group">
            <label>Filière concernée *</label>
            <select name="id_filiere" required>
              <option value="">-- Sélectionner une filière --</option>
              @foreach($filieres as $filiere)
                <option value="{{ $filiere->id_filiere }}"
                  {{ old('id_filiere') == $filiere->id_filiere ? 'selected' : '' }}>
                  {{ $filiere->nom }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Année d'étude *</label>
            <select name="annee_etude" required>
              <option value="1">1ère année</option>
              <option value="2">2ème année</option>
              <option value="3">3ème année</option>
              <option value="diplome">Diplômé</option>
            </select>
          </div>
          <div class="form-group">
            <label>Série du baccalauréat</label>
            <select name="id_serie">
              <option value="">-- Série --</option>
              @foreach($series as $serie)
                <option value="{{ $serie->id_serie }}"
                  {{ old('id_serie') == $serie->id_serie ? 'selected' : '' }}>
                  {{ $serie->libelle }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group" style="margin-bottom:16px;">
          <label>Note (étoiles) *</label>
          <div class="stars-input">
            @for($i = 1; $i <= 5; $i++)
              <button type="button" class="star-btn {{ old('note', 0) >= $i ? 'active' : '' }}"
                      onclick="setNote({{ $i }})">★</button>
            @endfor
          </div>
          <input type="hidden" name="note" id="note-input" value="{{ old('note', 0) }}" />
        </div>

        <div class="form-group" style="margin-bottom:20px;">
          <label>Ton témoignage *</label>
          <textarea name="contenu" placeholder="Partage ton expérience..." required>{{ old('contenu') }}</textarea>
        </div>

        <button type="submit" class="btn-envoyer">Envoyer mon témoignage</button>
        <p style="font-size:12px;color:#999;margin-top:12px;">⚠️ Ton témoignage sera vérifié par notre équipe avant publication.</p>
      </form>
    </div>

  </section>
@endsection

@section('scripts')
<script>
  let noteActuelle = {{ old('note', 0) }};
  function setNote(n) {
    noteActuelle = n;
    document.getElementById('note-input').value = n;
    document.querySelectorAll('.star-btn').forEach((btn, i) => {
      btn.classList.toggle('active', i < n);
    });
  }
</script>
@endsection