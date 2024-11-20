<?php

namespace App\Http\Controllers;

use App\Models\VendasPorVendedorModel;
use Illuminate\Http\Request;

class VendasPorVendedorController extends Controller
{
    public function index(Request $request)
    {
        // Captura os parâmetros de data do formulário
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        // Chama o método do modelo com os filtros de data
        $vendas = VendasPorVendedorModel::VendasPorVendedor($dataInicio, $dataFim);

        // Retorna os dados para a view
        return view('vendas', compact('vendas'));
    }
}
