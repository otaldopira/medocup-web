<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use Illuminate\Http\Request;

class ProfissionalController extends Controller
{
    public function index()
    {
        return Profissional::all();
    }
    public function find($id)
    {
        $profissional = Profissional::find($id);

        return $profissional;
    }
    public function create(Request $request)
    {
        try {
            // Valide os dados recebidos do formulário
            $request->validate([
                'nome' => 'required',
                'cpf' => 'required|min:11',
                'crm' => 'required|min:5',
            ]);

            Profissional::inserirProfissional(
                $request->nome,
                $request->cpf,
                $request->crm,

            );

            return response()->json([
                'message' => 'Profissional criado',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao cadastar o profissional ',
                'code' => 500
            ]);
        }
    }
    public function update(Request $request, $profissional_id)
    {
        try {
            // Valide os dados recebidos do formulário
            $request->validate([
                'nome' => 'required',
                'cpf' => 'required|min:11',
                'crm' => 'required|min:5',
            ]);

            Profissional::atualizarProfissional(
                $profissional_id,
                $request->nome,
                $request->cpf,
                $request->crm,

            );

            return response()->json([
                'message' => 'Profissional atualizado',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar o profissional ',
                'code' => 500
            ]);
        }
    }
    public function remove($profissional_id)
    {
        try {
            if (!$profissional_id) {
                return response()->json([
                    'message' => 'O ID do profissional é obrigatório',
                    'code' => 400
                ]);
            }
            Profissional::removerProfissional($profissional_id);

            return response()->json([
                'message' => 'Profissional excluído com sucesso',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir o profissional',
                'code' => 500
            ]);
        }
    }
    public function autenticacao(Request $request, $profissional_id)
    {
        try {
            $request->validate([
                'email' => 'required',
                'senha' => 'required',
            ]);

            if (!$profissional_id) {
                return response()->json([
                    'message' => 'O ID do profissional é obrigatório',
                    'code' => 400
                ]);
            }

            Profissional::autenticacaoProfissional(
                $profissional_id,
                $request->email,
                $request->senha,

            );
            
            return response()->json([
                'message' => 'Autenticação atualizada com sucesso',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar autenticação',
                'code' => 500
            ]);
        }
    }
    public function fazerLogin(Request $request)
    {
        try {
            $email = $request->email;
            $senha = $request->senha;
            $profissional = Profissional::login($email, $senha);
            if ($profissional) {
                return response()->json([
                    'profissional' => $profissional,
                    'message' => 'Sucesso',
                    'code' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'Usuário/Senha não conferem ',
                    'code' => 401
                ]);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }


}