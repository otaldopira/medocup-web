<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Profissional extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'cpf',
        'crm',
        'email',
        'senha'
    ];

    protected $table = 'profissionais';

    protected $primaryKey = 'profissional_id';

    public $timestamps = false;

    public static function inserirProfissional($nome, $cpf, $crm)
    {
        $sql = "INSERT INTO profissionais (nome, cpf, crm) 
                VALUES (?, ?, ?)";

        DB::insert($sql, [$nome, str_replace(["-", "."], [""], $cpf), $crm]);
    }
    public static function removerProfissional($profissional_id)
    {
        DB::table('profissionais')
            ->where('profissional_id', intval($profissional_id))
            ->delete();
    }
    public static function autenticacaoProfissional($profissional_id, $email, $senha)
    {
        DB::table('profissionais')
            ->where('profissional_id', intval($profissional_id))
            ->update(['email' => $email, 'senha' => $senha]);
    }
    public static function atualizarProfissional($id, $nome, $cpf, $crm)
    {
        DB::table('profissionais')
            ->where('profissional_id', intval($id))
            ->update([
                'nome' => $nome,
                'cpf' => str_replace(["-", "."], [""], $cpf),
                'crm' => $crm,

            ]);
    }
    public static function login($email, $senha)
    {
        $profissional = DB::table('profissionais')
            ->where('email', $email)
            ->where('senha', $senha)
            ->first();
        if (
            $profissional
        ) {
            $profissionalLogin['nome'] = $profissional->nome;
            $profissionalLogin['profissional_id'] = $profissional->profissional_id;
            $profissionalLogin['email'] = $profissional->email;
            return $profissionalLogin;
        } else {
            return false;
        }
    }
}