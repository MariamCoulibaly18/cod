<?php

namespace App\Events;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Event; 

class LivreurCommandeStatusUpdated
{
    use Dispatchable, SerializesModels;

    public $livreurCommande;
    public $boutique;

    public function __construct($livreurCommande,$boutique)
    {
        $this->livreurCommande = $livreurCommande;
        $this->boutique = $boutique;
    }
}