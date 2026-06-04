<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon profil — OrientaBac</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif; background: #F8FAFB; color: #1f2937; }

        .page-wrapper { min-height: 100vh; padding: 50px 20px 80px; background: linear-gradient(to bottom, #F8FAFB 0%, #EEF2F5 100%); }
        .container { width: 100%; max-width: 820px; margin: 0 auto; background: white; border-radius: 24px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); overflow: hidden; }

        /* HERO SECTION */
        .hero { background: linear-gradient(135deg, #1E3A5F 0%, #2d5f8a 70%, #1E3A5F 100%); color: white; padding: 50px 48px; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; top: -40%; right: -40%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); border-radius: 50%; }
        .hero-content { position: relative; z-index: 1; }
        .hero h1 { font-size: 32px; font-weight: 700; margin-bottom: 12px; letter-spacing: -0.5px; }
        .hero p { font-size: 15px; color: rgba(255,255,255,0.85); line-height: 1.7; max-width: 500px; }

        /* CONTENT SECTION */
        .content { padding: 48px 48px 50px; }

        /* ALERTS */
        .alert { padding: 16px 20px; border-radius: 14px; font-size: 14px; margin-bottom: 28px; display: flex; align-items: flex-start; gap: 12px; }
        .alert-success { background: linear-gradient(135deg, rgba(0,135,81,0.08) 0%, rgba(0,135,81,0.04) 100%); border: 1px solid rgba(0,135,81,0.2); color: #065f46; }
        .alert-error { background: linear-gradient(135deg, rgba(232,17,45,0.08) 0%, rgba(232,17,45,0.04) 100%); border: 1px solid rgba(232,17,45,0.2); color: #7f1d1d; }

        /* FORM SECTIONS */
        .form-sections { display: grid; gap: 44px; }
        .section-title { font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .section-icon { font-size: 20px; }

        /* PHOTO SECTION */
        .photo-section { background: linear-gradient(135deg, #F0F7FF 0%, #F9F0FF 100%); padding: 32px 28px; border-radius: 18px; border: 1px solid rgba(0,135,81,0.12); }
        .photo-upload-box { display: flex; align-items: center; gap: 28px; }
        .photo-preview-wrapper { position: relative; flex-shrink: 0; }
        .photo-avatar { width: 120px; height: 120px; border-radius: 20px; background: linear-gradient(135deg, #008751 0%, #006b40 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; font-weight: 700; box-shadow: 0 10px 30px rgba(0,135,81,0.2); border: 3px solid white; }
        .photo-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 17px; }
        .photo-upload-badge { position: absolute; bottom: -8px; right: -8px; background: white; border: 2px solid #008751; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 20px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s ease; }
        .photo-upload-badge:hover { transform: scale(1.1); }
        .photo-info { flex: 1; }
        .photo-info h3 { font-size: 15px; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
        .photo-info p { font-size: 14px; color: #64748b; line-height: 1.6; margin-bottom: 14px; }
        .photo-input-wrapper { position: relative; display: inline-block; }
        .photo-input-wrapper input { display: none; }
        .photo-input-label { display: inline-block; padding: 11px 24px; background: #008751; color: white; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; }
        .photo-input-label:hover { background: #006b40; transform: translateY(-2px); box-shadow: 0 8px 16px rgba(0,135,81,0.3); }

        /* INFO FIELDS SECTION */
        .info-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; }

        /* FORM GROUPS */
        .field-group { display: grid; gap: 8px; }
        .field-group label { font-size: 14px; font-weight: 700; color: #374151; display: flex; align-items: center; gap: 6px; }
        .field-group input { width: 100%; padding: 13px 16px; border: 1.5px solid #e5e7eb; border-radius: 12px; font-size: 14px; color: #1f2937; background: #fafbfc; transition: all 0.3s ease; font-family: inherit; }
        .field-group input:focus { outline: none; border-color: #008751; background: white; box-shadow: 0 0 0 3px rgba(0,135,81,0.1); }
        .field-group input::placeholder { color: #9ca3af; }
        .field-group input[readonly] { background: #f3f4f6; color: #6b7280; cursor: not-allowed; }
        .field-group small { font-size: 12px; color: #6b7280; font-weight: 400; }

        /* PASSWORD SECTION */
        .password-section { background: linear-gradient(135deg, #FFF7ED 0%, #FEF3F2 100%); padding: 32px 28px; border-radius: 18px; border: 1px solid rgba(232,17,45,0.12); }
        .password-fields { display: grid; gap: 22px; }

        /* FORM ACTIONS */
        .form-actions { display: flex; align-items: center; gap: 16px; margin-top: 44px; padding-top: 32px; border-top: 1px solid #e5e7eb; }
        .btn { padding: 14px 32px; border: none; border-radius: 12px; font-size: 15px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; }
        .btn-submit { background: linear-gradient(135deg, #008751 0%, #006b40 100%); color: white; flex: 0; box-shadow: 0 8px 20px rgba(0,135,81,0.25); }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(0,135,81,0.35); }
        .btn-submit:active { transform: translateY(0); }

        .back-link { color: #64748b; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease; margin-top: 28px; }
        .back-link:hover { color: #008751; }

        /* SINGLE COLUMN ON MOBILE */
        @media (max-width: 768px) {
            .hero { padding: 40px 32px; }
            .hero h1 { font-size: 26px; }
            .content { padding: 32px 24px; }
            .info-fields { grid-template-columns: 1fr; }
            .photo-upload-box { flex-direction: column; text-align: center; }
            .photo-section { padding: 24px 20px; }
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <div class="container">
            <div class="hero">
                <div class="hero-content">
                    <h1>Modifier mon profil</h1>
                    <p>Mettez à jour vos informations personnelles, votre photo de profil et changez votre mot de passe en toute sécurité.</p>
                </div>
            </div>
            <div class="content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <span></span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-error">
                        <span></span>
                        <div>
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-sections">

                        <!-- PHOTO SECTION -->
                        <div class="photo-section">
                            <div class="section-title">
                                <span class="section-icon"></span>
                                Photo de profil
                            </div>
                            <div class="photo-upload-box">
                                <div class="photo-preview-wrapper">
                                    <div class="photo-avatar">
                                        @if($user->photo)
                                            <img src="{{ asset($user->photo) }}" alt="Photo de profil">
                                        @else
                                            {{ strtoupper(substr($user->prenom, 0, 1) . substr($user->nom, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="photo-upload-badge" onclick="document.getElementById('photoInput').click()" title="Cliquer pour modifier">
                                        Modifier
                                    </div>
                                </div>
                                <div class="photo-info">
                                    <h3>Modifiez votre photo</h3>
                                    <p>Choisissez une image JPG ou PNG (max 2 MB) pour personnaliser votre profil.</p>
                                    <div class="photo-input-wrapper">
                                        <input type="file" id="photoInput" name="photo" accept="image/*">
                                        <label for="photoInput" class="photo-input-label">Sélectionner une photo</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- INFO FIELDS SECTION -->
                        <div>
                            <div class="section-title">
                                <span class="section-icon">Profil</span>
                                Informations personnelles
                            </div>
                            <div class="info-fields">
                                <div class="field-group">
                                    <label>Nom</label>
                                    <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" placeholder="Votre nom de famille" required>
                                </div>
                                <div class="field-group">
                                    <label>Prénom</label>
                                    <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" placeholder="Votre prénom" required>
                                </div>
                            </div>
                            <div class="field-group" style="margin-top: 22px;">
                                <label>Adresse email</label>
                                <input type="email" value="{{ $user->email }}" readonly title="Votre adresse email (non modifiable)">
                            </div>
                        </div>

                        <!-- PASSWORD SECTION -->
                        <div class="password-section">
                            <div class="section-title">
                                <span class="section-icon"></span>
                                Sécurité
                            </div>
                            <div class="password-fields">
                                <div class="field-group">
                                    <label>
                                        Nouveau mot de passe
                                        <small>(laisser vide pour conserver le mot de passe actuel)</small>
                                    </label>
                                    <input type="password" name="password" placeholder="••••••••">
                                </div>
                                <div class="field-group">
                                    <label>Confirmation du mot de passe</label>
                                    <input type="password" name="password_confirmation" placeholder="••••••••">
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- ACTIONS -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-submit">Enregistrer les modifications</button>
                    </div>
                </form>

                <a href="{{ route('profil') }}" class="back-link">← Retour à mon tableau de bord</a>
            </div>
        </div>
    </div>

    <script>
      // Preview photo upload
      document.getElementById('photoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(event) {
            const avatar = document.querySelector('.photo-avatar');
            avatar.innerHTML = `<img src="${event.target.result}" alt="Photo de profil">`;
          };
          reader.readAsDataURL(file);
        }
      });
    </script>
</body>
</html>
