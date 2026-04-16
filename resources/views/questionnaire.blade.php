@extends('layouts.app')

@section('title', 'Questionnaire — OrientaBac')

@section('styles')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background-color: #F4F6F9; color: #333333; }

    .drapeau-bande { height: 8px; position: relative; display: flex; }
    .drapeau-bande::before { content: ''; position: absolute; left: 0; top: 0; width: 33%; height: 100%; background-color: #008751; }
    .drapeau-bande::after { content: ''; position: absolute; left: 33%; top: 0; width: 67%; height: 50%; background-color: #FCD116; box-shadow: 0 4px 0 0 #E8112D; }

    nav { background-color: #1E3A5F; height: 70px; display: flex; align-items: center; justify-content: space-between; padding: 0 60px; position: sticky; top: 0; z-index: 100; }
    nav .logo { color: white; font-size: 22px; font-weight: bold; letter-spacing: 1px; display: flex; align-items: center; gap: 8px; }
    .logo-flag { display: grid; grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr; width: 22px; height: 16px; border-radius: 2px; overflow: hidden; }
    .logo-flag .f1 { background-color: #008751; grid-column: 1; grid-row: 1 / 3; }
    .logo-flag .f2 { background-color: #FCD116; grid-column: 2; grid-row: 1; }
    .logo-flag .f3 { background-color: #E8112D; grid-column: 2; grid-row: 2; }
    nav .logo span { color: #FCD116; }
    nav ul { list-style: none; display: flex; gap: 30px; }
    nav ul li a { color: white; text-decoration: none; font-size: 15px; transition: color 0.2s; }
    nav ul li a:hover { color: #FCD116; }
    .nav-btn { background-color: #008751; color: white !important; padding: 8px 20px; border-radius: 6px; font-weight: bold !important; }
    .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
    .hamburger span { width: 25px; height: 3px; background-color: white; border-radius: 2px; }

    .hero { background: linear-gradient(135deg, #1E3A5F 0%, #2d5f8a 100%); height: 180px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 0 20px; position: relative; overflow: hidden; }
    .hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 5px; background: linear-gradient(to right, #008751 33%, #FCD116 33% 66%, #E8112D 66%); }
    .hero h1 { color: white; font-size: 34px; font-weight: bold; margin-bottom: 10px; }
    .hero p { color: rgba(255,255,255,0.8); font-size: 15px; max-width: 550px; }

    .progress-section { background-color: white; padding: 20px 80px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
    .progress-info { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
    .progress-info span { font-size: 13px; color: #777; font-weight: bold; }
    .progress-info .step-label { color: #1E3A5F; font-size: 14px; font-weight: bold; }
    .progress-bar { width: 100%; height: 8px; background-color: #E0E0E0; border-radius: 4px; overflow: hidden; }
    .progress-fill { height: 100%; background: linear-gradient(to right, #008751, #FCD116); border-radius: 4px; transition: width 0.4s; width: 33%; }
    .steps-dots { display: flex; justify-content: space-between; margin-top: 12px; }
    .dot { display: flex; flex-direction: column; align-items: center; gap: 5px; flex: 1; }
    .dot-circle { width: 28px; height: 28px; border-radius: 50%; border: 2px solid #ddd; background-color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; color: #999; }
    .dot.active .dot-circle { background-color: #008751; border-color: #008751; color: white; }
    .dot.done .dot-circle { background-color: #FCD116; border-color: #FCD116; color: #1E3A5F; }
    .dot span { font-size: 11px; color: #999; text-align: center; }
    .dot.active span { color: #008751; font-weight: bold; }

    .form-section { max-width: 750px; margin: 40px auto; padding: 0 20px 60px; }
    .form-card { background-color: white; border-radius: 16px; padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-top: 4px solid #008751; }
    .form-card h2 { font-size: 22px; font-weight: bold; color: #1E3A5F; margin-bottom: 6px; }
    .form-card .form-subtitle { font-size: 14px; color: #777; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee; }

    .form-group { margin-bottom: 24px; }
    .form-group label { display: block; font-size: 14px; font-weight: bold; color: #1E3A5F; margin-bottom: 8px; }
    .form-group label span.required { color: #E8112D; margin-left: 3px; }
    .form-group select, .form-group input[type="number"] { width: 100%; padding: 12px 16px; border: 2px solid #E0E0E0; border-radius: 8px; font-size: 14px; color: #333; background-color: #FAFAFA; transition: border-color 0.2s; appearance: none; -webkit-appearance: none; }
    .form-group select:focus, .form-group input[type="number"]:focus { outline: none; border-color: #008751; background-color: white; }
    .select-wrapper { position: relative; }
    .select-wrapper::after { content: '▼'; position: absolute; right: 14px; top: 50%; transform: translateY(-50%); font-size: 11px; color: #999; pointer-events: none; }

    .notes-container { display: flex; flex-direction: column; gap: 16px; }
    .note-item { display: flex; flex-direction: column; gap: 6px; }
    .note-item label { font-size: 14px; font-weight: bold; color: #1E3A5F; }
    .note-input-wrapper { position: relative; }
    .note-input-wrapper input { width: 100%; padding: 12px 50px 12px 16px; border: 2px solid #E0E0E0; border-radius: 8px; font-size: 14px; color: #333; background-color: #FAFAFA; transition: border-color 0.2s; }
    .note-input-wrapper input:focus { outline: none; border-color: #008751; background-color: white; }
    .note-input-wrapper .sur20 { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); font-size: 12px; color: #999; font-weight: bold; }
    .coef-badge { display: inline-block; background-color: rgba(30,58,95,0.08); color: #1E3A5F; font-size: 11px; font-weight: bold; padding: 2px 8px; border-radius: 10px; margin-left: 8px; }

    .interets-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
    .interet-item { border: 2px solid #E0E0E0; border-radius: 8px; padding: 12px 10px; text-align: center; cursor: pointer; transition: all 0.2s; user-select: none; }
    .interet-item:hover { border-color: #008751; background-color: rgba(0,135,81,0.05); }
    .interet-item.selected { border-color: #008751; background-color: rgba(0,135,81,0.1); }
    .interet-item input[type="checkbox"] { display: none; }
    .interet-item .interet-icon { font-size: 26px; margin-bottom: 6px; pointer-events: none; }
    .interet-item .interet-label { font-size: 12px; font-weight: bold; color: #1E3A5F; pointer-events: none; }

    .form-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 35px; padding-top: 25px; border-top: 1px solid #eee; }
    .btn-retour { padding: 12px 28px; border: 2px solid #1E3A5F; color: #1E3A5F; border-radius: 8px; font-size: 14px; font-weight: bold; background-color: transparent; cursor: pointer; transition: all 0.2s; }
    .btn-retour:hover { background-color: #1E3A5F; color: white; }
    .btn-suivant { padding: 12px 35px; background-color: #008751; color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: bold; cursor: pointer; transition: background-color 0.2s; }
    .btn-suivant:hover { background-color: #006b40; }
    .btn-soumettre { padding: 12px 35px; background-color: #FCD116; color: #1E3A5F; border: none; border-radius: 8px; font-size: 14px; font-weight: bold; cursor: pointer; transition: background-color 0.2s; }
    .btn-soumettre:hover { background-color: #e6be00; }

    .info-box { background-color: rgba(0,135,81,0.08); border: 1px solid rgba(0,135,81,0.3); border-radius: 8px; padding: 14px 16px; margin-bottom: 24px; display: flex; gap: 10px; align-items: flex-start; }
    .info-box .info-icon { font-size: 18px; flex-shrink: 0; }
    .info-box p { font-size: 13px; color: #444; line-height: 1.5; }
    .formule-box { background-color: rgba(30,58,95,0.06); border: 1px solid rgba(30,58,95,0.15); border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; color: #1E3A5F; font-weight: bold; text-align: center; }

    .etape-form { display: none; }
    .etape-form.active { display: block; }

    footer { background-color: #12253d; padding: 50px 80px 30px; }
    .footer-top-band { height: 8px; position: relative; margin-bottom: 40px; border-radius: 2px; overflow: hidden; }
    .footer-top-band::before { content: ''; position: absolute; left: 0; top: 0; width: 33%; height: 100%; background-color: #008751; }
    .footer-top-band::after { content: ''; position: absolute; left: 33%; top: 0; width: 67%; height: 50%; background-color: #FCD116; box-shadow: 0 4px 0 0 #E8112D; }
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

    @media (max-width: 768px) {
      nav { padding: 0 20px; }
      nav ul { display: none; }
      .hamburger { display: flex; }
      .progress-section { padding: 20px; }
      .form-card { padding: 25px 20px; }
      .interets-grid { grid-template-columns: repeat(2, 1fr); }
      .form-actions { flex-direction: column; gap: 12px; }
      .btn-retour, .btn-suivant, .btn-soumettre { width: 100%; text-align: center; }
      footer { padding: 40px 20px 20px; }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 30px; }
    }
</style>
@endsection

@section('content')

  <div class="hero">
    <h1>Questionnaire d'orientation</h1>
    <p>Réponds à ces quelques questions pour recevoir des recommandations personnalisées</p>
  </div>

  <div class="progress-section">
    <div class="progress-info">
      <span class="step-label" id="stepLabel">Étape 1 sur 3 — Ton profil</span>
      <span id="stepPercent">33%</span>
    </div>
    <div class="progress-bar">
      <div class="progress-fill" id="progressFill"></div>
    </div>
    <div class="steps-dots">
      <div class="dot active" id="dot1"><div class="dot-circle">1</div><span>Ton profil</span></div>
      <div class="dot" id="dot2"><div class="dot-circle">2</div><span>Tes intérêts</span></div>
      <div class="dot" id="dot3"><div class="dot-circle">3</div><span>Tes notes</span></div>
    </div>
  </div>

  <div class="form-section">
    <div class="form-card">

      <!-- ETAPE 1 : PROFIL -->
      <div class="etape-form active" id="etape1">
        <h2>👤 Ton profil</h2>
        <p class="form-subtitle">Commence par les informations de base sur ton baccalauréat.</p>

        <div class="info-box">
          <span class="info-icon">ℹ️</span>
          <p>Tu n'as pas besoin de te connecter pour passer ce test. Tes résultats seront affichés immédiatement.</p>
        </div>

        <div class="form-group">
          <label>Série de baccalauréat <span class="required">*</span></label>
          <div class="select-wrapper">
            <select id="serie">
              <option value="">-- Sélectionne ta série --</option>
              @foreach($series as $serie)
                <option value="{{ $serie->code }}">Série {{ $serie->code }} — {{ $serie->libelle }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Mention obtenue au baccalauréat <span class="required">*</span></label>
          <div class="select-wrapper">
            <select id="mention">
              <option value="">-- Sélectionne ta mention --</option>
              <option value="TB">Très Bien (16/20 et plus)</option>
              <option value="B">Bien (14/20 à 15,99)</option>
              <option value="AB">Assez Bien (12/20 à 13,99)</option>
              <option value="P">Passable (10/20 à 11,99)</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Moyenne générale au baccalauréat <span class="required">*</span></label>
          <div class="note-input-wrapper">
            <input type="number" id="moyenne" min="10" max="20" step="0.01" placeholder="Ex : 13.50" />
            <span class="sur20">/20</span>
          </div>
        </div>

        <div class="form-actions">
          <span></span>
          <button class="btn-suivant" onclick="allerEtape(2)">Suivant →</button>
        </div>
      </div>

      <!-- ETAPE 2 : INTERETS -->
      <div class="etape-form" id="etape2">
        <h2>❤️ Tes centres d'intérêt</h2>
        <p class="form-subtitle">Sélectionne les domaines qui t'intéressent (1, 2 ou 3 choix).</p>

        <div class="form-group">
          <label>Domaines d'intérêt <span class="required">*</span></label>
          <div class="interets-grid" id="interetsGrid">

            @if($interets->isNotEmpty())
              @foreach($interets as $interet)
                <div class="interet-item" data-value="{{ $interet->id_interet }}">
                  <input type="checkbox" value="{{ $interet->id_interet }}" />
                  <div class="interet-icon">{{ $interet->icone ?? '🎓' }}</div>
                  <div class="interet-label">{{ $interet->libelle }}</div>
                </div>
              @endforeach
            @else
              <div class="interet-item" data-value="informatique">
                <input type="checkbox" value="informatique" />
                <div class="interet-icon">💻</div>
                <div class="interet-label">Informatique & Numérique</div>
              </div>
              <div class="interet-item" data-value="sante">
                <input type="checkbox" value="sante" />
                <div class="interet-icon">⚕️</div>
                <div class="interet-label">Santé & Médecine</div>
              </div>
              <div class="interet-item" data-value="droit">
                <input type="checkbox" value="droit" />
                <div class="interet-icon">⚖️</div>
                <div class="interet-label">Droit & Justice</div>
              </div>
              <div class="interet-item" data-value="economie">
                <input type="checkbox" value="economie" />
                <div class="interet-icon">📊</div>
                <div class="interet-label">Économie & Gestion</div>
              </div>
              <div class="interet-item" data-value="agriculture">
                <input type="checkbox" value="agriculture" />
                <div class="interet-icon">🌱</div>
                <div class="interet-label">Agriculture & Environnement</div>
              </div>
              <div class="interet-item" data-value="ingenierie">
                <input type="checkbox" value="ingenierie" />
                <div class="interet-icon">🏗️</div>
                <div class="interet-label">Ingénierie & BTP</div>
              </div>
              <div class="interet-item" data-value="lettres">
                <input type="checkbox" value="lettres" />
                <div class="interet-icon">📚</div>
                <div class="interet-label">Lettres & Sciences Humaines</div>
              </div>
              <div class="interet-item" data-value="sciences">
                <input type="checkbox" value="sciences" />
                <div class="interet-icon">🔬</div>
                <div class="interet-label">Sciences & Recherche</div>
              </div>
              <div class="interet-item" data-value="arts">
                <input type="checkbox" value="arts" />
                <div class="interet-icon">🎨</div>
                <div class="interet-label">Arts & Culture</div>
              </div>
            @endif

          </div>
        </div>

        <div class="form-group" style="margin-top:24px;">
          <label>Ambition professionnelle</label>
          <div class="select-wrapper">
            <select id="ambition">
              <option value="">-- Qu'est-ce qui t'attire le plus ? --</option>
              <option value="emploi_public">Travailler dans la fonction publique</option>
              <option value="emploi_prive">Travailler dans le secteur privé</option>
              <option value="entrepreneuriat">Créer ma propre entreprise</option>
              <option value="recherche">Faire de la recherche scientifique</option>
              <option value="international">Travailler à l'international</option>
              <option value="nsp">Je ne sais pas encore</option>
            </select>
          </div>
        </div>

        <div class="form-actions">
          <button class="btn-retour" onclick="allerEtape(1)">← Retour</button>
          <button class="btn-suivant" onclick="allerEtape(3)">Suivant →</button>
        </div>
      </div>

      <!-- ETAPE 3 : NOTES -->
      <div class="etape-form" id="etape3">
        <h2>📝 Tes notes</h2>
        <p class="form-subtitle">Notes dans les 3 matières fondamentales de ta série.</p>

        <div class="info-box">
          <span class="info-icon">💡</span>
          <p>Ces notes permettent de calculer ta moyenne de classement selon la formule officielle du MESRS.</p>
        </div>

        <div class="formule-box" id="formuleBox">
          M = (m1 × coef1 + m2 × coef2 + m3 × coef3) / (coef1 + coef2 + coef3)
        </div>

        <div class="notes-container" id="notesContainer"></div>

        <div class="form-actions">
          <button class="btn-retour" onclick="allerEtape(2)">← Retour</button>
          <button class="btn-soumettre" onclick="soumettre()">Voir mes recommandations</button>
        </div>
      </div>

    </div>
  </div>

@endsection

@section('scripts')
<script>
  let etapeActuelle = 1;
  const matieresSerie = @json($matieresSerie);

  // ===== GESTION SELECTION INTERETS =====
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.interet-item').forEach(function(item) {
      item.addEventListener('click', function() {
        const checkbox  = this.querySelector('input[type="checkbox"]');
        const isSelected = this.classList.contains('selected');

        if (isSelected) {
          this.classList.remove('selected');
          checkbox.checked = false;
        } else {
          // Max 3 sélections
          const nbSelected = document.querySelectorAll('.interet-item.selected').length;
          if (nbSelected >= 3) {
            alert('⚠️ Tu peux sélectionner au maximum 3 centres d\'intérêt.');
            return;
          }
          this.classList.add('selected');
          checkbox.checked = true;
        }
      });
    });
  });

  // ===== GENERATION CHAMPS NOTES =====
  function genererChampNotes(serie) {
    const container  = document.getElementById('notesContainer');
    const formuleBox = document.getElementById('formuleBox');
    const matieres   = matieresSerie[serie];

    if (!matieres) {
      container.innerHTML = '<p style="color:#999;font-size:14px;">Série non trouvée. Veuillez retourner à l\'étape 1.</p>';
      return;
    }

    const noms  = matieres.map(m => m.nom.split(' ')[0]);
    const coefs = matieres.map(m => m.coef);
    const total = coefs.reduce((a,b) => a+b, 0);

    formuleBox.innerHTML = `📐 Formule MESRS : M = (${noms[0]}×${coefs[0]} + ${noms[1]}×${coefs[1]} + ${noms[2]}×${coefs[2]}) / ${total}`;

    container.innerHTML = matieres.map((m, i) => `
      <div class="note-item">
        <label>${m.nom} <span class="coef-badge">Coef. ${m.coef}</span></label>
        <div class="note-input-wrapper">
          <input type="number" id="note${i}" min="0" max="20" step="0.25" placeholder="0.00" />
          <span class="sur20">/20</span>
        </div>
      </div>
    `).join('');
  }

  // ===== NAVIGATION ENTRE ETAPES =====
  function allerEtape(num) {

    // Validation étape 1
    if (num === 2) {
      const serie   = document.getElementById('serie').value;
      const mention = document.getElementById('mention').value;
      const moyenne = document.getElementById('moyenne').value;
      if (!serie || !mention || !moyenne) {
        alert('⚠️ Veuillez remplir tous les champs obligatoires.');
        return;
      }
    }

    // Validation étape 2 + génération notes
    if (num === 3) {
      const nbSelected = document.querySelectorAll('.interet-item.selected').length;
      if (nbSelected === 0) {
        alert('⚠️ Veuillez sélectionner au moins un centre d\'intérêt.');
        return;
      }
      const serie = document.getElementById('serie').value;
      genererChampNotes(serie);
    }

    // Cacher étape actuelle
    document.getElementById('etape' + etapeActuelle).classList.remove('active');
    document.getElementById('dot' + etapeActuelle).classList.remove('active');
    document.getElementById('dot' + etapeActuelle).classList.add('done');

    // Afficher nouvelle étape
    etapeActuelle = num;
    document.getElementById('etape' + num).classList.add('active');

    // Mettre à jour les dots
    for (let i = num; i <= 3; i++) {
      document.getElementById('dot' + i).classList.remove('done');
    }
    document.getElementById('dot' + num).classList.add('active');

    // Mettre à jour la barre de progression
    const percent = Math.round((num / 3) * 100);
    document.getElementById('progressFill').style.width = percent + '%';
    document.getElementById('stepPercent').textContent  = percent + '%';

    const labels = ['', 'Ton profil', 'Tes intérêts', 'Tes notes'];
    document.getElementById('stepLabel').textContent = 'Étape ' + num + ' sur 3 — ' + labels[num];

    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  // ===== SOUMISSION =====
  function soumettre() {
    const serie   = document.getElementById('serie').value;
    const mention = document.getElementById('mention').value;
    const moyenne = document.getElementById('moyenne').value;
    const matieres = matieresSerie[serie];

    if (!matieres) {
      alert('⚠️ Série introuvable.');
      return;
    }

    // Récupérer les notes
    const notes = matieres.map((m, i) => {
      const val = parseFloat(document.getElementById('note' + i)?.value);
      return isNaN(val) ? 0 : val;
    });

    // Vérifier que les notes sont remplies
    const notesVides = notes.some(n => n < 0 || n > 20);
    if (notesVides) {
      alert('⚠️ Veuillez entrer des notes valides entre 0 et 20.');
      return;
    }

    // Récupérer les intérêts sélectionnés
    const interets = Array.from(document.querySelectorAll('.interet-item.selected input'))
                         .map(el => el.value);

    const ambition = document.getElementById('ambition')?.value || '';

    // Calculer le score MESRS
    const coefs     = matieres.map(m => m.coef);
    const totalCoef = coefs.reduce((a,b) => a+b, 0);
    const score     = notes.reduce((sum, note, i) => sum + note * coefs[i], 0) / totalCoef;

    // Créer le formulaire POST
    const form  = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("questionnaire.submit") }}';

    const csrf  = document.createElement('input');
    csrf.type   = 'hidden';
    csrf.name   = '_token';
    csrf.value  = '{{ csrf_token() }}';
    form.appendChild(csrf);

    const fields = {
      serie,
      mention,
      moyenne,
      score:    score.toFixed(2),
      ambition,
      interets: JSON.stringify(interets),
      notes:    JSON.stringify(notes)
    };

    Object.entries(fields).forEach(([key, value]) => {
      const input = document.createElement('input');
      input.type  = 'hidden';
      input.name  = key;
      input.value = value;
      form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
  }
</script>
@endsection