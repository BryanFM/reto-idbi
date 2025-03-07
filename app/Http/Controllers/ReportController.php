<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\Sale;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // Generar reporte en formato JSON
    public function salesReport(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start'
        ]);

        $sales = Sale::whereBetween('created_at', [$request->start, $request->end])
            ->get();

        $formattedSales = $sales->map(function ($sale) {
            return [
                'Código' => $sale->code,
                'Nombre cliente' => $sale->client_name,
                'Identificación cliente' => $sale->client_identification_type . ' ' . $sale->client_identification_number,
                'Correo cliente' => $sale->client_email ?? 'N/A',
                'Cantidad productos' => $sale->items->sum('quantity'),
                'Monto total' => $sale->total,
                'Fecha y hora' => $sale->created_at->format('Y-m-d h:i a')
            ];
        });

        return response()->json($formattedSales);
    }

    // Exportar reporte a Excel
    public function exportSalesReport(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start'
        ]);

        $sales = Sale::whereBetween('created_at', [$request->start, $request->end])
            ->get();

        return Excel::download(new SalesExport($sales), 'reporte-ventas.xlsx');
    }
}
