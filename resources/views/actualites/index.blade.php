@extends('layouts.app')

@section('title', 'Actualités — OrientaBac')

@section('styles')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background-color: #F4F6F9; color: #333333; }

    .drapeau-bande { height: 8px; position: relative; display: flex; }
    .drapeau-bande::before { content: ''; position: absolute; left: 0; top: 0; width: 33%; height: 100%; background-color: #008751; }
    .drapeau-bande::after { content: ''; position: absolute; left: 33%; top: 0; width: 67%; height: 50%; background-color: #FCD116; box-shadow: 0 4px 0 0 #E8112D; }

    nav { background-color: #1E3A5F; height: 70px; display: flex; align-items: center; justify-content: space-between; padding: 0 60px; position: sticky; top: 0; z-index: 100; }
    nav .logo { color: white; font-size: 22px; font-weight: bold; letter-spacing: 1px; display: flex; align-items: center; gap: 8px; }
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

    .hero { background: linear-gradient(135deg, #1E3A5F 0%, #2d5f8a 100%); height: 180px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 0 20px; position: relative; overflow: hidden; }
    .hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 5px; background: linear-gradient(to right, #008751 33%, #FCD116 33% 66%, #E8112D 66%); }
    .hero h1 { color: white; font-size: 36px; font-weight: bold; margin-bottom: 10px; }
    .hero p { color: rgba(255,255,255,0.8); font-size: 16px; max-width: 600px; }

    .section-header { text-align: center; margin-bottom: 40px; }
    .section-header h2 { font-size: 28px; font-weight: bold; color: #1E3A5F; margin-bottom: 10px; }
    .section-header .line { width: 60px; height: 8px; position: relative; margin: 12px auto 0; border-radius: 2px; overflow: hidden; }
    .section-header .line::before { content: ''; position: absolute; left: 0; top: 0; width: 33%; height: 100%; background-color: #008751; }
    .section-header .line::after { content: ''; position: absolute; left: 33%; top: 0; width: 67%; height: 50%; background-color: #FCD116; box-shadow: 0 4px 0 0 #E8112D; }

    .section-actu { padding: 60px 80px; }

    .grille { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }

    .card { background-color: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; display: flex; flex-direction: column; transition: transform 0.2s; }
    .card:hover { transform: translateY(-5px); }
    .card-image { width: 100%; height: 180px; background-color: #D0E8DA; display: flex; align-items: center; justify-content: center; font-size: 40px; overflow: hidden; }
    .card-image img { width: 100%; height: 100%; object-fit: cover; }
    .card-body { padding: 18px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
    .card-tag { display: inline-block; background-color: rgba(0,135,81,0.1); color: #008751; font-size: 11px; font-weight: bold; padding: 3px 10px; border-radius: 20px; align-self: flex-start; }
    .card-date { font-size: 12px; color: #999; }
    .card-title { font-size: 15px; font-weight: bold; color: #1E3A5F; line-height: 1.4; }
    .card-desc { font-size: 13px; color: #666; line-height: 1.6; flex: 1; }
    .card-btn { display: inline-block; margin-top: 12px; padding: 8px 18px; background-color: #008751; color: white; font-size: 13px; font-weight: bold; border-radius: 6px; text-decoration: none; align-self: flex-start; transition: background-color 0.2s; }
    .card-btn:hover { background-color: #006b40; }

    .pagination { display: flex; justify-content: center; gap: 10px; margin-top: 50px; }
    .pagination a { padding: 8px 16px; border-radius: 6px; background-color: white; color: #1E3A5F; font-size: 14px; text-decoration: none; border: 1px solid #ddd; transition: all 0.2s; }
    .pagination a.active, .pagination a:hover { background-color: #008751; color: white; border-color: #008751; }

    footer { background-color: #12253d; padding: 50px 80px 30px; }
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
      .section-actu { padding: 40px 20px; }
      .grille { grid-template-columns: 1fr; }
      footer { padding: 40px 20px 20px; }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 30px; }
    }
</style>
@endsection

@section('content')

  <!-- HERO -->
  <div class="hero">
    <h1>Actualités</h1>
    <p>Restez informé des dernières nouvelles de l'enseignement supérieur au Bénin</p>
  </div>

  <!-- SECTION ACTUALITES -->
  <section class="section-actu">
    <div class="section-header">
      <h2>Dernières actualités</h2>
      <div class="line"></div>
    </div>

    <div class="grille">
      @forelse($actualites as $actualite)
        <div class="card">
          <div class="card-image">
            @if($actualite->image)
              <img src="{{ asset('storage/' . $actualite->image) }}" alt="{{ $actualite->titre }}" />
            @else
              
            @endif
          </div>
          <div class="card-body">
            <span class="card-tag">Actualité</span>
            <span class="card-date">{{ \Carbon\Carbon::parse($actualite->created_at)->locale('fr')->isoFormat('D MMMM YYYY') }}</span>
            <h3 class="card-title">{{ $actualite->titre }}</h3>
            <p class="card-desc">{{ Str::limit($actualite->contenu, 120) }}</p>
            <a href="{{ route('actualites.show', $actualite->id_actualite) }}" class="card-btn">Lire la suite →</a>
          </div>
        </div>
      @empty
        <div style="grid-column: 1/-1; text-align:center; padding:60px 20px; color:#777;">
          <p style="font-size:18px; margin-bottom:10px;">Aucune actualité disponible pour le moment</p>
          <p>Les actualités sont publiées par l'administrateur. Revenez bientôt pour découvrir les dernières nouvelles !</p>
        </div>
      @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="pagination">
      {{ $actualites->links('vendor.pagination.custom') }}
    </div>

  </section>

  <!-- FOOTER -->
  <footer>
    <div class="footer-top-band"></div>
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="logo">
          <div class="logo-flag"><div class="f1"></div><div class="f2"></div><div class="f3"></div></div>
          Orienta<span>Bac</span>
        </div>
        <p>Plateforme d'orientation universitaire pour les bacheliers béninois, basée sur les données officielles du Ministère de l'Enseignement Supérieur et de la Recherche Scientifique.</p>
      </div>
      <div class="footer-col">
        <h4>Navigation</h4>
        <ul>
          <li><a href="{{ route('accueil') }}">Accueil</a></li>
          <li><a href="{{ route('filieres.index') }}">Filières</a></li>
          <li><a href="{{ route('universites.index') }}">Universités</a></li>
          <li><a href="{{ route('actualites.index') }}">Actualités</a></li>
          <li><a href="{{ route('temoignages.index') }}">Témoignages</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Orientation</h4>
        <ul>
          <li><a href="{{ route('questionnaire') }}">Questionnaire</a></li>
          <li><a href="{{ route('resultats') }}">Mes résultats</a></li>
          <li><a href="{{ route('profil') }}">Mon profil</a></li>
          <li><a href="{{ route('register') }}">S'inscrire</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Contact</h4>
        <ul>
          <li><a href="#">À propos</a></li>
          <li><a href="#">Support</a></li>
          <li><a href="#">MESRS Bénin</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© {{ date('Y') }} OrientaBac — Ministère de l'Enseignement Supérieur et de la Recherche Scientifique du Bénin</p>
    </div>
  </footer>

@endsection