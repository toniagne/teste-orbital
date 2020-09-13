<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagersRequest;
use App\Models\Manager;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    // LISTAGEM
    public function index()
    {
        // CAPTURA TODOS OS REGISTROS
        $managers = Manager::all();

        // RETORNA EM JSON NA VARIÁVEL DATA
        return response()->json(['data' => $managers]);
    }

    // SALVA NO BANCO DE DADOS
    public function store(ManagersRequest $request)
    {

        try{
            // SALVA NO BANCO DE DAODOS OS REGISTROS DA REQUEST
            $manager = Manager::create($request->all());

            // GRAVA RETORNO NA ARRAY (OS DADOS DO CADASTRO + MENSAGEM DE SUCESSO)
            $response = [
                'success' => true,
                'data' => $manager,
                'message' => 'Cadastro efetuado com sucesso '
            ];

        // TRATATIVAS DE ERROS
        }catch (\Exception $e){

            // CAPTURA O ERRO QUE ESTA RETORNANDO
            $response =  [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        // RETORNA EM JSON
        return response()->json($response);
    }

    // RETORNA OS DADOS DE UM MANAGER SELECIONADO
    public function show($id)
    {
        // GRAVA OS DADOS ENCONTRADOS
        $managers = Manager::find($id);

        // RETORNA EM JSON
        return response()->json(['data' => $managers]);
    }

    // ATUALIZA CADASTRO
    public function update(Request $request, Manager $manager)
    {
        try{
            // ATIALIZA O CADASTRO PREVIAMENTE LOCALIZADO COM OS DADOS DA REQUEST
            $manager->update($request->all());

            // GRAVA RETORNO NA ARRAY (OS DADOS DO CADASTRO + MENSAGEM DE SUCESSO)
            $response = [
                'success' => true,
                'data' => $manager,
                'message' => 'Cadastro alterado com sucesso '
            ];

        // TRATATIVAS DE ERROS
        }catch (\Exception $e){

            // CAPTURA O ERRO QUE ESTA RETORNANDO
            $response =  [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        // RETORNA RESPOSTA EM JSON
        return response()->json($response);
    }

    // APAGA CADASTRO
    public function destroy(Manager $manager)
    {
        // DELETA O REGISTRO PREVIAMENTE SELECIONADO
        $manager->delete();

        // GRAVA RETORNO
        $response =  [
            'success' => true,
            'message' => 'Cadastro deletado com sucesso.'
        ];

        // RETORNA EM JSON
        return response()->json($response);
    }
}
