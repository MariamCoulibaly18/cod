<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Example 1</title>
  <link rel="stylesheet" href="css/app.css" type = "text/css">
  <style type="text/css">
    .clearfix:after {
      content: "";
      display: table;
      clear: both;
    }

    a {
      color: #5D6975;
      text-decoration: underline;
    }

    body {
      position: relative;
      width: 21cm;
      height: 29.7cm;
      margin: 0 auto;
      color: #001028;
      background: #FFFFFF;
      font-family: Arial, sans-serif;
      font-size: 12px;
    }

    header {
      padding: 10px 0;
      margin-bottom: 30px;
    }

    #logo {
      text-align: center;
      margin-bottom: 10px;
    }

    #logo img {
      width: 90px;
    }

    h1 {
      border-top: 1px solid #5D6975;
      border-bottom: 1px solid #5D6975;
      color: #5D6975;
      font-size: 2.4em;
      line-height: 1.4em;
      font-weight: normal;
      text-align: center;
      margin: 0 0 20px 0;
      background: url(images\dimension.png);
    }

    #project {
      float: left;
    }

    #project span {
      color: #5D6975;
      text-align: right;
      width: 52px;
      margin-right: 10px;
      display: inline-block;
      font-size: 0.71em;
    }

    #company {
      float: right;
      text-align: right;
    }

    #project div,
    #company div {
      white-space: nowrap;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-spacing: 0;
      margin-bottom: 20px;
    }

    table tr:nth-child(2n-1) td {
      background: #F5F5F5;
    }

    table th,
    table td {
      text-align: center;
    }

    table th {
      padding: 5px 20px;
      color: #5D6975;
      border-bottom: 1px solid #C1CED9;
      white-space: nowrap;
      font-weight: normal;
    }

    table .service,
    table .desc {
      text-align: left;
    }

    table td {
      padding: 20px;
      text-align: right;
    }

    table td.service,
    table td.desc {
      vertical-align: top;
    }

    table td.unit,
    table td.qty,
    table td.total {
      font-size: 1.2em;
    }

    table td.grand {
      border-top: 1px solid #5D6975;;
    }

    #notices .notice {
      color: #5D6975;
      font-size: 1.2em;
    }

    footer {
      color: #5D6975;
      width: 100%;
      height: 30px;
      position: absolute;
      bottom: 0;
      border-top: 1px solid #C1CED9;
      padding: 8px 0;
      text-align: center;
    }

    @page {
      size: 200 mm 200mm;
      margin: 0;
      margin-top:20px;
    }
  </style>
</head>
<body>
<header class="clearfix">

  <div id="logo">
    <img src="images/stores/{{ $data['icon'] }}">
    <h2>{{ $data['store'] }}</h2>
  </div>
  <h1>FACTURE {{ $data['numero_facture'] }}</h1>
  <div id="company" class="clearfix">
    <div>GTEL</div>
    <div>Boulevard Emile Zola,<br /> 20082, Casablanca</div>
    <div>+212-522-507-014</div>
    <div><a href="mailto:company@example.com">contact@gtel-dev.com</a></div>
  </div>
  <div id="project">
    <div><span>TRANSACTION</span> {{ $data['transaction_id'] }}</div>
    <div>
        <span>FOURNISSEUR</span>
        {{ $data['fournisseur'] }}
        @if($data['type'] =='Agreer')
            <a class = "badge badge-success">{{ $data['type'] }}</a>
        @else
            <a class = "badge badge-danger">{{ $data['type'] }}</a>
        @endif
    </div>
    <div><span>ADDRESSE</span> {{ $data['adresse']}}</div>
    <div><span>TELEPHONE</span> {{ $data['telephone'] }}</div>
    <div><span> DATE</span>{{ $data['date'] }}</div>
    <div><span>STATUS</span>
        @if($data['payment_status'] == 'paye')
        <a class = "badge badge-success">{{ $data['payment_status'] }}</a>
        @else
        <a class = "badge badge-warning">{{ $data['payment_status'] }}</a>
        @endif
    </div>
  </div>
</header>
<main>
  <table>
    <thead>
      <tr>
        <th class="service">NOM</th>
        <th class="desc">MARQUE</th>
        <th>PRIX</th>
        <th>QTY</th>
        <th>TOTAL</th>
      </tr>
    </thead>
    <tbody>
        <tr>
            <td class="service">{{ $data['product_name'] }}</td>
            <td class="desc">{{ $data['marque_name'] }}</td>
            <td>{{ $data['product_price'] }} DHS</td>
            <td>{{ $data['product_quantity'] }}</td>
            <td>{{ $data['product_price'] * $data['product_quantity'] }} DHS</td>
        </tr>
        <tr>
            <td colspan="4" class="grand total">GRAND TOTAL</td>
            <td class="grand total">{{ $data['total']}} DHS</td>
        </tr>
        <tr>
            <td colspan="4" class="grand total"> DUE</td>
            <td class="grand total">{{ $data['due']}} DHS</td>
        </tr>
    </tbody>
  </table>
  <div id="notices">
    <div>REMARQUE:</div>
    <div class="notice">Des frais financiers de 1,5 % seront prélevés sur les soldes impayés après 30 jours.</div>
  </div>
</main>
<footer>
    La facture a été créée sur ordinateur et est valable sans la signature et le sceau.</footer>
</body>
</html>

{{-- <!-- Facture -->
<div class="row">
    <!-- Entreprise et boutique name et logo -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">Entreprise</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-4">GTEL</h5>
                        <p>Adresse: 123 Rue de l'Entreprise</p>
                        <p>Téléphone: 0606060606</p>
                        <p>Email: GTEL@gmail.com</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <!-- store name -->
                        <h5 class="mb-4">{{ $data['store'] }}</h5>
                        <!-- store logo -->
                        <img src="{{ asset('images/stores/'.$data['icon']) }}" alt="logo" width="100px" height="100px">
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">Facture</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-4">Facture N° {{ $data['numero_facture'] }}</h5>
                        <p>Fournisseur : {{ $data['fournisseur']}}</p>
                        <p>Type : {{ $data['type'] }}</p>
                        <p>Adresse : {{ $data['adresse'] }}</p>
                        <p>Téléphone : {{ $data['telephone'] }}</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <h5 class="mb-4">Date : {{ $data['date'] }}</h5>
                        <h5>Montant : {{ $data['total'] }}</h5>
                        <h5>Mode de paiement : à domicile</h5>
                        <h5>Statut : {{ $data['payment_status'] }}</h5>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h5 class="mb-4">Marque name : {{ $data['marque_name'] }}</h5>
                        <img src="{{ $data['marque_logo'] }}" alt="logo" width="100px" height="100px">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire</th>
                                    <th>Prix total</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>{{ $data['product_name'] }}</td>
                                        <td>{{ $data['product_quantity'] }}</td>
                                        <td>{{ $data['product_price'] }}</td>
                                        <td>{{ $data['product_price'] * $data['product_quantity'] }}</td>
                                    </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Total</th>
                                    <th>{{ $data['total'] }}</th>
                                </tr>
                                <!--Due-->
                                <tr>
                                    <th colspan="3" class="text-right">Due</th>
                                    <th>{{ $data['due'] }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
