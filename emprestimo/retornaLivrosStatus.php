<?php

// retorna livros filtrados dos emprestimos selecionados
function retornaLivros($emprestimosFiltrados, $l)
{
    $listLivros = [];
    foreach ($emprestimosFiltrados as $emprestimos)
    {
        $livro = $l->exibirLivroPorId($emprestimos['id_livro']);
        $listLivros[] = $livro;
    }
    return $listLivros;
}

function retornaDetalhesEmprestimos($emprestimosFiltrados)
{
    // algum método que retorne os dias dos empréstimos e imprima uma vez que são em ordem
    $listDetalhesEmprestimos = [];
    foreach ($emprestimosFiltrados as $emprestimo)
    {
        $dataDoEmprestimo = new DateTimeImmutable($emprestimo['data_emprestimo']);
        $dataDoEmprestimoStr = $dataDoEmprestimo->format('d-m-Y');

        $dataDevolucao = $dataDoEmprestimo->add(new DateInterval('P'.$emprestimo['dias_emprestimos'].'D'));
        $dataDevolucaoStr = $dataDevolucao->format('d-m-Y');

        $dadosEmprestimos = ["dataEmprestimo" => $dataDoEmprestimoStr,
            "diasDeEmprestimo" => $emprestimo['dias_emprestimos'],
            "dataDeDevolucao" => $dataDevolucaoStr];
        $listDetalhesEmprestimos[] = $dadosEmprestimos;
    }
    return $listDetalhesEmprestimos;
}

function livrosEmprestimos($idUsuario, $e, $l, EstadoDoEmprestimo $estadoDoEmprestimo)
{
    // 1 trazer os livros que estao 1 e que pertence ao usuario
    $livrosEmprestados = [];
    $livrosEmprestados[] = $l->livrosEmpAtivosUsuario($idUsuario);

    $contagemLivros = $l->contagenLivrosUsuario($idUsuario);
    $numeroLivros = $contagemLivros[0][0];

    // 2 pegar a data de cada livro e trazer para manipulavel
    $emprestimosUsuario = [];
    for ($i = 0; $i < $numeroLivros; $i++)
    {
        $livroid = $livrosEmprestados[0][$i]['id_livro'];
        $emprestimosUsuario [] = $e->retornaEmprestimosAtivos($livroid);
    }

    $emprestimosNoPrazo = [];

    // 3 calcular a data de vencer
    foreach ($emprestimosUsuario as $emprestimo)
    {
        $dataDoEmprestimo = new DateTimeImmutable($emprestimo['data_emprestimo']);
        $dataDevolucao = $dataDoEmprestimo->add(new DateInterval('P'.$emprestimo['dias_emprestimos'].'D'));
        $dataHoje = new DateTimeImmutable();
        $diasFaltantes = $dataHoje->diff($dataDevolucao);

/////////////////////////////////////////////////////////////////////////////////////

        // comparação de datas e segregação dos emprestimos, conforme o tipo solicitado
        if (( EstadoDoEmprestimo::MaisDeSeteDiasEmDia == $estadoDoEmprestimo) &&
            ($dataDevolucao > $dataHoje) && ($diasFaltantes->d > 6))
        {
            $emprestimosNoPrazo[] = $emprestimo;
        }

        if ((EstadoDoEmprestimo::MenosDeSeteDias == $estadoDoEmprestimo) &&
            ($dataDevolucao >= $dataHoje) && ($diasFaltantes->d <= 6))
        {
            $emprestimosNoPrazo[] = $emprestimo;
        }

        if ((EstadoDoEmprestimo::Vecidos == $estadoDoEmprestimo) &&
            ($dataDevolucao < $dataHoje))
        {
            $emprestimosNoPrazo[] = $emprestimo;
        }
////////////////////////////////////////////////////////////////////////////////////////
    }
    return $emprestimosNoPrazo;
}
