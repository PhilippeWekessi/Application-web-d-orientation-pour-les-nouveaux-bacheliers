<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Inscription Université — OrientaBac</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI',sans-serif; background:#F4F6F9; color:#333; }
    .header { background:linear-gradient(135deg,#1E3A5F,#2d5f8a); padding:30px 40px; }
    .header h1 { color:white; font-size:26px; font-weight:bold; margin-bottom:6px; }
    .header h1 span { color:#FCD116; }
    .header p { color:rgba(255,255,255,0.7); font-size:14px; }
    .container { max-width:800px; margin:40px auto; padding:0 20px 60px; }
    .card { background:white; border-radius:14px; padding:35px; box-shadow:0 4px 20px rgba(0,0,0,0.08); margin-bottom:24px; border-top:4px solid #008751; }
    .card h2 { font-size:18px; font-weight:bold; color:#1E3A5F; margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid #eee; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-group { margin-bottom:16px; }
    .form-group.full { grid-column:1/-1; }
    .form-group label { display:block; font-size:13px; font-weight:bold; color:#555; margin-bottom:6px; }
    .form-group label span { color:#E8112D; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:11px 14px; border:1.5px solid #ddd; border-radius:8px; font-size:14px; color:#333; outline:none; background:#fafafa; font-family:'Segoe UI',sans-serif; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#008751; background:white; }
    .form-group textarea { resize:vertical; min-height:100px; }
    .btn-submit { width:100%; padding:14px; background:#008751; color:white; border:none; border-radius:10px; font-size:16px; font-weight:bold; cursor:pointer; transition:background 0.2s; }
    .btn-submit:hover { background:#006b40; }
    .alert-error { background:rgba(232,17,45,0.1); border:1px solid #E8112D; color:#E8112D; padding:12px 16px; border-radius:8px; font-size:13px; margin-bottom:20px; }
    .info-box { background:rgba(0,135,81,0.08); border:1px solid rgba(0,135,81,0.3); border-radius:8px; padding:14px; margin-bottom:20px; font-size:13px; color:#444; }
    @media(max-width:768px) { .form-grid { grid-template-columns:1fr; } .container { padding:0 16px 40px; } .card { padding:24px 20px; } }
  </style>
</head>
<body>
  <div class="header">
    <h1>Orienta<span>Bac</span> — Inscription université</h1>
    <p>Créez votre espace pour soumettre vos filières à l'administrateur MESRS</p>
  </div>

  <div class="container">

    @if($errors->any())
      <div class="alert-error">
        @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('responsable.register.post') }}">
      @csrf

      <!-- INFOS RESPONSABLE -->
      <div class="card">
        <h2>👤 Informations du responsable</h2>
        <div class="info-box">ℹ️ Ces informations servent à créer votre compte personnel pour accéder à l'espace université.</div>
        <div class="form-grid">
          <div class="form-group">
            <label>Nom <span>*</span></label>
            <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Votre nom" required />
          </div>
          <div class="form-group">
            <label>Prénom <span>*</span></label>
            <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Votre prénom" required />
          </div>
          <div class="form-group">
            <label>Email <span>*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="contact@université.bj" required />
          </div>
          <div class="form-group">
            <label>Téléphone <span>*</span></label>
            <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="+229 97 00 00 00" required />
          </div>
          <div class="form-group">
            <label>Fonction / Poste <span>*</span></label>
            <input type="text" name="fonction" value="{{ old('fonction') }}" placeholder="Ex: Directeur des études" required />
          </div>
          <div class="form-group"></div>
          <div class="form-group">
            <label>Mot de passe <span>*</span></label>
            <input type="password" name="password" placeholder="Minimum 6 caractères" required />
          </div>
          <div class="form-group">
            <label>Confirmer le mot de passe <span>*</span></label>
            <input type="password" name="password_confirmation" placeholder="Répétez le mot de passe" required />
          </div>
        </div>
      </div>

      <!-- INFOS UNIVERSITE -->
      <div class="card">
        <h2>🏛️ Informations de votre établissement</h2>
        <div class="info-box">ℹ️ Ces informations seront vérifiées par l'administrateur MESRS avant validation de votre compte.</div>
        <div class="form-grid">
          <div class="form-group full">
            <label>Nom complet de l'établissement <span>*</span></label>
            <input type="text" name="nom_universite" value="{{ old('nom_universite') }}" placeholder="Ex: Institut Supérieur de Technologie de Cotonou" required />
          </div>
          <div class="form-group">
            <label>Sigle / Acronyme <span>*</span></label>
            <input type="text" name="sigle" value="{{ old('sigle') }}" placeholder="Ex: ISTC" required />
          </div>
          <div class="form-group">
            <label>Ville <span>*</span></label>
            <select name="ville" required>
              <option value="">-- Sélectionner --</option>
              <option value="Cotonou" {{ old('ville') == 'Cotonou' ? 'selected' : '' }}>Cotonou</option>
              <option value="Abomey-Calavi" {{ old('ville') == 'Abomey-Calavi' ? 'selected' : '' }}>Abomey-Calavi</option>
              <option value="Parakou" {{ old('ville') == 'Parakou' ? 'selected' : '' }}>Parakou</option>
              <option value="Porto-Novo" {{ old('ville') == 'Porto-Novo' ? 'selected' : '' }}>Porto-Novo</option>
              <option value="Lokossa" {{ old('ville') == 'Lokossa' ? 'selected' : '' }}>Lokossa</option>
              <option value="Abomey" {{ old('ville') == 'Abomey' ? 'selected' : '' }}>Abomey</option>
              <option value="Autre" {{ old('ville') == 'Autre' ? 'selected' : '' }}>Autre</option>
            </select>
          </div>
          <div class="form-group full">
            <label>Adresse complète <span>*</span></label>
            <input type="text" name="adresse" value="{{ old('adresse') }}" placeholder="Ex: Rue 123, Quartier Akpakpa, Cotonou" required />
          </div>
          <div class="form-group full">
            <label>Description de l'établissement</label>
            <textarea name="description" placeholder="Présentez brièvement votre établissement, son histoire, sa mission...">{{ old('description') }}</textarea>
          </div>
        </div>
      </div>

      <button type="submit" class="btn-submit">
        📤 Soumettre ma demande d'inscription
      </button>

      <p style="text-align:center;margin-top:16px;font-size:13px;color:#999;">
        Déjà un compte ? <a href="{{ route('responsable.login') }}" style="color:#008751;font-weight:bold;">Se connecter</a>
      </p>

    </form>
  </div>
</body>
</html>