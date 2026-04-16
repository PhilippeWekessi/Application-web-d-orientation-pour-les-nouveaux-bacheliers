<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin — Connexion OrientaBac</title>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #12253d, #1E3A5F); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    .login-box { background: white; border-radius: 16px; padding: 40px; width: 100%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    .login-header { text-align: center; margin-bottom: 30px; }
    .login-logo { font-size: 24px; font-weight: bold; color: #1E3A5F; margin-bottom: 6px; }
    .login-logo span { color: #FCD116; }
    .login-header p { font-size: 13px; color: #999; }
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 6px; }
    .form-group input { width: 100%; padding: 12px 14px; border: 1.5px solid #ddd; border-radius: 8px; font-size: 14px; outline: none; transition: border-color 0.2s; }
    .form-group input:focus { border-color: #008751; }
    .btn-login { width: 100%; padding: 13px; background-color: #008751; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; margin-top: 8px; }
    .btn-login:hover { background-color: #006b40; }
    .alert-error { background: rgba(232,17,45,0.1); border: 1px solid #E8112D; color: #E8112D; padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }
    .top-band { height: 6px; background: linear-gradient(to right, #008751 33%, #FCD116 33% 66%, #E8112D 66%); border-radius: 16px 16px 0 0; margin: -40px -40px 30px; }
  </style>
</head>
<body>
  <div class="login-box">
    <div class="top-band"></div>
    <div class="login-header">
      <div class="login-logo">Orienta<span>Bac</span> — Admin</div>
      <p>Espace réservé aux administrateurs MESRS</p>
    </div>

    @if($errors->any())
      <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
      @csrf
      <div class="form-group">
        <label>Adresse email</label>
        <input type="email" name="email" placeholder="admin@mesrs.bj" value="{{ old('email') }}" required />
      </div>
      <div class="form-group">
        <label>Mot de passe</label>
        <input type="password" name="password" placeholder="••••••••" required />
      </div>
      <button type="submit" class="btn-login">Se connecter</button>
    </form>
  </div>
</body>
</html>