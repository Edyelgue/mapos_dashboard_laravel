<?php

namespace App\Http\Controllers;

use App\Models\VendasPorVendedorModel;
use Illuminate\Http\Request;

class VendasPorVendedorController extends Controller
{
    public function index(Request $request)
    {
        // Validação de entrada
        $validated = $request->validate([
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date',
        ]);

        // Obter filtros de data ou definir padrões
        $dataInicio = $validated['data_inicio'] ?? now()->startOfMonth()->toDateString();
        $dataFim = $validated['data_fim'] ?? now()->toDateString();

        // Obter dados de vendas com os filtros aplicados
        $vendas = VendasPorVendedorModel::VendasPorVendedor($dataInicio, $dataFim);

        // dd($vendas);

        // Processar os dados para o gráfico
        $vendedores = $vendas->pluck('vendedor')->toArray();
        $valoresVendas = $vendas->pluck('valor_total')->toArray();
        $valorTotal = $vendas->sum('valor_total');

        // Obter a quantidade de vendas por vendedor
        $quantidadeVendasPorVendedor = $vendas->groupBy('vendedor')->map(function ($grupo) {
            return $grupo->count();
        })->toArray();

        // Ajuste para contar corretamente o número total de vendas realizadas
        $vendasRealizadas = $vendas->count(); // Apenas contar as vendas sem agrupar

        // Passar os dados para a view
        return view('vendas', [
            'vendedores' => $vendedores,
            'valoresVendas' => $valoresVendas,
            'vendas' => $vendas,
            'valorTotal' => $valorTotal,
            'vendasRealizadas' => $vendasRealizadas,
            'quantidadeVendasPorVendedor' => $quantidadeVendasPorVendedor
        ]);
    }
}
