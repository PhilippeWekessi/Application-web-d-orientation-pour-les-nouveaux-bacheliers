<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Administration — OrientaBac</title>
  
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background-color: #eef3f8; color: #1f2937; display: flex; min-height: 100vh; }

    .admin-sidebar { width: 280px; background-color: #11263e; min-height: 100vh; display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100; }
    .sidebar-logo { padding: 26px 22px; border-bottom: 1px solid rgba(255,255,255,0.08); }
    .sidebar-logo .logo { font-size: 20px; font-weight: 800; color: white; display: flex; align-items: center; gap: 10px; }
    .logo-flag { display: grid; grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr; width: 20px; height: 14px; border-radius: 3px; overflow: hidden; }
    .logo-flag .f1 { background-color: #008751; grid-column: 1; grid-row: 1 / 3; }
    .logo-flag .f2 { background-color: #fcd116; grid-column: 2; grid-row: 1; }
    .logo-flag .f3 { background-color: #e8112d; grid-column: 2; grid-row: 2; }
    .logo span { color: #fcd116; }
    .sidebar-logo p { font-size: 11px; color: rgba(255,255,255,0.55); margin-top: 5px; margin-left: 30px; }

    .sidebar-admin-info { padding: 18px 22px; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; gap: 14px; }
    .admin-avatar { width: 44px; height: 44px; border-radius: 50%; background-color: #008751; color: white; font-weight: 800; font-size: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .admin-info h4 { font-size: 14px; font-weight: 700; color: white; }
    .admin-info span { font-size: 11px; color: rgba(255,255,255,0.55); }

    .sidebar-nav { flex: 1; padding: 16px 0; }
    .nav-section { margin-bottom: 14px; }
    .nav-section-title { font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.35); text-transform: uppercase; padding: 10px 22px 6px; letter-spacing: 0.12em; }
    .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 22px; color: rgba(255,255,255,0.7); font-size: 14px; transition: all 0.2s ease; text-decoration: none; }
    .nav-item:hover { background-color: rgba(255,255,255,0.08); color: white; }
    .nav-item.active { background-color: rgba(0,135,81,0.18); color: #d1fae5; border-left: 3px solid #00b57d; }
    .nav-item .icon { font-size: 18px; width: 20px; text-align: center; }
    .nav-badge { margin-left: auto; background-color: #e8112d; color: white; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 999px; }

    .sidebar-bottom { padding: 18px 22px; border-top: 1px solid rgba(255,255,255,0.08); }
    .btn-logout { display: flex; align-items: center; gap: 10px; color: rgba(255,255,255,0.75); font-size: 14px; cursor: pointer; transition: color 0.2s ease; background: none; border: none; width: 100%; text-align: left; }
    .btn-logout:hover { color: #f87171; }

    .admin-main { margin-left: 280px; flex: 1; display: flex; flex-direction: column; }
    .admin-topbar { background: transparent; padding: 24px 36px 0; display: flex; align-items: center; justify-content: space-between; gap: 16px; position: sticky; top: 0; z-index: 50; }
    .topbar-left h2 { font-size: 28px; font-weight: 800; color: #111827; }
    .topbar-left p { font-size: 14px; color: #4b5563; margin-top: 6px; }
    .topbar-right { display: flex; align-items: center; gap: 16px; }
    .topbar-date { font-size: 13px; color: #6b7280; }

    .admin-alert {
      background: #fef3c7;
      border: 1px solid #f59e0b;
      color: #92400e;
      padding: 18px 22px;
      border-radius: 18px;
      margin: 0 36px 24px;
      font-size: 14px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }
    .admin-alert a { color: #b45309; font-weight: 700; text-decoration: underline; }

    .admin-content { padding: 0 36px 34px; flex: 1; }

    .stats-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 20px; margin-bottom: 28px; }
    .stat-card { background: white; border-radius: 18px; padding: 24px; box-shadow: 0 24px 80px rgba(15,23,42,0.08); display: flex; align-items: center; gap: 18px; }
    .stat-icon { width: 54px; height: 54px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; }
    .stat-icon.green { background-color: rgba(16,185,129,0.12); }
    .stat-icon.blue { background-color: rgba(30,58,95,0.1); }
    .stat-icon.yellow { background-color: rgba(249,168,38,0.18); }
    .stat-icon.red { background-color: rgba(239,68,68,0.14); }
    .stat-info h3 { font-size: 28px; font-weight: 900; color: #111827; margin-bottom: 4px; }
    .stat-info p { font-size: 12px; color: #6b7280; margin-bottom: 8px; }
    .stat-info .trend { font-size: 12px; font-weight: 700; color: #047857; }

    .grid-3-1 { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 24px; margin-bottom: 26px; }
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px; }

    .panel { background: white; border-radius: 20px; padding: 26px; box-shadow: 0 24px 80px rgba(15,23,42,0.06); }
    .panel-header { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 14px; margin-bottom: 20px; }
    .panel-header h3 { font-size: 18px; font-weight: 800; color: #111827; }
    .btn-panel { padding: 11px 18px; background-color: #008751; color: white; border: none; border-radius: 14px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
    .btn-panel:hover { background-color: #047857; }
    .btn-panel-outline { padding: 11px 18px; background-color: transparent; color: #1f2937; border: 1.8px solid #d1d5db; border-radius: 14px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
    .btn-panel-outline:hover { border-color: #008751; color: #008751; }

    .table-wrapper { overflow-x: auto; }
    .data-table { width: 100%; border-collapse: collapse; min-width: 760px; }
    .data-table th { text-align: left; font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; padding: 14px 16px; background-color: #f8fafc; letter-spacing: 0.02em; }
    .data-table td { padding: 14px 16px; font-size: 14px; color: #374151; border-bottom: 1px solid #e5e7eb; vertical-align: middle; }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover td { background-color: #f8fafc; }

    .badge { display: inline-block; padding: 5px 12px; border-radius: 999px; font-size: 11px; font-weight: 700; }
    .badge-green { background-color: rgba(16,185,129,0.12); color: #047857; }
    .badge-yellow { background-color: rgba(245,158,11,0.18); color: #92400e; }
    .badge-red { background-color: rgba(254,202,202,0.8); color: #b91c1c; }
    .badge-blue { background-color: rgba(30,58,95,0.08); color: #1e3a5f; }

    .action-btns { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn-edit { padding: 8px 14px; background: rgba(30,58,95,0.08); color: #1f2937; border: none; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; text-decoration: none; }
    .btn-delete { padding: 8px 14px; background: rgba(239,68,68,0.12); color: #b91c1c; border: none; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; }
    .btn-approve { padding: 8px 14px; background: rgba(16,185,129,0.12); color: #047857; border: none; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; }

    .activite-list { display: flex; flex-direction: column; gap: 16px; }
    .activite-item { display: flex; align-items: flex-start; gap: 14px; }
    .activite-dot { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; margin-top: 6px; }
    .dot-green { background-color: #047857; }
    .dot-yellow { background-color: #f59e0b; }
    .dot-red { background-color: #dc2626; }
    .dot-blue { background-color: #1e3a8a; }
    .activite-text { font-size: 14px; color: #374151; line-height: 1.7; }
    .activite-time { font-size: 12px; color: #6b7280; }

    .quick-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .quick-btn { padding: 18px 16px; background-color: #f8fafc; border: 2px dashed #d1d5db; border-radius: 16px; cursor: pointer; text-align: center; transition: all 0.2s ease; font-size: 14px; color: #334155; font-weight: 700; text-decoration: none; display: block; }
    .quick-btn:hover { border-color: #008751; color: #047857; background-color: rgba(236,253,245,0.8); }
    .quick-btn .qicon { font-size: 24px; display: block; margin-bottom: 8px; }

    .alert-warning { background: rgba(254,226,226,1); border-radius: 14px; border-left: 4px solid #ef4444; padding: 18px; margin-top: 22px; }
    .alert-warning h4 { font-size: 14px; font-weight: 800; color: #b91c1c; margin-bottom: 8px; }
    .alert-warning p { font-size: 13px; color: #4b5563; line-height: 1.7; }

    @media (max-width: 1080px) {
      .admin-sidebar { position: relative; width: 100%; min-height: auto; }
      .admin-main { margin-left: 0; }
      .admin-topbar { padding: 18px 24px 0; }
      .admin-content { padding: 0 24px 28px; }
      .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .grid-3-1 { grid-template-columns: 1fr; }
      .grid-2 { grid-template-columns: 1fr; }
      .panel { padding: 22px; }
    }

    @media (max-width: 720px) {
      .stats-grid { grid-template-columns: 1fr; }
      .grid-3-1 { grid-template-columns: 1fr; }
      .grid-2 { grid-template-columns: 1fr; }
      .nav-item { padding: 12px 18px; }
      .admin-topbar { flex-direction: column; align-items: flex-start; gap: 12px; }
      .topbar-right { width: 100%; justify-content: space-between; }
      .admin-content { padding: 0 16px 24px; }
      .panel { padding: 20px; }
      .btn-panel, .btn-panel-outline { width: 100%; justify-content: center; }
      .quick-btn { width: 100%; }
    }
  </style>
</head>
<body>

  <!-- SIDEBAR -->
  <div class="admin-sidebar">
    <div class="sidebar-logo">
      <div class="logo">
        <div class="logo-flag"><div class="f1"></div><div class="f2"></div><div class="f3"></div></div>
        Orienta<span>Bac</span>
      </div>
      <p>Espace Administrateur</p>
    </div>

    <div class="sidebar-admin-info">
      <div class="admin-avatar">
        @if(session('admin_photo'))
          <img src="{{ asset('storage/' . session('admin_photo')) }}" alt="Photo de profil" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
        @else
          {{ strtoupper(substr(session('admin_nom', 'A'), 0, 1) . substr(session('admin_prenom', 'D'), 0, 1)) }}
        @endif
      </div>
      <div class="admin-info">
        <h4>{{ session('admin_prenom', 'Admin') }} {{ session('admin_nom', '') }}</h4>
        <span>Administrateur MESRS</span>
      </div>
    </div>

    <div class="sidebar-nav">
      <div class="nav-section">
        <div class="nav-section-title">Général</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item active">Tableau de bord
        </a>
        <a href="{{ route('admin.profil') }}" class="nav-item">Mon profil
        </a>
      </div>
      <div class="nav-section">
        <div class="nav-section-title">Contenu</div>
        <a href="{{ route('admin.universites') }}" class="nav-item"> Universités & Campus
          @if($universitesEnAttente > 0)
            <span class="nav-badge">{{ $universitesEnAttente }}</span>
          @endif
        </a>
        <a href="{{ route('admin.filieres') }}" class="nav-item">Filières
          @if($filiersEnAttente > 0)
            <span class="nav-badge">{{ $filiersEnAttente }}</span>
          @endif
        </a>
        <a href="{{ route('admin.actualites') }}" class="nav-item">Actualités
        </a>
      </div>
      <div class="nav-section">
        <div class="nav-section-title">Modération</div>
        <a href="{{ route('admin.temoignages') }}" class="nav-item">Témoignages
          @if($temoignagesEnAttente > 0)
            <span class="nav-badge">{{ $temoignagesEnAttente }}</span>
          @endif
        </a>
      </div>
      <div class="sidebar-bottom">
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button type="submit" class="btn-logout">Se déconnecter</button>
        </form>
      </div>
    </div>
  </div>

  <!-- MAIN -->
  <div class="admin-main">

    <div class="admin-topbar">
      <div class="topbar-left">
        <h2>Tableau de bord</h2>
        <p>Bienvenue — Voici un résumé de l'activité OrientaBac</p>
      </div>
      <div class="topbar-right">
        <span class="topbar-date">{{ \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</span>
      </div>
    </div>

    @if($temoignagesEnAttente > 0)
      <div class="admin-alert">
        <strong>Nouvelle modération requise :</strong>
        Il y a <strong>{{ $temoignagesEnAttente }}</strong> témoignage(s) en attente de validation.
        <a href="{{ route('admin.temoignages') }}">Voir les témoignages</a>
      </div>
    @endif

    <div class="admin-content">

      <!-- STATS -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-info">
            <h3>{{ $totalFilieres }}</h3>
            <p>Filières enregistrées</p>
            <span class="trend">{{ $filiersEnAttente }} en attente</span>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-info">
            <h3>{{ $totalUniversites }}</h3>
            <p>Universités & Écoles</p>
            <span class="trend" style="color:#c9a000;">{{ $universitesEnAttente }} en attente</span>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-info">
            <h3>{{ $totalTemoignages }}</h3>
            <p>Témoignages publiés</p>
            <span class="trend" style="color:#c9a000;">{{ $temoignagesEnAttente }} en attente</span>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-info">
            <h3>{{ $totalActualites }}</h3>
            <p>Actualités publiées</p>
          </div>
        </div>
      </div>

      <!-- FILIERES + UNIVERSITES + ACTIVITE -->
      <div class="grid-3-1" style="grid-template-columns: 1fr 1fr 1fr;">

        <!-- TABLE FILIERES -->
        <div class="panel">
          <div class="panel-header">
            <h3>Dernières filières</h3>
            <a href="{{ route('admin.filieres.create') }}" class="btn-panel">+ Ajouter</a>
          </div>
          <table class="data-table">
            <thead>
              <tr>
                <th>Filière</th>
                <th>Campus</th>
                <th>Statut</th>
                <th>Bourse</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($dernieresFilieres as $filiere)
              <tr>
                <td><strong>{{ $filiere->nom }}</strong></td>
                <td>{{ $filiere->campus->first()?->nom ?? 'N/A' }}</td>
                <td>
                  @if($filiere->statut === 'validee')
                    <span class="badge badge-green">Validée</span>
                  @elseif($filiere->statut === 'en_attente')
                    <span class="badge badge-yellow">En attente</span>
                  @else
                    <span class="badge badge-red">Rejetée</span>
                  @endif
                </td>
                <td><span class="badge badge-green">{{ $filiere->quota_bourse }} places</span></td>
                <td>
                  <div class="action-btns">
                    <a href="{{ route('admin.filieres.edit', $filiere->id_filiere) }}" class="btn-edit">Modifier</a>
                    <form method="POST" action="{{ route('admin.filieres.destroy', $filiere->id_filiere) }}" style="display:inline;">
                      @csrf @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Supprimer cette filière ?')">Supprimer</button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- TABLE UNIVERSITES -->
        <div class="panel">
          <div class="panel-header">
            <h3>Dernières universités</h3>
            <a href="{{ route('admin.universites.create') }}" class="btn-panel">+ Ajouter</a>
          </div>
          <table class="data-table">
            <thead>
              <tr>
                <th>Université</th>
                <th>Ville</th>
                <th>Type</th>
                <th>Statut</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($dernieresUniversites ?? [] as $universite)
              <tr>
                <td><strong>{{ $universite->nom }}</strong></td>
                <td>{{ $universite->ville }}</td>
                <td>
                  @if($universite->type === 'public')
                    <span class="badge badge-green">Public</span>
                  @else
                    <span class="badge badge-blue">Privé</span>
                  @endif
                </td>
                <td>
                  @if($universite->statut === 'validee')
                    <span class="badge badge-green">Validée</span>
                  @elseif($universite->statut === 'en_attente')
                    <span class="badge badge-yellow">En attente</span>
                  @else
                    <span class="badge badge-red">Rejetée</span>
                  @endif
                </td>
                <td>
                  <div class="action-btns">
                    <a href="{{ route('admin.universites.edit', $universite->id_universite) }}" class="btn-edit">Modifier</a>
                    <form method="POST" action="{{ route('admin.universites.destroy', $universite->id_universite) }}" style="display:inline;">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn-delete" onclick="return confirm('Supprimer cette université ?')">Supprimer</button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- ACTIVITE RECENTE -->
        <div class="panel">
          <div class="panel-header"><h3>Activité récente</h3></div>
          <div class="activite-list">
            @forelse($activites as $activite)
              <div class="activite-item">
                <div class="activite-dot dot-{{ $activite['couleur'] }}"></div>
                <div>
                  <div class="activite-text">{!! $activite['texte'] !!}</div>
                  <div class="activite-time">{{ $activite['temps'] }}</div>
                </div>
              </div>
            @empty
              <p style="font-size:13px;color:#999;">Aucune activité récente.</p>
            @endforelse
          </div>
        </div>

      </div>

      <!-- TEMOIGNAGES EN ATTENTE + ACTIONS RAPIDES -->
      <div class="grid-2">

        <!-- TEMOIGNAGES -->
        <div class="panel">
          <div class="panel-header">
            <h3>Témoignages en attente
              @if($temoignagesEnAttente > 0)
                <span class="badge badge-red" style="margin-left:8px;">{{ $temoignagesEnAttente }}</span>
              @endif
            </h3>
            <a href="{{ route('admin.temoignages') }}" class="btn-panel-outline">Voir tous</a>
          </div>
          <table class="data-table">
            <thead>
              <tr><th>Étudiant</th><th>Filière</th><th>Note</th><th>Actions</th></tr>
            </thead>
            <tbody>
              @forelse($temoignagesPendants as $temoignage)
              <tr>
                <td><strong>{{ $temoignage->user->prenom }} {{ $temoignage->user->nom }}</strong></td>
                <td>{{ Str::limit($temoignage->filiere->nom, 20) }}</td>
                <td>{{ str_repeat('★', $temoignage->note) }}</td>
                <td>
                  <div class="action-btns">
                    <form method="POST" action="{{ route('admin.temoignages.valider', $temoignage->id_temoignage) }}" style="display:inline;">
                      @csrf
                      <button type="submit" class="btn-approve">Valider</button>
                    </form>
                    <form method="POST" action="{{ route('admin.temoignages.rejeter', $temoignage->id_temoignage) }}" style="display:inline;">
                      @csrf
                      <button type="submit" class="btn-delete">Rejeter</button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr><td colspan="4" style="text-align:center;color:#999;padding:20px;">Aucun témoignage en attente</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- ACTIONS RAPIDES -->
        <div class="panel">
          <div class="panel-header"><h3>Actions rapides</h3></div>
          <div class="quick-actions">
            <a href="{{ route('admin.filieres.create') }}" class="quick-btn">
              <span class="qicon"></span>Ajouter une filière
            </a>
            <a href="{{ route('admin.universites.create') }}" class="quick-btn">
              <span class="qicon"></span>Ajouter une université
            </a>
            <a href="{{ route('admin.actualites.create') }}" class="quick-btn">
              <span class="qicon"></span>Publier une actualité
            </a>
            <a href="{{ route('admin.filieres', ['statut' => 'en_attente']) }}" class="quick-btn">
              <span class="qicon"></span>Filières en attente
            </a>
            <a href="{{ route('admin.universites', ['statut' => 'en_attente']) }}" class="quick-btn">
              <span class="qicon"></span>Universités en attente
            </a>
          </div>

          <div class="alert-warning">
            <h4>Rappel important</h4>
            <p>Pensez à mettre à jour les quotas et filières avant l'ouverture de la plateforme AprèsMonBac.bj.</p>
          </div>
        </div>

      </div>

    </div>
  </div>

</body>
</html>