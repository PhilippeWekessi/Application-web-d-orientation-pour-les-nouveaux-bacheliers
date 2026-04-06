<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'OrientaBac')</title>
  <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
  @yield('styles')
</head>
<body>

  <!-- BANDEAU DRAPEAU -->
  <div class="drapeau-bande"></div>

  <!-- NAVBAR -->
  <nav>
    <div class="logo">
      <div class="logo-flag"></div>
      Orienta<span>Bac</span>
    </div>
    <ul>
      <li><a href="{{ route('accueil') }}" class="{{ request()->routeIs('accueil') ? 'active' : '' }}">Accueil</a></li>
      <li><a href="{{ route('filieres.index') }}">Filières</a></li>
      <li><a href="{{ route('universites.index') }}">Universités</a></li>
      <li><a href="{{ route('actualites.index') }}">Actualités</a></li>
      <li><a href="{{ route('temoignages.index') }}">Témoignages</a></li>
      @auth
        <li><a href="{{ route('profil') }}" class="nav-btn">Mon profil</a></li>
      @else
        <li><a href="{{ route('login') }}" class="nav-btn">Se connecter</a></li>
      @endauth
    </ul>
    <div class="hamburger">
      <span></span><span></span><span></span>
    </div>
  </nav>

  <!-- CONTENU -->
  @yield('content')

  <!-- FOOTER -->
  <footer>
    <div class="footer-top-band"></div>
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="logo">
          <div class="logo-flag"></div>
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

  @yield('scripts')
</body>
</html>