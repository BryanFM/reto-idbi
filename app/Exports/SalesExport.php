<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    protected $sales;

    public function __construct($sales)
    {
        $this->sales = $sales;
    }

    public function collection()
    {
        return $this->sales->map(function ($sale) {
            return [
                $sale->code,
                $sale->client_name,
                $sale->client_identification_type . ' ' . $sale->client_identification_number,
                $sale->client_email ?? 'N/A',
                $sale->items->sum('quantity'),
                $sale->total,
                $sale->created_at->format('Y-m-d H:i:s')
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Código',
            'Nombre Cliente',
            'Documento',
            'Correo Electrónico',
            'Cantidad de Productos',
            'Monto Total',
            'Fecha y Hora'
        ];
    }
}