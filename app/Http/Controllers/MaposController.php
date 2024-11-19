<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaposModel;

class MaposController extends Controller
{
    public function index()
    {
        // Obtendo dados do banco de dados remoto
        $dados = MaposModel::all();
        
        // Retornando como resposta JSON
        return response()->json($dados);
    }
}
