<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VendasPorVendedorModel extends Model
{
    protected $connection = 'mapos';
    protected $table = 'vendas';

    public static function VendasPorVendedor($dataInicio = null, $dataFim = null)
    {
        $query = DB::connection('mapos')
            ->table('vendas')
            ->join('usuarios', 'vendas.usuarios_id', '=', 'usuarios.idUsuarios')
            ->select(
                'usuarios.nome as vendedor', // Nome do vendedor
                DB::raw('SUM(vendas.valorTotal) as valor_total') // Soma do valorTotal para cada vendedor
            )
            ->groupBy('usuarios.nome'); // Agrupa pelo nome do vendedor

        // Aplica o filtro de data de início, se fornecido
        if ($dataInicio) {
            $query->where('vendas.dataVenda', '>=', $dataInicio);
        }

        // Aplica o filtro de data de fim, se fornecido
        if ($dataFim) {
            $query->where('vendas.dataVenda', '<=', $dataFim);
        }

        return $query->get(); // Retorna os resultados
    }
}
