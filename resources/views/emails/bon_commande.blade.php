<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande</title>
</head>
<body>
    <p>Cher {{ $data['client']->prenom }} {{ $data['client']->nom }},</p>

    <p>Nous tenons à vous remercier d'avoir choisi {{ $data['boutique']}} pour votre commande.</p>

    <p>Votre commande a été traitée avec succès.</p>

    <p>Vous trouverez ci-joint votre bon de commande au format PDF.</p>

    <p>Si vous avez des questions ou avez besoin d'assistance supplémentaire, n'hésitez pas à nous contacter. Nous sommes là pour vous aider.</p>

    <p>Merci encore pour votre confiance en notre boutique {{ $data['boutique'] }}.</p>

    <p>Cordialement,</p>
    <p>Votre boutique {{ $data['boutique'] }}</p>
</body>
</html>
