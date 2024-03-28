<?php

namespace App\Imports;

use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportClient implements ToArray, WithHeadingRow, WithValidation
{
    
    public function Array(array $rows)
    {
        $clients = [];

        foreach ($rows as $row) {
            $validatedData = $this->validateRow($row->toArray());

            $client = [
                'prenom' => $validatedData['prenom'],
                'nom' => $validatedData['nom'],
                'email' => $validatedData['email'],
                //telephone is written "06xxxx" in the excel file, convert it to decimal
                'telephone' => '0606060606',//problem here tobe fixed later
                //'telephone' => preg_replace('/[^0-9]/', '', $validatedData['telephone']),
                'adresse' => $validatedData['adresse'],
                'pays' => $validatedData['pays'],
            ];

            $clients[] = $client;
        }

        if(count($clients) == 0)
            return null;

        return $clients;
    }

    //validation rules
    public function rules(): array
    {
        return [
            'prenom' => 'required|string|max:191|regex:/^[\pL\s\-]+$/u',
            'nom' => 'required|string|max:191|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|string|email|max:191',
            'telephone' => 'required|string:10',
            'pays' => 'required|string|max:191',
            'adresse' => 'required|string|max:191',
        ];
    }

    private function validateRow(array $row): array
    {
        return Validator::make($row, $this->rules())->validate();
    }
}