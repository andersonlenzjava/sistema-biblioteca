<?php

class Emprestimo
{
    private $mysql;

    public function __construct(mysqli $mysql)
    {
        $this->mysql = $mysql;
    }

    public function adicionarEmprestimo($idLivro, $idUsuario, $dataEmprestimo, $diasEmprestimo)
    {
        $insereEmprestimo = $this->mysql->prepare('INSERT INTO 
            emprestimos (id_livro, id_usuario, data_emprestimo, dias_emprestimos) VALUES (?, ?, ?, ?)');
        $insereEmprestimo->bind_param('iisi', $idLivro, $idUsuario, $dataEmprestimo, $diasEmprestimo);
        $insereEmprestimo->execute();
        return true;
    }

    public function retornaEmprestimosAtivos($livroid)
    {
        $emprestimos = $this->mysql->prepare('SELECT * FROM emprestimos WHERE id_livro = ?');
        $emprestimos->bind_param('s', $livroid);
        $emprestimos->execute();
        $emprestimosAtivos = $emprestimos->get_result()->fetch_assoc();

        return $emprestimosAtivos;
    }

}