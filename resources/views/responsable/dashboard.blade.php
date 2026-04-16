<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Responsable — OrientaBac</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background: #eef2f7; color: #1f2937; }
    a { color: inherit; }
    .topbar { background: #1e3a5f; padding: 22px 36px; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
    .logo { color: white; font-size: 22px; font-weight: 700; letter-spacing: .02em; }
    .logo span { color: #fcd116; }
    .topbar-right { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
    .topbar-user { color: rgba(255,255,255,0.85); font-size: 14px; }
    .btn-logout { padding: 10px 18px; background: rgba(255,255,255,0.12); color: #f8fafc; border: 1px solid rgba(255,255,255,0.18); border-radius: 14px; font-size: 13px; font-weight: 700; cursor: pointer; }
    .container { max-width: 1160px; margin: 30px auto; padding: 0 20px 40px; }
    .hero-card { background: linear-gradient(135deg, #1e3a5f, #2b5f88); border-radius: 24px; color: white; padding: 32px 36px; position: relative; overflow: hidden; margin-bottom: 28px; }
    .hero-card::after { content: ''; position: absolute; right: -60px; top: -60px; width: 180px; height: 180px; background: rgba(255,255,255,0.13); border-radius: 50%; }
    .hero-card h1 { font-size: 32px; font-weight: 800; margin-bottom: 12px; line-height: 1.1; }
    .hero-card p { font-size: 15px; max-width: 720px; line-height: 1.75; color: rgba(255,255,255,0.87); }
    .stats-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 18px; margin-bottom: 28px; }
    .stat-card { background: white; border-radius: 22px; padding: 24px 22px; box-shadow: 0 18px 50px rgba(15,23,42,0.08); }
    .stat-card .label { display: block; font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 14px; }
    .stat-card .value { font-size: 30px; font-weight: 800; color: #111827; }
    .stat-card .note { margin-top: 10px; font-size: 13px; color: #6b7280; line-height: 1.6; }
    .panel { background: white; border-radius: 24px; padding: 28px; box-shadow: 0 18px 50px rgba(15,23,42,0.06); }
    .panel-header { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; }
    .panel-header h2 { font-size: 20px; font-weight: 800; color: #111827; }
    .btn-add { padding: 12px 20px; background: #008751; color: white; border: none; border-radius: 16px; font-size: 14px; font-weight: 700; cursor: pointer; text-decoration: none; }
    .btn-add:hover { background: #006b40; }
    .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #166534; padding: 16px 18px; border-radius: 16px; margin-bottom: 24px; font-size: 14px; }
    .table-wrapper { overflow-x: auto; }
    .table { width: 100%; min-width: 760px; border-collapse: collapse; }
    .table thead th { text-align: left; padding: 16px 14px; font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .08em; background: #f8fafc; border-bottom: 1px solid #e5e7eb; }
    .table tbody tr { border-bottom: 1px solid #e5e7eb; }
    .table tbody tr:last-child { border-bottom: none; }
    .table td { padding: 16px 14px; font-size: 14px; color: #334155; vertical-align: middle; }
    .table tbody tr:hover { background: #f8fafc; }
    .badge { display: inline-flex; align-items: center; justify-content: center; padding: 8px 14px; border-radius: 999px; font-size: 12px; font-weight: 700; }
    .badge-green { background: rgba(16,185,129,0.12); color: #047857; }
    .badge-yellow { background: rgba(245,158,11,0.16); color: #92400e; }
    .badge-red { background: rgba(239,68,68,0.14); color: #b91c1c; }
    .empty { text-align: center; padding: 50px 0; color: #64748b; }
    .empty p { font-size: 16px; margin-bottom: 18px; }
    .status-note { color: #475569; font-size: 13px; }
    @media (max-width: 1024px) {
      .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 720px) {
      .topbar { flex-direction: column; align-items: flex-start; gap: 18px; }
      .panel-header { flex-direction: column; align-items: stretch; }
      .stats-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <header class="topbar">
    <div class="logo">Orienta<span>Bac</span> — Espace Responsable</div>
    <div class="topbar-right">
      <span class="topbar-user">👤 {{ session('responsable_prenom') }} {{ session('responsable_nom') }}</span>
      <form method="POST" action="{{ route('responsable.logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="btn-logout">Déconnexion</button>
      </form>
    </div>
  </header>

  <main class="container">

    @if(session('success'))
      <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <section class="hero-card">
      <h1>Bienvenue sur votre dashboard</h1>
      <p>Suivez le statut des filières que vous avez proposées, consultez les validations et continuez à enrichir votre catalogue de formations.</p>
    </section>

    <section class="stats-grid">
      <div class="stat-card">
        <span class="label">Total filières soumises</span>
        <div class="value">{{ $totalFilieres }}</div>
        <div class="note">Toutes vos propositions enregistrées.</div>
      </div>
      <div class="stat-card">
        <span class="label">Filières validées</span>
        <div class="value">{{ $filiersValidees }}</div>
        <div class="note">Filières publiées sur la plateforme.</div>
      </div>
      <div class="stat-card">
        <span class="label">En attente</span>
        <div class="value">{{ $filiersEnAttente }}</div>
        <div class="note">Propositions en cours de validation.</div>
      </div>
      <div class="stat-card">
        <span class="label">Filières rejetées</span>
        <div class="value">{{ $filiersRejetees }}</div>
        <div class="note">Propositions à corriger ou retraitées.</div>
      </div>
    </section>

    <section class="panel">
      <div class="panel-header">
        <h2>Mes filières soumises</h2>
        <a href="{{ route('responsable.filiere.create') }}" class="btn-add">+ Soumettre une filière</a>
      </div>

      @if($filieres->isEmpty())
        <div class="empty">
          <p>Aucune filière soumise pour le moment.</p>
          <a href="{{ route('responsable.filiere.create') }}" class="btn-add">Soumettre ma première filière</a>
        </div>
      @else
        <div class="table-wrapper">
          <table class="table">
            <thead>
              <tr>
                <th>Filière</th>
                <th>Durée</th>
                <th>Mode d'entrée</th>
                <th>Quota bourse</th>
                <th>Statut</th>
                <th>Motif rejet</th>
              </tr>
            </thead>
            <tbody>
              @foreach($filieres as $filiere)
                <tr>
                  <td><strong>{{ $filiere->nom }}</strong></td>
                  <td>{{ $filiere->duree_annees }} ans</td>
                  <td>{{ ucfirst($filiere->mode_entree) }}</td>
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
                  <td class="status-note">{{ $filiere->motif_rejet ?? '—' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </section>

  </main>
</body>
</html>