<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaposModel extends Model
{
    protected $connection = 'mapos'; // Nome da conexão no config/database.php
    protected $table = 'vendas'; // Nome da tabela que deseja acessar
}
