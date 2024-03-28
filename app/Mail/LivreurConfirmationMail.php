<?php

namespace App\Mail;

use App\Models\Boutique;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LivreurConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $responsableEmail;
    public $LivreurData;
    /**
     * Create a new message instance.
     *
     * @param int $commande_id
     * @param int $accepted
     * @param int $boutique_id
     * @return void
     */
    public function __construct($responsableEmail, $LivreurData)
    {
        $this->responsableEmail = $responsableEmail;
        $this->LivreurData = $LivreurData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
            return $this->from('fstage.media@gmail.com', 'Yassine')
                ->to($this->responsableEmail)
                ->subject($this->LivreurData['subject'])
                ->markdown('emails.livreur_confirmation', [
                    'company' => $this->LivreurData['company'],
                    'accepted' => $this->LivreurData['accepted'],
                    'boutique' => $this->LivreurData['boutique'],
                    'user' => $this->LivreurData['user'],
                    'commande_id' => $this->LivreurData['commande_id']
    ]);

           
    }
}
