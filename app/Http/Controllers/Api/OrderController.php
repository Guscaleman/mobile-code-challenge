<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'order_date'    => ['required', 'date'],
            'delivered_at'  => ['nullable', 'date', 'after_or_equal:order_date'],
        ]);

        $validated['status'] = 'pendente';

        $order = Order::create($validated);

        return response()->json([
            'message' => 'Pedido criado com sucesso',
            'data' => $order
        ], 201);
    }

    public function show(int $id)
    {
        return response()->json(Order::findOrFail($id));
    }

    public function update(Request $request, int $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'customer_name' => ['sometimes', 'required', 'string', 'max:255'],
            'order_date'    => ['sometimes', 'required', 'date'],
            'delivered_at'  => ['nullable', 'date', 'after_or_equal:order_date'],
            'status'        => ['sometimes', 'required', Rule::in(['pendente', 'entregue', 'cancelado'])],
        ]);

        $order->update($validated);

        return response()->json([
            'message' => 'Pedido atualizado com sucesso',
            'data' => $order
        ]);
    }

    public function destroy(int $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json([
            'message' => 'Pedido removido com sucesso'
        ]);
    }
}
