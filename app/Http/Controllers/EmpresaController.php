<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        return Empresa::all();
    }
    public function findById($empresa_id)
    {
        return Empresa::find($empresa_id);
    }

    public function create(Request $request)
    {
        try {
            // Valide os dados recebidos do formulário
            $request->validate([
                'nome_fantasia' => 'required',
                'cnpj' => 'required|min:18',
            ]);

            // Chame o método insertAgendamento no modelo Agendamento
            Empresa::inserirEmpresa(
                $request->nome_fantasia,
                $request->cnpj,

            );

            return response()->json([
                'message' => 'Empresa criada',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao cadastar a empresa ',
                'code' => 500
            ]);
        }
    }
    public function update(Request $request, $empresa_id)
    {
        try {
            // Valide os dados recebidos do formulário
            $request->validate([
                'nome_fantasia' => 'required',
                'cnpj' => 'required|min:18',
            ]);

            // Chame o método insertAgendamento no modelo Agendamento
            Empresa::atualizarEmpresa(
                $empresa_id,
                $request->nome_fantasia,
                $request->cnpj,

            );

            return response()->json([
                'message' => 'Empresa criada',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao cadastar a empresa ',
                'code' => 500
            ]);
        }
    }
    public function remove($empresa_id)
    {
        try {
            // Validar se o $agendamento_id está presente
            if (!$empresa_id) {
                return response()->json([
                    'message' => 'O ID da empresa é obrigatório',
                    'code' => 400
                ]);
            }
            Empresa::removerEmpresa($empresa_id);
            return response()->json([
                'message' => 'Empresa excluída com sucesso',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir a empresa',
                'code' => 500
            ]);
        }
    }

    
}