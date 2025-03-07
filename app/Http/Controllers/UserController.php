<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class UserController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:3000/', // URL do seu JSON Server
        ]);
    }

    public function index()
    {
        $response = $this->client->get('users'); // Endpoint do JSON Server
        $users = json_decode($response->getBody()->getContents(), true);

        return view('users.index', compact('users')); // Envia os usuários para a view
    }

    public function store(Request $request)
    {
        $response = $this->client->post('users', [
            'json' => $request->all()
        ]);

        return redirect()->route('users.index');
    }

    public function update(Request $request, $id)
    {
        $response = $this->client->put("users/{$id}", [
            'json' => $request->all()
        ]);

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $this->client->delete("users/{$id}");

        return redirect()->route('users.index');
    }
}
