@extends('layouts.app')

@section('title', 'OrientaBac - Trouve ta filière idéale')

@section('styles')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #F4F6F9;
      color: #333333;
    }

    /* ===== BANDEAU DRAPEAU ===== */
    .drapeau-bande {
      height: 8px;
      background: linear-gradient(to bottom, #008751 0%, #008751 100%);
      position: relative;
      display: flex;
    }
    .drapeau-bande::before {
      content: '';
      position: absolute;
      left: 0; top: 0;
      width: 33%; height: 100%;
      background-color: #008751;
    }
    .drapeau-bande::after {
      content: '';
      position: absolute;
      left: 33%; top: 0;
      width: 67%; height: 50%;
      background-color: #FCD116;
      box-shadow: 0 4px 0 0 #E8112D;
    }

    /* ===== NAVBAR ===== */
    nav {
      background-color: #1E3A5F;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 60px;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    nav .logo {
      color: white;
      font-size: 22px;
      font-weight: bold;
      letter-spacing: 1px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .logo-flag {
      width: 22px;
      height: 16px;
      border-radius: 2px;
      overflow: hidden;
    }
    nav .logo span { color: #FCD116; }
    nav ul { list-style: none; display: flex; gap: 30px; }
    nav ul li a {
      color: white;
      text-decoration: none;
      font-size: 15px;
      transition: color 0.2s;
    }
    nav ul li a:hover { color: #FCD116; }
    nav ul li a.active { color: #FCD116; font-weight: bold; }
    .nav-btn {
      background-color: #008751;
      color: white !important;
      padding: 8px 20px;
      border-radius: 6px;
      font-weight: bold !important;
    }
    .nav-btn:hover { background-color: #006b40 !important; }
    .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
    .hamburger span { width: 25px; height: 3px; background-color: white; border-radius: 2px; }

    /* ===== HERO ===== */
    .hero {
      background: linear-gradient(135deg, #1E3A5F 0%, #2d5f8a 100%);
      min-height: 550px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 60px 80px;
      gap: 40px;
    }
    .hero-text { max-width: 580px; }
    .hero-badge {
      display: inline-block;
      background-color: rgba(0,135,81,0.25);
      color: #4cff9f;
      font-size: 13px;
      font-weight: bold;
      padding: 6px 14px;
      border-radius: 20px;
      margin-bottom: 20px;
      border: 1px solid #008751;
    }
    .hero-text h1 {
      color: white;
      font-size: 48px;
      font-weight: bold;
      line-height: 1.2;
      margin-bottom: 20px;
    }
    .hero-text h1 span { color: #FCD116; }
    .hero-text p {
      color: rgba(255,255,255,0.85);
      font-size: 17px;
      line-height: 1.7;
      margin-bottom: 35px;
    }
    .hero-buttons { display: flex; gap: 15px; flex-wrap: wrap; }
    .btn-primary {
      background-color: #008751;
      color: white;
      padding: 14px 30px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      text-decoration: none;
      transition: background-color 0.2s;
    }
    .btn-primary:hover { background-color: #006b40; }
    .btn-secondary {
      background-color: transparent;
      padding: 14px 30px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      text-decoration: none;
      border: 2px solid #FCD116;
      color: #FCD116;
      transition: all 0.2s;
    }
    .btn-secondary:hover { background-color: #FCD116; color: #1E3A5F; }
    .hero-image {
      background-color: rgba(255,255,255,0.08);
      border-radius: 16px;
      width: 420px;
      height: 350px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 16px;
      flex-shrink: 0;
      border: 1px solid rgba(255,255,255,0.15);
      padding: 30px;
      position: relative;
      overflow: hidden;
    }
    .hero-image::before {
      content: '';
      position: absolute;
      bottom: 0; left: 0; right: 0;
      height: 5px;
      background: linear-gradient(to right, #008751 33%, #FCD116 33% 66%, #E8112D 66%);
    }
    .hero-image .icon-box { font-size: 60px; }
    .hero-image p { color: rgba(255,255,255,0.7); font-size: 15px; text-align: center; }
    .hero-stats { display: flex; gap: 30px; margin-top: 40px; }
    .stat { text-align: center; }
    .stat h3 { color: #FCD116; font-size: 28px; font-weight: bold; }
    .stat p { color: rgba(255,255,255,0.7); font-size: 13px; margin-bottom: 0; }

    /* ===== SECTIONS ===== */
    .section { padding: 70px 80px; }
    .section-header { text-align: center; margin-bottom: 50px; }
    .section-header h2 { font-size: 32px; font-weight: bold; color: #1E3A5F; margin-bottom: 12px; }
    .section-header p { font-size: 16px; color: #777; max-width: 600px; margin: 0 auto; }
    .section-header .line {
      width: 60px; height: 8px;
      position: relative;
      margin: 16px auto 0;
      border-radius: 2px;
      overflow: hidden;
    }
    .section-header .line::before {
      content: '';
      position: absolute;
      left: 0; top: 0;
      width: 33%; height: 100%;
      background-color: #008751;
    }
    .section-header .line::after {
      content: '';
      position: absolute;
      left: 33%; top: 0;
      width: 67%; height: 50%;
      background-color: #FCD116;
      box-shadow: 0 4px 0 0 #E8112D;
    }

    /* ===== ETAPES ===== */
    .etapes { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
    .etape {
      background-color: white;
      border-radius: 12px;
      padding: 35px 30px;
      text-align: center;
      box-shadow: 0 2px 12px rgba(0,0,0,0.07);
      transition: transform 0.2s;
      border-top: 4px solid transparent;
    }
    .etape:nth-child(1) { border-top-color: #008751; }
    .etape:nth-child(2) { border-top-color: #FCD116; }
    .etape:nth-child(3) { border-top-color: #E8112D; }
    .etape:hover { transform: translateY(-5px); }
    .etape-num {
      width: 50px; height: 50px;
      color: white;
      font-size: 20px;
      font-weight: bold;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
    }
    .etape:nth-child(1) .etape-num { background-color: #008751; }
    .etape:nth-child(2) .etape-num { background-color: #FCD116; color: #333; }
    .etape:nth-child(3) .etape-num { background-color: #E8112D; }
    .etape-icon { font-size: 40px; margin-bottom: 16px; }
    .etape h3 { font-size: 18px; font-weight: bold; color: #1E3A5F; margin-bottom: 10px; }
    .etape p { font-size: 14px; color: #777; line-height: 1.6; }

    /* ===== FILIERES ===== */
    .section-grey { background-color: #EEF1F5; padding: 70px 80px; }
    .filieres-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
    .filiere-card {
      background-color: white;
      border-radius: 10px;
      padding: 25px 20px;
      text-align: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
      cursor: pointer;
      transition: all 0.2s;
      border-bottom: 3px solid transparent;
    }
    .filiere-card:hover { transform: translateY(-3px); }
    .filiere-card:nth-child(4n+1):hover { border-bottom-color: #008751; }
    .filiere-card:nth-child(4n+2):hover { border-bottom-color: #FCD116; }
    .filiere-card:nth-child(4n+3):hover { border-bottom-color: #E8112D; }
    .filiere-card:nth-child(4n+4):hover { border-bottom-color: #1E3A5F; }
    .filiere-card .icon { font-size: 36px; margin-bottom: 12px; }
    .filiere-card h4 { font-size: 14px; font-weight: bold; color: #1E3A5F; margin-bottom: 6px; }
    .filiere-card p { font-size: 12px; color: #999; }
    .voir-plus { text-align: center; margin-top: 35px; }
    .voir-plus a {
      display: inline-block;
      padding: 12px 30px;
      border: 2px solid #008751;
      color: #008751;
      border-radius: 8px;
      font-size: 15px;
      font-weight: bold;
      text-decoration: none;
      transition: all 0.2s;
    }
    .voir-plus a:hover { background-color: #008751; color: white; }

    /* ===== TEMOIGNAGES ===== */
    .temoignages-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; }
    .temoignage-card {
      background-color: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.07);
      border-left: 4px solid #008751;
    }
    .temoignage-card:nth-child(2) { border-left-color: #FCD116; }
    .temoignage-card:nth-child(3) { border-left-color: #E8112D; }
    .stars { color: #FCD116; font-size: 16px; margin-bottom: 12px; }
    .temoignage-card p { font-size: 14px; color: #555; line-height: 1.7; margin-bottom: 16px; font-style: italic; }
    .temoignage-auteur { display: flex; align-items: center; gap: 12px; }
    .avatar {
      width: 40px; height: 40px;
      border-radius: 50%;
      background-color: #1E3A5F;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 15px;
    }
    .temoignage-card:nth-child(1) .avatar { background-color: #008751; }
    .temoignage-card:nth-child(2) .avatar { background-color: #c9a000; }
    .temoignage-card:nth-child(3) .avatar { background-color: #E8112D; }
    .temoignage-auteur div h5 { font-size: 14px; font-weight: bold; color: #1E3A5F; }
    .temoignage-auteur div span { font-size: 12px; color: #999; }

    /* ===== CTA ===== */
    .cta {
      background: linear-gradient(135deg, #006b40, #008751);
      padding: 70px 80px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .cta::after {
      content: '';
      position: absolute;
      bottom: 0; left: 0; right: 0;
      height: 6px;
      background: linear-gradient(to right, #008751 33%, #FCD116 33% 66%, #E8112D 66%);
    }
    .cta h2 { color: white; font-size: 34px; font-weight: bold; margin-bottom: 15px; }
    .cta p { color: rgba(255,255,255,0.85); font-size: 16px; margin-bottom: 35px; max-width: 550px; margin-left: auto; margin-right: auto; }
    .btn-cta {
      display: inline-block;
      background-color: #FCD116;
      color: #1E3A5F;
      padding: 14px 35px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      text-decoration: none;
      transition: background-color 0.2s;
    }
    .btn-cta:hover { background-color: #e6be00; }

    /* ===== FOOTER ===== */
    footer { background-color: #12253d; padding: 50px 80px 30px; }
    .footer-top-band {
      height: 8px;
      position: relative;
      margin-bottom: 40px;
      border-radius: 2px;
      overflow: hidden;
    }
    .footer-top-band::before {
      content: '';
      position: absolute;
      left: 0; top: 0;
      width: 33%; height: 100%;
      background-color: #008751;
    }
    .footer-top-band::after {
      content: '';
      position: absolute;
      left: 33%; top: 0;
      width: 67%; height: 50%;
      background-color: #FCD116;
      box-shadow: 0 4px 0 0 #E8112D;
    }
    .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 40px; }
    .footer-brand .logo { color: white; font-size: 20px; font-weight: bold; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
    .footer-brand .logo span { color: #FCD116; }
    .footer-brand p { color: rgba(255,255,255,0.5); font-size: 13px; line-height: 1.7; }
    .footer-col h4 { color: white; font-size: 14px; font-weight: bold; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 2px solid #008751; display: inline-block; }
    .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
    .footer-col ul li a { color: rgba(255,255,255,0.5); text-decoration: none; font-size: 13px; transition: color 0.2s; }
    .footer-col ul li a:hover { color: #FCD116; }
    .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 25px; text-align: center; }
    .footer-bottom p { color: rgba(255,255,255,0.4); font-size: 12px; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      nav { padding: 0 20px; }
      nav ul { display: none; }
      .hamburger { display: flex; }
      .hero { flex-direction: column; padding: 40px 20px; min-height: auto; text-align: center; }
      .hero-text h1 { font-size: 30px; }
      .hero-image { width: 100%; height: 200px; }
      .hero-buttons { justify-content: center; }
      .hero-stats { justify-content: center; }
      .section { padding: 50px 20px; }
      .section-grey { padding: 50px 20px; }
      .etapes { grid-template-columns: 1fr; }
      .filieres-grid { grid-template-columns: repeat(2, 1fr); }
      .temoignages-grid { grid-template-columns: 1fr; }
      .cta { padding: 50px 20px; }
      footer { padding: 40px 20px 20px; }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 30px; }
    }
</style>
@endsection

@section('content')

  <!-- HERO -->
  <section class="hero">
    <div class="hero-text">
      <div class="hero-badge">Guide Orientation — Bénin</div>
      <h1>Trouve ta filière idéale après le <span>Baccalauréat</span></h1>
      <p>OrientaBac t'accompagne dans ton choix d'orientation universitaire. Réponds à quelques questions et découvre les filières qui correspondent à ton profil, tes notes et tes ambitions.</p>
      <div class="hero-buttons">
        <a href="{{ route('questionnaire') }}" class="btn-primary">Commencer l'orientation</a>
        <a href="{{ route('filieres.index') }}" class="btn-secondary">Voir les filières</a>
      </div>
      <div class="hero-stats">
        <div class="stat"><h3>80 000+</h3><p>Bacheliers/an</p></div>
        <div class="stat"><h3>200+</h3><p>Filières disponibles</p></div>
        <div class="stat"><h3>100%</h3><p>Gratuit</p></div>
      </div>
    </div>
    <div class="hero-image">
      <div class="icon-box">🎓</div>
      <p>Orientation personnalisée basée sur le guide officiel du MESRS</p>
    </div>
  </section>

  <!-- COMMENT CA MARCHE -->
  <section class="section">
    <div class="section-header">
      <h2>Comment ça marche ?</h2>
      <p>En 3 étapes simples, trouve la filière qui te correspond vraiment</p>
      <div class="line"></div>
    </div>
    <div class="etapes">
      <div class="etape">
        <div class="etape-num">1</div>
        <div class="etape-icon"></div>
        <h3>Remplis le questionnaire</h3>
        <p>Indique ta série de baccalauréat, tes notes dans les matières fondamentales et tes centres d'intérêt professionnels.</p>
      </div>
      <div class="etape">
        <div class="etape-num">2</div>
        <div class="etape-icon"></div>
        <h3>L'algorithme analyse</h3>
        <p>Notre système calcule ton score d'éligibilité pour chaque filière selon la formule officielle du MESRS et ton profil.</p>
      </div>
      <div class="etape">
        <div class="etape-num">3</div>
        <div class="etape-icon"></div>
        <h3>Découvre tes résultats</h3>
        <p>Reçois une liste personnalisée de filières avec ton diagnostic : boursier, titre payant ou non admissible.</p>
      </div>
    </div>
  </section>

  <!-- FILIERES -->
  <section id="filieres" class="section-grey">
    <div class="section-header">
      <h2>Filières disponibles</h2>
      <p>Explore toutes les formations des universités publiques et privées du Bénin</p>
      <div class="line"></div>
    </div>
    <div class="filieres-grid">
      @forelse($filieres as $filiere)
        <div class="filiere-card" onclick="window.location='{{ route('filieres.show', $filiere->id_filiere) }}'">
          <div class="icon">{{ $filiere->icone ?? '🎓' }}</div>
          <h4>{{ $filiere->nom }}</h4>
          <p>{{ $filiere->campus->pluck('universite.sigle')->implode(' · ') }}</p>
        </div>
      @empty
        <div class="filiere-card"><div class="icon">💻</div><h4>Informatique</h4><p>IFRI · EPAC · ENEAM</p></div>
        <div class="filiere-card"><div class="icon">⚕️</div><h4>Sciences de la Santé</h4><p>FSS · INMeS · IFSIO</p></div>
        <div class="filiere-card"><div class="icon">⚖️</div><h4>Droit & Sciences Politiques</h4><p>FADESP · FDSP</p></div>
        <div class="filiere-card"><div class="icon">📊</div><h4>Économie & Gestion</h4><p>FASEG · ENEAM</p></div>
        <div class="filiere-card"><div class="icon">🌱</div><h4>Agronomie</h4><p>FSA · UNA</p></div>
        <div class="filiere-card"><div class="icon">🏗️</div><h4>Génie Civil & BTP</h4><p>EPAC · UNSTIM</p></div>
        <div class="filiere-card"><div class="icon">🎨</div><h4>Lettres & Arts</h4><p>FLASH · FLLAC · INMAAC</p></div>
        <div class="filiere-card"><div class="icon">🔬</div><h4>Sciences & Techniques</h4><p>FAST · IMSP</p></div>
      @endforelse
    </div>
    <div class="voir-plus">
      <a href="{{ route('filieres.index') }}">Voir toutes les filières →</a>
    </div>
  </section>

  <!-- TEMOIGNAGES -->
  <section id="temoignages" class="section">
    <div class="section-header">
      <h2>Ils ont trouvé leur voie</h2>
      <p>Témoignages d'étudiants qui ont utilisé OrientaBac</p>
      <div class="line"></div>
    </div>
    <div class="temoignages-grid">
      @forelse($temoignages as $temoignage)
        <div class="temoignage-card">
          <div class="stars">{{ str_repeat('★', $temoignage->note) }}{{ str_repeat('☆', 5 - $temoignage->note) }}</div>
          <p>"{{ $temoignage->contenu }}"</p>
          <div class="temoignage-auteur">
            <div class="avatar">{{ strtoupper(substr($temoignage->user->nom, 0, 1) . substr($temoignage->user->prenom, 0, 1)) }}</div>
            <div>
              <h5>{{ $temoignage->user->prenom }} {{ $temoignage->user->nom }}</h5>
              <span>{{ $temoignage->filiere->nom }}</span>
            </div>
          </div>
        </div>
      @empty
        <div class="temoignage-card">
          <div class="stars">★★★★★</div>
          <p>"Grâce à OrientaBac, j'ai découvert la filière Génie Logiciel à l'IFRI qui correspondait parfaitement à mon profil."</p>
          <div class="temoignage-auteur">
            <div class="avatar">KA</div>
            <div><h5>Kolade Ahounou</h5><span>Génie Logiciel — IFRI, UAC</span></div>
          </div>
        </div>
        <div class="temoignage-card">
          <div class="stars">★★★★★</div>
          <p>"Le questionnaire m'a aidé à comprendre que j'avais les notes pour être boursière en Médecine."</p>
          <div class="temoignage-auteur">
            <div class="avatar">SF</div>
            <div><h5>Salimata Fassinou</h5><span>Médecine Générale — FSS, UAC</span></div>
          </div>
        </div>
        <div class="temoignage-card">
          <div class="stars">★★★★☆</div>
          <p>"J'ai apprécié avoir les informations sur les quotas et les débouchés directement sur la plateforme."</p>
          <div class="temoignage-auteur">
            <div class="avatar">MB</div>
            <div><h5>Marius Biaou</h5><span>Finance & Comptabilité — FASEG, UP</span></div>
          </div>
        </div>
      @endforelse
    </div>
  </section>

  <!-- CTA -->
  <section class="cta">
    <h2>Prêt à trouver ta filière idéale ?</h2>
    <p>Commence ton orientation maintenant, c'est gratuit et sans inscription obligatoire.</p>
    <a href="{{ route('questionnaire') }}" class="btn-cta">Commencer l'orientation</a>
  </section>

@endsection