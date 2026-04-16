<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>Responsables — Admin OrientaBac</title>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI',sans-serif; background:#F0F2F5; }
    .topbar { background:#12253d; padding:16px 35px; display:flex; align-items:center; justify-content:space-between; }
    .topbar .logo { color:white; font-size:18px; font-weight:bold; }
    .topbar .logo span { color:#FCD116; }
    .topbar a { color:rgba(255,255,255,0.6); font-size:14px; text-decoration:none; }
    .topbar a:hover { color:white; }
    .container { max-width:1100px; margin:30px auto; padding:0 20px; }
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
    .page-header h1 { font-size:22px; font-weight:bold; color:#1E3A5F; }
    .btn-add { padding:10px 20px; background:#008751; color:white; border:none; border-radius:8px; font-size:14px; font-weight:bold; text-decoration:none; display:inline-block; }
    .panel { background:white; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); overflow:hidden; }
    .table { width:100%; border-collapse:collapse; }
    .table th { text-align:left; font-size:12px; font-weight:bold; color:#999; text-transform:uppercase; padding:12px 16px; background:#F8F9FA; }
    .table td { padding:14px 16px; font-size:14px; color:#555; border-bottom:1px solid #f0f0f0; vertical-align:middle; }
    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:bold; }
    .badge-green { background:rgba(0,135,81,0.1); color:#008751; }
    .badge-yellow { background:rgba(252,209,22,0.2); color:#c9a000; }
    .badge-red { background:rgba(232,17,45,0.08); color:#E8112D; }
    .action-btns { display:flex; gap:8px; }
    .btn-val { padding:6px 14px; background:rgba(0,135,81,0.1); color:#008751; border:none; border-radius:6px; font-size:12px; font-weight:bold; cursor:pointer; }
    .btn-val:hover { background:#008751; color:white; }
    .btn-rej { padding:6px 14px; background:rgba(232,17,45,0.08); color:#E8112D; border:none; border-radius:6px; font-size:12px; font-weight:bold; cursor:pointer; }
    .alert-success { background:rgba(0,135,81,0.1); border:1px solid #008751; color:#008751; padding:12px 16px; border-radius:8px; margin-bottom:20px; }
  </style>
</head>
<body>
  <div class="topbar">
    <div class="logo">Orienta<span>Bac</span> — Admin</div>
    <a href="{{ route('admin.dashboard') }}">← Tableau de bord</a>
  </div>
  <div class="container">
    @if(session('success'))
      <div class="alert-success">✅ {{ session('success') }}</div>
    @endif
    <div class="page-header">
      <h1>🔑 Comptes responsables universités</h1>
      <a href="{{ route('admin.responsables.create') }}" class="btn-add">+ Créer un compte</a>
    </div>
    <div class="panel">
      <table class="table">
        <thead>
          <tr><th>Nom</th><th>Email</th><th>Université</th><th>Fonction</th><th>Statut</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @forelse($responsables as $r)
          <tr>
            <td><strong>{{ $r->prenom }} {{ $r->nom }}</strong></td>
            <td>{{ $r->email }}</td>
            <td>{{ $r->universite?->sigle ?? 'N/A' }}</td>
            <td>{{ $r->fonction ?? '—' }}</td>
            <td>
              @if($r->statut === 'actif')
                <span class="badge badge-green">✅ Actif</span>
              @elseif($r->statut === 'en_attente')
                <span class="badge badge-yellow">⏳ En attente</span>
              @else
                <span class="badge badge-red">❌ Inactif</span>
              @endif
            </td>
            <td>
              <div class="action-btns">
                @if($r->statut !== 'actif')
                  <form method="POST" action="{{ route('admin.responsables.valider', $r->id_responsable) }}">
                    @csrf
                    <button type="submit" class="btn-val">✅ Valider</button>
                  </form>
                @endif
                @if($r->statut !== 'inactif')
                  <form method="POST" action="{{ route('admin.responsables.rejeter', $r->id_responsable) }}">
                    @csrf
                    <button type="submit" class="btn-rej">❌ Désactiver</button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center;padding:30px;color:#999;">Aucun compte responsable.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>