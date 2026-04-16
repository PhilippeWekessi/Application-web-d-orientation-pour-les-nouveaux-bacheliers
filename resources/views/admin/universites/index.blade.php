<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>Universités — Admin OrientaBac</title>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI',sans-serif; background:#F0F2F5; }
    .topbar { background:#12253d; padding:16px 35px; display:flex; align-items:center; justify-content:space-between; }
    .topbar .logo { color:white; font-size:18px; font-weight:bold; }
    .topbar .logo span { color:#FCD116; }
    .topbar a { color:rgba(255,255,255,0.6); font-size:14px; text-decoration:none; }
    .container { max-width:1100px; margin:30px auto; padding:0 20px; }
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
    .page-header h1 { font-size:22px; font-weight:bold; color:#1E3A5F; }
    .btn-add { padding:10px 20px; background:#008751; color:white; border:none; border-radius:8px; font-size:14px; font-weight:bold; text-decoration:none; }
    .panel { background:white; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); overflow:hidden; }
    .table { width:100%; border-collapse:collapse; }
    .table th { text-align:left; font-size:12px; font-weight:bold; color:#999; text-transform:uppercase; padding:12px 16px; background:#F8F9FA; }
    .table td { padding:14px 16px; font-size:14px; color:#555; border-bottom:1px solid #f0f0f0; }
    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:bold; }
    .badge-green { background:rgba(0,135,81,0.1); color:#008751; }
    .badge-blue { background:rgba(30,58,95,0.08); color:#1E3A5F; }
    .btn-del { padding:6px 14px; background:rgba(232,17,45,0.08); color:#E8112D; border:none; border-radius:6px; font-size:12px; font-weight:bold; cursor:pointer; }
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
      <h1>🏛️ Gestion des universités</h1>
      <a href="{{ route('admin.universites.create') }}" class="btn-add">+ Ajouter une université</a>
    </div>
    <div class="panel">
      <table class="table">
        <thead>
          <tr><th>Nom</th><th>Sigle</th><th>Ville</th><th>Type</th><th>Campus</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @forelse($universites as $u)
          <tr>
            <td><strong>{{ $u->nom }}</strong></td>
            <td>{{ $u->sigle }}</td>
            <td>{{ $u->ville }}</td>
            <td>
              @if($u->type === 'public')
                <span class="badge badge-green">Public</span>
              @else
                <span class="badge badge-blue">Privé</span>
              @endif
            </td>
            <td>{{ $u->campus_count }} campus</td>
            <td>
              <form method="POST" action="{{ route('admin.universites.destroy', $u->id_universite) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn-del" onclick="return confirm('Supprimer cette université ?')">🗑️ Supprimer</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center;padding:30px;color:#999;">Aucune université.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div style="margin-top:20px;">{{ $universites->links() }}</div>
  </div>
</body>
</html>