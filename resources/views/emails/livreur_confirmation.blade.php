{{-- resources/views/emails/livreur_confirmation.blade.php --}}

{{-- <!DOCTYPE html>
<html>
<head>
    <title>Confirmation de commande</title>
</head>
<body>
    <p>Bonjour cher {{$user}},</p>

    <p>
        @if ($accepted == 1)
            Le livreur a accepté la commande {{ $commande_id }} de votre boutique {{$boutique}}.
        @elseif ($accepted == -1)
            Le livreur a refusé la commande {{ $commande_id }} de votre boutique {{$boutique}}.
        @endif
    </p>

    <p>Merci de votre coopération.</p>

    <p>Cordialement,</p>
    <p>L'équipe de {{$company}}</p>
</body>
</html> --}}
@component('mail::message')
# Confirmation de livreur pour la boutique {{ $boutique }}

Bonjour {{ $user }},

@if($accepted == 1)
Nous tenons à vous informer que la commande {{ $commande_id }} pour la boutique {{ $boutique }} a été acceptée et sera traitée dans les plus brefs délais.
@elseif($accepted == -1)
Veuillez noter que la commande  {{ $commande_id }} pour la boutique {{ $boutique }} a été refusée. Si vous avez des questions, n'hésitez pas à contacter le livreur.
@endif

Détails de la commande:
- ID de la commande: {{ $commande_id }}
- Boutique: {{ $boutique }}

Pour toute assistance supplémentaire, veuillez nous contacter.

Cordialement,
{{ $company }}
@endcomponent
