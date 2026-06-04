@extends('layouts.app')

@section('title', $title)

@section('styles')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background-color: #F4F6F9; color: #333; }
    .auth-wrapper { min-height: calc(100vh - 78px); display: flex; align-items: center; justify-content: center; padding: 50px 20px; background: linear-gradient(135deg, #1E3A5F 0%, #2d5f8a 60%, #F4F6F9 100%); }
    .auth-box { background: white; border-radius: 16px; box-shadow: 0 8px 30px rgba(0,0,0,0.15); width: 100%; max-width: 480px; overflow: hidden; }
    .auth-top-band { height: 6px; position: relative; overflow: hidden; }
    .auth-top-band::before { content: ''; position: absolute; left: 0; top: 0; width: 33%; height: 100%; background-color: #008751; }
    .auth-top-band::after { content: ''; position: absolute; left: 33%; top: 0; width: 67%; height: 50%; background-color: #FCD116; box-shadow: 0 3px 0 0 #E8112D; }
    .auth-header { padding: 30px 35px 20px; text-align: center; }
    .auth-logo { font-size: 28px; font-weight: bold; color: #1E3A5F; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 8px; }
    .auth-logo span { color: #FCD116; }
    .auth-header p { font-size: 14px; color: #777; }
    .auth-form { padding: 25px 35px 35px; }
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 6px; }
    .form-group input { width: 100%; padding: 12px 14px; border: 1.5px solid #ddd; border-radius: 8px; font-size: 14px; color: #333; transition: border-color 0.2s; outline: none; background-color: #fafafa; }
    .form-group input:focus { border-color: #008751; background-color: white; }
    .btn-submit { width: 100%; padding: 13px; background-color: #008751; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; margin-top: 8px; }
    .btn-submit:hover { background-color: #006b40; }
    .form-footer { text-align: center; margin-top: 18px; font-size: 13px; color: #777; }
    .form-footer a { color: #008751; font-weight: bold; text-decoration: none; }
    .alert-error { background-color: rgba(232,17,45,0.1); border: 1px solid #E8112D; color: #E8112D; padding: 12px 18px; border-radius: 8px; margin-bottom: 18px; font-size: 13px; }
    .alert-success { background-color: rgba(0,135,81,0.1); border: 1px solid #008751; color: #008751; padding: 12px 18px; border-radius: 8px; margin-bottom: 18px; font-size: 13px; }
</style>
@endsection

@section('content')
<div class="auth-wrapper">
  <div class="auth-box">
    <div class="auth-top-band"></div>
    <div class="auth-header">
      <div class="auth-logo">Orienta<span>Bac</span></div>
      <p>{{ $description }}</p>
    </div>
    <div class="auth-form">
      @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
      @endif
      @if($errors->any())
        <div class="alert-error">
          @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif
      <form method="POST" action="{{ route($submitRoute) }}">
        @csrf
        <div class="form-group">
          <label>Adresse email</label>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="exemple@domaine.bj" required />
        </div>
        <button type="submit" class="btn-submit">Envoyer</button>
      </form>
      <div class="form-footer">
        <a href="{{ route($backRoute) }}">← Retour à la connexion</a>
      </div>
    </div>
  </div>
</div>
@endsection
