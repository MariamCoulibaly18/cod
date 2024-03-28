<!doctype html>
<html>
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
                  <h2 class="mb-3 fs-7 fw-bolder">Bienvenue sur l'Api Gateway</h2>
                  <div class="position-relative text-center my-4">
                    <span ></span>
                  </div>
                  <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                      <label for="name"  class="form-label">Nom</label>
                      <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Entrez votre nom"  value="{{ old('name') }}" required autocomplete="name" autofocus
                      type="text"  aria-describedby="textHelp">
                      @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
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
                    <div class="mb-4">
                      <label  for="password-confirm"  class="Sorm-label">Confirmer le mot de passe</label>
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" 
                      placeholder="Confirmer le mot de passe" required autocomplete="new-password">
                      @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2" style="background: #01357F; color: white;">
                      {{ __("S'inscrire") }}
                    </button>
                    <div class="d-flex align-items-center">
                      <p class="fs-4 mb-0 text-dark">Vous avez déjà un compte ?</p> 
                      <a class="fw-medium ms-2" href="/login" style="color: #074eb3;">Se connecter</a>
                    </div> 
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
    </script>  

  </body>

</html>
