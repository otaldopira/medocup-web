<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AgendamentoController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->input('info');

        return Inertia::render('Agendamento', ['info' => $data]);
    }

    public function create(Request $request)
    {
        try {
            // Valide os dados recebidos do formulário
            $request->validate([
                'profissional_id' => 'required',
                'data' => 'required|date',
                'hora' => 'required',
                'status' => 'required',
                'empresa' => 'required',
                'colaborador' => 'required',
                'telefone' => 'required',
                'procedimento' => 'required',
                'tempo' => 'required',
                'valor' => 'required',
            ]);
            // Chame o método insertAgendamento no modelo Agendamento
            Agendamento::inserirAgendamento(
                $request->profissional_id,
                $request->data,
                $request->hora,
                $request->status,
                $request->colaborador,
                $request->empresa,
                $request->telefone,
                $request->procedimento,
                $request->tempo,
                $request->valor,
                $request->observacoes
            );

            return response()->json([
                'message' => 'Agendamento criado com sucesso',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar o agendamento',
                'code' => 500
            ]);
        }
    }

    public function update(Request $request)
    {

        try {
            $request->validate([
                'agendamento_id' => 'required',
                'data' => 'required|date',
                'hora' => 'required',
                'status' => 'required',
                'empresa' => 'required',
                'colaborador' => 'required',
                'telefone' => 'required',
                'procedimento' => 'required',
                'tempo' => 'required',
                'valor' => 'required',
            ]);


            Agendamento::atualizarAgendamento(
                $request->agendamento_id,
                $request->status,
                $request->empresa,
                $request->colaborador,
                $request->telefone,
                $request->procedimento,
                $request->tempo,
                $request->valor,
                $request->observacoes
            );

            return response()->json([
                'message' => 'Agendamento atualizado com sucesso',
                'code' => 200
            ]);
        } catch (QueryException $e) {

            return response()->json([
                'message' => 'Erro ao atualizar o agendamento ',
                'code' => 500
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Erro ao atualizar o agendamento',
                'code' => 500
            ]);
        }
    }

    public function remove($agendamento_id)
    {
        try {
            // Validar se o $agendamento_id está presente
            if (!$agendamento_id) {
                return response()->json([
                    'message' => 'O ID do agendamento é obrigatório',
                    'code' => 400
                ]);
            }
            Agendamento::removerAgendamento($agendamento_id);
            return response()->json([
                'message' => 'Agendamento excluído com sucesso',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir agendamentos',
                'code' => 500
            ]);
        }
    }
    public function schedulingSearch($id)
    {
        try {

            if (!$id) {
                return response()->json([
                    'message' => 'O ID do agendamento é obrigatório',
                    'code' => 400
                ]);
            }

            $agendamento = Agendamento::buscarAgendamentoPorId($id);

            return Inertia::render('Agendamento', ['agendamento' => $agendamento]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar agendamentos',
                'code' => 500
            ]);
        }
    }
    public function search($id)
    {
        try {
            if (!$id) {
                return response()->json([
                    'message' => 'O ID do profissional é obrigatório',
                    'code' => 400
                ]);
            }
            return Agendamento::buscarAgendamentosPorProfissional($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar agendamentos',
                'code' => 500
            ]);
        }
    }


}