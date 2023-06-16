<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProcedimentoController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\RelatorioController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/relatorio', function () {
    return Inertia::render('Relatorio');
});
Route::get('/login', function () {
    return Inertia::render('Login');
});
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/agenda', function () {
    return Inertia::render('Home');
});

Route::post('/verificarlogin', [ProfissionalController::class, 'fazerLogin']);

// COLABORADORES
Route::get('/colaboradores', function () {
    return Inertia::render('Listagem/Listar_Colaboradores');
});
Route::get('/colaborador/{id}', function ($id) {
    return Inertia::render('Cadastro/Cadastro_Colaborador', ['id' => $id]);
});
Route::get('/cadastro/colaborador', function () {
    return Inertia::render('Cadastro/Cadastro_Colaborador');
});
Route::put('/atualizar/colaborador/{id}', [ColaboradorController::class, 'update']);
Route::post('/buscar/colaborador/{id}', [ColaboradorController::class, 'find']);
Route::post('/adicionar/colaborador', [ColaboradorController::class, 'create']);
Route::post('/remover/colaborador', [ColaboradorController::class, 'remove']);
Route::post('/listar/colaboradores', [ColaboradorController::class, 'index']);

// PROFISSIONAIS
Route::get('/cadastro/profissional', function () {
    return Inertia::render('Cadastro/Cadastro_Profissional');
});
Route::get('/profissionais', function () {
    return Inertia::render('Listagem/Listar_Profissionais');
});
Route::get('/profissional/{id}', function ($id) {
    return Inertia::render('Cadastro/Cadastro_Profissional', ['id' => $id]);
});
Route::get('/listar/profissionais', [ProfissionalController::class, 'index']);
Route::get('/buscar/profissional/{id}', [ProfissionalController::class, 'find']);
Route::post('/adicionar/profissional', [ProfissionalController::class, 'create']);
Route::put('/atualizar/profissional/{id}', [ProfissionalController::class, 'update']);
Route::post('/remover/profissional/{id}', [ProfissionalController::class, 'remove']);

// EMPRESAS
Route::get('/empresas', function () {
    return Inertia::render('Listagem/Listar_Empresas');
});
Route::get('/empresa/{id}', function ($id) {
    return Inertia::render('Cadastro/Cadastro_Empresa', ['id' => $id]);
});
Route::get('/cadastro/empresa', function () {
    return Inertia::render('Cadastro/Cadastro_Empresa');
});
Route::get('/listar/empresas', [EmpresaController::class, 'index']);
Route::get('/buscar/empresa/{id}', [EmpresaController::class, 'findById']);
Route::post('/adicionar/empresas', [EmpresaController::class, 'create']);
Route::post('/remover/empresa/{id}', [EmpresaController::class, 'remove']);
Route::put('/atualizar/empresa/{id}', [EmpresaController::class, 'update']);

// AGENDAMENTOS
Route::get('/agendamento', function () {
    return redirect('/agenda');
});
Route::post('/adicionar/agendamento', [AgendamentoController::class, 'create']);
Route::post('/agendamento', [AgendamentoController::class, 'index']);
Route::get('/agendamento/{id}', [AgendamentoController::class, 'schedulingSearch']);
Route::get('/agendamentos/{id}', [AgendamentoController::class, 'search']);
Route::put('/atualizar/agendamento', [AgendamentoController::class, 'update']);
Route::post('/excluir/agendamento/{id}', [AgendamentoController::class, 'remove']);

// PROCEDIMENTOS
Route::get('/procedimentos', function () {
    return Inertia::render('Listagem/Listar_Procedimentos');
});
Route::get('cadastro/procedimento', function () {
    return Inertia::render('Cadastro/Cadastro_Procedimentos');
});
Route::get('/procedimento/{id}', function ($id) {
    return Inertia::render('Cadastro/Cadastro_Procedimentos', ['id' => $id]);
});
Route::get('/listar/procedimentos', [ProcedimentoController::class, 'index']);
Route::get('/buscar/procedimento/{id}', [ProcedimentoController::class, 'find']);
Route::post('/adicionar/procedimento', [ProcedimentoController::class, 'create']);
Route::put('/atualizar/procedimento', [ProcedimentoController::class, 'update']);
Route::post('/remover/procedimento/{id}', [ProcedimentoController::class, 'remove']);

// ATENDIMENTOS 
Route::post(('/upload'), [AtendimentoController::class, 'upload']);
Route::get(('/atendimentos/{id}'), [AtendimentoController::class, 'findById']);
Route::post(('/download'), [AtendimentoController::class, 'download']);

// RELATÓRIOS
Route::post(('/relatorio/buscar/profissional'), [RelatorioController::class, 'relatorioByProfissional']);
Route::post(('/relatorio/buscar/empresa'), [RelatorioController::class, 'relatorioByEmpresa']);
Route::post(('/relatorio/buscar/geral'), [RelatorioController::class, 'relatorioByEmpresa']);