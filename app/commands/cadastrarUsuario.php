<?php

use Illuminate\Console\Command;

class cadastrarUsuario extends Command {

    // nome do comando no artisan
    protected $name = 'cadastro:csv';

    // descrição
    protected $description = 'cadastrar usuário de uma planilha em csv.';

    public function __construct()
    {
        parent::__construct();
    }

    public function fire() // em 4.2 é fire(), não handle()
    {
        $caminho = $this->ask("informe o caminho do arquivo csv");

        if(!file_exists($caminho)) {
            $this->error("arquivo nao encontrado: $caminho");
            return;
        }
        $this->info("verificando o arquivo");
        
        $arquivo = fopen($caminho, 'r');

        $cabecalho = fgetcsv($arquivo, 0, ",");

        $cont = 0;

        while(($dados = fgetcsv($arquivo, 0, ",")) !== false) {

            $linha = array_combine($cabecalho, $dados);

            $cpf = preg_replace('/\D/', '', $linha["CPF"]);
            
            if($linha['GRUPO'] == "ESTUDANTE") {
                $grupo_id = 2;
            }
            else if($linha['GRUPO'] == "DOCENTE") {
                $grupo_id = 3;
            }
            else {
                $grupo_id = 1;
            }

            if(Pessoa::where('cpf', $cpf)->exists()) {
                $this->comment("usuário: " .  $linha['NOME'] . "com o cpf" . $cpf . "já cadastrado");
                continue;
            }

            $pessoa = new Pessoa;
            $pessoa->nome = $linha['NOME'];
            $pessoa->email = $linha['EMAIL'];
            $pessoa->cpf = $linha['CPF'];
            $pessoa->telefone = $linha['TELEFONE'];
            $pessoa->grupo_id = $grupo_id;
            $pessoa->save();

            $cont++;

            $this->info("usuário: " .  $linha['NOME'] . "cadastrado com sucesso!");
        }

        fclose($arquivo);

        $this->info("importação completa");
        $this->info("total de usuários inseridos: $cont");
    }
}
