<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GenerateScrapingRequestExcel implements FromCollection, WithHeadings
{
    use Exportable;

    protected $collection;

    public function __construct($collection) {
        $this->collection = $collection;
    }

    public function collection() {
        return $this->collection;
    }

    public function headings(): array
    {
        return [
            'State',
            'City/ County/ Zip Codes',
            'Listing Type',
            'Price Range',
            'Property Type',
            'Bathrooms',
            'Bedrooms',
            'Additional Filters',
            'Job Name',
        ];
    }
}
