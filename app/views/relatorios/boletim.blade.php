@extends('layouts.main')

@section('title', 'BOLETIM')

@section('content')
    <style>
        .tabela-boletim {
            width: 80%;
            font-size: 13px; 
            text-align: center;
            margin: 0 auto;
        }

        .tabela-boletim-handler {
            width: 80%;
            font-size: 13px; 
            text-align: left;
            margin: 0 auto;
        }

        .tabela-boletim th,
        .tabela-boletim td {
            padding: 6px; 
            white-space: nowrap; 
        }

        .tabela-boletim thead th {
            font-size: 14px;
        }

        .container-boletim {
            max-width: 98%; 
        }
    </style>

    <div class="container-boletim mt-5">
        <h2 class="text-center mb-4">BOLETIM</h2>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered mb-4 tabela-boletim-handler">
                    <tbody>
                        <tr>
                            <th scope="row" class="text-left">ALUNO: {{ $aluno->nome }}</th>
                            <td class="text-left">TURMA: {{ $aluno->turma_nome }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4 class="text-center mb-3">NOTAS</h4>
                <table class="table table-bordered tabela-boletim">
                    <thead>
                        <tr>
                            <th style="text-align: center; font-size: 14px;" scope="col">DISCIPLINAS</th>
                            @foreach ($diarios as $diario)
                                <th scope="col" colspan="3"> {{ $diario->periodo_nome }} </th>
                            @endforeach
                                <th scope="col"> {{ 'NOTA FINAL' }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($disciplinas as $disciplina)
                            <tr>
                                <th scope="row"> {{$disciplina->disciplina_nome}} </th>
                                    @foreach ($avaliacoes as $avaliacao)
                                        @if ($avaliacao->disciplina_id == $disciplina->disciplina_id)
                                            @foreach ($notas_periodos as $nota_periodo)
                                                @if ($nota_periodo->avaliacao_id == $avaliacao->avaliacao_id && $nota_periodo->disciplina_id == $avaliacao->disciplina_id)
                                                    <td>N. mínima: 70</td>
                                                    <td>N. máxima: 100</td>
                                                    @if ($nota_periodo->valor_nota < 70)
                                                        <td style="background-color: red; color: white;"> {{ $nota_periodo->valor_nota }} </td>
                                                    @else
                                                        <td style="background-color: green; color: white;"> {{ $nota_periodo->valor_nota }} </td>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach

                                    @foreach ($notas_finais as $nota_final)
                                        @if ($nota_final['disciplina_id'] == $disciplina->disciplina_id)
                                            @if ($nota_final['valor_nota'] < 70)
                                                <td style="background-color: red; color: white;"> {{ $nota_final['valor_nota'] }} </td>
                                            @else
                                                <td style="background-color: green; color: white;"> {{ $nota_final['valor_nota'] }} </td>
                                            @endif
                                        @endif
                                    @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection