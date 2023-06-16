<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Profissional;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function relatorioByGeral(Request $request)
    {
        try {
            // Valide os dados recebidos do formulário
            $request->validate([
                'profissional_id' => 'required',
                'empresa_id' => 'required',
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date',
            ]);
            // Chame o método insertAgendamento no modelo Agendamento
            $agendamentos = Agendamento::relatorioAgendamentoGeral(
                $request->profissional_id,
                $request->empresa_id,
                $request->data_inicio,
                $request->data_fim,
            );
            return response()->json([
                'agendamentos' => $agendamentos,
                'message' => 'Relatório criado com sucesso',
                'code' => 200
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar o relatório',
                'code' => 500
            ]);
        }
    }
    public function relatorioByEmpresa(Request $request)
    {
        try {
            // Valide os dados recebidos do formulário
            $request->validate([
                'empresa_id' => 'required',
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date',
            ]);
            // Chame o método insertAgendamento no modelo Agendamento
            $agendamentos = Agendamento::relatorioAgendamentoEmpresa(
                $request->empresa_id,
                $request->data_inicio,
                $request->data_fim,
            );

            return response()->json([
                'agendamentos' => $agendamentos,
                'message' => 'Relatório criado com sucesso',
                'code' => 200
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar o relatório',
                'code' => 500
            ]);
        }
    }
    public function relatorioByProfissional(Request $request)
    {
        try {
            // Valide os dados recebidos do formulário
            $request->validate([
                'profissional_id' => 'required',
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date',
            ]);
            // Chame o método insertAgendamento no modelo Agendamento
            $agendamentos = Agendamento::relatorioAgendamentoProfissional(
                $request->profissional_id,
                $request->data_inicio,
                $request->data_fim,
            );

            return response()->json([
                'agendamentos' => $agendamentos,
                'message' => 'Relatório criado com sucesso',
                'code' => 200
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar o relatório',
                'code' => 500
            ]);
        }
    }
}