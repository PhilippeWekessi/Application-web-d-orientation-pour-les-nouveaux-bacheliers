<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>Universités — Admin OrientaBac</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI',sans-serif; background:#F0F2F5; }
    .topbar { background:#12253d; padding:16px 35px; display:flex; align-items:center; justify-content:space-between; }
    .topbar .logo { color:white; font-size:18px; font-weight:bold; }
    .topbar .logo span { color:#FCD116; }
    .topbar a { color:rgba(255,255,255,0.6); font-size:14px; text-decoration:none; }
    .topbar a:hover { color:white; }
    .container { max-width:1100px; margin:30px auto; padding:0 20px; }

    .stats-mini { display:flex; gap:14px; margin-bottom:22px; flex-wrap:wrap; }
    .stat-mini { background:white; border-radius:10px; padding:14px 20px; box-shadow:0 2px 8px rgba(0,0,0,0.06); display:flex; align-items:center; gap:10px; }
    .stat-mini .num { font-size:22px; font-weight:bold; color:#1E3A5F; }
    .stat-mini .lbl { font-size:12px; color:#999; }
    .stat-mini.warning .num { color:#c9a000; }
    .stat-mini.danger .num { color:#E8112D; }

    .filtres-bar { display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap; align-items:center; justify-content:space-between; }
    .filtres-left { display:flex; gap:10px; flex-wrap:wrap; }
    .filtre-btn { padding:8px 18px; border-radius:20px; border:2px solid #ddd; background:white; font-size:13px; font-weight:bold; color:#777; cursor:pointer; text-decoration:none; transition:all 0.2s; }
    .filtre-btn:hover, .filtre-btn.active { border-color:#1E3A5F; color:#1E3A5F; background:rgba(30,58,95,0.07); }
    .filtre-btn.en-attente.active, .filtre-btn.en-attente:hover { border-color:#c9a000; color:#c9a000; background:rgba(252,209,22,0.1); }

    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px; }
    .page-header h1 { font-size:22px; font-weight:bold; color:#1E3A5F; }
    .btn-add { padding:10px 20px; background:#008751; color:white; border:none; border-radius:8px; font-size:14px; font-weight:bold; text-decoration:none; display:inline-block; }
    .btn-add:hover { background:#006b40; }

    .panel { background:white; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); overflow:hidden; }
    .table { width:100%; border-collapse:collapse; }
    .table th { text-align:left; font-size:12px; font-weight:bold; color:#999; text-transform:uppercase; padding:12px 16px; background:#F8F9FA; }
    .table td { padding:14px 16px; font-size:14px; color:#555; border-bottom:1px solid #f0f0f0; vertical-align:middle; }
    .table tr:last-child td { border-bottom:none; }
    .table tr:hover td { background:#fafafa; }

    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:bold; }
    .badge-green { background:rgba(0,135,81,0.1); color:#008751; }
    .badge-blue { background:rgba(30,58,95,0.08); color:#1E3A5F; }
    .badge-yellow { background:rgba(252,209,22,0.2); color:#c9a000; }
    .badge-red { background:rgba(232,17,45,0.08); color:#E8112D; }

    .action-btns { display:flex; gap:8px; flex-wrap:wrap; }
    .btn-val { padding:6px 14px; background:rgba(0,135,81,0.1); color:#008751; border:none; border-radius:6px; font-size:12px; font-weight:bold; cursor:pointer; transition:all 0.2s; }
    .btn-val:hover { background:#008751; color:white; }
    .btn-rej { padding:6px 14px; background:rgba(232,17,45,0.08); color:#E8112D; border:none; border-radius:6px; font-size:12px; font-weight:bold; cursor:pointer; transition:all 0.2s; }
    .btn-rej:hover { background:#E8112D; color:white; }
    .btn-del { padding:6px 14px; background:rgba(232,17,45,0.08); color:#E8112D; border:none; border-radius:6px; font-size:12px; font-weight:bold; cursor:pointer; }
    .btn-del:hover { background:#E8112D; color:white; }
    .btn-voir { padding:6px 14px; background:rgba(30,58,95,0.08); color:#1E3A5F; border:none; border-radius:6px; font-size:12px; font-weight:bold; cursor:pointer; text-decoration:none; }
    .btn-voir:hover { background:#1E3A5F; color:white; }

    .alert-success { background:rgba(0,135,81,0.1); border:1px solid #008751; color:#008751; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:14px; }
    .alert-warning { background:rgba(252,209,22,0.15); border:1px solid #c9a000; color:#c9a000; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:14px; }
    .empty { text-align:center; padding:40px; color:#999; }
    .resp-info { font-size:11px; color:#aaa; margin-top:3px; }
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

    @if($totalEnAttente > 0)
      <div class="alert-warning">
        <strong>{{ $totalEnAttente }} université(s)</strong> en attente de validation.
        <a href="{{ route('admin.universites', ['statut' => 'en_attente']) }}"
           style="color:#c9a000;font-weight:bold;margin-left:8px;">Voir →</a>
      </div>
    @endif

    <!-- STATS -->
    <div class="stats-mini">
      <div class="stat-mini">
        <div>
          <div class="num">{{ $total }}</div>
          <div class="lbl">Total universités</div>
        </div>
      </div>
      <div class="stat-mini">
        <div>
          <div class="num">{{ $totalPubliques }}</div>
          <div class="lbl">Universités publiques</div>
        </div>
      </div>
      <div class="stat-mini warning">
        <div>
          <div class="num">{{ $totalEnAttente }}</div>
          <div class="lbl">En attente validation</div>
        </div>
      </div>
      <div class="stat-mini">
        <div>
          <div class="num">{{ $totalPrivees }}</div>
          <div class="lbl">Établissements privés</div>
        </div>
      </div>
    </div>

    <div class="page-header">
      <h1>Gestion des universités</h1>
      <a href="{{ route('admin.universites.create') }}" class="btn-add">+ Ajouter une université</a>
    </div>

    <!-- FILTRES -->
    <div class="filtres-bar">
      <div class="filtres-left">
        <a href="{{ route('admin.universites') }}"
           class="filtre-btn {{ !request('statut') && !request('type') ? 'active' : '' }}">
          Toutes
        </a>
        <a href="{{ route('admin.universites', ['statut' => 'en_attente']) }}"
           class="filtre-btn en-attente {{ request('statut') == 'en_attente' ? 'active' : '' }}">
          En attente
          @if($totalEnAttente > 0)
            <span style="background:#c9a000;color:white;padding:1px 7px;border-radius:10px;font-size:10px;margin-left:4px;">
              {{ $totalEnAttente }}
            </span>
          @endif
        </a>
        <a href="{{ route('admin.universites', ['type' => 'public']) }}"
           class="filtre-btn {{ request('type') == 'public' ? 'active' : '' }}">
          Publiques
        </a>
        <a href="{{ route('admin.universites', ['type' => 'prive']) }}"
           class="filtre-btn {{ request('type') == 'prive' ? 'active' : '' }}">
          Privées
        </a>
      </div>
    </div>

    <div class="panel">
      <table class="table">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Sigle</th>
            <th>Ville</th>
            <th>Type</th>
            <th>Statut</th>
            <th>Campus</th>
            <th>Responsable</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($universites as $u)
          <tr>
            <td><strong>{{ $u->nom }}</strong></td>
            <td>{{ $u->sigle ?? '—' }}</td>
            <td>{{ $u->ville ?? '—' }}</td>
            <td>
              @if($u->type === 'public')
                <span class="badge badge-blue">Public</span>
              @else
                <span class="badge badge-green">Privé</span>
              @endif
            </td>
            <td>
              @php $statut = $u->statut ?? 'active'; @endphp
              @if($statut === 'active' || $statut === 'validee')
                <span class="badge badge-green">Active</span>
              @elseif($statut === 'en_attente')
                <span class="badge badge-yellow">En attente</span>
              @else
                <span class="badge badge-red">Inactive</span>
              @endif
            </td>
            <td>{{ $u->campus_count }} campus</td>
            <td>
              {{-- Utiliser la collection $responsables déjà chargée — pas de requête SQL ici --}}
              @php $resp = $responsables->get($u->id_universite); @endphp
              @if($resp)
                <div style="font-size:13px;font-weight:bold;color:#1E3A5F;">
                  {{ $resp->prenom }} {{ $resp->nom }}
                </div>
                <div class="resp-info">{{ $resp->email }}</div>
                <div class="resp-info">{{ $resp->telephone ?? '' }}</div>
              @else
                <span style="color:#aaa;font-size:12px;">Aucun responsable</span>
              @endif
            </td>
            <td>
              <div class="action-btns">
                {{-- VOIR DÉTAILS --}}
                <a href="{{ route('admin.universites.show', $u->id_universite) }}" class="btn-voir">Voir</a>

                @if(($u->statut ?? 'active') === 'en_attente')
                  <form method="POST" action="{{ route('admin.universites.valider', $u->id_universite) }}">
                    @csrf
                    <button type="submit" class="btn-val">Valider</button>
                  </form>
                  <form method="POST" action="{{ route('admin.universites.rejeter', $u->id_universite) }}">
                    @csrf
                    <button type="submit" class="btn-rej"
                            onclick="return confirm('Rejeter cette université ?')">Rejeter</button>
                  </form>
                @elseif(($u->statut ?? 'active') === 'active' && $u->type === 'prive')
                  <form method="POST" action="{{ route('admin.universites.rejeter', $u->id_universite) }}">
                    @csrf
                    <button type="submit" class="btn-rej"
                            onclick="return confirm('Désactiver cette université ?')">Désactiver</button>
                  </form>
                @endif

                <form method="POST" action="{{ route('admin.universites.destroy', $u->id_universite) }}">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-del"
                          onclick="return confirm('Supprimer définitivement cette université ?')">Supprimer</button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8">
              <div class="empty">Aucune université trouvée.</div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top:20px;">{{ $universites->links() }}</div>

  </div>
</body>
</html>