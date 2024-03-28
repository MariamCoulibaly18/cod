<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Bon de commande</title>
  {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css"> --}}
  <link rel="stylesheet" href="/css/app.css" type="text/css">
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

    /* #logo {
      text-align: center;
      margin-bottom: 10px;
    }

    #logo img {
      width: 90px;
    } */

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
      padding: left;
    }

    #company {
      float: right;
      text-align: right;
      padding: right;
    }

    #project div{
      white-space: nowrap;
      padding-left: 10px;
    }
    #company div {
      white-space: nowrap;
      padding-right: 10px;
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
      padding-left: 5px;
    }
    #notices .remarque {
      color: black;
      padding-left: 5px;
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

  <!-- {{-- <div id="logo">
    <img src="images/stores/{{ $data['icon'] }}">
    <h2>{{ $data['store'] }}</h2>
  </div> --}} -->
  <h1>Bon de Commande  {{ $data['numero_commande']}}</h1>
  <div id="company" class="clearfix">
    <div>GTEL</div>
    <div>Boulevard Emile Zola,<br /> 20082, Casablanca</div>
    <div>+212-522-507-014</div>
    <div><a href="mailto:company@example.com">contact@gtel-dev.com</a></div>
  </div>
  <div id="project">
    @isset($data['order_id'])
    <div><span>COMMANDE</span> {{ $data['commande']->id }}</div>
    @endisset
    <div><span>CLIENT</span>{{ $data['client']->prenom }} {{ $data['client']->nom }}</div>
    <div><span>ADDRESSE</span> {{ $data['client']->adresse}}, {{ $data['client']->pays }}</div>
    <div><span>TELEPHONE</span> {{ $data['client']->telephone }}</div>
    <div><span>EMAIL</span> <a href="mailto:john@example.com">{{ $data['client']->email }}</a></div>
    <div><span> DATE</span>{{ $data['date'] }}</div>
    <div><span>STATUS</span>
      @isset($data['commande']->status)
        @if($data['commande']->status == 'completed')
        <a class = "badge badge-success">{{ $data['commande']->status}}</a>
        @elseif($data['commande']->status == 'canceled')
        <a class = "badge badge-danger">{{ $data['commande']->status }}</a>
        @else
        <a class = "badge badge-warning">{{ $data['commande']->status }}</a>
        @endif
      @endisset
    </div>

  </div>
</header>
<main>
  <table >
    <thead>
      <tr>
        <th class="desc">Produit</th>
        <th class="service">Reference</th>
        <th>Quantité</th>
        <th>Prix</th>
        <th>TOTAL</th>
      </tr>
    </thead>
    <tbody>
      @php
        $subtotal = 0;
      @endphp
      @foreach ($data['commandeProduit'] as $commandeProduit)
        <tr>
          <td class="desc">{{ $commandeProduit->produit->nom }}</td>
          <td class="service">{{  $commandeProduit->produit->sku  }}</td>
          <td>{{  $commandeProduit['quantite']}}</td>
          <td>{{ $commandeProduit['prix']  }} DHS</td>
          <td>{{ $commandeProduit['prix'] *  $commandeProduit['quantite']}} DHS</td>
          @php
            $subtotal += $commandeProduit['prix'] *  $commandeProduit['quantite'];
          @endphp
        </tr>
      @endforeach 
      <tr>
        <td colspan="4">SOUS-TOTAL</td>
        <td class="total">{{ $subtotal }} DHS</td>
      </tr>
      {{-- <tr>
        <td colspan="4">Total des frais d'expédition</td>
        <td class="total">{{ $data['shipping_total'] }} DHS</td>
      </tr> --}}
      <tr>
        <td colspan="4" class="grand total">GRAND TOTAL</td>
        <td class="grand total">{{ $data['total']}} DHS</td>
      </tr>
    </tbody>
  </table>
  <div id="notices">
    <div class="remarque">REMARQUE:</div>
    <div class="notice">Des frais financiers de 1,5 % seront prélevés sur les soldes impayés après 30 jours.</div>
  </div>
</main>
<footer>
    La commande a été créée sur ordinateur et est valable sans la signature et le sceau.</footer>
</body>
</html>