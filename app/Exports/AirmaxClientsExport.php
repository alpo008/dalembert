<?php

namespace App\Exports;

use App\Models\AirmaxClient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AirmaxClientsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct(?string $keyword)
    {
        $this->keyword = $keyword;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AirmaxClient::statistics($this->keyword);
    }

    public function headings(): array
    {
        return [
            __('Place'),
            __('Name'),
            __('Phone'),
            __('Bridge IP'),
            __('Active')
        ];
    }
}
