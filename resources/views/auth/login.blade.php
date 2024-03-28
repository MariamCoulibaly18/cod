<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/png" href="/images/icon.png">
  <!-- Core Css -->
  <link rel="stylesheet" href="/assets/css/styles.css" />
  <title>GTEL|COD</title>
</head>
<body data-sidebartype="full" cz-shortcut-listen="true">
  <div id="main-wrapper">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
      <div class="position-relative z-index-5">
        <div class="" style="display:flex; flex-direction:row; align-items:center; justify-content:space-between;">
          <div class="" style="width: 60% !important;">
            <a class="text-nowrap logo-img d-block px-4 w-100">
                <!-- <img src="{{ asset('images/logicom.png') }}" alt="" width="150"> -->
                <img src="{{ asset('images/icon.png') }}" alt="GTEL Logo" class="brand-image img-circle elevation-3" style="opacity: .8;width:100px;height:50px">
                <span class="brand-text font-weight-light" style="color:black">GTEL COD</span>
            <a>
            <div class="d-none d-xl-flex align-items-center justify-content-center" style="height: calc(100vh - 80px);">
                <img src="/assets/images/backgrounds/login-security.svg" alt class="img-fluid" width="500">
            </div>
          </div>
          <div class="" style="width: 40% !important;">
            <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-start p-4">
              <div class="col-sm-8 col-md-6 col-xl-9">
                <h2 class="mb-3 fs-7 fw-bolder">Bienvenue sur GTEL COD</h2>
                <div class="position-relative text-center my-4">
                  <span ></span>
                </div>
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" 
                    placeholder="Entrez votre adresse email"  required autocomplete="email" aria-describedby="emailHelp">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label  for="password" class="Sorm-label">Mot de passe</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                    placeholder="Entrez votre mot de passe"  required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input primary" type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }}> 
                        <label class="form-check-label text-dark" for="flexCheckChecked">Se souvenir de moi </label>
                    </div>
                    @if (Route::has('password.request'))
                    <a class="btn btn-link fw-medium" href="{{ route('password.request') }}" style="color: #074eb3;">
                        {{ __('Mot de passe oublié?') }}
                    </a>
                    @endif
                  </div>
                  <button type="submit" class="btn btn  w-100 py-8 mb-4 rounded-2" style="background: #01357F; color: white;">
                    {{ __('Se connecter') }}
                  </button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-medium">Nouveau sur l'api gateway?</p>
                    <a class=" fw-medium ms-2" href="/register" style="color: #074eb3;">Créer un compte</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<script>
  //la première chose à faire est d'effacer le stockage local
  localStorage.removeItem('currentBoutique');
  localStorage.removeItem('currentSocieteTransport');
</script>
</html>
 <!-- <div class="field field-checkbox padding-bottom--24 flex-flex align-center">
                  <label >
                    <input type="checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Se souvenir de moi
                  </label>
                </div> -->