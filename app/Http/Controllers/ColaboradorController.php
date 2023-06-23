<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;

class ColaboradorController extends Controller
{
    public function index()
    {
        return Colaborador::all();
    }

    public function find($id)
    {
        // Encontrar um colaborador específico com base no ID fornecido
        $colaborador = Colaborador::find($id);

        // Retornar os dados do colaborador encontrado
        return $colaborador;
    }


    public function create(Request $request)
    {
        try {

            // Valide os dados recebidos do formulário
            $request->validate([
                'nome_completo' => 'required',
                'cpf' => 'required|min:11',
                'data_nascimento' => 'required',
                'genero' => 'required',
                'celular' => 'required',
                'cep' => 'required',
                'rua' => 'required',
                'bairro' => 'required',
                'cidade' => 'required',
                'estado' => 'required',

            ]);

            // Chame o método insertAgendamento no modelo Agendamento
            Colaborador::inserirColaborador(
                $request->nome_completo,
                $request->cpf,
                $request->data_nascimento,
                $request->data_admissao,
                $request->genero,
                $request->celular,
                $request->cep,
                $request->rua,
                $request->numero,
                $request->bairro,
                $request->cidade,
                $request->estado,

            );

            return response()->json([
                'message' => 'Colaborador criado',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao cadastar o colaborador ',
                'code' => 500
            ]);
        }
    }

    public function remove(Request $request)
    {
        try {
            // Valide os dados recebidos do formulário
            $request->validate([
                'colaborador_id' => 'required',
            ]);

            // Obtenha o ID do colaborador a ser removido
            $colaboradorId = $request->colaborador_id;

            // Remova o colaborador chamando o método estático removerColaborador no modelo Colaborador
            Colaborador::removerColaborador($colaboradorId);

            return response()->json([
                'message' => 'Colaborador removido',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            // Outros erros genéricos
            return response()->json([
                'message' => 'Erro desconhecido',
                'code' => 500
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Valide os dados recebidos do formulário
            $request->validate([
                'nome_completo' => 'required',
                'cpf' => 'required|min:11',
                'data_nascimento' => 'required',
                'genero' => 'required',
                'celular' => 'required',
                'cep' => 'required',
                'rua' => 'required',
                'bairro' => 'required',
                'cidade' => 'required',
                'estado' => 'required',
            ]);

            // Chame o método updateColaborador no modelo Colaborador
            Colaborador::atualizarColaborador(
                $id, $request->nome_completo,
                $request->cpf,
                $request->data_nascimento,
                $request->data_admissao,
                $request->genero,
                $request->celular,
                $request->cep,
                $request->rua,
                $request->numero,
                $request->bairro,
                $request->cidade,
                $request->estado
            );

            return response()->json([
                'message' => 'Colaborador atualizado',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar o colaborador',
                'code' => 500
            ]);
        }
    }


}