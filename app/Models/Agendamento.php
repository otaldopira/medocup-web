<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Agendamento extends Model
{
    use HasFactory;

    protected $table = 'agendamentos';

    protected $fillable = [
        'profissional',
        'data',
        'hora',
        'status_id',
        'colaborador_id',
        'telefone',
        'procedimento_id',
        'empresa_id',
        'tempo',
        'valor',
    ];

    public static function inserirAgendamento($profissional_id, $data, $hora, $status, $colaborador, $empresa, $telefone, $procedimento, $tempo, $valor)
    {
        DB::table('agendamentos')->insert(['profissional_id' => $profissional_id, 'data' => $data, 'hora' => $hora, 'status_id' => $status, 'colaborador_id' => $colaborador, 'empresa_id' => $empresa, 'telefone' => $telefone, 'procedimento_id' => $procedimento, 'tempo' => $tempo, 'valor' => str_replace(['.', ','], ['', '.'], $valor)]);
    }

    public static function atualizarAgendamento($agendamento_id, $status, $empresa, $colaborador, $telefone, $procedimento, $tempo, $valor)
    {
        DB::table('agendamentos')
            ->where('agendamento_id', intval($agendamento_id))
            ->update([
                'status_id' => intval($status),
                'colaborador_id' => intval($colaborador),
                'empresa_id' => intval($empresa),
                'telefone' => $telefone,
                'procedimento_id' => intval($procedimento),
                'tempo' => $tempo,
                'valor' => str_replace(['.', ','], ['', '.'], $valor),
            ]);
    }
    public static function removerAgendamento($agendamento_id)
    {
        DB::table('agendamentos')
            ->where('agendamento_id', intval($agendamento_id))
            ->delete();
    }
    public static function buscarAgendamentoPorId($agendamento_id)
    {
        $agendamento = DB::table('agendamentos')
            ->where('agendamento_id', intval($agendamento_id))
            ->get();

        return $agendamento;
    }
    public static function relatorioAgendamentoGeral($profissional_id,$empresa_id, $data_inicio, $data_fim)
    {
        // ID 5 é atendido
        $agendamento = DB::table('agendamentos')
            ->join('profissionais', 'agendamentos.profissional_id', '=', 'profissionais.profissional_id')
            ->join('colaboradores', 'agendamentos.colaborador_id', '=', 'colaboradores.colaborador_id')
            ->join('empresas', 'agendamentos.empresa_id', '=', 'empresas.empresa_id')
            ->join('procedimentos', 'agendamentos.procedimento_id', '=', 'procedimentos.procedimento_id')
            ->where('agendamentos.profissional_id', intval($profissional_id))
            ->where('agendamentos.empresa_id', intval($empresa_id))
            ->where('agendamentos.status_id', 5)
            ->whereBetween('agendamentos.data', [$data_inicio, $data_fim])
            ->select('colaboradores.nome_completo as nome_colaborador', 'empresas.nome_fantasia as nome_empresa', 'procedimentos.nome as nome_procedimento', 'agendamentos.data', 'agendamentos.hora', 'agendamentos.valor', 'profissionais.nome as nome_profissional')
            ->get();

        return $agendamento;


    }
    public static function relatorioAgendamentoEmpresa($empresa_id, $data_inicio, $data_fim)
    {
        // ID 5 é atendido
        $agendamento = DB::table('agendamentos')
            ->join('profissionais', 'agendamentos.profissional_id', '=', 'profissionais.profissional_id')
            ->join('colaboradores', 'agendamentos.colaborador_id', '=', 'colaboradores.colaborador_id')
            ->join('empresas', 'agendamentos.empresa_id', '=', 'empresas.empresa_id')
            ->join('procedimentos', 'agendamentos.procedimento_id', '=', 'procedimentos.procedimento_id')
            ->where('agendamentos.empresa_id', intval($empresa_id))
            ->where('agendamentos.status_id', 5)
            ->whereBetween('agendamentos.data', [$data_inicio, $data_fim])
            ->select('colaboradores.nome_completo as nome_colaborador', 'empresas.nome_fantasia as nome_empresa', 'procedimentos.nome as nome_procedimento', 'agendamentos.data', 'agendamentos.hora', 'agendamentos.valor', 'profissionais.nome as nome_profissional')
            ->get();

        return $agendamento;


    }
    public static function relatorioAgendamentoProfissional($profissional_id, $data_inicio, $data_fim)
    {
        // ID 5 é atendido
        $agendamento = DB::table('agendamentos')
            ->join('profissionais', 'agendamentos.profissional_id', '=', 'profissionais.profissional_id')
            ->join('colaboradores', 'agendamentos.colaborador_id', '=', 'colaboradores.colaborador_id')
            ->join('empresas', 'agendamentos.empresa_id', '=', 'empresas.empresa_id')
            ->join('procedimentos', 'agendamentos.procedimento_id', '=', 'procedimentos.procedimento_id')
            ->where('agendamentos.profissional_id', intval($profissional_id))
            ->where('agendamentos.status_id', 5)
            ->whereBetween('agendamentos.data', [$data_inicio, $data_fim])
            ->select('colaboradores.nome_completo as nome_colaborador', 'empresas.nome_fantasia as nome_empresa', 'procedimentos.nome as nome_procedimento', 'agendamentos.data', 'agendamentos.hora', 'agendamentos.valor', 'profissionais.nome as nome_profissional')
            ->get();

        return $agendamento;


    }
    public static function buscarAgendamentosPorProfissional($profissional_id)
    {
        $agendamentos = DB::table('agendamentos')
            ->where('profissional_id', intval($profissional_id))
            ->get();

        return $agendamentos;
    }
}