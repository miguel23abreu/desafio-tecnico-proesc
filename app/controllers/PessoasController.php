<?php

use Illuminate\Http\Request;

class PessoasController extends BaseController {

    public function visualizarFormulario() {
        $grupos = Grupo::all()->lists('nome', 'id');
        return View::make('formularios.cadastro', compact('grupos'));
    }

    public function cadastrarPessoa() {
        $pessoa = new Pessoa;
        $pessoa->nome = Input::get('nome');
        $pessoa->email = Input::get('email');
        $pessoa->cpf = preg_replace('/[^0-9]/', '', Input::get('cpf'));
        $pessoa->telefone = Input::get('telefone');
        $pessoa->grupo_id = Input::get('grupo_id');
        $pessoa->save();

        return Redirect::to('/cadastro')->with('success', 'Cadastro realizado com sucesso!');
        
    }
}