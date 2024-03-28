<?php
namespace App\Providers;
use TCPDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use setasign\Fpdi\Tcpdf\Fpdi;
use App\Mail\BonDeCommandeMail;
use Illuminate\Support\Facades\Mail;


class FacturePdfProvider
{

    // public static function generatePDF($data,$template) { 

    //     // Create a new Dompdf instance 
    //     $dompdf = new Dompdf(); 
    //     $dompdf->getOptions()->setChroot(public_path()); 
    //     // Fetch the HTML content from your Blade view 
    //     $html = view('facture.'.$template, compact('data'))->render(); 
    //     // Load the HTML into Dompdf 
    //     $dompdf->loadHtml($html); 
    //     // Render the HTML as PDF 
    //     $dompdf->render(); 
    //     // Generate a unique filename for the PDF 
    //     $filename = $data['numero_facture'].'.pdf'; 
    //     // Specify the storage path where the PDF will be saved 
    //     $storagePath = 'factures/'; 
    //     // Get the public path to the storage folder 
    //     $publicPath = public_path($storagePath); 
    //     // Check if the storage folder exists, if not, create it 
    //     if (!is_dir($publicPath)) { 
    //         mkdir($publicPath, 0777, true); 
    //     } 
    //     // Save the PDF file to the storage folder 
    //     file_put_contents($publicPath . $filename, $dompdf->output()); 
    // }
    public static function generatePDF($data,$template)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('debugPng', true);
        $options->set('chroot', [base_path('public')]);

        // Create a new instance of Dompdf
        $dompdf = new Dompdf($options);
        // Load the HTML content or template for your PDF
        $html = view('facture.'.$template, compact('data'))->render();
        $dompdf->loadHtml($html);
        // (Optional) Set additional configuration options, if needed
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();
        // Generate a unique filename for the PDF
        $filename = $data['numero_facture'].'.pdf';

        // Specify the storage path where the PDF will be saved
        $storagePath = 'factures/';
        // Get the public path to the storage folder
        $publicPath = public_path($storagePath);

        // Check if the storage folder exists, if not, create it
        if (!is_dir($publicPath)) {
            mkdir($publicPath, 0777, true);
        }

        // Save the PDF file to the storage foldzer
        file_put_contents($publicPath . $filename, $dompdf->output());
    }
    public static function generateBonCommandePDF($data,$template)
    {
        // Create a new instance of Dompdf
        $dompdf = new Dompdf();

        // Load the HTML content or template for your PDF
        $html = view('Bon.'.$template, compact('data'))->render();
        $dompdf->loadHtml($html);

        // (Optional) Set additional configuration options, if needed
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Generate a unique filename for the PDF
        $filename = $data['numero_commande'].'.pdf';

        // Specify the storage path where the PDF will be saved
        $storagePath = 'bon_de_commande/';
        // Get the public path to the storage folder
        $publicPath = public_path($storagePath);

        // Check if the storage folder exists, if not, create it
        if (!is_dir($publicPath)) {
            mkdir($publicPath, 0777, true);
        }
        // Save the PDF file to the storage folder
        $pdfPath = $publicPath . $filename;
        file_put_contents($publicPath . $filename, $dompdf->output());
         // Créez une instance de BonDeCommandeMail avec les données et le chemin du PDF
        // $email = new BonDeCommandeMail($data, $pdfPath);
        // // Envoyez l'e-mail en utilisant l'instance
        // Mail::send($email);
    }
    //download pdf
    public static function downloadFactureIndirect($data,$template)
    {
        // Create a new instance of Dompdf
        $dompdf = new Dompdf();

        // Load the HTML content or template for your PDF
        $html = view('facture.'.$template, compact('data'))->render();
        $dompdf->loadHtml($html);

        // (Optional) Set additional configuration options, if needed
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Generate a unique filename for the PDF
        $filename = $data['numero_facture'].'.pdf';

        // Output the generated PDF to Browser (force download)
        $dompdf->stream($filename, [
            'Attachment' => true
        ]);
    }
    public static function downloadBonCommande($pdf_file){
        // Create a new instance of FPDI
        $pdf = new Fpdi();  
    
        // Set the source file
        $pdf->setSourceFile($pdf_file);
        // dd($pdf);
        // Import the first page of the file
        $tplId = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($tplId);
    
        // Create a page (landscape or portrait depending on the imported page size)
        if ($size['width'] > $size['height']) {
            $pdf->AddPage('L', array($size['width'], $size['height']));
        } else {
            $pdf->AddPage('P', array($size['width'], $size['height']));
        }
    
        // Use the imported page as the template
        $pdf->useTemplate($tplId);
    
        // Set the correct content type header
        header('Content-Type: application/pdf');
    
        // Output the PDF for download
        $pdf->Output('bon_de_commande.pdf', 'D');
    
        exit; // Terminate the script to prevent any additional output
    }
    
    public static function ModifyFactureDirect($pdf_file, $payment_status,$due){

        // Create a new instance of FPDI
        $pdf = new Fpdi();  
        // Set the source file
        $pdf->setSourceFile($pdf_file);
        // Import the first page of the file
        $tplId = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($tplId);
        // Create a page (landscape or portrait depending on the imported page size)
        if ($size['width'] > $size['height']) {
            $pdf->AddPage('L', array($size['width'], $size['height']));
        } else {
            $pdf->AddPage('P', array($size['width'], $size['height']));
        }
        // Use the imported page as the template
        $pdf->useTemplate($tplId);

        //ajouter html pour 'payement status'
        /*$html = '
        <div style="white-space: nowrap;"><span style="color: #5D6975;width: 52px;display: inline-block;font-family: Arial, sans-serif;font-size: 0.6em;">STATUS</span> ' . ($payment_status == 'paye' ? '<a style="display: inline-block;padding: 0.25em 0.4em;font-size: 75%;font-weight: 700;line-height: 1;text-align: center;white-space: nowrap; vertical-align: baseline;border-radius: 0.25rem;color: #ffffff;background-color: #28a745;">' . $payment_status . '</a>' : '<a style="display: inline-block;padding: 0.25em 0.4em;font-size: 75%;font-weight: 700;line-height: 1;text-align: center;white-space: nowrap; vertical-align: baseline;border-radius: 0.50rem;color: #ffffff;background-color: #ffc107;">' . $payment_status . '</a>') . '</div>
        ';*/
        $pdf->SetXY(15.5, 91); // Set the position for the HTML content
        $html = '<span style="display: inline-block; font-size: 0.7em; font-weight: bold;border:5px solid black; background-color: ' . ($payment_status == 'paye' ? '#28a745' : '#ffc107') . '; color: #333;">' . $payment_status . '</span>';
        $pdf->writeHTML($html, true, false, true, false, '');
        //due
        $pdf->SetXY(10.5, 96.7); // Set the position for the HTML content
        $html = '<span style="font-family: Arial, sans-serif;font-size: 0.7em;"> '. $due . '  DHS</span>';
        $pdf->writeHTML($html, true, false, true, false, '');
        
        return $pdf;
    }

    // Download PDF using FPDI (facture directe)
    public static function downloadFactureDirect($pdf_file, $payment_status,$due)
    {
        $pdf = FacturePdfProvider::ModifyFactureDirect($pdf_file, $payment_status,$due);
        // Output the generated PDF to Browser (force download)
        $pdf->Output($pdf_file, 'D');
    }


    //get Facture direct pdf content to attach with an email
    public static function getFactureDirect($pdf_file, $payment_status,$due)
    {
        $pdf = FacturePdfProvider::ModifyFactureDirect($pdf_file, $payment_status,$due);
        $pdf_content = $pdf->Output($pdf_file, 'S');
        return $pdf_content;
        
    }

}