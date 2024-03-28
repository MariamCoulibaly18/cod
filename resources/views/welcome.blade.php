<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>E-commerce Admin Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #fff;
            padding: 10px 0;
        }

        .logo h1 {
            font-size: 24px;
            font-weight: bold;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin-right: 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
        }

        .signin a {
            padding: 8px 12px;
            background-color: #333;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
        }

        

        main {
            padding: 40px 0;
            text-align: center;
        }

        .title {
            font-size: 48px;
            font-weight: bold;
            color: #333;
        }

        .description {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            text-align: justify
        }

        .signup-btn {
            padding: 10px 20px;
            background-color: lightcoral;
            color: #fff;
            border-radius: 10px;
            text-decoration: none;
            display: block;
            width: 60%;
        }

        .image {
            width: 100%;
            height: auto;
            height: auto;
            margin-bottom: 20px;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        footer p {
            margin-bottom: 10px;
        }

        footer ul {
            list-style: none;
            display: flex;
            justify-content: center;
        }

        footer ul li {
            margin: 0 10px;
        }

        footer ul li a {
            text-decoration: none;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
              <a class="navbar-brand logo" href="#">GTEL COD</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent" style="justify-content: flex-end;">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Fonctionnalités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">À propos</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <div class="d-flex">
                    @if (Route::has('login'))
                    <div class="signin">
                        <a href="{{ route('login') }}">S'identifier</a>
                    </div>
                    @endif
                </div>
              </div>
            </div>
        </nav>
    </div>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="mt-5 mb-5 title">Cash On Delivery</h1>
                    <p class="description">Lorem ipsum dolor sit amet consecteturimpedit sunt sequi dolorum magnam. Exercitationem architecto ullam debitis, consequuntur, quia harum illum aliquid repudiandae ducimus maiores vero a aut quo vitae facilis placeat doloribus perferendis quisquam magni adipisci. Magnam odio iure vero, ea deleniti deserunt!</p>
                    @if (Route::has('register'))
                    <div class="signup" style="display:flex;justify-content:center">
                        <a href="{{ route('register') }}" class="signup-btn">Commencer</a>
                    </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <img src="https://www.kindpng.com/picc/m/732-7329685_e-commerce-website-background-image-e-commerce-website.png" alt="E-commerce Image" class="hero">
                </div>
            </div>
        </div>
    </main>
    <footer style="margin-top: 20px;position: absolute;bottom: 0;width: 100%;">
        <div class="container" style="display: flex; flex-direction: column; align-items: center;">
            <p>&copy; 2023 GTEL COD. Tous droits réservés.</p>
            <ul>
                <li><a href="#">Politique de confidentialité</a></li>
                <li><a href="#">Conditions d'utilisation</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
