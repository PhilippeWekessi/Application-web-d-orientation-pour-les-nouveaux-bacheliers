<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Responsable — OrientaBac</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI',sans-serif; background:#F4F6F9; min-height:100vh; }

    /* TOPBAR */
    .topbar { background:#1E3A5F; height:65px; display:flex; align-items:center; justify-content:space-between; padding:0 40px; }
    .logo { color:white; font-size:20px; font-weight:bold; text-decoration:none; }
    .logo span { color:#FCD116; }
    .topbar-right { display:flex; align-items:center; gap:14px; }
    .user-avatar { width:34px; height:34px; border-radius:50%; background:#008751; color:white; font-weight:bold; font-size:13px; display:flex; align-items:center; justify-content:center; cursor:pointer; position:relative; }
    .user-avatar img { width:100%; height:100%; border-radius:50%; object-fit:cover; }
    .user-menu { position:absolute; top:100%; right:0; background:white; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.15); min-width:180px; z-index:1000; display:none; }
    .user-menu.show { display:block; }
    .user-menu-item { display:block; padding:12px 16px; color:#555; text-decoration:none; font-size:14px; transition:background 0.2s; }
    .user-menu-item:hover { background:#f8f9fa; color:#1E3A5F; }
    .user-menu-item:first-child { border-radius:8px 8px 0 0; }
    .user-menu-item:last-child { border-radius:0 0 8px 8px; border-top:1px solid #eee; color:#E8112D; }
    .user-menu-item:last-child:hover { background:#fef2f2; }
    .user-name { color:rgba(255,255,255,0.85); font-size:14px; cursor:pointer; }
    .user-info { display:flex; align-items:center; gap:8px; position:relative; }
    .btn-logout { padding:7px 16px; background:rgba(232,17,45,0.2); color:#ff6b6b; border:1px solid rgba(232,17,45,0.3); border-radius:7px; font-size:13px; font-weight:bold; cursor:pointer; }

    .drapeau { height:5px; background:linear-gradient(to right,#008751 33%,#FCD116 33% 66%,#E8112D 66%); }

    .container { max-width:960px; margin:0 auto; padding:30px 20px 60px; }

    /* HERO */
    .hero { background:linear-gradient(135deg,#1E3A5F,#2d5f8a); border-radius:16px; padding:30px 35px; color:white; margin-bottom:24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px; }
    .hero h1 { font-size:24px; font-weight:bold; margin-bottom:6px; }
    .hero p { font-size:14px; opacity:0.75; max-width:500px; }
    .hero-badge { background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); border-radius:12px; padding:14px 20px; text-align:center; }
    .hero-badge .icon { font-size:28px; }
    .hero-badge .label { font-size:11px; color:rgba(255,255,255,0.6); margin-top:4px; }

    /* ALERTS */
    .alert { padding:12px 16px; border-radius:10px; font-size:13px; margin-bottom:20px; display:flex; align-items:center; gap:8px; }
    .alert-success { background:rgba(0,135,81,0.1); border:1px solid #008751; color:#008751; }
    .alert-error { background:rgba(232,17,45,0.08); border:1px solid #E8112D; color:#E8112D; }

    /* STATS */
    .stats-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px; }
    .stat-card { background:white; border-radius:12px; padding:20px; box-shadow:0 2px 8px rgba(0,0,0,0.06); text-align:center; }
    .stat-card .num { font-size:28px; font-weight:bold; color:#1E3A5F; }
    .stat-card .lbl { font-size:12px; color:#999; margin-top:4px; }
    .stat-card.vert .num { color:#008751; }
    .stat-card.jaune .num { color:#c9a000; }
    .stat-card.rouge .num { color:#E8112D; }

    /* PANELS */
    .panel { background:white; border-radius:14px; padding:28px; box-shadow:0 2px 10px rgba(0,0,0,0.06); margin-bottom:20px; }
    .panel-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px; }
    .panel-header h2 { font-size:18px; font-weight:bold; color:#1E3A5F; }

    /* BADGES */
    .badge { display:inline-block; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:bold; }
    .badge-green { background:rgba(0,135,81,0.12); color:#008751; }
    .badge-yellow { background:rgba(252,209,22,0.2); color:#c9a000; }
    .badge-red { background:rgba(232,17,45,0.1); color:#E8112D; }
    .badge-blue { background:rgba(30,58,95,0.08); color:#1E3A5F; }

    /* BOUTONS */
    .btn-primary { padding:11px 24px; background:#008751; color:white; border:none; border-radius:8px; font-size:14px; font-weight:bold; cursor:pointer; text-decoration:none; display:inline-block; transition:background 0.2s; }
    .btn-primary:hover { background:#006b40; }
    .btn-secondary { padding:11px 24px; background:#1E3A5F; color:white; border:none; border-radius:8px; font-size:14px; font-weight:bold; cursor:pointer; text-decoration:none; display:inline-block; transition:background 0.2s; }
    .btn-secondary:hover { background:#152c47; }

    /* BOITE STATUT */
    .status-box { border-radius:12px; padding:24px; text-align:center; margin-bottom:20px; }
    .status-box.waiting { background:#fffbeb; border:2px dashed #f59e0b; }
    .status-box.validated { background:rgba(0,135,81,0.06); border:2px solid rgba(0,135,81,0.2); }
    .status-box.rejected { background:#fef2f2; border:2px dashed #ef4444; }
    .status-box .icon { font-size:40px; margin-bottom:10px; }
    .status-box h3 { font-size:16px; font-weight:bold; margin-bottom:8px; }
    .status-box.waiting h3 { color:#92400e; }
    .status-box.validated h3 { color:#008751; }
    .status-box.rejected h3 { color:#b91c1c; }
    .status-box p { font-size:13px; line-height:1.7; }
    .status-box.waiting p { color:#78350f; }
    .status-box.rejected p { color:#b91c1c; }

    /* INFOS UNIVERSITE */
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:16px; }
    .info-item { background:#F8F9FA; border-radius:8px; padding:12px 16px; }
    .info-item .lbl { font-size:11px; font-weight:bold; color:#aaa; text-transform:uppercase; margin-bottom:4px; }
    .info-item .val { font-size:14px; font-weight:bold; color:#1E3A5F; }

    /* TABLE FILIERES */
    .table { width:100%; border-collapse:collapse; }
    .table th { text-align:left; font-size:12px; font-weight:bold; color:#999; text-transform:uppercase; padding:10px 14px; background:#F8F9FA; }
    .table td { padding:14px; font-size:14px; color:#555; border-bottom:1px solid #f0f0f0; vertical-align:middle; }
    .table tr:last-child td { border-bottom:none; }
    .motif { font-size:12px; color:#E8112D; margin-top:4px; }
    .empty { text-align:center; padding:40px; color:#aaa; font-size:14px; }

    /* STEPS */
    .steps { display:flex; gap:0; margin-bottom:28px; }
    .step { flex:1; text-align:center; position:relative; }
    .step:not(:last-child)::after { content:''; position:absolute; top:18px; left:50%; width:100%; height:2px; background:#ddd; z-index:0; }
    .step.done::after { background:#008751; }
    .step-circle { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:bold; margin:0 auto 8px; border:2px solid #ddd; background:white; color:#aaa; position:relative; z-index:1; }
    .step.done .step-circle { background:#008751; border-color:#008751; color:white; }
    .step.active .step-circle { background:#1E3A5F; border-color:#1E3A5F; color:white; }
    .step-label { font-size:12px; color:#aaa; font-weight:bold; }
    .step.done .step-label { color:#008751; }
    .step.active .step-label { color:#1E3A5F; }

    @media(max-width:768px) {
      .topbar { padding:0 20px; }
      .stats-grid { grid-template-columns:1fr; }
      .info-grid { grid-template-columns:1fr; }
      .container { padding:20px 16px; }
    }
  </style>
</head>
<body>

  <div class="topbar">
    <a href="{{ route('accueil') }}" class="logo">Orienta<span>Bac</span></a>
    <div class="topbar-right">
      <div class="user-info" onclick="toggleUserMenu()">
        <div class="user-avatar">
          @if(session('responsable_photo'))
            <img src="{{ asset('storage/' . session('responsable_photo')) }}" alt="Photo de profil">
          @else
            {{ strtoupper(substr(session('responsable_prenom','R'),0,1).substr(session('responsable_nom',''),0,1)) }}
          @endif
        </div>
        <span class="user-name">{{ session('responsable_prenom') }} {{ session('responsable_nom') }}</span>
        <div class="user-menu" id="userMenu">
          <a href="{{ route('responsable.profil') }}" class="user-menu-item">Mon profil</a>
          <form method="POST" action="{{ route('responsable.logout') }}">
            @csrf
            <button type="submit" class="user-menu-item" style="width:100%; text-align:left; border:none; background:none; cursor:pointer;">Déconnexion</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="drapeau"></div>

  <div class="container">

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <!-- HERO -->
    <div class="hero">
      <div>
        <h1>Bonjour {{ session('responsable_prenom') }} </h1>
        <p>Gérez votre université et soumettez vos filières pour validation par l'administrateur MESRS.</p>
      </div>
      <div class="hero-badge">
        <div class="label">Espace Responsable</div>
      </div>
    </div>

    {{-- ===== ETAPES DE PROGRESSION ===== --}}
    @php
      $stepUniv    = $universite ? ($universite->statut === 'validee' ? 'done' : 'active') : '';
      $stepFilieres = ($universite && $universite->statut === 'validee') ? 'active' : '';
    @endphp

    <div class="steps">
      <div class="step done">
        <div class="step-circle">✓</div>
        <div class="step-label">1. Inscription</div>
      </div>
      <div class="step done">
        <div class="step-circle">✓</div>
        <div class="step-label">2. Connexion</div>
      </div>
      <div class="step {{ $universite ? ($universite->statut === 'validee' ? 'done' : 'active') : 'active' }}">
        <div class="step-circle">
          {{ $universite && $universite->statut === 'validee' ? '✓' : '3' }}
        </div>
        <div class="step-label">3. Université</div>
      </div>
      <div class="step {{ ($universite && $universite->statut === 'validee') ? 'active' : '' }}">
        <div class="step-circle">4</div>
        <div class="step-label">4. Filières</div>
      </div>
    </div>

    {{-- ===== CAS 1 : PAS D'UNIVERSITE ENCORE ===== --}}
    @if(!$universite)
      <div class="panel">
        <div class="panel-header">
          <h2>Enregistrer votre université</h2>
        </div>
        <p style="font-size:14px;color:#777;margin-bottom:24px;line-height:1.7;">
          Vous n'avez pas encore enregistré votre établissement. Cliquez sur le bouton ci-dessous pour soumettre les informations de votre université. Elle sera examinée et validée par l'administrateur du MESRS avant d'apparaître sur la plateforme.
        </p>
        <a href="{{ route('responsable.universite.create') }}" class="btn-primary">
          Enregistrer mon université
        </a>
      </div>

    {{-- ===== CAS 2 : UNIVERSITE EN ATTENTE ===== --}}
    @elseif($universite->statut === 'en_attente')
      <div class="panel">
        <div class="panel-header">
          <h2>Mon université</h2>
          <span class="badge badge-yellow">En attente de validation</span>
        </div>

        <div class="status-box waiting">
          <div class="icon"></div>
          <h3>En attente de validation par l'administrateur</h3>
          <p>
            Votre université <strong>{{ $universite->nom }}</strong> a bien été soumise.<br>
            L'administrateur du MESRS va l'examiner et vous sera notifié dès qu'elle sera validée.<br>
            Une fois validée, vous pourrez soumettre vos filières.
          </p>
        </div>

        <div class="info-grid">
          <div class="info-item">
            <div class="lbl">Nom</div>
            <div class="val">{{ $universite->nom }}</div>
          </div>
          <div class="info-item">
            <div class="lbl">Sigle</div>
            <div class="val">{{ $universite->sigle ?: '—' }}</div>
          </div>
          <div class="info-item">
            <div class="lbl">Ville</div>
            <div class="val">{{ $universite->ville }}</div>
          </div>
          <div class="info-item">
            <div class="lbl">Type</div>
            <div class="val"><span class="badge badge-blue">Privé</span></div>
          </div>
        </div>
      </div>

    {{-- ===== CAS 3 : UNIVERSITE REJETEE ===== --}}
    @elseif($universite->statut === 'inactive' || $universite->statut === 'rejetee')
      <div class="panel">
        <div class="panel-header">
          <h2>Mon université</h2>
          <span class="badge badge-red">Rejetée</span>
        </div>

        <div class="status-box rejected">
          <div class="icon"></div>
          <h3>Université rejetée par l'administrateur</h3>
          <p>
            Votre université <strong>{{ $universite->nom }}</strong> a été rejetée.
            @if(isset($universite->motif_rejet) && $universite->motif_rejet)
              <br><strong>Motif :</strong> {{ $universite->motif_rejet }}
            @endif
            <br><br>Veuillez contacter l'administrateur pour plus d'informations.
          </p>
        </div>
      </div>

    {{-- ===== CAS 4 : UNIVERSITE VALIDEE → GESTION DES FILIERES ===== --}}
    @elseif($universite->statut === 'active' || $universite->statut === 'validee')

      {{-- INFO UNIVERSITE --}}
      <div class="panel">
        <div class="panel-header">
          <h2>Mon université</h2>
          <span class="badge badge-green">Validée</span>
        </div>
        <div class="info-grid">
          <div class="info-item">
            <div class="lbl">Nom</div>
            <div class="val">{{ $universite->nom }}</div>
          </div>
          <div class="info-item">
            <div class="lbl">Sigle</div>
            <div class="val">{{ $universite->sigle ?: '—' }}</div>
          </div>
          <div class="info-item">
            <div class="lbl">Ville</div>
            <div class="val">{{ $universite->ville }}</div>
          </div>
          <div class="info-item">
            <div class="lbl">Type</div>
            <div class="val"><span class="badge badge-blue">Privé</span></div>
          </div>
        </div>
      </div>

      {{-- CAMPUS --}}
      <div class="panel">
        <div class="panel-header">
          <h2>Campus</h2>
        </div>
        @if($campusList->isEmpty())
          <div class="empty">
            <p>Aucun campus enregistré pour le moment.</p>
          </div>
        @else
          <table class="table">
            <thead>
              <tr>
                <th>Nom du campus</th>
                <th>Ville</th>
                <th>Adresse</th>
              </tr>
            </thead>
            <tbody>
              @foreach($campusList as $campus)
              <tr>
                <td><strong>{{ $campus->nom }}</strong></td>
                <td>{{ $campus->ville }}</td>
                <td>{{ $campus->adresse ?: '—' }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>

      {{-- STATS FILIERES --}}
      <div class="stats-grid">
        <div class="stat-card vert">
          <div class="num">{{ $filiersValidees }}</div>
          <div class="lbl">Filières validées</div>
        </div>
        <div class="stat-card jaune">
          <div class="num">{{ $filiersEnAttente }}</div>
          <div class="lbl">En attente</div>
        </div>
        <div class="stat-card rouge">
          <div class="num">{{ $filiersRejetees }}</div>
          <div class="lbl">Rejetées</div>
        </div>
      </div>

      {{-- LISTE FILIERES --}}
      <div class="panel">
        <div class="panel-header">
          <h2>Mes filières soumises</h2>
          <a href="{{ route('responsable.filiere.create') }}" class="btn-primary">
            + Soumettre une filière
          </a>
        </div>

        @if($filieres->isEmpty())
          <div class="empty">
            <p style="font-size:16px;margin-bottom:14px;">Aucune filière soumise pour l'instant.</p>
            <a href="{{ route('responsable.filiere.create') }}" class="btn-primary">
              Soumettre ma première filière
            </a>
          </div>
        @else
          <table class="table">
            <thead>
              <tr>
                <th>Filière</th>
                <th>Durée</th>
                <th>Mode d'entrée</th>
                <th>Quota bourse</th>
                <th>Statut</th>
              </tr>
            </thead>
            <tbody>
              @foreach($filieres as $filiere)
              <tr>
                <td>
                  <strong>{{ $filiere->nom }}</strong>
                  @if($filiere->statut === 'rejetee' && $filiere->motif_rejet)
                    <div class="motif"><strong>Motif du rejet :</strong> {{ $filiere->motif_rejet }}</div>
                  @endif
                </td>
                <td>{{ $filiere->duree_annees }} ans</td>
                <td>{{ ucfirst($filiere->mode_entree) }}</td>
                <td>{{ $filiere->quota_bourse }} places</td>
                <td>
                  @if($filiere->statut === 'validee')
                    <span class="badge badge-green">Validée</span>
                  @elseif($filiere->statut === 'en_attente')
                    <span class="badge badge-yellow">En attente</span>
                  @else
                    <span class="badge badge-red">Rejetée</span>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>

    @endif

  </div>

  <script>
    function toggleUserMenu() {
      const menu = document.getElementById('userMenu');
      menu.classList.toggle('show');
    }

    // Fermer le menu si on clique ailleurs
    document.addEventListener('click', function(event) {
      const userInfo = document.querySelector('.user-info');
      const menu = document.getElementById('userMenu');

      if (!userInfo.contains(event.target)) {
        menu.classList.remove('show');
      }
    });
  </script>
</body>
</html>