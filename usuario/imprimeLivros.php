<?php

function imprimeLivros($listLivros, $dadosEmprestimos)
{
    if((sizeof($listLivros)) > 0)
    {
        ?>
        <table title="Livro(s)">
            <tr><th colspan="5">Livros</th></tr>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Ano</th>
                <th>Pag.</th>
            </tr>
            <?php foreach ($listLivros as $livro): ?>
                <tr>
                    <th><?php echo $livro['id_livro'] ?></th>
                    <th><?php echo $livro['nome']; ?></th>
                    <th><?php echo $livro['ano']; ?></th>
                    <th><?php echo $livro['paginas'].'p'; ?></th>
                </tr>
            <?php endforeach; ?>
        </table>
        <table title="Dados emprestimos">
            <tr><th colspan="5">Dados do emprestimo</th></tr>
            <tr>
                <th>Data emprestimo</th>
                <th>Dias</th>
                <th>Data devolução</th>
            </tr>
            <?php foreach ($dadosEmprestimos as $emprestimo): ?>
                <tr>
                    <th><?php echo $emprestimo["dataEmprestimo"]; ?></th>
                    <th><?php echo $emprestimo['diasDeEmprestimo']; ?></th>
                    <th><?php echo $emprestimo['dataDeDevolucao']; ?></th>
                </tr>
            <?php endforeach; ?>
        </table>


        <?php
    }
}