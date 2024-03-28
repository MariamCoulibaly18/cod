<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendFactureMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;
    public $toClient;
    public $factureData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($toClient,$pdf,$factureData)
    {
        //
        $this->pdf = $pdf;
        $this->toClient = $toClient;
        $this->factureData = $factureData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdfName = 'Facture-'.$this->factureData['store'].'-'.$this->factureData['order_date'].'.pdf';
        return $this->from('fstage.media@gmail.com','Yassine')
                ->view('emails.sendFacture',['company' => $this->factureData['company'],'store' => $this->factureData['store'],'order_date' => $this->factureData['order_date'],'total' => $this->factureData['total']])
                ->subject('Facture de votre commande en boutique '.$this->factureData['store'])
                ->to($this->toClient)
                ->attachData($this->pdf,$pdfName, [
                    'mime' => 'application/pdf',
                ]);

    }
}
