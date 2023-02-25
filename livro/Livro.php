<?php

class Livro
{
    private $mysql;

    public function __construct(mysqli $mysql)
    {
        $this->mysql = $mysql;
    }

    public function adicionarLivro($nome, $ano, $paginas)
    {
        // verificar se já existe
        $retornaLivro = $this->mysql->prepare("SELECT * FROM livro WHERE nome = ? AND ano = ?");
        $retornaLivro->bind_param('si', $nome, $ano);
        $retornaLivro->execute();
        $livro = $retornaLivro->get_result()->fetch_assoc(); // converte para um array

        if(!empty($livro)){
            return false;
        }
        else{
            // adicionar se não existe
            $insereLivro = $this->mysql->prepare('INSERT INTO 
            livro (nome, ano, paginas, emprestado) VALUES (?, ?, ?, false)');
            $insereLivro->bind_param('sii', $nome, $ano, $paginas);
            $insereLivro->execute();
            return true;
        }
    }

    public function exibirTodosLivros(): array
    {
        $todos = $this->mysql->query('SELECT id_livro, nome, ano, paginas From livro');

        $todosLivros = $todos->fetch_all(MYSQLI_ASSOC);

        return $todosLivros;
    }

    public function exibirTodosLivrosSemEmprestimo(): array
    {
        $todos = $this->mysql->query('SELECT id_livro, nome, ano, paginas From livro WHERE emprestado = false');

        $todosLivros = $todos->fetch_all(MYSQLI_ASSOC);

        return $todosLivros;
    }

    public function exibirTodosLivrosComEmprestimo(): array
    {
        $todos = $this->mysql->query('SELECT id_livro, nome, ano, paginas,id_usuario From livro WHERE emprestado = true');

        $todosLivros = $todos->fetch_all(MYSQLI_ASSOC);

        return $todosLivros;
    }

    public function livrosEmpAtivosUsuario(string $id)
    {
//        // 1 trazer os livros que estao 1 e que pertence ao usuario

        $todos = $this->mysql->prepare('SELECT id_livro FROM livro WHERE emprestado = true AND id_usuario = ?');
        $todos->bind_param('s', $id);
        $todos->execute();
        $todosLivrosUsuario = $todos->get_result()->fetch_all(MYSQLI_ASSOC);

        return $todosLivrosUsuario;

    }

    public function contagenLivrosUsuario(string $id)
    {
        $todos = $this->mysql->prepare('SELECT COUNT(id_usuario) FROM livro WHERE emprestado = true AND id_usuario = ?');
        $todos->bind_param('s', $id);
        $todos->execute();
        $todosLivrosUsuario = $todos->get_result()->fetch_all();

        return $todosLivrosUsuario;

    }


    public function exibirLivroPorId(string $id): array
    {
        $retornaLivro = $this->mysql->prepare("SELECT * FROM livro WHERE id_livro = ?");
        $retornaLivro->bind_param('s', $id);
        $retornaLivro->execute();
        $livro = $retornaLivro->get_result()->fetch_assoc(); // converte para um array

        return $livro;
    }

    public function ligaEmprestimo(string $idUsuario, string $idLivro)
    {
        $editaLivro = $this->mysql->prepare('UPDATE livro 
            SET emprestado = true, id_usuario = ? WHERE id_livro = ?');
        $editaLivro->bind_param('ss', $idUsuario, $idLivro);
        $editaLivro->execute();
    }

    public function desligaEmprestimo(string $id)
    {
        $editaLivro = $this->mysql->prepare('UPDATE livro 
            SET emprestado = false, id_usuario = null WHERE id_livro = ?');
        $editaLivro->bind_param('s', $id);
        $editaLivro->execute();
    }



}