<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>Modifier Université — Admin OrientaBac</title>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI',sans-serif; background:#F0F2F5; display:flex; min-height:100vh; }
    .sidebar { width:260px; background:#12253d; min-height:100vh; display:flex; flex-direction:column; position:fixed; top:0; left:0; z-index:100; }
    .sidebar-logo { padding:24px 20px; border-bottom:1px solid rgba(255,255,255,0.08); }
    .sidebar-logo .logo { font-size:20px; font-weight:bold; color:white; display:flex; align-items:center; gap:8px; }
    .logo-flag { display:grid; grid-template-columns:1fr 1fr; grid-template-rows:1fr 1fr; width:20px; height:14px; border-radius:2px; overflow:hidden; }
    .logo-flag .f1 { background:#008751; grid-column:1; grid-row:1/3; }
    .logo-flag .f2 { background:#FCD116; grid-column:2; grid-row:1; }
    .logo-flag .f3 { background:#E8112D; grid-column:2; grid-row:2; }
    .sidebar-logo p { font-size:11px; color:rgba(255,255,255,0.4); margin-top:4px; margin-left:28px; }
    .sidebar-admin-info { padding:16px 20px; border-bottom:1px solid rgba(255,255,255,0.08); display:flex; align-items:center; gap:12px; }
    .admin-avatar { width:38px; height:38px; border-radius:50%; background:#008751; color:white; font-weight:bold; font-size:14px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .admin-info h4 { font-size:13px; font-weight:bold; color:white; }
    .admin-info span { font-size:11px; color:rgba(255,255,255,0.4); }
    .sidebar-nav { flex:1; padding:16px 0; }
    .nav-section-title { font-size:10px; font-weight:bold; color:rgba(255,255,255,0.3); text-transform:uppercase; padding:8px 20px 4px; letter-spacing:1px; }
    .nav-item { display:flex; align-items:center; gap:12px; padding:11px 20px; color:rgba(255,255,255,0.6); font-size:14px; cursor:pointer; transition:all 0.2s; text-decoration:none; }
    .nav-item:hover { background:rgba(255,255,255,0.06); color:white; }
    .nav-item.active { background:rgba(0,135,81,0.2); color:#4cff9f; border-left:3px solid #008751; }
    .sidebar-bottom { padding:16px 20px; border-top:1px solid rgba(255,255,255,0.08); }
    .btn-logout { display:flex; align-items:center; gap:10px; color:rgba(255,255,255,0.5); font-size:14px; cursor:pointer; transition:color 0.2s; background:none; border:none; width:100%; }
    .btn-logout:hover { color:#E8112D; }
    .main { margin-left:260px; flex:1; display:flex; flex-direction:column; }
    .topbar { background:white; padding:16px 35px; display:flex; align-items:center; justify-content:space-between; box-shadow:0 1px 6px rgba(0,0,0,0.06); position:sticky; top:0; z-index:50; }
    .topbar-left h2 { font-size:20px; font-weight:bold; color:#1E3A5F; }
    .topbar-left p { font-size:13px; color:#999; }
    .topbar-right { display:flex; align-items:center; gap:16px; }
    .topbar-date { font-size:13px; color:#999; }
    .content { padding:30px 35px; flex:1; }
    .panel { background:white; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.06); }
    .panel-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
    .panel-header h3 { font-size:16px; font-weight:bold; color:#1E3A5F; }
    .btn-panel { padding:7px 16px; background:#008751; color:white; border:none; border-radius:8px; font-size:12px; font-weight:bold; cursor:pointer; text-decoration:none; display:inline-block; }
    .btn-panel:hover { background:#006b40; }
    .btn-panel-outline { padding:7px 16px; background:transparent; color:#1E3A5F; border:1.5px solid #ddd; border-radius:8px; font-size:12px; font-weight:bold; cursor:pointer; text-decoration:none; display:inline-block; }
  </style>
</head>
<body>

  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="sidebar-logo">
      <div class="logo">
        <div class="logo-flag"><div class="f1"></div><div class="f2"></div><div class="f3"></div></div>
        Orienta<span>Bac</span>
      </div>
      <p>Espace Administrateur</p>
    </div>

    <div class="sidebar-admin-info">
      <div class="admin-avatar">
        {{ strtoupper(substr(session('admin_nom', 'A'), 0, 1) . substr(session('admin_prenom', 'D'), 0, 1)) }}
      </div>
      <div class="admin-info">
        <h4>{{ session('admin_prenom', 'Admin') }} {{ session('admin_nom', '') }}</h4>
        <span>Administrateur MESRS</span>
      </div>
    </div>

    <div class="sidebar-nav">
      <div class="nav-section">
        <div class="nav-section-title">Général</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
          <span class="icon">📊</span> Tableau de bord
        </a>
      </div>
      <div class="nav-section">
        <div class="nav-section-title">Contenu</div>
        <a href="{{ route('admin.universites') }}" class="nav-item active">
          <span class="icon">🏛️</span> Universités & Campus
        </a>
        <a href="{{ route('admin.filieres') }}" class="nav-item">
          <span class="icon">📚</span> Filières
        </a>
        <a href="{{ route('admin.actualites') }}" class="nav-item">
          <span class="icon">📰</span> Actualités
        </a>
      </div>
      <div class="nav-section">
        <div class="nav-section-title">Modération</div>
        <a href="{{ route('admin.temoignages') }}" class="nav-item">
          <span class="icon">💬</span> Témoignages
        </a>
      </div>
    </div>

    <div class="sidebar-bottom">
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="btn-logout">
          <span>🚪</span> Se déconnecter
        </button>
      </form>
    </div>
  </div>

  <!-- MAIN -->
  <div class="main">
    <div class="topbar">
      <div class="topbar-left">
        <h2>Modifier l'université</h2>
        <p>Modifier les informations de l'université</p>
      </div>
      <div class="topbar-right">
        <span class="topbar-date">{{ \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</span>
      </div>
    </div>

    <div class="content">
      <div class="panel">
        <div class="panel-header">
          <h3>Informations de l'université</h3>
        </div>
        <form method="POST" action="{{ route('admin.universites.update', $universite->id_universite) }}">
          @csrf @method('PUT')
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
              <label style="display:block; margin-bottom:5px; font-weight:bold;">Nom</label>
              <input type="text" name="nom" value="{{ $universite->nom }}" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
            </div>
            <div>
              <label style="display:block; margin-bottom:5px; font-weight:bold;">Sigle</label>
              <input type="text" name="sigle" value="{{ $universite->sigle }}" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
            </div>
            <div>
              <label style="display:block; margin-bottom:5px; font-weight:bold;">Ville</label>
              <input type="text" name="ville" value="{{ $universite->ville }}" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
            </div>
            <div>
              <label style="display:block; margin-bottom:5px; font-weight:bold;">Type</label>
              <select name="type" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                <option value="public" {{ $universite->type == 'public' ? 'selected' : '' }}>Public</option>
                <option value="prive" {{ $universite->type == 'prive' ? 'selected' : '' }}>Privé</option>
              </select>
            </div>
            <div>
              <label style="display:block; margin-bottom:5px; font-weight:bold;">Statut</label>
              <select name="statut" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                <option value="en_attente" {{ $universite->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="validee" {{ $universite->statut == 'validee' ? 'selected' : '' }}>Validée</option>
                <option value="rejetee" {{ $universite->statut == 'rejetee' ? 'selected' : '' }}>Rejetée</option>
              </select>
            </div>
          </div>
          <button type="submit" class="btn-panel">Mettre à jour</button>
          <a href="{{ route('admin.universites') }}" class="btn-panel-outline">Annuler</a>
        </form>
      </div>
    </div>
  </div>

</body>
</html>