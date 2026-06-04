<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Enregistrer mon université — OrientaBac</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI',sans-serif; background:#F4F6F9; min-height:100vh; }
    .topbar { background:#1E3A5F; height:65px; display:flex; align-items:center; justify-content:space-between; padding:0 40px; }
    .logo { color:white; font-size:20px; font-weight:bold; }
    .logo span { color:#FCD116; }
    .topbar-right { display:flex; align-items:center; gap:14px; }
    .user-name { color:rgba(255,255,255,0.85); font-size:14px; }
    .btn-logout { padding:7px 16px; background:rgba(232,17,45,0.2); color:#ff6b6b; border:1px solid rgba(232,17,45,0.3); border-radius:7px; font-size:13px; font-weight:bold; cursor:pointer; }
    .drapeau { height:5px; background:linear-gradient(to right,#008751 33%,#FCD116 33% 66%,#E8112D 66%); }
    .container { max-width:700px; margin:0 auto; padding:40px 20px; }
    .back-link { display:inline-flex; align-items:center; gap:6px; color:#1E3A5F; font-size:14px; font-weight:bold; text-decoration:none; margin-bottom:20px; }
    .back-link:hover { color:#008751; }
    .panel { background:white; border-radius:16px; padding:36px; box-shadow:0 2px 10px rgba(0,0,0,0.06); border-top:4px solid #008751; }
    .panel h2 { font-size:22px; font-weight:bold; color:#1E3A5F; margin-bottom:6px; }
    .panel p { font-size:14px; color:#777; margin-bottom:28px; padding-bottom:20px; border-bottom:1px solid #eee; }
    .form-group { margin-bottom:20px; }
    .form-group label { display:block; font-size:13px; font-weight:bold; color:#1E3A5F; margin-bottom:7px; }
    .form-group input { width:100%; padding:12px 14px; border:1.5px solid #ddd; border-radius:8px; font-size:14px; outline:none; background:#fafafa; color:#333; transition:border-color 0.2s; }
    .form-group input:focus { border-color:#008751; background:white; }
    .form-group .hint { font-size:12px; color:#999; margin-top:5px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .type-info { background:rgba(30,58,95,0.06); border:1px solid rgba(30,58,95,0.15); border-radius:8px; padding:12px 16px; font-size:13px; color:#1E3A5F; margin-bottom:20px; display:flex; align-items:center; gap:8px; }
    .btn-submit { padding:13px 30px; background:#008751; color:white; border:none; border-radius:10px; font-size:15px; font-weight:bold; cursor:pointer; transition:background 0.2s; }
    .btn-submit:hover { background:#006b40; }
    .btn-cancel { padding:13px 24px; background:transparent; color:#1E3A5F; border:2px solid #1E3A5F; border-radius:10px; font-size:14px; font-weight:bold; cursor:pointer; transition:all 0.2s; text-decoration:none; display:inline-block; }
    .btn-cancel:hover { background:#1E3A5F; color:white; }
    .alert-error { background:rgba(232,17,45,0.08); border:1px solid #E8112D; color:#E8112D; padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:16px; }
    .required { color:#E8112D; margin-left:2px; }
    .actions { display:flex; gap:12px; margin-top:10px; }
    @media(max-width:480px) { .form-row { grid-template-columns:1fr; } .actions { flex-direction:column; } }
  </style>
</head>
<body>

  <div class="topbar">
    <div class="logo">Orienta<span>Bac</span></div>
    <div class="topbar-right">
      <span class="user-name">{{ session('responsable_prenom') }} {{ session('responsable_nom') }}</span>
      <form method="POST" action="{{ route('responsable.logout') }}">
        @csrf
        <button type="submit" class="btn-logout">Déconnexion</button>
      </form>
    </div>
  </div>
  <div class="drapeau"></div>

  <div class="container">

    <a href="{{ route('responsable.dashboard') }}" class="back-link">← Retour au dashboard</a>

    <div class="panel">
      <h2>Enregistrer mon université</h2>
      <p>Renseignez les informations de votre établissement. Il sera soumis à la validation de l'administrateur avant d'être publié sur OrientaBac.</p>

      @if($errors->any())
        <div class="alert-error">
          @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      @endif

      <div class="type-info">
        Le type de votre établissement sera automatiquement défini comme <strong>Privé</strong>.
      </div>

      <form method="POST" action="{{ route('responsable.universite.store') }}">
        @csrf

        <div class="form-group">
          <label>Nom complet de l'établissement</label>
          <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Ex : Institut Supérieur de Management du Bénin" required />
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Sigle / Acronyme</label>
            <input type="text" name="sigle" value="{{ old('sigle') }}" placeholder="Ex : ISMB" />
            <div class="hint">Optionnel</div>
          </div>
          <div class="form-group">
            <label>Ville</label>
            <input type="text" name="ville" value="{{ old('ville') }}" placeholder="Ex : Cotonou" required />
          </div>
        </div>

        <div class="form-group">
          <label>Adresse complète</label>
          <input type="text" name="adresse" value="{{ old('adresse') }}" placeholder="Ex : Lot 123, Quartier Cadjèhoun, Cotonou" />
          <div class="hint">Optionnel</div>
        </div>

        <div class="form-group">
          <label>Téléphone de l'établissement</label>
          <input type="text" name="telephone_uni" value="{{ old('telephone_uni') }}" placeholder="Ex : +229 21 30 00 00" />
          <div class="hint">Optionnel</div>
        </div>

        <div class="actions">
          <button type="submit" class="btn-submit">Soumettre pour validation</button>
          <a href="{{ route('responsable.dashboard') }}" class="btn-cancel">Annuler</a>
        </div>

      </form>
    </div>

  </div>
</body>
</html>