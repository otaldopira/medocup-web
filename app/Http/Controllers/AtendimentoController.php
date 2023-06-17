<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AtendimentoController extends Controller
{
    public function upload(Request $request)
    {
        try {
            $profissional_id = $request->profissional_id;
            $colaborador_id = $request->colaborador_id;
            // Verifique se o arquivo foi enviado corretamente
            if ($request->hasFile('documento')) {
                $documento = $request->file('documento');
                
                // Salve as informações do arquivo no banco de dados
                return Atendimento::salvarDocumento($documento, $profissional_id, $colaborador_id);
                 
            }

        } catch (\Exception $e) {
            return response()->json([
                $e->getMessage()
            ]);
        }
    }
    public function index(Request $request)
    {
        return Atendimento::all();
    }
    public function findById($id)
    {
        return Atendimento::buscarAtendimentosPorId($id);
    }

    public function download(Request $request)
    {
        $caminho = $request->caminho;
        $file = Storage::path($caminho);

        return response()->download($file, 'doc.docx');
    }


}