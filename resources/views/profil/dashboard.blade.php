<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Segoe UI', sans-serif; background: #F4F6F9; color: #333; }

  /* TOPBAR */
  .topbar { background: #132C54; padding: 0 40px; height: 72px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; box-shadow: 0 10px 30px rgba(0,0,0,0.16); }
  .logo { color: white; font-size: 22px; font-weight: 800; display: flex; align-items: center; gap: 10px; text-decoration: none; }
  .logo span { color: #FDDC43; }
  .topbar-right { display: flex; align-items: center; gap: 16px; }
  .topbar-user { color: rgba(255,255,255,0.95); font-size: 14px; display: flex; align-items: center; gap: 12px; padding: 10px 14px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.14); border-radius: 999px; }
  .topbar-user .user-avatar { width: 36px; height: 36px; border-radius: 50%; overflow: hidden; display: inline-flex; align-items: center; justify-content: center; background: #008751; }
  .topbar-user .user-avatar img { width: 100%; height: 100%; object-fit: cover; }
  .topbar-user span { display: inline-flex; width: 36px; height: 36px; border-radius: 50%; align-items: center; justify-content: center; background: #008751; color: white; font-weight: 800; font-size: 13px; }
  .btn-logout { padding: 10px 22px; background: rgba(255,255,255,0.12); color: white; border: 1px solid rgba(255,255,255,0.2); border-radius: 999px; font-size: 13px; font-weight: 700; cursor: pointer; }
  .btn-logout:hover { background: rgba(255,255,255,0.22); }

  /* DRAPEAU */
  .drapeau-bande { height: 6px; background: linear-gradient(to right, #008751 33%, #FDDC43 33% 66%, #E8112D 66%); }

  /* HERO */
  .hero { background: linear-gradient(135deg, #0F335E 0%, #163E7B 55%, #1B3160 100%); padding: 40px 45px; position: relative; overflow: hidden; border-radius: 32px; box-shadow: 0 28px 90px rgba(14,30,64,0.2); margin-bottom: 36px; }
  .hero::before { content: ''; position: absolute; right: 0; top: 0; width: 45%; height: 100%; background: radial-gradient(circle at top right, rgba(255,255,255,0.12), transparent 55%); pointer-events: none; }
  .hero-inner { display: grid; grid-template-columns: minmax(0, 1.4fr) minmax(300px, 1fr); gap: 28px; align-items: center; }
  .hero-text h1 { color: white; font-size: 38px; font-weight: 800; line-height: 1.05; margin-bottom: 14px; }
  .hero-text p { color: rgba(255,255,255,0.88); font-size: 15px; max-width: 520px; line-height: 1.75; }
  .hero-actions { display: flex; gap: 12px; margin-top: 22px; }
  .btn-hero-primary { padding: 12px 26px; background: #FCD116; color: #132C54; border-radius: 999px; font-size: 14px; font-weight: 800; text-decoration: none; transition: transform 0.2s, background 0.2s; }
  .btn-hero-primary:hover { background: #e6be00; transform: translateY(-1px); }
  .btn-hero-secondary { padding: 12px 26px; background: transparent; color: white; border: 1px solid rgba(255,255,255,0.28); border-radius: 999px; font-size: 14px; font-weight: 700; text-decoration: none; transition: transform 0.2s, background 0.2s; }
  .btn-hero-secondary:hover { background: rgba(255,255,255,0.16); transform: translateY(-1px); }
  .hero-card { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); border-radius: 28px; padding: 26px; color: white; display: grid; gap: 20px; backdrop-filter: blur(12px); }
  .hero-card-top { display: flex; align-items: center; gap: 16px; }
  .hero-card-avatar { width: 60px; height: 60px; border-radius: 50%; background: rgba(255,255,255,0.14); display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 800; border: 1px solid rgba(255,255,255,0.18); overflow: hidden; }
  .hero-card-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
  .hero-card-title { font-size: 18px; font-weight: 800; }
  .hero-card-subtitle { font-size: 13px; color: rgba(255,255,255,0.78); line-height: 1.7; max-width: 310px; }
  .hero-card-metrics { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
  .hero-card-metric { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.16); border-radius: 20px; padding: 16px 18px; }
  .hero-card-metric span { display: block; color: rgba(255,255,255,0.7); font-size: 12px; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.04em; }
  .hero-card-metric strong { display: block; font-size: 26px; font-weight: 800; color: white; }
  .hero-card-note { color: rgba(255,255,255,0.75); font-size: 13px; line-height: 1.7; }

  /* CONTAINER */
  .container { max-width: 1100px; margin: 0 auto; padding: 30px 20px 60px; }

  /* STATS */
  .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
  .stat-card { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 14px; }
  .stat-icon { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; }
  .stat-icon.vert { background: rgba(0,135,81,0.7); }
  .stat-icon.bleu { background: rgba(30,58,95,0.7); }
  .stat-icon.jaune { background: rgba(252,209,22,0.8); }
  .stat-icon.rouge { background: rgba(232,17,45,0.7); }
  .stat-info h3 { font-size: 24px; font-weight: bold; color: #1E3A5F; }
  .stat-info p { font-size: 12px; color: #999; }

  /* GRID 2 COLONNES */
  .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px; }

  /* PANELS */
  .panel { background: white; border-radius: 14px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
  .panel-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
  .panel-header h2 { font-size: 17px; font-weight: bold; color: #1E3A5F; }
  .btn-voir-tout { font-size: 13px; color: #008751; font-weight: bold; text-decoration: none; }
  .btn-voir-tout:hover { text-decoration: underline; }

  /* SERVICES CARDS */
  .services-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
  .service-card { background: white; border-radius: 18px; padding: 24px; border: 1px solid #e8edf4; box-shadow: 0 18px 40px rgba(15,23,42,0.06); transition: transform 0.2s, border-color 0.2s; text-decoration: none; color: inherit; display: grid; gap: 16px; }
  .service-card:hover { transform: translateY(-4px); border-color: #008751; }
  .service-icon { width: 44px; height: 44px; border-radius: 14px; background: rgba(0,135,81,0.08); }
  .service-title { font-size: 15px; font-weight: 700; color: #1E293B; margin-bottom: 4px; }
  .service-desc { font-size: 13px; color: #556575; line-height: 1.6; }

  /* ACTUALITES */
  .actu-list { display: flex; flex-direction: column; gap: 14px; }
  .actu-item { display: flex; align-items: flex-start; gap: 14px; padding: 14px; background: #F8F9FA; border-radius: 10px; border-left: 3px solid #008751; }
  .actu-item:nth-child(2) { border-left-color: #FCD116; }
  .actu-item:nth-child(3) { border-left-color: #E8112D; }
  .actu-content { flex: 1; }
  .actu-titre { font-size: 14px; font-weight: bold; color: #1E3A5F; margin-bottom: 4px; }
  .actu-date { font-size: 11px; color: #aaa; margin-bottom: 8px; }
  .actu-extrait { font-size: 13px; color: #666; line-height: 1.5; }
  .btn-abonner { padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: bold; cursor: pointer; border: none; transition: all 0.2s; white-space: nowrap; flex-shrink: 0; }
  .btn-abonner.abonne { background: rgba(0,135,81,0.1); color: #008751; }
  .btn-abonner.abonne:hover { background: rgba(0,135,81,0.2); }
  .btn-abonner.non-abonne { background: #1E3A5F; color: white; }
  .btn-abonner.non-abonne:hover { background: #152c47; }

  /* PROFIL */
  .profil-info { display: flex; flex-direction: column; gap: 14px; }
  .profil-ligne { display: flex; align-items: center; gap: 12px; padding: 12px; background: #F8F9FA; border-radius: 10px; }
  .profil-icone { font-size: 18px; width: 36px; text-align: center; }
  .profil-label { font-size: 11px; color: #aaa; font-weight: bold; text-transform: uppercase; }
  .profil-valeur { font-size: 14px; font-weight: bold; color: #1E3A5F; }
  .btn-modifier { display: block; width: 100%; padding: 11px; background: #1E3A5F; color: white; border: none; border-radius: 10px; font-size: 14px; font-weight: bold; cursor: pointer; margin-top: 16px; text-align: center; text-decoration: none; transition: background 0.2s; }
  .btn-modifier:hover { background: #152c47; }

  /* ALERT */
  .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
  .alert-success { background: rgba(0,135,81,0.1); border: 1px solid #008751; color: #008751; }
  .alert-error { background: rgba(232,17,45,0.08); border: 1px solid #E8112D; color: #E8112D; }

  /* EMPTY */
  .empty { text-align: center; padding: 30px; color: #aaa; font-size: 14px; }

  @media (max-width: 1024px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .grid-2 { grid-template-columns: 1fr; }
    .services-grid { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 768px) {
    .topbar { padding: 0 20px; }
    .hero { padding: 28px 20px; }
    .stats-grid { grid-template-columns: 1fr 1fr; }
    .services-grid { grid-template-columns: 1fr; }
    .container { padding: 20px 16px 40px; }
  }
  @media (max-width: 480px) {
    .stats-grid { grid-template-columns: 1fr; }
    .hero-inner { grid-template-columns: 1fr; }
    .hero-card { padding: 24px; }
  }
  /* ===== FOOTER ===== */
    footer { background-color: #12253d; padding: 50px 80px 30px; }
    .footer-top-band {
      height: 8px;
      position: relative;
      margin-bottom: 40px;
      border-radius: 2px;
      overflow: hidden;
    }
    .footer-top-band::before {
      content: '';
      position: absolute;
      left: 0; top: 0;
      width: 33%; height: 100%;
      background-color: #008751;
    }
    .footer-top-band::after {
      content: '';
      position: absolute;
      left: 33%; top: 0;
      width: 67%; height: 50%;
      background-color: #FCD116;
      box-shadow: 0 4px 0 0 #E8112D;
    }
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
</style>

  <div class="drapeau-bande"></div>

  <!-- TOPBAR -->
  <div class="topbar">
    <a href="{{ route('accueil') }}" class="logo">
      <div class="logo-flag"><div class="f1"></div><div class="f2"></div><div class="f3"></div></div>
      Orienta<span>Bac</span>
    </a>
    <div class="topbar-right">
      <div class="topbar-user">
        <div class="user-avatar">
          @if(session('user_photo'))
            <img src="{{ asset(session('user_photo')) }}" alt="Profil" style="width:100%;height:100%;border-radius:50%;object-fit:cover;" />
          @else
            {{ strtoupper(substr(session('user_prenom', 'U'), 0, 1) . substr(session('user_nom', ''), 0, 1)) }}
          @endif
        </div>
        {{ session('user_prenom') }} {{ session('user_nom') }}
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">Déconnexion</button>
      </form>
    </div>
  </div>

  <!-- HERO -->
  <div class="hero">
    <div class="hero-inner">
      <div class="hero-text">
        <h1>Bonjour {{ session('user_prenom') }}</h1>
        <p>Bienvenue dans ton espace personnel OrientaBac. Retrouve tes recommandations, abonne-toi aux actualités universitaires et explore les filières disponibles.</p>
        <div class="hero-actions">
          <a href="{{ route('resultats') }}" class="btn-hero-primary">Mes résultats</a>
          <a href="{{ route('filieres.index') }}" class="btn-hero-secondary">Explorer les filières</a>
        </div>
      </div>
      <div class="hero-card">
        <div class="hero-card-top">
          <div class="hero-card-avatar">
            @if(session('user_photo'))
              <img src="{{ asset(session('user_photo')) }}" alt="Profil" />
            @else
              {{ strtoupper(substr(session('user_prenom', 'U'), 0, 1) . substr(session('user_nom', ''), 0, 1)) }}
            @endif
          </div>
          <div>
            <div class="hero-card-title">Bienvenue dans ton espace</div>
            <div class="hero-card-subtitle">Retrouve tes résultats, suis l'actualité et enrichis ton profil en toute simplicité.</div>
          </div>
        </div>
        <div class="hero-card-metrics">
          <div class="hero-card-metric">
            <span>Filières disponibles</span>
            <strong>{{ $totalFilieres }}</strong>
          </div>
          <div class="hero-card-metric">
            <span>Universités référencées</span>
            <strong>{{ $totalUniversites }}</strong>
          </div>
        </div>
        <div class="hero-card-note">Ton espace est mis à jour automatiquement pour te permettre de revenir consulter tes recommandations à tout moment.</div>
      </div>
    </div>
  </div>

  <div class="container">

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <!-- STATS -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon vert"></div>
        <div class="stat-info">
          <h3>{{ $totalFilieres }}</h3>
          <p>Filières disponibles</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon bleu"></div>
        <div class="stat-info">
          <h3>{{ $totalUniversites }}</h3>
          <p>Universités référencées</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon jaune"></div>
        <div class="stat-info">
          <h3>{{ $totalActualites }}</h3>
          <p>Actualités publiées</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon rouge"></div>
        <div class="stat-info">
          <h3>{{ $nbAbonnements }}</h3>
          <p>Mes abonnements</p>
        </div>
      </div>
    </div>

    <!-- SERVICES -->
    <div class="panel" style="margin-bottom:24px;">
      <div class="panel-header">
        <h2>Services disponibles</h2>
      </div>
      <div class="services-grid">
        <a href="{{ route('questionnaire') }}" class="service-card">
          <div class="service-title">Questionnaire d'orientation</div>
          <div class="service-desc">Réponds à quelques questions pour recevoir des recommandations personnalisées.</div>
        </a>
        <a href="{{ route('filieres.index') }}" class="service-card">
          <div class="service-title">Explorer les filières</div>
          <div class="service-desc">Consulte toutes les filières disponibles dans les universités publiques et privées.</div>
        </a>
        <a href="{{ route('universites.index') }}" class="service-card">
          <div class="service-title">Universités & Campus</div>
          <div class="service-desc">Découvre les universités et leurs campus à travers tout le Bénin.</div>
        </a>
        <a href="{{ route('actualites.index') }}" class="service-card">
          <div class="service-title">Actualités universitaires</div>
          <div class="service-desc">Reste informé des dernières nouvelles du MESRS et des universités.</div>
        </a>
        <a href="{{ route('temoignages.create') }}" class="service-card">
          <div class="service-title">Témoignages</div>
          <div class="service-desc">Lis les témoignages d'étudiants et partage ta propre expérience.</div>
        </a>
        <a href="{{ route('resultats') }}" class="service-card">
          <div class="service-title">Mes résultats</div>
          <div class="service-desc">Retrouve tes dernières recommandations d'orientation personnalisées.</div>
        </a>
      </div>
    </div>

    <!-- ACTUALITES + PROFIL -->
    <div class="grid-2">

      <!-- ACTUALITES AVEC ABONNEMENT -->
      <div class="panel">
        <div class="panel-header">
          <h2>Actualités récentes</h2>
          <a href="{{ route('actualites.index') }}" class="btn-voir-tout">Voir toutes →</a>
        </div>

        <div class="actu-list">
          @forelse($actualites as $actu)
            <div class="actu-item">
              <div class="actu-content">
                <div class="actu-titre">{{ $actu->titre }}</div>
                <div class="actu-date">{{ $actu->created_at?->format('d/m/Y') ?? '—' }}</div>
                <div class="actu-extrait">{{ Str::limit($actu->contenu, 80) }}</div>
              </div>
              <form method="POST"
                    action="{{ $abonnementsIds->contains($actu->id_actualite)
                        ? route('abonnements.retirer', $actu->id_actualite)
                        : route('abonnements.ajouter', $actu->id_actualite) }}">
                  @csrf
                  @if($abonnementsIds->contains($actu->id_actualite))
                      @method('DELETE')
                  @endif
                  <button type="submit"
                          class="btn-abonner {{ $abonnementsIds->contains($actu->id_actualite) ? 'abonne' : 'non-abonne' }}">
                      {{ $abonnementsIds->contains($actu->id_actualite) ? 'Abonné' : '+ S\'abonner' }}
                  </button>
              </form>
            </div>
          @empty
            <div class="empty">Aucune actualité pour l'instant.</div>
          @endforelse
        </div>
      </div>

      <!-- PROFIL -->
      <div class="panel">
        <div class="panel-header">
          <h2>Mon profil</h2>
        </div>
        <div class="profil-info">
          <div class="profil-ligne">
            <div>
              <div class="profil-label">Nom complet</div>
              <div class="profil-valeur">{{ session('user_prenom') }} {{ session('user_nom') }}</div>
            </div>
          </div>
          <div class="profil-ligne">
            <div>
              <div class="profil-label">Email</div>
              <div class="profil-valeur">{{ session('user_email') }}</div>
            </div>
          </div>
          <div class="profil-ligne">
            <div>
              <div class="profil-label">Série du bac</div>
              <div class="profil-valeur">{{ session('user_serie') ?? 'Non renseignée' }}</div>
            </div>
          </div>
          <div class="profil-ligne">
            <div>
              <div class="profil-label">Abonnements actifs</div>
              <div class="profil-valeur">{{ $nbAbonnements }} actualité(s)</div>
            </div>
          </div>
        </div>
        <a href="{{ route('profil.edit') }}" class="btn-modifier">Modifier mon profil</a>
        <a href="{{ route('questionnaire') }}" class="btn-modifier" style="margin-top:8px; background:#FCD116; color:#1E3A5F;">Refaire mon orientation</a>
      </div>

    </div>

  </div>