<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>Témoignages — Admin OrientaBac</title>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI',sans-serif; background:#F0F2F5; }
    .topbar { background:#12253d; padding:16px 35px; display:flex; align-items:center; justify-content:space-between; }
    .topbar .logo { color:white; font-size:18px; font-weight:bold; }
    .topbar .logo span { color:#FCD116; }
    .topbar a { color:rgba(255,255,255,0.6); font-size:14px; text-decoration:none; }
    .container { max-width:1100px; margin:30px auto; padding:0 20px; }
    .page-header { margin-bottom:24px; }
    .page-header h1 { font-size:22px; font-weight:bold; color:#1E3A5F; }
    .panel { background:white; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); overflow:hidden; }
    .table { width:100%; border-collapse:collapse; }
    .table th { text-align:left; font-size:12px; font-weight:bold; color:#999; text-transform:uppercase; padding:12px 16px; background:#F8F9FA; }
    .table td { padding:14px 16px; font-size:13px; color:#555; border-bottom:1px solid #f0f0f0; vertical-align:top; }
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
      <div class="alert-success">{{ session('success') }}</div>
    @endif
    <div class="page-header">
      <h1>Modération des témoignages</h1>
    </div>
    <div class="panel">
      <table class="table">
        <thead>
          <tr>
            <th>Étudiant</th>
            <th>Filière</th>
            <th>Note</th>
            <th>Contenu</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
          @forelse($temoignages as $t)
          <tr>
            <td><strong>{{ $t->user?->prenom }} {{ $t->user?->nom }}</strong></td>
            <td>{{ Str::limit($t->filiere?->nom, 25) }}</td>
            <td>{{ str_repeat('★', $t->note) }}</td>
            <td style="max-width:300px;">{{ Str::limit($t->contenu, 80) }}</td>
            <td>
              @if($t->statut === 'valide')
                <span class="badge badge-green">Validé</span>
              @elseif($t->statut === 'en_attente')
                <span class="badge badge-yellow">En attente</span>
              @else
                <span class="badge badge-red">Rejeté</span>
              @endif
            </td>
            <td>
              <div class="action-btns">
                @if($t->statut !== 'valide')
                  <form method="POST" action="{{ route('admin.temoignages.valider', $t->id_temoignage) }}">
                    @csrf
                    <button type="submit" class="btn-val">Valider</button>
                  </form>
                @endif
                @if($t->statut !== 'rejete')
                  <form method="POST" action="{{ route('admin.temoignages.rejeter', $t->id_temoignage) }}">
                    @csrf
                    <button type="submit" class="btn-rej">Rejeter</button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center;padding:30px;color:#999;">Aucun témoignage.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div style="margin-top:20px;">{{ $temoignages->links() }}</div>
  </div>
</body>
</html>