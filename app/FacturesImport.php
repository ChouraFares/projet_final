<?php

namespace App\Imports;

use App\Models\FactureComplimentaireThonModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FacturesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new FactureComplimentaireThonModel([
            'facture' => $row['facture'] ?? null,
            'num_conteneur' => $row['num_conteneur'] ?? null,
            'fournisseur' => $row['fournisseur'] ?? null,
            'armateur' => $row['armateur'] ?? null,
            'incoterm' => $row['incoterm'] ?? null,
            'port' => $row['port'] ?? null,
            'bank' => $row['bank'] ?? null,
            'date_declaration' => $row['date_declaration'] ?? null,
            'assureur' => $row['assureur'] ?? null,
            'date_expiration' => $row['date_expiration'] ?? null,
            'BL' => $row['bl'] ?? null,
        ]);
    }
}
