<?php

namespace App\Http\Controllers;

use App\Models\VendasPorVendedorModel;
use Illuminate\Http\JsonResponse;

class VendasPorVendedorController extends Controller
{
    public function index(): JsonResponse
    {
        $vendas = VendasPorVendedorModel::VendasPorVendedor();

        return response()->json($vendas, 200);
    }
}
