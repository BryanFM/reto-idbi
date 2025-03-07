<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string',
            'client_identification_type' => 'required|in:DNI,RUC',
            'client_identification_number' => 'required|string',
            'client_email' => 'nullable|email',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        return DB::transaction(function () use ($request) {
            // Calcular el total y validar el stock
            $total = 0;
            $items = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    return response()->json([
                        'error' => 'Stock insuficiente para el producto: ' . $product->name
                    ], 400);
                }

                $subtotal = $product->unit_price * $item['quantity'];
                $total += $subtotal;

                $items[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->unit_price,
                    'subtotal' => $subtotal
                ];

                // Disminuir el stock del producto
                $product->decrement('stock', $item['quantity']);
            }

            // Crear la venta
            $sale = Sale::create([
                'code' => 'V-' . time(),
                'client_name' => $request->client_name,
                'client_identification_type' => $request->client_identification_type,
                'client_identification_number' => $request->client_identification_number,
                'client_email' => $request->client_email,
                'total' => $total,
                'user_id' => $request->user()->id
            ]);

            // Crear los items de la venta
            $sale->items()->createMany($items);

            return response()->json($sale->load('items'), 201);
        });
    }
}