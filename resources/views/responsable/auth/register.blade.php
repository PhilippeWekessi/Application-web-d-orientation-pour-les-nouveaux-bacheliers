<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Inscription Responsable — OrientaBac</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI',sans-serif; background:linear-gradient(135deg,#1E3A5F,#2d5f8a); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:30px 16px; }
    .box { background:white; border-radius:16px; padding:40px; width:100%; max-width:480px; box-shadow:0 20px 60px rgba(0,0,0,0.3); }
    .top-band { height:6px; background:linear-gradient(to right,#008751 33%,#FCD116 33% 66%,#E8112D 66%); border-radius:16px 16px 0 0; margin:-40px -40px 30px; }
    .header { text-align:center; margin-bottom:24px; }
    .header h1 { font-size:22px; font-weight:bold; color:#1E3A5F; margin-bottom:6px; }
    .header h1 span { color:#FCD116; }
    .header p { font-size:13px; color:#999; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .form-group { margin-bottom:16px; }
    .form-group label { display:block; font-size:13px; font-weight:bold; color:#555; margin-bottom:6px; }
    .form-group input { width:100%; padding:12px 14px; border:1.5px solid #ddd; border-radius:8px; font-size:14px; outline:none; background:#fafafa; color:#333; }
    .form-group input:focus { border-color:#008751; background:white; }
    .btn { width:100%; padding:13px; background:#008751; color:white; border:none; border-radius:8px; font-size:15px; font-weight:bold; cursor:pointer; margin-top:8px; transition:background 0.2s; }
    .btn:hover { background:#006b40; }
    .alert-error { background:rgba(232,17,45,0.08); border:1px solid #E8112D; color:#E8112D; padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:16px; }
    .alert-success { background:rgba(0,135,81,0.1); border:1px solid #008751; color:#008751; padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:16px; }
    .footer-link { text-align:center; margin-top:18px; font-size:13px; color:#777; }
    .footer-link a { color:#008751; font-weight:bold; text-decoration:none; }
    .required { color:#E8112D; margin-left:2px; }
    @media(max-width:480px) { .form-row { grid-template-columns:1fr; } }
  </style>
</head>
<body>
  <div class="box">
    <div class="top-band"></div>
    <div class="header">
      <h1>Orienta<span>Bac</span></h1>
      <p>Créer un compte Responsable</p>
    </div>

    @if(session('success'))
      <div class="alert-success">✅ {{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="alert-error">
        @foreach($errors->all() as $error)
          <div>❌ {{ $error }}</div>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('responsable.register.post') }}">
      @csrf
      <div class="form-row">
        <div class="form-group">
          <label>Prénom <span class="required">*</span></label>
          <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Ex : Kofi" required />
        </div>
        <div class="form-group">
          <label>Nom <span class="required">*</span></label>
          <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Ex : AGOSSOU" required />
        </div>
      </div>
      <div class="form-group">
        <label>Email <span class="required">*</span></label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="contact@ecole.bj" required />
      </div>
      <div class="form-group">
        <label>Téléphone</label>
        <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="+229 97..." />
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Mot de passe <span class="required">*</span></label>
          <input type="password" name="password" placeholder="Min. 6 caractères" required />
        </div>
        <div class="form-group">
          <label>Confirmer <span class="required">*</span></label>
          <input type="password" name="password_confirmation" placeholder="Répéter" required />
        </div>
      </div>
      <button type="submit" class="btn">✅ Créer mon compte</button>
    </form>

    <div class="footer-link">
      Déjà un compte ? <a href="{{ route('responsable.login') }}">Se connecter</a>
    </div>
    <div class="footer-link" style="margin-top:8px;">
      <a href="{{ route('accueil') }}">← Retour à OrientaBac</a>
    </div>
  </div>
</body>
</html>