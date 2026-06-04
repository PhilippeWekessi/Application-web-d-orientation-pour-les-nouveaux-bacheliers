@extends('layouts.app')

@section('title', 'Soumettre un témoignage — OrientaBac')

@section('styles')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background-color: #F4F6F9; color: #333; }

    .drapeau-bande { height: 8px; position: relative; display: flex; }
    .drapeau-bande::before { content: ''; position: absolute; left: 0; top: 0; width: 33%; height: 100%; background-color: #008751; }
    .drapeau-bande::after { content: ''; position: absolute; left: 33%; top: 0; width: 67%; height: 50%; background-color: #FCD116; box-shadow: 0 4px 0 0 #E8112D; }

    nav { background-color: #1E3A5F; height: 70px; display: flex; align-items: center; justify-content: space-between; padding: 0 60px; position: sticky; top: 0; z-index: 100; }
    nav .logo { color: white; font-size: 22px; font-weight: bold; display: flex; align-items: center; gap: 8px; }
    .logo-flag { display: grid; grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr; width: 22px; height: 16px; border-radius: 2px; overflow: hidden; }
    .logo-flag .f1 { background-color: #008751; grid-column: 1; grid-row: 1 / 3; }
    .logo-flag .f2 { background-color: #FCD116; grid-column: 2; grid-row: 1; }
    .logo-flag .f3 { background-color: #E8112D; grid-column: 2; grid-row: 2; }
    nav .logo span { color: #FCD116; }
    nav ul { list-style: none; display: flex; gap: 30px; }
    nav ul li a { color: white; text-decoration: none; font-size: 15px; transition: color 0.2s; }
    nav ul li a:hover { color: #FCD116; }
    nav ul li a.active { color: #FCD116; font-weight: bold; }
    .nav-btn { background-color: #008751; color: white !important; padding: 8px 20px; border-radius: 6px; font-weight: bold !important; }
    .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
    .hamburger span { width: 25px; height: 3px; background-color: white; border-radius: 2px; }

    .hero { background: linear-gradient(135deg, #1E3A5F 0%, #2d5f8a 100%); padding: 50px 80px; position: relative; overflow: hidden; }
    .hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 5px; background: linear-gradient(to right, #008751 33%, #FCD116 33% 66%, #E8112D 66%); }
    .hero h1 { color: white; font-size: 34px; font-weight: bold; margin-bottom: 10px; }
    .hero p { color: rgba(255,255,255,0.8); font-size: 15px; margin-bottom: 30px; max-width: 600px; }
    .btn-back { display: inline-block; padding: 13px 28px; background-color: rgba(255,255,255,0.1); color: white; border: 2px solid rgba(255,255,255,0.3); border-radius: 10px; font-size: 15px; font-weight: bold; cursor: pointer; text-decoration: none; transition: all 0.2s; margin-right: 15px; }
    .btn-back:hover { background-color: rgba(255,255,255,0.2); border-color: rgba(255,255,255,0.5); }

    .form-section { background: white; border-radius: 16px; padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin: 50px auto; max-width: 800px; }
    .form-section h2 { font-size: 22px; font-weight: bold; color: #1E3A5F; margin-bottom: 8px; }
    .form-section p { font-size: 14px; color: #777; margin-bottom: 28px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group label { font-size: 13px; font-weight: bold; color: #555; }
    .form-group input, .form-group select, .form-group textarea { padding: 11px 14px; border: 1.5px solid #ddd; border-radius: 8px; font-size: 14px; color: #333; outline: none; transition: border-color 0.2s; background-color: #fafafa; font-family: 'Segoe UI', sans-serif; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #008751; background-color: white; }
    .form-group textarea { resize: vertical; min-height: 120px; }
    .stars-input { display: flex; gap: 8px; }
    .star-btn { font-size: 24px; cursor: pointer; color: #ddd; transition: color 0.2s; background: none; border: none; }
    .star-btn.active { color: #FCD116; }
    .btn-envoyer { padding: 13px 35px; background-color: #008751; color: white; border: none; border-radius: 10px; font-size: 15px; font-weight: bold; cursor: pointer; transition: background-color 0.2s; margin-top: 8px; }
    .btn-envoyer:hover { background-color: #006b40; }

    .alert-success { background-color: rgba(0,135,81,0.1); border: 1px solid #008751; color: #008751; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: bold; }
    .alert-error { background-color: rgba(232,17,45,0.1); border: 1px solid #E8112D; color: #E8112D; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }

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
      .hero { padding: 30px 20px; }
      .form-grid { grid-template-columns: 1fr; }
      footer { padding: 30px 20px; }
    }
</style>
@endsection

@section('content')

  <!-- HERO -->
  <div class="hero">
    <h1>Soumettre un témoignage</h1>
    <p>Partage ton expérience pour aider les futurs bacheliers dans leur choix d'orientation.</p>
    <a href="{{ route('temoignages.index') }}" class="btn-back">← Retour aux témoignages</a>
  </div>

  <div class="form-section">
    @if(session('success'))
      <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="alert-error">
        @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <form id="temoignage-form" method="POST" action="{{ route('temoignages.store') }}">
      @csrf
      <div class="form-grid">
        @if(session('user_id'))
          <div class="form-group">
            <label>Nom et prénom</label>
            <input type="text" name="nom_prenom" value="{{ session('user_prenom') }} {{ session('user_nom') }}" readonly />
          </div>
        @else
          <div class="form-group">
            <label>Nom et prénom</label>
            <input type="text" name="nom_prenom" placeholder="Ex: Kolade Ahounou"
                   value="{{ old('nom_prenom') }}" required />
          </div>
        @endif
        <div class="form-group">
          <label>Filière concernée</label>
          <select name="id_filiere" required>
            <option value="">-- Sélectionner une filière --</option>
            @foreach($filieres as $filiere)
              <option value="{{ $filiere->id_filiere }}"
                {{ old('id_filiere') == $filiere->id_filiere ? 'selected' : '' }}>
                {{ $filiere->nom }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Année d'étude</label>
          <select name="annee_etude" required>
            <option value="1">1ère année</option>
            <option value="2">2ème année</option>
            <option value="3">3ème année</option>
            <option value="diplome">Diplômé</option>
          </select>
        </div>
        <div class="form-group">
          <label>Série du baccalauréat</label>
          <select name="id_serie">
            <option value="">-- Série --</option>
            @foreach($series as $serie)
              <option value="{{ $serie->id_serie }}"
                {{ old('id_serie') == $serie->id_serie ? 'selected' : '' }}>
                {{ $serie->libelle }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group" style="margin-bottom:16px;">
        <label>Note (étoiles)</label>
        <div class="stars-input">
          @for($i = 1; $i <= 5; $i++)
            <button type="button" class="star-btn {{ old('note', 0) >= $i ? 'active' : '' }}"
                    onclick="setNote({{ $i }})">★</button>
          @endfor
        </div>
        <input type="hidden" name="note" id="note-input" value="{{ old('note', 0) }}" />
        <div id="note-error" style="color:#E11D48;font-size:13px;margin-top:6px;display:none;">La note doit être au moins 1 étoile.</div>
      </div>

      <div class="form-group" style="margin-bottom:20px;">
        <label>Ton témoignage(minimum 20 caractères)</label>
        <textarea name="contenu" placeholder="Partage ton expérience..." required minlength="20">{{ old('contenu') }}</textarea>
        @error('contenu')
          <div style="color:#E11D48;font-size:13px;margin-top:6px;">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn-envoyer">Envoyer mon témoignage</button>
      <p style="font-size:12px;color:#999;margin-top:12px;">Ton témoignage sera vérifié par notre équipe avant publication.</p>
    </form>
  </div>

@endsection

@section('scripts')
<script>
  let noteActuelle = {{ old('note', 0) }};
  function setNote(n) {
    noteActuelle = n;
    document.getElementById('note-input').value = n;
    document.querySelectorAll('.star-btn').forEach((btn, i) => {
      btn.classList.toggle('active', i < n);
    });
    document.getElementById('note-error').style.display = 'none';
  }

  document.getElementById('temoignage-form').addEventListener('submit', function(event) {
    if (!noteActuelle || noteActuelle < 1) {
      event.preventDefault();
      document.getElementById('note-error').style.display = 'block';
      document.getElementById('note-error').scrollIntoView({ behavior: 'smooth', block: 'center' });
      return false;
    }
  });
</script>
@endsection