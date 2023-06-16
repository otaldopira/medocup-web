<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Procedimento extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'valor',
        'tempo',
    ];

    protected $table = 'procedimentos';

    protected $primaryKey = 'procedimento_id';

    public $timestamps = false;

    public static function inserirProcedimento($nome, $tempo, $valor)
    {
        DB::table('procedimentos')->insert([
            'nome' => $nome,
            'tempo' => $tempo,
            'valor' => str_replace(['.', ','], ['', '.'], $valor),
        ]);
    }
    public static function atualizarProcedimento($procedimento_id, $nome, $tempo, $valor)
    {
        DB::table('procedimentos')->where('procedimento_id', $procedimento_id)->update([
            'nome' => $nome,
            'tempo' => $tempo,
            'valor' => str_replace(['.', ','], ['', '.'], $valor),
        ]);
    }
    public static function removerProcedimento($procedimento_id)
    {
        DB::table('procedimentos')->where('procedimento_id', $procedimento_id)->delete();
    }
}