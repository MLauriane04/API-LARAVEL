<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class UsuarioController extends Controller
{
    private $client;
    private $baseUrl;

    public function __construct()
    {
        // Inicializando o Guzzle client
        $this->client = new Client();
        // Pegando a URL do JSON Server a partir do arquivo .env
        $this->baseUrl = env('JSON_SERVER_URL', 'http://localhost:3000/usuarios');
    }

    // Listar usuários
    public function index()
    {
        // Fazendo requisição GET ao JSON Server
        $response = $this->client->get($this->baseUrl);
        // Decodificando a resposta JSON para array
        $usuarios = json_decode($response->getBody()->getContents(), true);

        return response()->json($usuarios);
    }

    // Criar novo usuário
    public function store(Request $request)
    {
        // Validando os dados
        $data = $request->validate([
            'nome' => 'required|string',
            'dataNascimento' => 'required|date',
            'email' => 'required|email',
            'cpf' => 'required|string',
            'fone' => 'required|string',
            'endereco' => 'required|array',
            'endereco.rua' => 'required|string',
            'endereco.cep' => 'required|string',
            'endereco.bairro' => 'required|string',
            'endereco.numero' => 'required|string',
            'endereco.cidade' => 'required|string',
            'endereco.estado' => 'required|string',
        ]);

        // Fazendo requisição POST ao JSON Server
        $response = $this->client->post($this->baseUrl, [
            'json' => $data
        ]);

        // Decodificando a resposta
        $usuario = json_decode($response->getBody()->getContents(), true);

        return response()->json($usuario, 201);
    }

    // Atualizar usuário
    public function update(Request $request, $id)
    {
        // Validando os dados
        $data = $request->validate([
            'nome' => 'required|string',
            'dataNascimento' => 'required|date',
            'email' => 'required|email',
            'cpf' => 'required|string',
            'fone' => 'required|string',
            'endereco' => 'required|array',
            'endereco.rua' => 'required|string',
            'endereco.cep' => 'required|string',
            'endereco.bairro' => 'required|string',
            'endereco.numero' => 'required|string',
            'endereco.cidade' => 'required|string',
            'endereco.estado' => 'required|string',
        ]);

        // Fazendo requisição PUT ao JSON Server
        $response = $this->client->put("{$this->baseUrl}/{$id}", [
            'json' => $data
        ]);

        // Decodificando a resposta
        $usuario = json_decode($response->getBody()->getContents(), true);

        return response()->json($usuario);
    }

    // Deletar usuário
    public function destroy($id)
    {
        // Fazendo requisição DELETE ao JSON Server
        $response = $this->client->delete("{$this->baseUrl}/{$id}");
        
        return response()->json(['message' => 'Usuário deletado com sucesso!']);
    }
}
