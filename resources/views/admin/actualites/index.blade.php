<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>Actualités — Admin OrientaBac</title>
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
    .table td { padding:14px 16px; font-size:14px; color:#555; border-bottom:1px solid #f0f0f0; vertical-align:middle; }
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
      <div class="alert-success">{{ session('success') }}</div>
    @endif
    <div class="page-header">
      <h1>Gestion des actualités</h1>
      <a href="{{ route('admin.actualites.create') }}" class="btn-add">+ Publier une actualité</a>
    </div>
    <div class="panel">
      <table class="table">
        <thead>
          <tr><th>Titre</th><th>Date</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @forelse($actualites as $a)
          <tr>
            <td><strong>{{ $a->titre }}</strong></td>
            <td>{{ $a->created_at?->format('d/m/Y') ?? '—' }}</td>
            <td>
              <form method="POST" action="{{ route('admin.actualites.destroy', $a->id_actualite) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn-del" onclick="return confirm('Supprimer ?')">Supprimer</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="3" style="text-align:center;padding:30px;color:#999;">Aucune actualité.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div style="margin-top:20px;">{{ $actualites->links() }}</div>
  </div>
</body>
</html>