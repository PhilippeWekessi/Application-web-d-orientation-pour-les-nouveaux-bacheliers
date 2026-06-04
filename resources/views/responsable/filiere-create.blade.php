<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ajouter une filière — OrientaBac</title>
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
    .container { max-width:750px; margin:0 auto; padding:40px 20px; }
    .back-link { display:inline-flex; align-items:center; gap:6px; color:#1E3A5F; font-size:14px; font-weight:bold; text-decoration:none; margin-bottom:20px; }
    .back-link:hover { color:#008751; }
    .uni-badge { background:rgba(0,135,81,0.08); border:1px solid rgba(0,135,81,0.2); border-radius:10px; padding:12px 16px; font-size:13px; color:#1E3A5F; margin-bottom:24px; display:flex; align-items:center; gap:8px; }
    .panel { background:white; border-radius:16px; padding:36px; box-shadow:0 2px 10px rgba(0,0,0,0.06); border-top:4px solid #008751; }
    .panel h2 { font-size:22px; font-weight:bold; color:#1E3A5F; margin-bottom:6px; }
    .panel > p { font-size:14px; color:#777; margin-bottom:28px; padding-bottom:20px; border-bottom:1px solid #eee; }
    .form-group { margin-bottom:20px; }
    .form-group label { display:block; font-size:13px; font-weight:bold; color:#1E3A5F; margin-bottom:7px; }
    .form-group input,
    .form-group select,
    .form-group textarea { width:100%; padding:12px 14px; border:1.5px solid #ddd; border-radius:8px; font-size:14px; outline:none; background:#fafafa; color:#333; transition:border-color 0.2s; appearance:none; -webkit-appearance:none; }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus { border-color:#008751; background:white; }
    .form-group textarea { resize:vertical; min-height:90px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .select-wrapper { position:relative; }
    .select-wrapper::after { content:'▼'; position:absolute; right:12px; top:50%; transform:translateY(-50%); font-size:11px; color:#999; pointer-events:none; }
    .form-group .hint { font-size:12px; color:#999; margin-top:5px; }
    .info-box { background:rgba(252,209,22,0.1); border:1px solid rgba(252,209,22,0.4); border-radius:8px; padding:12px 16px; font-size:13px; color:#92400e; margin-bottom:20px; }
    .btn-submit { padding:13px 30px; background:#008751; color:white; border:none; border-radius:10px; font-size:15px; font-weight:bold; cursor:pointer; transition:background 0.2s; }
    .btn-submit:hover { background:#006b40; }
    .btn-cancel { padding:13px 24px; background:transparent; color:#1E3A5F; border:2px solid #1E3A5F; border-radius:10px; font-size:14px; font-weight:bold; cursor:pointer; transition:all 0.2s; text-decoration:none; display:inline-block; }
    .btn-cancel:hover { background:#1E3A5F; color:white; }
    .alert-success { background:rgba(16,185,129,0.08); border:1px solid #008751; color:#047857; padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:16px; }
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

    <div class="uni-badge">
      Université : <strong>{{ $universite->nom }}</strong>
      &nbsp;|&nbsp; Ville : {{ $universite->ville }}
    </div>

    <div class="panel">
      <h2>Ajouter une filière</h2>
      <p>La filière sera soumise à la validation de l'administrateur avant d'être publiée sur OrientaBac.</p>

      @if($errors->any())
        <div class="alert-error">
          @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      @endif

      @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
      @endif

      <div class="info-box">
        <strong>Processus de validation :</strong> Après soumission, votre filière sera examinée par l'administrateur du MESRS. Vous recevrez une notification une fois qu'elle sera validée ou rejetée.
      </div>

      <form method="POST" action="{{ route('responsable.filiere.store') }}">
        @csrf

        <input type="hidden" name="id_universite" value="{{ $universite->id_universite }}" />

        <div class="form-group">
          <label>Campus</label>
          <div class="select-wrapper">
            <select name="id_campus" required>
              <option value="">-- Choisir un campus --</option>
              @foreach($campusList as $campusItem)
                <option value="{{ $campusItem->id_campus }}" {{ old('id_campus') == $campusItem->id_campus ? 'selected' : '' }}>
                  {{ $campusItem->nom }} @if($campusItem->ville) - {{ $campusItem->ville }}@endif
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Nom de la filière</label>
          <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Ex : Génie Logiciel" required />
        </div>

        <div class="form-group">
          <label>Description</label>
          <textarea name="description" placeholder="Décrivez brièvement la filière...">{{ old('description') }}</textarea>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Durée (années)</label>
            <input type="number" name="duree_annees" value="{{ old('duree_annees', 3) }}" min="1" max="10" required />
          </div>
          <div class="form-group">
            <label>Mode d'entrée <span class="required"></span></label>
            <div class="select-wrapper">
              <select name="mode_entree" required>
                <option value="">-- Choisir --</option>
                <option value="classement" {{ old('mode_entree') == 'classement' ? 'selected' : '' }}>Classement</option>
                <option value="concours" {{ old('mode_entree') == 'concours' ? 'selected' : '' }}>Concours</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Quota Bourses</label>
            <input type="number" name="quota_bourse" value="{{ old('quota_bourse', 0) }}" min="0" />
            <div class="hint">Nombre de places avec bourse</div>
          </div>
          <div class="form-group">
            <label>Quota Aide/FPP</label>
            <input type="number" name="quota_aide_fpp" value="{{ old('quota_aide_fpp', 0) }}" min="0" />
            <div class="hint">Nombre de places partiellement payantes</div>
          </div>
        </div>

        <div class="actions">
          <button type="submit" class="btn-submit">Soumettre la filière pour validation</button>
          <a href="{{ route('responsable.dashboard') }}" class="btn-cancel">Annuler</a>
        </div>

      </form>
    </div>

  </div>
</body>
</html>