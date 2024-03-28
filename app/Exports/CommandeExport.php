<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class CommandeExport implements FromView, WithEvents,WithColumnWidths
{
    protected $orders;
    protected $store_name;
    protected $store_logo;

    public function __construct($orders, $store_name, $store_logo)
    {
        $this->orders = $orders;
        $this->store_name = $store_name;
        $this->store_logo = $store_logo;
    }

    public function view(): View
    {
        return view('exports.commande', [
            'orders' => $this->orders,
            'store_name' => $this->store_name,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Insert logo
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('This is my logo');
                $drawing->setPath(public_path($this->store_logo));
                $drawing->setHeight(40);
                $drawing->setCoordinates('C1');
                $drawing->setWorksheet($event->sheet->getDelegate());
            },
        ];
    }

    // Set column widths
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,
            'C' => 35,
            'D' => 35,
            'E' => 40,
            'F' => 20,
            'G' => 35,
            'H' => 20,
            'I' => 20,
            'J' => 20,
            'K' => 40,
            'L' => 20,
            'M' => 20,
        ];
    }
}