<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Espace Université — OrientaBac</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI',sans-serif; background:linear-gradient(135deg,#1E3A5F,#2d5f8a); min-height:100vh; display:flex; align-items:center; justify-content:center; }
    .box { background:white; border-radius:16px; padding:40px; width:100%; max-width:440px; box-shadow:0 20px 60px rgba(0,0,0,0.3); }
    .top-band { height:6px; background:linear-gradient(to right,#008751 33%,#FCD116 33% 66%,#E8112D 66%); border-radius:16px 16px 0 0; margin:-40px -40px 30px; }
    .header { text-align:center; margin-bottom:28px; }
    .header h1 { font-size:22px; font-weight:bold; color:#1E3A5F; margin-bottom:6px; }
    .header h1 span { color:#FCD116; }
    .header p { font-size:13px; color:#999; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:bold; color:#555; margin-bottom:6px; }
    .form-group input { width:100%; padding:12px 14px; border:1.5px solid #ddd; border-radius:8px; font-size:14px; outline:none; }
    .form-group input:focus { border-color:#008751; }
    .btn { width:100%; padding:13px; background:#008751; color:white; border:none; border-radius:8px; font-size:15px; font-weight:bold; cursor:pointer; margin-top:8px; }
    .btn:hover { background:#006b40; }
    .alert-error { background:rgba(232,17,45,0.1); border:1px solid #E8112D; color:#E8112D; padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:16px; }
    .alert-success { background:rgba(0,135,81,0.1); border:1px solid #008751; color:#008751; padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:16px; }
    .footer-link { text-align:center; margin-top:20px; font-size:13px; color:#777; }
    .footer-link a { color:#008751; font-weight:bold; text-decoration:none; }
  </style>
</head>
<body>
  <div class="box">
    <div class="top-band"></div>
    <div class="header">
      <h1>Orienta<span>Bac</span></h1>
      <p>Espace Université / École privée</p>
    </div>

    @if(session('success'))
      <div class="alert-success">✅ {{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('responsable.login.post') }}">
      @csrf
      <div class="form-group">
        <label>Adresse email</label>
        <input type="email" name="email" placeholder="contact@monuniversite.bj" value="{{ old('email') }}" required />
      </div>
      <div class="form-group">
        <label>Mot de passe</label>
        <input type="password" name="password" placeholder="••••••••" required />
      </div>
      <button type="submit" class="btn">Se connecter</button>
    </form>

    <div class="footer-link">
      Pas encore de compte ? <a href="{{ route('responsable.register') }}">Créer un compte</a>
    </div>
    <div class="footer-link" style="margin-top:8px;">
      <a href="{{ route('accueil') }}">← Retour à OrientaBac</a>
    </div>
  </div>
</body>
</html>