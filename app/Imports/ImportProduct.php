<?php

namespace App\Imports;

use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportProduct implements ToArray, WithHeadingRow, WithValidation
{
    

    public function Array(array $rows)
    {
        $products = [];

        foreach ($rows as $row) {
            
            
            $validatedData = $this->validateRow($row->toArray());
            //$validatedData = $row->toArray();
            //categories s'ecrit en format "cat1\ncat2\ncat3" dans le fichier excel, convertir en tableau
            //$validatedData['categories'] = explode("\n", $validatedData['categories']);

            $product = [
                'nom' => $validatedData['nom'],
                'sku' => $validatedData['sku'],
                'status' => $validatedData['pub_status'],
                'description' => $validatedData['description'],
                'prix' => $validatedData['prix'],
                'permalien' => $validatedData['permalien'],
                'categories' => $validatedData['categories'],
                'marque' => $validatedData['marque'],
            ];

            $products[] = $product;
            
        }

        if(count($products) == 0)
            return null;

        return $products;
    }

    //validation rules
    public function rules(): array
    {
        return [
            'nom' => 'required|string',
            'sku' => 'required|string',
            'pub_status' => 'required|string',
            'prix' => 'required|numeric',
            'categories' => 'required|string',
        ];
    }

    private function validateRow(array $row): array
    {
        return Validator::make($row, $this->rules())->validate();
    }
}
