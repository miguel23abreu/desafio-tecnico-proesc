<?php

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class relatorioFinanceiro extends Command {

    protected $name = 'sql:run';

    protected $description = 'Executa um SELECT de um arquivo SQL e exibe o resultado.';

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $caminho = $this->ask("Informe o caminho do arquivo .sql");

        if (!file_exists($caminho)) {
            $this->error("Arquivo não encontrado: $caminho");
            return;
        }

        $sql = file_get_contents($caminho);

        $this->info("Executando consulta...");
        $this->comment($sql);

        try {
            $resultados = DB::select(DB::raw($sql));
        } catch (Exception $e) {
            $this->error("Erro ao executar SQL: " . $e->getMessage());
            return;
        }

        if (empty($resultados)) {
            $this->info("Nenhum resultado encontrado.");
            return;
        }

        $this->info("\n--- RESULTADO ---");

        foreach ($resultados as $linha) {
            $array = (array) $linha;

            $saida = [];
            foreach ($array as $campo => $valor) {
                $saida[] = "$campo: $valor";
            }

            $this->info(implode(" | ", $saida));
        }

        $this->info("\nConsulta concluída com sucesso!");
    }
}
