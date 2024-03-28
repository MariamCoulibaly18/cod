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
/* 
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

    /* #project {
      float: left;
      padding-left: 14px;
    }

    #project span {
      color: #5D6975;
      text-align: right;
      width: 52px;
      margin-right: 10px;
      display: inline-block;
      font-size: 0.71em;
    } */
    #project {
      display: flex;
      justify-content: space-between;
      align-items: flex-start; /* Vous pouvez ajuster ceci selon vos besoins */
      padding-left: 14px;
    }

    #project div {
      display: flex;
      align-items: center;
      margin-bottom: 2px; /* Ajustez ceci selon vos besoins */
    }

    #project span {
      color: #5D6975;
      text-align: right;
      width: 52px;
      margin-right: 10px;
      font-size: 0.71em;
    }

    #company {
      float: right;
      text-align: right;
      padding-right: 14px;
    }
    #notices div {
      padding-left: 14px;
      color: black;
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
      padding-left: 14px;
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
    <img src="{{ public_path('images/stores/' . $data['icon']) }}" style="width: 100px; height: 100px;">
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
    {{-- @isset($data['order_id'])
    <div><span>COMMANDE</span> {{ $data['order_id'] }}</div>
    @endisset --}}
    <div>
      <span>CLIENT</span>
      {{ $data['client'] }}
    </div>
    <div>
      <span>ADDRESSE</span>
      {{ $data['adresse']}}, {{ $data['pays'] }}
    </div>
    <div>
      <span>TELEPHONE</span> 
      {{ $data['telephone'] }}
    </div>
    <div><span>EMAIL</span> <a href="mailto:john@example.com">{{ $data['email'] }}</a></div>
    <div><span> DATE</span>{{ $data['date'] }}</div>
    <div><span>STATUS</span>
      @isset($data['payment_status'])
        @if($data['payment_status'] == 'paye')
        <a class = "badge badge-success">{{ $data['payment_status'] }}</a>
        @else
        <a class = "badge badge-warning">{{ $data['payment_status'] }}</a>
        @endif
      @endisset
    </div>
    <div>
      <span>DUE</span> @isset($data['due']) {{ $data['due'] }} DHS @endisset
    </div>
  </div>
</header>
<main>
  <table>
    <thead>
      <tr>
        <th class="service">SKU</th>
        <th class="desc">NOM</th>
        <th>PRIX</th>
        <th>QTY</th>
        <th>TOTAL</th>
      </tr>
    </thead>
    <tbody>
      @php
        $subtotal = 0;
      @endphp
      @foreach ($data['line_items'] as $item)
        <tr>
            <td class="service">{{ $item['sku'] }}</td>
            <td class="desc">{{ $item['name'] }}</td>
            <td>{{ $item['price'] }} DHS</td>
            <td>{{ $item['quantity'] }}</td>
            <td>{{ $item['price'] * $item['quantity'] }} DHS</td>
            @php
                $subtotal += $item['price'] * $item['quantity'];
            @endphp
        </tr>
    @endforeach 
      <tr>
        <td colspan="4">SOUS-TOTAL</td>
        <td class="total">{{ $subtotal }} DHS</td>
      </tr>
      <tr>
        <td colspan="4">Total des frais d'expédition</td>
        <td class="total">{{ $data['shipping_total'] }} DHS</td>
      </tr>
      <tr>
        <td colspan="4" class="grand total">GRAND TOTAL</td>
        <td class="grand total">{{ $data['total']}} DHS</td>
      </tr>
    </tbody>
  </table>
  <div id="notices">
    <div class="notice">REMARQUE:</div>
    <div class="notice">Des frais financiers de 1,5 % seront prélevés sur les soldes impayés après 30 jours.</div>
  </div>
</main>
<footer>
    La facture a été créée sur ordinateur et est valable sans la signature et le sceau.</footer>
</body>
</html>