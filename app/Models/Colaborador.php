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
        'genero',
        'celular',
    ];

    protected $table = 'colaboradores';

    protected $primaryKey = 'colaborador_id';

    public $timestamps = false;

    public static function inserirColaborador($nome, $cpf, $dataNascimento, $genero, $celular)
    {
        $sql = "INSERT INTO colaboradores (nome_completo, cpf, data_nascimento, genero, celular) 
                VALUES (?, ?, ?, ?, ?)";

        DB::insert($sql, [$nome, str_replace(["-", "."], [""], $cpf), $dataNascimento, $genero, $celular]);
    }

    public static function removerColaborador($colaboradorId)
    {
        $sql = "DELETE FROM colaboradores WHERE colaborador_id = ?";

        DB::delete($sql, [$colaboradorId]);
    }

    public static function atualizarColaborador($id, $nome, $cpf, $dataNascimento, $genero, $celular)
    {
        DB::table('colaboradores')
            ->where('colaborador_id',  intval($id))
            ->update([
                'nome_completo' => $nome,
                'cpf' => str_replace(["-", "."], [""], $cpf),
                'data_nascimento' => $dataNascimento,
                'genero' => $genero,
                'celular' => $celular,
            ]);
    }

}