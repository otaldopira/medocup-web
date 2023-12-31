<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Colaborador extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_completo',
        'cpf',
        'data_nascimento',
        'data_admissao',
        'genero',
        'celular',
        'cep',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'estado',
    ];

    protected $table = 'colaboradores';

    protected $primaryKey = 'colaborador_id';

    public $timestamps = false;

    public static function inserirColaborador($nome, $cpf, $dataNascimento, $dataAdmissao, $genero, $celular, $cep, $rua, $numero, $bairro, $cidade, $estado)
    {
        DB::table('colaboradores')->insert(['nome_completo' => $nome, 'cpf' => str_replace(["-", "."], [""], $cpf), 'data_nascimento' => $dataNascimento, 'data_admissao' => $dataAdmissao, 'genero' => $genero, 'celular' => $celular, 'cep' => $cep, 'rua' => $rua, 'numero' => $numero, 'bairro' => $bairro, 'cidade' => $cidade, 'estado' => $estado]);

    }

    public static function removerColaborador($colaboradorId)
    {
        $sql = "DELETE FROM colaboradores WHERE colaborador_id = ?";

        DB::delete($sql, [$colaboradorId]);
    }

    public static function atualizarColaborador($id, $nome, $cpf, $dataNascimento, $dataAdmissao, $genero, $celular, $cep, $rua, $numero, $bairro, $cidade, $estado)
    {
        DB::table('colaboradores')
            ->where('colaborador_id', intval($id))
            ->update([
                'nome_completo' => $nome,
                'cpf' => str_replace(["-", "."], [""], $cpf),
                'data_nascimento' => $dataNascimento,
                'data_admissao' => $dataAdmissao,
                'genero' => $genero,
                'celular' => $celular,
                'cep' => $cep,
                'rua' => $rua,
                'numero' => $numero,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'estado' => $estado
            ]);
    }

}