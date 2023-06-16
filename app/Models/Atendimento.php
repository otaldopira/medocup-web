<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class Atendimento extends Model
{
    use HasFactory;

    protected $table = 'atendimentos'; // Nome da tabela no banco de dados
    protected $fillable = ['nome', 'caminho']; // Campos preenchíveis

    public static function salvarDocumento($arquivo, $profissional_id, $colaborador_id)
    {
        $path = Storage::disk('public')->putFile('atendimentos', $arquivo);
        $nomeArquivo = $arquivo->getClientOriginalName();
        DB::table('atendimentos')->insert([
            'nome' => $nomeArquivo,
            'caminho' => $path,
            'profissional_id' => $profissional_id,
            'colaborador_id' => $colaborador_id,
        ]);
        
        return [
            'nome' => $nomeArquivo,
            'caminho' => $path,
        ];
    }

    public static function buscarAtendimentosPorId($colaborador_id)
    {
        $atendimentos = DB::table('atendimentos')
            ->where('colaborador_id', intval($colaborador_id))
            ->get();

        return $atendimentos;
    }
}