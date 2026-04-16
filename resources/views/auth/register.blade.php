@extends('layouts.app')

@section('title', 'Inscription — OrientaBac')

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
    .nav-btn { background-color: #008751; color: white !important; padding: 8px 20px; border-radius: 6px; font-weight: bold !important; }
    .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
    .hamburger span { width: 25px; height: 3px; background-color: white; border-radius: 2px; }

    .auth-wrapper { min-height: calc(100vh - 78px); display: flex; align-items: center; justify-content: center; padding: 50px 20px; background: linear-gradient(135deg, #1E3A5F 0%, #2d5f8a 60%, #F4F6F9 100%); }
    .auth-box { background: white; border-radius: 16px; box-shadow: 0 8px 30px rgba(0,0,0,0.15); width: 100%; max-width: 480px; overflow: hidden; }
    .auth-top-band { height: 6px; position: relative; overflow: hidden; }
    .auth-top-band::before { content: ''; position: absolute; left: 0; top: 0; width: 33%; height: 100%; background-color: #008751; }
    .auth-top-band::after { content: ''; position: absolute; left: 33%; top: 0; width: 67%; height: 50%; background-color: #FCD116; box-shadow: 0 3px 0 0 #E8112D; }
    .auth-header { padding: 30px 35px 20px; text-align: center; }
    .auth-logo { font-size: 28px; font-weight: bold; color: #1E3A5F; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 8px; }
    .auth-logo span { color: #FCD116; }
    .auth-header p { font-size: 14px; color: #777; }
    .auth-tabs { display: flex; border-bottom: 2px solid #eee; margin: 0 35px; }
    .tab-btn { flex: 1; padding: 12px; background: none; border: none; font-size: 15px; font-weight: bold; color: #999; cursor: pointer; transition: all 0.2s; border-bottom: 3px solid transparent; margin-bottom: -2px; text-decoration: none; display: block; text-align: center; }
    .tab-btn.active { color: #008751; border-bottom-color: #008751; }
    .auth-form { padding: 25px 35px 35px; }
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 6px; }
    .form-group input, .form-group select { width: 100%; padding: 12px 14px; border: 1.5px solid #ddd; border-radius: 8px; font-size: 14px; color: #333; transition: border-color 0.2s; outline: none; background-color: #fafafa; }
    .form-group input:focus, .form-group select:focus { border-color: #008751; background-color: white; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .btn-submit { width: 100%; padding: 13px; background-color: #008751; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background-color 0.2s; margin-top: 8px; }
    .btn-submit:hover { background-color: #006b40; }
    .form-footer { text-align: center; margin-top: 16px; font-size: 13px; color: #777; }
    .form-footer a { color: #008751; font-weight: bold; text-decoration: none; }
    .divider { display: flex; align-items: center; gap: 12px; margin: 20px 0; color: #bbb; font-size: 13px; }
    .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background-color: #eee; }
    .btn-guest { width: 100%; padding: 12px; background-color: transparent; color: #1E3A5F; border: 2px solid #1E3A5F; border-radius: 8px; font-size: 14px; font-weight: bold; cursor: pointer; transition: all 0.2s; text-decoration: none; display: block; text-align: center; }
    .btn-guest:hover { background-color: #1E3A5F; color: white; }
    .alert-error { background-color: rgba(232,17,45,0.1); border: 1px solid #E8112D; color: #E8112D; padding: 12px 18px; border-radius: 8px; margin-bottom: 18px; font-size: 13px; }

    footer { background-color: #12253d; padding: 30px 80px; }
    .footer-bottom { text-align: center; }
    .footer-bottom p { color: rgba(255,255,255,0.4); font-size: 12px; }

    @media (max-width: 768px) {
      nav { padding: 0 20px; }
      nav ul { display: none; }
      .hamburger { display: flex; }
      .auth-form { padding: 20px; }
      .auth-tabs { margin: 0 20px; }
      .form-row { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

  <div class="auth-wrapper">
    <div class="auth-box">
      <div class="auth-top-band"></div>

      <div class="auth-header">
        <div class="auth-logo">
          <div class="logo-flag"><div class="f1"></div><div class="f2"></div><div class="f3"></div></div>
          Orienta<span>Bac</span>
        </div>
        <p>Ton guide d'orientation universitaire au Bénin</p>
      </div>

      <div class="auth-tabs">
        <a href="{{ route('login') }}" class="tab-btn">Se connecter</a>
        <a href="{{ route('register') }}" class="tab-btn active">S'inscrire</a>
      </div>

      <!-- INSCRIPTION -->
      <div class="auth-form">

        @if($errors->any())
          <div class="alert-error">
            @foreach($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
          @csrf
          <div class="form-row">
            <div class="form-group">
              <label>Nom</label>
              <input type="text" name="nom" placeholder="Votre nom"
                     value="{{ old('nom') }}" required />
            </div>
            <div class="form-group">
              <label>Prénom</label>
              <input type="text" name="prenom" placeholder="Votre prénom"
                     value="{{ old('prenom') }}" required />
            </div>
          </div>
          <div class="form-group">
            <label>Adresse email</label>
            <input type="email" name="email" placeholder="exemple@gmail.com"
                   value="{{ old('email') }}" required />
          </div>
          <div class="form-group">
            <label>Série du baccalauréat</label>
            <select name="id_serie">
              <option value="">-- Sélectionner votre série --</option>
              @foreach($series as $serie)
                <option value="{{ $serie->id_serie }}"
                  {{ old('id_serie') == $serie->id_serie ? 'selected' : '' }}>
                  {{ $serie->libelle }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Mot de passe</label>
              <input type="password" name="password" placeholder="••••••••" required />
            </div>
            <div class="form-group">
              <label>Confirmer</label>
              <input type="password" name="password_confirmation" placeholder="••••••••" required />
            </div>
          </div>
          <button type="submit" class="btn-submit">Créer mon compte</button>
        </form>

        <div class="divider">ou</div>
        <a href="{{ route('questionnaire') }}" class="btn-guest">🎯 Continuer sans compte</a>

        <div class="form-footer">
          Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
        </div>
      </div>

    </div>
  </div>

  <footer>
    <div class="footer-bottom">
      <p>© {{ date('Y') }} OrientaBac — Ministère de l'Enseignement Supérieur et de la Recherche Scientifique du Bénin</p>
    </div>
  </footer>

@endsection