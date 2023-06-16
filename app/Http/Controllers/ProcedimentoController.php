<?php

namespace App\Http\Controllers;

use App\Models\Procedimento;
use Illuminate\Http\Request;

class ProcedimentoController extends Controller
{
    public function index()
    {
        return Procedimento::all();
    }
    public function create(Request $request)
    {
        try {
            // Valide os dados recebidos do formulário
            $request->validate([
                'nome' => 'required',
                'tempo' => 'required',
                'valor' => 'required',
            ]);

            Procedimento::inserirProcedimento(
                $request->nome,
                $request->tempo,
                $request->valor
            );

            return response()->json([
                'message' => 'Procedimento criado com sucesso',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar o procedimento',
                'code' => 500
            ]);
        }
    }
    public function update(Request $request)
    {
        try {
            // Valide os dados recebidos do formulário
            $request->validate([
                'procedimento_id' => 'required',
                'nome' => 'required',
                'tempo' => 'required',
                'valor' => 'required',
            ]);

            Procedimento::atualizarProcedimento(
                $request->procedimento_id,
                $request->nome,
                $request->tempo,
                $request->valor
            );

            return response()->json([
                'message' => 'Procedimento atualizado com sucesso',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar o procedimento',
                'code' => 500
            ]);
        }
    }
    public function remove($procedimento_id)
    {
        try {
            // Validar se o $agendamento_id está presente
            if (!$procedimento_id) {
                return response()->json([
                    'message' => 'O ID do procedimento é obrigatório',
                    'code' => 400
                ]);
            }
            Procedimento::removerProcedimento($procedimento_id);
            return response()->json([
                'message' => 'Procedimento excluído com sucesso',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir procedimento',
                'code' => 500
            ]);
        }
    }
    public function find($procedimento_id)
    {
        return Procedimento::find($procedimento_id);
    }



}