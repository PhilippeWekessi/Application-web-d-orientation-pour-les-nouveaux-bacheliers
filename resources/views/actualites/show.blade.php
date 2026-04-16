@extends('layouts.app')

@section('title', $actualite->titre . ' — OrientaBac')

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
    nav ul li a.active { color: #FCD116; font-weight: bold; }
    .nav-btn { background-color: #008751; color: white !important; padding: 8px 20px; border-radius: 6px; font-weight: bold !important; }
    .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
    .hamburger span { width: 25px; height: 3px; background-color: white; border-radius: 2px; }

    .hero { background: linear-gradient(135deg, #1E3A5F 0%, #2d5f8a 100%); padding: 50px 80px; position: relative; overflow: hidden; }
    .hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 5px; background: linear-gradient(to right, #008751 33%, #FCD116 33% 66%, #E8112D 66%); }
    .hero h1 { color: white; font-size: 34px; font-weight: bold; margin-bottom: 10px; }
    .hero p { color: rgba(255,255,255,0.8); font-size: 15px; margin-bottom: 30px; }

    .main { padding: 40px 80px; }

    .actu-detail { background: white; border-radius: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); overflow: hidden; }
    .actu-image { width: 100%; height: 300px; background-color: #D0E8DA; display: flex; align-items: center; justify-content: center; font-size: 60px; overflow: hidden; }
    .actu-image img { width: 100%; height: 100%; object-fit: cover; }
    .actu-body { padding: 30px; }
    .actu-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
    .actu-date { font-size: 14px; color: #777; }
    .actu-tag { background-color: rgba(0,135,81,0.1); color: #008751; font-size: 12px; font-weight: bold; padding: 4px 12px; border-radius: 20px; }
    .actu-title { font-size: 28px; font-weight: bold; color: #1E3A5F; margin-bottom: 20px; line-height: 1.3; }
    .actu-content { font-size: 16px; line-height: 1.7; color: #555; margin-bottom: 30px; }
    .actu-actions { display: flex; gap: 15px; align-items: center; }
    .btn-subscribe { background-color: #008751; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: bold; cursor: pointer; transition: background-color 0.2s; }
    .btn-subscribe:hover { background-color: #006b40; }
    .btn-unsubscribe { background-color: #E8112D; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: bold; cursor: pointer; transition: background-color 0.2s; }
    .btn-unsubscribe:hover { background-color: #c00; }
    .btn-login { background-color: #1E3A5F; color: white; padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: bold; text-decoration: none; transition: background-color 0.2s; }
    .btn-login:hover { background-color: #152c47; }
    .subscription-status { font-size: 14px; color: #777; }

    footer { background-color: #12253d; padding: 50px 80px 30px; margin-top: 40px; }
    .footer-top-band { height: 8px; position: relative; margin-bottom: 40px; border-radius: 2px; overflow: hidden; }
    .footer-top-band::before { content: ''; position: absolute; left: 0; top: 0; width: 33%; height: 100%; background-color: #008751; }
    .footer-top-band::after { content: ''; position: absolute; left: 33%; top: 0; width: 67%; height: 50%; background-color: #FCD116; box-shadow: 0 4px 0 0 #E8112D; }
    .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 40px; }
    .footer-brand .logo { color: white; font-size: 20px; font-weight: bold; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
    .footer-brand .logo span { color: #FCD116; }
    .footer-brand p { color: rgba(255,255,255,0.5); font-size: 13px; line-height: 1.7; }
    .footer-col h4 { color: white; font-size: 14px; font-weight: bold; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 2px solid #008751; display: inline-block; }
    .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
    .footer-col ul li a { color: rgba(255,255,255,0.5); text-decoration: none; font-size: 13px; transition: color 0.2s; }
    .footer-col ul li a:hover { color: #FCD116; }
    .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 25px; text-align: center; }
    .footer-bottom p { color: rgba(255,255,255,0.4); font-size: 12px; }

    @media (max-width: 768px) {
      nav { padding: 0 20px; }
      nav ul { display: none; }
      .hamburger { display: flex; }
      .hero { padding: 30px 20px; }
      .main { padding: 30px 20px; }
      .actu-meta { flex-direction: column; align-items: flex-start; }
      .actu-actions { flex-direction: column; align-items: stretch; }
      footer { padding: 40px 20px 20px; }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 30px; }
    }
</style>
@endsection

@section('content')

  <!-- HERO -->
  <div class="hero">
    <h1>{{ $actualite->titre }}</h1>
    <p>Restez informé des dernières actualités de l'enseignement supérieur</p>
  </div>

  <!-- MAIN -->
  <div class="main">

    <div class="actu-detail">
      <div class="actu-image">
        @if($actualite->image)
          <img src="{{ asset('storage/' . $actualite->image) }}" alt="{{ $actualite->titre }}" />
        @else
          📢
        @endif
      </div>
      <div class="actu-body">
        <div class="actu-meta">
          <span class="actu-date">{{ \Carbon\Carbon::parse($actualite->created_at)->locale('fr')->isoFormat('D MMMM YYYY') }}</span>
          <span class="actu-tag">Actualité</span>
        </div>
        <h2 class="actu-title">{{ $actualite->titre }}</h2>
        <div class="actu-content">
          {!! nl2br(e($actualite->contenu)) !!}
        </div>
        <div class="actu-actions">
          @auth
            @if(auth()->user()->abonnements()->where('id_actualite', $actualite->id_actualite)->exists())
              <form method="POST" action="{{ route('actualites.subscribe', $actualite->id_actualite) }}" style="display: inline;">
                @csrf
                @method('POST')
                <button type="submit" class="btn-unsubscribe">Se désabonner</button>
              </form>
              <span class="subscription-status">Vous êtes abonné à cette actualité</span>
            @else
              <form method="POST" action="{{ route('actualites.subscribe', $actualite->id_actualite) }}" style="display: inline;">
                @csrf
                @method('POST')
                <button type="submit" class="btn-subscribe">S'abonner à cette actualité</button>
              </form>
            @endif
          @else
            <a href="{{ route('login') }}" class="btn-login">Se connecter pour s'abonner</a>
            <span class="subscription-status">Connectez-vous pour recevoir les mises à jour</span>
          @endauth
        </div>
      </div>
    </div>

  </div>
@endsection