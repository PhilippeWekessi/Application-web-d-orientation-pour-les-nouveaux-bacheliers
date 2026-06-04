<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>Ajouter filière — Admin OrientaBac</title>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI',sans-serif; background:#F0F2F5; }
    .topbar { background:#12253d; padding:16px 35px; display:flex; align-items:center; justify-content:space-between; }
    .topbar .logo { color:white; font-size:18px; font-weight:bold; }
    .topbar .logo span { color:#FCD116; }
    .topbar a { color:rgba(255,255,255,0.6); font-size:14px; text-decoration:none; }
    .container { max-width:800px; margin:40px auto; padding:0 20px 60px; }
    .card { background:white; border-radius:14px; padding:35px; box-shadow:0 4px 20px rgba(0,0,0,0.08); border-top:4px solid #008751; margin-bottom:24px; }
    .card h2 { font-size:18px; font-weight:bold; color:#1E3A5F; margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid #eee; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-group { margin-bottom:16px; }
    .form-group.full { grid-column:1/-1; }
    .form-group label { display:block; font-size:13px; font-weight:bold; color:#555; margin-bottom:6px; }
    .form-group label span { color:#E8112D; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:11px 14px; border:1.5px solid #ddd; border-radius:8px; font-size:14px; outline:none; background:#fafafa; font-family:'Segoe UI',sans-serif; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#008751; background:white; }
    .form-group textarea { resize:vertical; min-height:100px; }

    .series-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; }
    .serie-item { border:2px solid #ddd; border-radius:8px; padding:10px; cursor:pointer; transition:all 0.2s; text-align:center; }
    .serie-item.selected { border-color:#008751; background:rgba(0,135,81,0.05); }
    .serie-item input { display:none; }
    .serie-item label { font-size:13px; font-weight:bold; color:#1E3A5F; cursor:pointer; }
    .serie-item small { display:block; font-size:10px; color:#999; margin-top:2px; }

    .campus-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; }
    .campus-item { border:2px solid #ddd; border-radius:8px; padding:10px; cursor:pointer; transition:all 0.2s; }
    .campus-item.selected { border-color:#008751; background:rgba(0,135,81,0.05); }
    .campus-item input { display:none; }
    .campus-item label { font-size:13px; font-weight:bold; color:#1E3A5F; cursor:pointer; }
    .campus-item small { display:block; font-size:11px; color:#999; }

    .interets-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; }
    .interet-item { border:2px solid #ddd; border-radius:8px; padding:10px; cursor:pointer; transition:all 0.2s; text-align:center; }
    .interet-item.selected { border-color:#008751; background:rgba(0,135,81,0.05); }
    .interet-item input { display:none; }
    .interet-item label { font-size:12px; font-weight:bold; color:#1E3A5F; cursor:pointer; }

    .btn-submit { width:100%; padding:14px; background:#008751; color:white; border:none; border-radius:10px; font-size:15px; font-weight:bold; cursor:pointer; }
    .btn-submit:hover { background:#006b40; }
    .alert-error { background:rgba(232,17,45,0.1); border:1px solid #E8112D; color:#E8112D; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:13px; }
    .info-box { background:rgba(0,135,81,0.08); border:1px solid rgba(0,135,81,0.3); border-radius:8px; padding:12px 16px; margin-bottom:20px; font-size:13px; color:#444; }
  </style>
</head>
<body>

  <div class="topbar">
    <div class="logo">Orienta<span>Bac</span> — Admin</div>
    <a href="{{ route('admin.filieres') }}">← Retour aux filières</a>
  </div>

  <div class="container">

    @if($errors->any())
      <div class="alert-error">
        @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('admin.filieres.store') }}">
      @csrf

      <!-- INFOS GENERALES -->
      <div class="card">
        <h2>Informations générales</h2>
        <div class="form-grid">
          <div class="form-group full">
            <label>Nom de la filière <span>*</span></label>
            <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Ex: Génie Logiciel" required />
          </div>
          <div class="form-group full">
            <label>Description</label>
            <textarea name="description" placeholder="Décrivez la filière..." required>{{ old('description') }}</textarea>
          </div>
          <div class="form-group">
            <label>Durée (années)</label>
            <select name="duree_annees" required>
              <option value="">-- Sélectionner --</option>
              @for($i = 1; $i <= 10; $i++)
                <option value="{{ $i }}" {{ old('duree_annees') == $i ? 'selected' : '' }}>
                  {{ $i }} an{{ $i > 1 ? 's' : '' }}
                </option>
              @endfor
            </select>
          </div>
          <div class="form-group">
            <label>Mode d'entrée</label>
            <select name="mode_entree" required>
              <option value="">-- Sélectionner --</option>
              <option value="classement" {{ old('mode_entree') == 'classement' ? 'selected' : '' }}>Classement</option>
              <option value="concours" {{ old('mode_entree') == 'concours' ? 'selected' : '' }}>Concours</option>
              <option value="dossier" {{ old('mode_entree') == 'dossier' ? 'selected' : '' }}>Dossier</option>
              <option value="direct" {{ old('mode_entree') == 'direct' ? 'selected' : '' }}>Accès direct</option>
            </select>
          </div>
          <div class="form-group">
            <label>Quota bourse</label>
            <input type="number" name="quota_bourse" value="{{ old('quota_bourse', 0) }}" min="0" required />
          </div>
          <div class="form-group">
            <label>Quota FPP</label>
            <input type="number" name="quota_aide_fpp" value="{{ old('quota_aide_fpp', 0) }}" min="0" required />
          </div>
          <div class="form-group">
            <label>Seuil bourse /20</label>
            <input type="number" name="seuil_bourse" value="{{ old('seuil_bourse', 12) }}" min="0" max="20" step="0.5" required />
          </div>
        </div>
      </div>

      <!-- CAMPUS -->
      <div class="card">
        <h2>Campus proposant cette filière <span style="color:#E8112D;font-size:14px;"></span></h2>
        <div class="campus-grid">
          @foreach($campus as $c)
            <div class="campus-item" id="campus-item-{{ $c->id_campus }}"
                 onclick="toggleItem('campus', {{ $c->id_campus }}, this)">
              <input type="checkbox" name="campus[]" value="{{ $c->id_campus }}"
                     id="campus-{{ $c->id_campus }}"
                     {{ in_array($c->id_campus, old('campus', [])) ? 'checked' : '' }} />
              <label for="campus-{{ $c->id_campus }}">{{ $c->nom }}</label>
              <small>{{ $c->universite?->sigle ?? '' }} — {{ $c->ville }}</small>
            </div>
          @endforeach
        </div>
      </div>

      <!-- SERIES -->
      <div class="card">
        <h2>Séries acceptées <span style="color:#E8112D;font-size:14px;"></span></h2>
        <div class="series-grid">
          @foreach($series as $serie)
            <div class="serie-item" id="serie-item-{{ $serie->id_serie }}"
                 onclick="toggleItem('serie', {{ $serie->id_serie }}, this)">
              <input type="checkbox" name="series[]" value="{{ $serie->id_serie }}"
                     id="serie-{{ $serie->id_serie }}"
                     {{ in_array($serie->id_serie, old('series', [])) ? 'checked' : '' }} />
              <label for="serie-{{ $serie->id_serie }}">Série {{ $serie->code }}</label>
              <small>{{ Str::limit($serie->libelle, 20) }}</small>
            </div>
          @endforeach
        </div>
      </div>

      <!-- INTERETS -->
      <div class="card">
        <h2>Centres d'intérêt associés</h2>
        <div class="interets-grid">
          @foreach($interets as $interet)
            <div class="interet-item" id="interet-item-{{ $interet->id_interet }}"
                 onclick="toggleItem('interet', {{ $interet->id_interet }}, this)">
              <input type="checkbox" name="interets[]" value="{{ $interet->id_interet }}"
                     id="interet-{{ $interet->id_interet }}"
                     {{ in_array($interet->id_interet, old('interets', [])) ? 'checked' : '' }} />
              <div style="font-size:22px;margin-bottom:4px;">{{ $interet->icone ?? '🎓' }}</div>
              <label for="interet-{{ $interet->id_interet }}">{{ $interet->libelle }}</label>
            </div>
          @endforeach
        </div>
      </div>

      <!-- DEBOUCHES -->
      <div class="card">
        <h2>Débouchés professionnels</h2>
        <div class="form-group">
          <label>Liste des débouchés <small style="color:#999;font-weight:normal;">(séparés par des virgules)</small></label>
          <textarea name="debouches" placeholder="Ex: Développeur web, Analyste programmeur, Chef de projet IT">{{ old('debouches') }}</textarea>
        </div>
      </div>

      <button type="submit" class="btn-submit">Ajouter la filière</button>

    </form>
  </div>

  <script>
    function toggleItem(type, id, el) {
      const checkbox = document.getElementById(type + '-' + id);
      checkbox.checked = !checkbox.checked;
      el.classList.toggle('selected', checkbox.checked);
    }
    // Initialiser les sélections
    document.querySelectorAll('.serie-item input:checked, .campus-item input:checked, .interet-item input:checked').forEach(cb => {
      cb.closest('[class$="-item"]').classList.add('selected');
    });
  </script>

</body>
</html>