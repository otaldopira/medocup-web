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
        'telefone',
        'cep',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'estado',
    ];

    protected $table = 'empresas';
    protected $primaryKey = 'empresa_id';
    public $timestamps = false;

    public static function inserirEmpresa($nome_fantasia, $cnpj, $telefone, $cep, $rua, $numero, $bairro, $cidade, $estado)
    {
        DB::table('empresas')->insert([
            'nome_fantasia' => $nome_fantasia,
            'cnpj' => str_replace(["-", ".", "/"], [""], $cnpj),
            'telefone' => $telefone,
            'cep' => $cep,
            'rua' => $rua,
            'numero' => $numero,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'estado' => $estado,
        ]);
    }
    public static function atualizarEmpresa($empresa_id, $nome_fantasia, $cnpj, $telefone, $cep, $rua, $numero, $bairro, $cidade, $estado)
    {
        DB::table('empresas')->where('empresa_id', intval($empresa_id))->update([
            'nome_fantasia' => $nome_fantasia,
            'cnpj' => str_replace(["-", ".", "/"], [""], $cnpj),
            'telefone' => $telefone,
            'cep' => $cep,
            'rua' => $rua,
            'numero' => $numero,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'estado' => $estado,
        ]);
    }
    public static function removerEmpresa($empresa_id)
    {
        DB::table('empresas')->where('empresa_id', intval($empresa_id))->delete();
    }


}