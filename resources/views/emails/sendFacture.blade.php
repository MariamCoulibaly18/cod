<!DOCTYPE html>
<html>
<head>
    <title>Facture de votre commande</title>
</head>
<body>
    <h1>Bonjour !</h1>

    <p>Nous vous remercions d'avoir effectué une commande dans notre boutique.</p>

    <p>Voici la facture de votre commande :</p>

    <p>Entreprise : {{ $company }}</p>
    <p>Boutique : {{ $store }} </p>
    <p>Date : {{ $order_date }} </p>
    <p>Montant : {{ $total }} MAD</p>-->

    <p>Vous trouverez également la facture en pièce jointe.</p>

    <p>N'hésitez pas à nous contacter si vous avez des questions ou des préoccupations.</p>

    <p>Meilleures salutations,</p>
    <p>Votre équipe {{ $company }} Casablanca </p>
</body>
</html>
