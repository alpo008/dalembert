<?php

namespace App\Exports;

use App\Models\AirmaxClient;
use Maatwebsite\Excel\Concerns\FromCollection;

class AirmaxClientsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AirmaxClient::all();
    }
}
