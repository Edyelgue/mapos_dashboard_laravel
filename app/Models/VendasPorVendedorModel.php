<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VendasPorVendedorModel extends Model
{
    protected $connection = 'mapos';
    protected $table = 'vendas';

    public static function VendasPorVendedor()
    {
        return DB::connection('mapos')
            ->table('vendas')
            ->join('usuarios', 'vendas.usuarios_id', '=', 'usuarios.idUsuarios')
            ->select('usuarios.nome as vendedor', DB::raw('SUM(vendas.valorTotal) as valor_total'))
            ->groupBy('usuarios.nome')
            ->get();
    }
    
}
