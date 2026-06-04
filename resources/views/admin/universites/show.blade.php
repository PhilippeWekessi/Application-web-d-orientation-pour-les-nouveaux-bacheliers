<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>{{ $universite->nom }} — Admin OrientaBac</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI',sans-serif; background:#F0F2F5; }
    .topbar { background:#12253d; padding:16px 35px; display:flex; align-items:center; justify-content:space-between; }
    .topbar .logo { color:white; font-size:18px; font-weight:bold; }
    .topbar .logo span { color:#FCD116; }
    .topbar a { color:rgba(255,255,255,0.6); font-size:14px; text-decoration:none; }
    .topbar a:hover { color:white; }
    .container { max-width:1100px; margin:30px auto; padding:0 20px 60px; }

    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header h1 { font-size:22px; font-weight:bold; color:#1E3A5F; }
    .back-btn { padding:9px 18px; background:white; color:#1E3A5F; border:2px solid #1E3A5F; border-radius:8px; font-size:13px; font-weight:bold; text-decoration:none; }
    .back-btn:hover { background:#1E3A5F; color:white; }

    .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
    .grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px; margin-bottom:20px; }

    .card { background:white; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.06); }
    .card h2 { font-size:16px; font-weight:bold; color:#1E3A5F; margin-bottom:16px; padding-bottom:12px; border-bottom:2px solid #f0f0f0; display:flex; align-items:center; gap:8px; }
    .card h2 .icon { font-size:18px; }

    .info-row { display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f5f5f5; }
    .info-row:last-child { border-bottom:none; }
    .info-label { font-size:13px; color:#999; }
    .info-value { font-size:13px; font-weight:bold; color:#1E3A5F; text-align:right; }

    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:bold; }
    .badge-green { background:rgba(0,135,81,0.1); color:#008751; }
    .badge-blue { background:rgba(30,58,95,0.08); color:#1E3A5F; }
    .badge-yellow { background:rgba(252,209,22,0.2); color:#c9a000; }
    .badge-red { background:rgba(232,17,45,0.08); color:#E8112D; }

    /* RESPONSABLE CARD */
    .resp-card { background:linear-gradient(135deg, #1E3A5F, #2d5f8a); border-radius:12px; padding:24px; color:white; margin-bottom:20px; }
    .resp-card h2 { color:white; font-size:16px; font-weight:bold; margin-bottom:16px; padding-bottom:12px; border-bottom:1px solid rgba(255,255,255,0.2); }
    .resp-avatar { width:56px; height:56px; border-radius:50%; background:rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; font-size:22px; font-weight:bold; color:white; margin-bottom:12px; }
    .resp-nom { font-size:18px; font-weight:bold; color:white; margin-bottom:4px; }
    .resp-detail { font-size:13px; color:rgba(255,255,255,0.7); margin-bottom:3px; }
    .resp-none { color:rgba(255,255,255,0.5); font-size:13px; font-style:italic; }

    /* FORMULAIRE ASSIGNER */
    .assign-form { margin-top:16px; padding-top:16px; border-top:1px solid rgba(255,255,255,0.2); }
    .assign-form label { font-size:12px; color:rgba(255,255,255,0.7); display:block; margin-bottom:6px; }
    .assign-form select { width:100%; padding:10px 12px; border-radius:8px; border:none; font-size:13px; color:#1E3A5F; background:white; margin-bottom:10px; }
    .assign-form select:focus { outline:none; }
    .btn-assign { padding:9px 20px; background:#FCD116; color:#1E3A5F; border:none; border-radius:8px; font-size:13px; font-weight:bold; cursor:pointer; transition:background 0.2s; }
    .btn-assign:hover { background:#e6be00; }

    /* CAMPUS */
    .campus-list { display:flex; flex-direction:column; gap:10px; }
    .campus-item { background:#F8F9FA; border-radius:8px; padding:14px 16px; display:flex; align-items:center; justify-content:space-between; }
    .campus-name { font-size:14px; font-weight:bold; color:#1E3A5F; }
    .campus-meta { font-size:12px; color:#999; margin-top:3px; }
    .campus-count { background:rgba(0,135,81,0.1); color:#008751; font-size:12px; font-weight:bold; padding:4px 10px; border-radius:20px; }

    /* FILIERES */
    .table { width:100%; border-collapse:collapse; }
    .table th { text-align:left; font-size:12px; font-weight:bold; color:#999; text-transform:uppercase; padding:10px 14px; background:#F8F9FA; }
    .table td { padding:12px 14px; font-size:13px; color:#555; border-bottom:1px solid #f0f0f0; }
    .table tr:last-child td { border-bottom:none; }
    .table tr:hover td { background:#fafafa; }

    .alert-success { background:rgba(0,135,81,0.1); border:1px solid #008751; color:#008751; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:14px; }
    .empty { text-align:center; padding:30px; color:#999; font-size:14px; }

    @media(max-width:768px) {
      .grid-2, .grid-3 { grid-template-columns:1fr; }
      .topbar { padding:14px 20px; }
      .container { padding:0 14px 40px; }
    }
  </style>
</head>
<body>

  <div class="topbar">
    <div class="logo">Orienta<span>Bac</span> — Admin</div>
    <a href="{{ route('admin.universites') }}">← Retour aux universités</a>
  </div>

  <div class="container">

    @if(session('success'))
      <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="page-header">
      <h1>{{ $universite->nom }}</h1>
      <a href="{{ route('admin.universites') }}" class="back-btn">← Retour</a>
    </div>

    <div class="grid-2">

      <!-- INFOS UNIVERSITÉ -->
      <div class="card">
        <h2><span class="icon">🏛️</span> Informations générales</h2>
        <div class="info-row">
          <span class="info-label">Nom complet</span>
          <span class="info-value">{{ $universite->nom }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Sigle</span>
          <span class="info-value">{{ $universite->sigle ?? '—' }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Ville</span>
          <span class="info-value">{{ $universite->ville ?? '—' }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Type</span>
          <span class="info-value">
            @if($universite->type === 'public')
              <span class="badge badge-blue">Public</span>
            @else
              <span class="badge badge-green">Privé</span>
            @endif
          </span>
        </div>
        <div class="info-row">
          <span class="info-label">Statut</span>
          <span class="info-value">
            @php $statut = $universite->statut ?? 'active'; @endphp
            @if($statut === 'active' || $statut === 'validee')
              <span class="badge badge-green">Active</span>
            @elseif($statut === 'en_attente')
              <span class="badge badge-yellow">En attente</span>
            @else
              <span class="badge badge-red">Inactive</span>
            @endif
          </span>
        </div>
        <div class="info-row">
          <span class="info-label">Nombre de campus</span>
          <span class="info-value">{{ $universite->campus->count() }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Nombre de filières</span>
          <span class="info-value">{{ $filieres->count() }}</span>
        </div>
      </div>

      <!-- RESPONSABLE -->
      <div class="resp-card">
        <h2>👤 Responsable de l'université</h2>

        @if($responsable)
          <div class="resp-avatar">
            {{ strtoupper(substr($responsable->prenom, 0, 1)) }}{{ strtoupper(substr($responsable->nom, 0, 1)) }}
          </div>
          <div class="resp-nom">{{ $responsable->prenom }} {{ $responsable->nom }}</div>
          <div class="resp-detail">📧 {{ $responsable->email }}</div>
          @if($responsable->telephone)
            <div class="resp-detail">📞 {{ $responsable->telephone }}</div>
          @endif
          <div class="resp-detail" style="margin-top:6px;">
            <span style="background:rgba(0,255,100,0.2);padding:2px 10px;border-radius:10px;font-size:11px;">
              {{ $responsable->statut ?? 'actif' }}
            </span>
          </div>
        @else
          <div class="resp-none">Aucun responsable assigné à cette université.</div>
        @endif

        <!-- FORMULAIRE D'ASSIGNATION -->
        <div class="assign-form">
          <form method="POST" action="{{ route('admin.universites.assigner', $universite->id_universite) }}">
            @csrf
            <label>Assigner un responsable :</label>
            <select name="id_responsable">
              <option value="">-- Aucun responsable --</option>
              @foreach($responsables as $resp)
                <option value="{{ $resp->id_responsable }}"
                  {{ $responsable && $responsable->id_responsable == $resp->id_responsable ? 'selected' : '' }}>
                  {{ $resp->prenom }} {{ $resp->nom }} — {{ $resp->email }}
                </option>
              @endforeach
            </select>
            <button type="submit" class="btn-assign">Assigner</button>
          </form>
        </div>
      </div>

    </div>

    <!-- CAMPUS -->
    <div class="card" style="margin-bottom:20px;">
      <h2><span class="icon">🏫</span> Campus ({{ $universite->campus->count() }})</h2>
      @if($universite->campus->isEmpty())
        <div class="empty">Aucun campus enregistré.</div>
      @else
        <div class="campus-list">
          @foreach($universite->campus as $campus)
            <div class="campus-item">
              <div>
                <div class="campus-name">{{ $campus->nom }}</div>
                <div class="campus-meta">{{ $campus->ville ?? '' }} {{ $campus->adresse ? '— ' . $campus->adresse : '' }}</div>
              </div>
              <span class="campus-count">{{ $campus->filieres->count() }} filière(s)</span>
            </div>
          @endforeach
        </div>
      @endif
    </div>

    <!-- FILIÈRES -->
    <div class="card">
      <h2><span class="icon">📚</span> Filières ({{ $filieres->count() }})</h2>
      @if($filieres->isEmpty())
        <div class="empty">Aucune filière enregistrée pour cette université.</div>
      @else
        <table class="table">
          <thead>
            <tr>
              <th>Nom de la filière</th>
              <th>Campus</th>
              <th>Durée</th>
              <th>Mode d'entrée</th>
              <th>Quota bourse</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tbody>
            @foreach($filieres as $filiere)
              <tr>
                <td><strong>{{ $filiere->nom }}</strong></td>
                <td style="color:#999;font-size:12px;">{{ $filiere->campus->nom ?? '—' }}</td>
                <td>{{ $filiere->duree_annees }} ans</td>
                <td>
                  @if($filiere->mode_entree === 'classement')
                    <span class="badge badge-blue">Classement</span>
                  @else
                    <span class="badge badge-yellow">Concours</span>
                  @endif
                </td>
                <td>{{ $filiere->quota_bourse ?? 0 }}</td>
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

  </div>
</body>
</html>