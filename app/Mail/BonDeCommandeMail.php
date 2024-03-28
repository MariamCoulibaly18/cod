<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BonDeCommandeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $pdfPath;

    public function __construct($data, $pdfPath)
    {
        $this->data = $data;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        // dd($this->data['client']->email);
        return $this->from('fstage.media@gmail.com', 'Yassine')
            ->to($this->data['client']->email)
            ->subject('Bon de commande')
            ->view('emails.bon_commande') 
            ->attach($this->pdfPath);
    }
}

// namespace App\Mail;

// use Illuminate\Bus\Queueable;
// use Illuminate\Mail\Mailable;
// use Illuminate\Queue\SerializesModels;

// class BonDeCommandeMail extends Mailable
// {
//     use Queueable, SerializesModels;

//     public $data;
//     public $pdfPath;

  
//     public function __construct($data, $pdfPath)
//     {
//         $this->data = $data;
//         $this->data = $pdfPath;
//     }

//     /**
//      * Build the message.
//      *
//      * @return $this
//      */
//     public function build()
//     {
//             return $this->from('fstage.media@gmail.com', 'Yassine')
//                 ->to($this->data['client']->email)
//                 ->subject('Bon de commande')
//                 ->attach($this->pdfPath);
//     }
// }
