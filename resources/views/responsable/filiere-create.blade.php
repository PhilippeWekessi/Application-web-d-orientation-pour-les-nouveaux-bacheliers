<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Soumettre une filière — OrientaBac</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI',sans-serif; background:#F4F6F9; }
    .topbar { background:#1E3A5F; padding:16px 40px; display:flex; align-items:center; justify-content:space-between; }
    .topbar .logo { color:white; font-size:20px; font-weight:bold; }
    .topbar .logo span { color:#FCD116; }
    .topbar a { color:rgba(255,255,255,0.7); font-size:14px; text-decoration:none; }
    .topbar a:hover { color:white; }
    .container { max-width:800px; margin:40px auto; padding:0 20px 60px; }
    .card { background:white; border-radius:14px; padding:35px; box-shadow:0 4px 20px rgba(0,0,0,0.08); margin-bottom:24px; border-top:4px solid #008751; }
    .card h2 { font-size:18px; font-weight:bold; color:#1E3A5F; margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid #eee; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-group { margin-bottom:16px; }
    .form-group.full { grid-column:1/-1; }
    .form-group label { display:block; font-size:13px; font-weight:bold; color:#555; margin-bottom:6px; }
    .form-group label span { color:#E8112D; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:11px 14px; border:1.5px solid #ddd; border-radius:8px; font-size:14px; outline:none; background:#fafafa; font-family:'Segoe UI',sans-serif; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#008751; background:white; }
    .form-group textarea { resize:vertical; min-height:100px; }
    .series-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; }
    .serie-item { border:2px solid #ddd; border-radius:8px; padding:10px; cursor:pointer; transition:all 0.2s; }
    .serie-item.selected { border-color:#008751; background:rgba(0,135,81,0.05); }
    .serie-item input { display:none; }
    .serie-item label { font-size:13px; font-weight:bold; color:#1E3A5F; cursor:pointer; }
    .btn-submit { width:100%; padding:14px; background:#008751; color:white; border:none; border-radius:10px; font-size:16px; font-weight:bold; cursor:pointer; }
    .btn-submit:hover { background:#006b40; }
    .alert-error { background:rgba(232,17,45,0.1); border:1px solid #E8112D; color:#E8112D; padding:12px 16px; border-radius:8px; font-size:13px; margin-bottom:20px; }
    .info-box { background:rgba(0,135,81,0.08); border:1px solid rgba(0,135,81,0.3); border-radius:8px; padding:14px; margin-bottom:20px; font-size:13px; color:#444; }
  </style>
</head>
<body>

  <div class="topbar">
    <div class="logo">Orienta<span>Bac</span></div>
    <a href="{{ route('responsable.dashboard') }}">← Retour au tableau de bord</a>
  </div>

  <div class="container">

    @if($errors->any())
      <div class="alert-error">
        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('responsable.filiere.store') }}">
      @csrf

      <!-- INFOS FILIERE -->
      <div class="card">
        <h2>📚 Informations de la filière</h2>
        <div class="info-box">ℹ️ Cette filière sera soumise à l'administrateur MESRS pour validation avant d'apparaître sur la plateforme.</div>
        <div class="form-grid">
          <div class="form-group full">
            <label>Nom de la filière <span>*</span></label>
            <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Ex: Génie Informatique" required />
          </div>
          <div class="form-group full">
            <label>Description <span>*</span></label>
            <textarea name="description" placeholder="Décrivez la filière, les compétences acquises..." required>{{ old('description') }}</textarea>
          </div>
          <div class="form-group">
            <label>Durée (années) <span>*</span></label>
            <select name="duree_annees" required>
              <option value="">-- Sélectionner --</option>
              @for($i = 1; $i <= 10; $i++)
                <option value="{{ $i }}" {{ old('duree_annees') == $i ? 'selected' : '' }}>{{ $i }} an{{ $i > 1 ? 's' : '' }}</option>
              @endfor
            </select>
          </div>
          <div class="form-group">
            <label>Mode d'entrée <span>*</span></label>
            <select name="mode_entree" required>
              <option value="">-- Sélectionner --</option>
              <option value="classement" {{ old('mode_entree') == 'classement' ? 'selected' : '' }}>Classement</option>
              <option value="concours" {{ old('mode_entree') == 'concours' ? 'selected' : '' }}>Concours</option>
              <option value="dossier" {{ old('mode_entree') == 'dossier' ? 'selected' : '' }}>Dossier</option>
              <option value="direct" {{ old('mode_entree') == 'direct' ? 'selected' : '' }}>Accès direct</option>
            </select>
          </div>
          <div class="form-group">
            <label>Quota bourse <span>*</span></label>
            <input type="number" name="quota_bourse" value="{{ old('quota_bourse', 0) }}" min="0" required />
          </div>
          <div class="form-group">
            <label>Quota FPP (partiellement payant) <span>*</span></label>
            <input type="number" name="quota_fpp" value="{{ old('quota_fpp', 0) }}" min="0" required />
          </div>
          <div class="form-group">
            <label>Seuil de bourse estimé /20 <span>*</span></label>
            <input type="number" name="seuil_bourse" value="{{ old('seuil_bourse', 12) }}" min="0" max="20" step="0.5" required />
          </div>
        </div>
      </div>

      <!-- SERIES ACCEPTEES -->
      <div class="card">
        <h2>🎓 Séries de baccalauréat acceptées</h2>
        <div class="series-grid" id="seriesGrid">
          @foreach($series as $serie)
            <div class="serie-item" id="serie-item-{{ $serie->id_serie }}" onclick="toggleSerie({{ $serie->id_serie }}, this)">
              <input type="checkbox" name="series[]" value="{{ $serie->id_serie }}" id="serie-{{ $serie->id_serie }}"
                     {{ in_array($serie->id_serie, old('series', [])) ? 'checked' : '' }} />
              <label for="serie-{{ $serie->id_serie }}">Série {{ $serie->code }}</label>
              <div style="font-size:11px;color:#999;margin-top:2px;">{{ $serie->libelle }}</div>
            </div>
          @endforeach
        </div>
      </div>

      <!-- DEBOUCHES -->
      <div class="card">
        <h2>💼 Débouchés professionnels</h2>
        <div class="form-group">
          <label>Liste des débouchés <span>*</span> <small style="color:#999;font-weight:normal;">(séparés par des virgules)</small></label>
          <textarea name="debouches" placeholder="Ex: Développeur web, Analyste programmeur, Chef de projet IT, Entrepreneur numérique" required>{{ old('debouches') }}</textarea>
        </div>
      </div>

      <button type="submit" class="btn-submit">📤 Soumettre pour validation</button>

    </form>
  </div>

  <script>
    function toggleSerie(id, el) {
      const checkbox = document.getElementById('serie-' + id);
      checkbox.checked = !checkbox.checked;
      el.classList.toggle('selected', checkbox.checked);
    }

    // Initialiser les sélections existantes
    document.querySelectorAll('.serie-item input:checked').forEach(cb => {
      cb.closest('.serie-item').classList.add('selected');
    });
  </script>
</body>
</html>