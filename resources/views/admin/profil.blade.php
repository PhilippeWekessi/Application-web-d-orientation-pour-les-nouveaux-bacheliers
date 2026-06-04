<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mon Profil — OrientaBac</title>

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

    .admin-content { padding: 0 36px 34px; flex: 1; }

    .profil-container { max-width: 800px; margin: 0 auto; }
    .profil-card { background: white; border-radius: 20px; padding: 40px; box-shadow: 0 24px 80px rgba(15,23,42,0.06); margin-bottom: 24px; }

    .profil-header { text-align: center; margin-bottom: 40px; }
    .profil-avatar-container { position: relative; display: inline-block; margin-bottom: 20px; }
    .profil-avatar { width: 120px; height: 120px; border-radius: 50%; background-color: #008751; color: white; font-weight: 800; font-size: 36px; display: flex; align-items: center; justify-content: center; margin: 0 auto; border: 4px solid white; box-shadow: 0 8px 24px rgba(0,0,0,0.15); }
    .profil-avatar img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; }
    .avatar-upload { position: absolute; bottom: 0; right: 0; background-color: #008751; color: white; border: none; border-radius: 50%; width: 36px; height: 36px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; transition: background-color 0.2s; }
    .avatar-upload:hover { background-color: #047857; }
    .profil-header h3 { font-size: 24px; font-weight: 800; color: #111827; margin-bottom: 8px; }
    .profil-header p { font-size: 16px; color: #6b7280; }

    .form-group { margin-bottom: 24px; }
    .form-label { display: block; font-size: 14px; font-weight: 700; color: #374151; margin-bottom: 8px; }
    .form-input { width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; color: #111827; transition: border-color 0.2s; }
    .form-input:focus { outline: none; border-color: #008751; box-shadow: 0 0 0 3px rgba(0,135,81,0.1); }
    .form-input:read-only { background-color: #f9fafb; cursor: not-allowed; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-row .form-group { margin-bottom: 0; }

    .form-actions { display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; }
    .btn-primary { padding: 12px 24px; background-color: #008751; color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; transition: background-color 0.2s; }
    .btn-primary:hover { background-color: #047857; }
    .btn-secondary { padding: 12px 24px; background-color: transparent; color: #6b7280; border: 2px solid #d1d5db; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.2s; }
    .btn-secondary:hover { border-color: #008751; color: #008751; }

    .alert { padding: 16px; border-radius: 12px; margin-bottom: 24px; }
    .alert-success { background-color: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); color: #047857; }
    .alert-error { background-color: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #b91c1c; }

    @media (max-width: 768px) {
      .admin-sidebar { position: relative; width: 100%; min-height: auto; }
      .admin-main { margin-left: 0; }
      .admin-topbar { padding: 18px 24px 0; }
      .admin-content { padding: 0 24px 28px; }
      .profil-card { padding: 24px; }
      .form-row { grid-template-columns: 1fr; }
      .form-actions { flex-direction: column; }
      .btn-primary, .btn-secondary { width: 100%; }
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
          <span class="icon"></span> Tableau de bord
        </a>
        <a href="{{ route('admin.profil') }}" class="nav-item active">
          <span class="icon"></span> Mon profil
        </a>
      </div>
      <div class="nav-section">
        <div class="nav-section-title">Contenu</div>
        <a href="{{ route('admin.universites') }}" class="nav-item">
          <span class="icon"></span> Universités & Campus
        </a>
        <a href="{{ route('admin.filieres') }}" class="nav-item">
          <span class="icon"></span> Filières
        </a>
        <a href="{{ route('admin.actualites') }}" class="nav-item">
          <span class="icon"></span> Actualités
        </a>
      </div>
      <div class="nav-section">
        <div class="nav-section-title">Modération</div>
        <a href="{{ route('admin.temoignages') }}" class="nav-item">
          <span class="icon"></span> Témoignages
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
  <div class="admin-main">

    <div class="admin-topbar">
      <div class="topbar-left">
        <h2>Mon Profil</h2>
        <p>Gérez vos informations personnelles</p>
      </div>
      <div class="topbar-right">
        <span class="topbar-date">{{ \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</span>
      </div>
    </div>

    <div class="admin-content">
      <div class="profil-container">

        @if(session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-error">
            {{ session('error') }}
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-error">
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="profil-card">
          <div class="profil-header">
            <div class="profil-avatar-container">
              <div class="profil-avatar" id="avatarPreview">
                @if(session('admin_photo'))
                  <img src="{{ asset('storage/' . session('admin_photo')) }}" alt="Photo de profil">
                @else
                  {{ strtoupper(substr(session('admin_nom', 'A'), 0, 1) . substr(session('admin_prenom', 'D'), 0, 1)) }}
                @endif
              </div>
              <button type="button" class="avatar-upload" onclick="document.getElementById('photoInput').click()">
                Profil
              </button>
            </div>
            <h3>{{ session('admin_prenom', 'Admin') }} {{ session('admin_nom', '') }}</h3>
            <p>Administrateur MESRS</p>
          </div>

          <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="file" id="photoInput" name="photo" accept="image/*" style="display: none;" onchange="previewPhoto(this)">

            <div class="form-row">
              <div class="form-group">
                <label class="form-label" for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" class="form-input" value="{{ session('admin_prenom', '') }}" required>
              </div>
              <div class="form-group">
                <label class="form-label" for="nom">Nom</label>
                <input type="text" id="nom" name="nom" class="form-input" value="{{ session('admin_nom', '') }}" required>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="email">Email</label>
              <input type="email" id="email" name="email" class="form-input" value="{{ session('admin_email', '') }}" readonly>
            </div>

            <div class="form-actions">
              <button type="button" class="btn-secondary" onclick="window.history.back()">Annuler</button>
              <button type="submit" class="btn-primary">Enregistrer les modifications</button>
            </div>
          </form>
        </div>

      </div>
    </div>

  </div>

  <script>
    function previewPhoto(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const avatar = document.getElementById('avatarPreview');
          avatar.innerHTML = `<img src="${e.target.result}" alt="Photo de profil">`;
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>

</body>
</html>