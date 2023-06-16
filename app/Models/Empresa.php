<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_fantasia',
        'cnpj',
    ];

    protected $table = 'empresas';
    protected $primaryKey = 'empresa_id';
    public $timestamps = false;

    public static function inserirEmpresa($nome_fantasia, $cnpj)
    {
        DB::table('empresas')->insert([
            'nome_fantasia' => $nome_fantasia,
            'cnpj' => str_replace(["-", ".", "/"], [""], $cnpj),
        ]);
    }
    public static function atualizarEmpresa($empresa_id, $nome_fantasia, $cnpj)
    {
        DB::table('empresas')->where('empresa_id', intval($empresa_id))->update([
            'nome_fantasia' => $nome_fantasia,
            'cnpj' => str_replace(["-", ".", "/"], [""], $cnpj),
        ]);
    }
    public static function removerEmpresa($empresa_id)
    {
        DB::table('empresas')->where('empresa_id', intval($empresa_id))->delete();
    }


}