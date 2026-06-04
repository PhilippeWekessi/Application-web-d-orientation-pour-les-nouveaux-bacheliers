<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>Filières — Admin OrientaBac</title>
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
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header h1 { font-size:22px; font-weight:bold; color:#1E3A5F; }
    .filtres { display:flex; gap:10px; flex-wrap:wrap; }
    .filtre-btn { padding:8px 18px; border-radius:20px; border:2px solid #ddd; background:white; font-size:13px; font-weight:bold; color:#777; cursor:pointer; text-decoration:none; transition:all 0.2s; }
    .filtre-btn.active, .filtre-btn:hover { border-color:#008751; color:#008751; background:rgba(0,135,81,0.08); }
    .panel { background:white; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); overflow:hidden; }
    .table { width:100%; border-collapse:collapse; }
    .table th { text-align:left; font-size:12px; font-weight:bold; color:#999; text-transform:uppercase; padding:12px 16px; background:#F8F9FA; }
    .table td { padding:14px 16px; font-size:14px; color:#555; border-bottom:1px solid #f0f0f0; vertical-align:middle; }
    .table tr:last-child td { border-bottom:none; }
    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:bold; }
    .badge-green { background:rgba(0,135,81,0.1); color:#008751; }
    .badge-yellow { background:rgba(252,209,22,0.2); color:#c9a000; }
    .badge-red { background:rgba(232,17,45,0.08); color:#E8112D; }
    .action-btns { display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
    .btn-val { padding:6px 14px; background:rgba(0,135,81,0.1); color:#008751; border:none; border-radius:6px; font-size:12px; font-weight:bold; cursor:pointer; }
    .btn-val:hover { background:#008751; color:white; }
    .btn-rej { padding:6px 14px; background:rgba(232,17,45,0.08); color:#E8112D; border:none; border-radius:6px; font-size:12px; font-weight:bold; cursor:pointer; }
    .btn-rej:hover { background:#E8112D; color:white; }
    .motif-input { padding:6px 10px; border:1.5px solid #ddd; border-radius:6px; font-size:12px; outline:none; width:160px; }
    .motif-input:focus { border-color:#E8112D; }
    .alert-success { background:rgba(0,135,81,0.1); border:1px solid #008751; color:#008751; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:20px; }
    .empty { text-align:center; padding:40px; color:#999; }
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
      <h1>Gestion des filières</h1>
      <div class="filtres">
        <a href="{{ route('admin.filieres') }}" class="filtre-btn {{ !request('statut') ? 'active' : '' }}">Toutes</a>
        <a href="{{ route('admin.filieres', ['statut' => 'en_attente']) }}" class="filtre-btn {{ request('statut') == 'en_attente' ? 'active' : '' }}">En attente</a>
        <a href="{{ route('admin.filieres', ['statut' => 'validee']) }}" class="filtre-btn {{ request('statut') == 'validee' ? 'active' : '' }}">Validées</a>
        <a href="{{ route('admin.filieres', ['statut' => 'rejetee']) }}" class="filtre-btn {{ request('statut') == 'rejetee' ? 'active' : '' }}">Rejetées</a>
      </div>
    </div>

    <div class="panel">
      <table class="table">
        <thead>
          <tr>
            <th>Filière</th>
            <th>Établissement</th>
            <th>Soumis par</th>
            <th>Durée</th>
            <th>Bourse</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($filieres as $filiere)
          <tr>
            <td>
              <strong>{{ $filiere->nom }}</strong>
              @if($filiere->statut === 'rejetee' && $filiere->motif_rejet)
                <div style="font-size:12px;color:#E8112D;margin-top:4px;">
                  <strong>Motif du rejet :</strong> {{ $filiere->motif_rejet }}
                </div>
              @endif
            </td>
            <td>{{ $filiere->campus->first()?->universite?->sigle ?? 'N/A' }}</td>
            <td>
              @if($filiere->responsableSoumis)
                {{ $filiere->responsableSoumis->prenom }} {{ $filiere->responsableSoumis->nom }}
              @else
                Admin
              @endif
            </td>
            <td>{{ $filiere->duree_annees }} ans</td>
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
            <td>
              <div class="action-btns">
                @if($filiere->statut === 'en_attente')
                  <form method="POST" action="{{ route('admin.filieres.valider', $filiere->id_filiere) }}">
                    @csrf
                    <button type="submit" class="btn-val" onclick="return confirm('Êtes-vous sûr de vouloir valider cette filière ?')">Valider</button>
                  </form>
                  <form method="POST" action="{{ route('admin.filieres.rejeter', $filiere->id_filiere) }}" style="display:flex;gap:6px;align-items:center;">
                    @csrf
                    <input type="text" name="motif" class="motif-input" placeholder="Motif du rejet..." required minlength="5" />
                    <button type="submit" class="btn-rej" onclick="return confirm('Êtes-vous sûr de vouloir rejeter cette filière ?')">Rejeter</button>
                  </form>
                @elseif($filiere->statut === 'rejetee')
                  <form method="POST" action="{{ route('admin.filieres.valider', $filiere->id_filiere) }}">
                    @csrf
                    <button type="submit" class="btn-val" onclick="return confirm('Êtes-vous sûr de vouloir revalider cette filière ?')">Revalider</button>
                  </form>
                @else
                  <span style="font-size:12px;color:#999;">Aucune action</span>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6"><div class="empty">Aucune filière trouvée.</div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top:20px;">
      {{ $filieres->links() }}
    </div>

  </div>
</body>
</html>