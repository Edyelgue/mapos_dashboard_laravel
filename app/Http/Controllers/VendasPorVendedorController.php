<?php

namespace App\Http\Controllers;

use App\Models\VendasPorVendedorModel;
use Illuminate\Http\Request;

class VendasPorVendedorController extends Controller
{
    public function index(Request $request)
    {
        // Obter filtros de data, caso existam
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');
    
        // Obter dados de vendas com os filtros aplicados
        $vendas = VendasPorVendedorModel::VendasPorVendedor($dataInicio, $dataFim);
    
        // Processar os dados para o gráfico
        $vendedores = $vendas->pluck('vendedor')->toArray();
        $valoresVendas = $vendas->pluck('valor_total')->toArray();
    
        // Passar os dados para a view
        return view('vendas', compact('vendedores', 'valoresVendas', 'vendas'));
    }    

}
