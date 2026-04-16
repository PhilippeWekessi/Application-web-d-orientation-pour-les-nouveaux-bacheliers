<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>Ajouter université — Admin OrientaBac</title>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI',sans-serif; background:#F0F2F5; }
    .topbar { background:#12253d; padding:16px 35px; display:flex; align-items:center; justify-content:space-between; }
    .topbar .logo { color:white; font-size:18px; font-weight:bold; }
    .topbar .logo span { color:#FCD116; }
    .topbar a { color:rgba(255,255,255,0.6); font-size:14px; text-decoration:none; }
    .container { max-width:700px; margin:40px auto; padding:0 20px 60px; }
    .card { background:white; border-radius:14px; padding:35px; box-shadow:0 4px 20px rgba(0,0,0,0.08); border-top:4px solid #008751; }
    .card h2 { font-size:20px; font-weight:bold; color:#1E3A5F; margin-bottom:24px; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-group { margin-bottom:16px; }
    .form-group.full { grid-column:1/-1; }
    .form-group label { display:block; font-size:13px; font-weight:bold; color:#555; margin-bottom:6px; }
    .form-group input, .form-group select { width:100%; padding:11px 14px; border:1.5px solid #ddd; border-radius:8px; font-size:14px; outline:none; background:#fafafa; }
    .form-group input:focus, .form-group select:focus { border-color:#008751; background:white; }
    .btn-submit { width:100%; padding:14px; background:#008751; color:white; border:none; border-radius:10px; font-size:15px; font-weight:bold; cursor:pointer; }
    .alert-error { background:rgba(232,17,45,0.1); border:1px solid #E8112D; color:#E8112D; padding:12px; border-radius:8px; margin-bottom:20px; font-size:13px; }
  </style>
</head>
<body>
  <div class="topbar">
    <div class="logo">Orienta<span>Bac</span> — Admin</div>
    <a href="{{ route('admin.universites') }}">← Retour</a>
  </div>
  <div class="container">
    @if($errors->any())
      <div class="alert-error">@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
    @endif
    <div class="card">
      <h2>🏛️ Ajouter une université</h2>
      <form method="POST" action="{{ route('admin.universites.store') }}">
        @csrf
        <div class="form-grid">
          <div class="form-group full">
            <label>Nom complet *</label>
            <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Ex: Université d'Abomey-Calavi" required />
          </div>
          <div class="form-group">
            <label>Sigle *</label>
            <input type="text" name="sigle" value="{{ old('sigle') }}" placeholder="Ex: UAC" required />
          </div>
          <div class="form-group">
            <label>Ville *</label>
            <select name="ville" required>
              <option value="">-- Sélectionner --</option>
              <option value="Cotonou">Cotonou</option>
              <option value="Abomey-Calavi">Abomey-Calavi</option>
              <option value="Parakou">Parakou</option>
              <option value="Porto-Novo">Porto-Novo</option>
              <option value="Lokossa">Lokossa</option>
              <option value="Abomey">Abomey</option>
              <option value="Kétou">Kétou</option>
            </select>
          </div>
          <div class="form-group full">
            <label>Type *</label>
            <select name="type" required>
              <option value="public" {{ old('type') == 'public' ? 'selected' : '' }}>Public</option>
              <option value="prive" {{ old('type') == 'prive' ? 'selected' : '' }}>Privé</option>
            </select>
          </div>
        </div>
        <button type="submit" class="btn-submit">Ajouter l'université</button>
      </form>
    </div>
  </div>
</body>
</html>