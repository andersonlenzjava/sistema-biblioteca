<?php

class Usuario
{
    private $mysql;

    public function __construct(mysqli $mysql)
    {
        $this->mysql = $mysql;
    }

    public function adicionar($nome, $telefone, $email, $senha)
    {
        // verificar se já existe
        $retornaUsuario = $this->mysql->prepare("SELECT * FROM usuarios WHERE email = ?");
        $retornaUsuario->bind_param('s', $email);
        $retornaUsuario->execute();
        $usuario = $retornaUsuario->get_result()->fetch_assoc(); // converte para um array

        if(!empty($usuario)){
            return false;
        }
        else{
            // adicionar se não existe
            $senha = md5($senha); // criptografa a senha
            $insereUsuario = $this->mysql->prepare('INSERT INTO 
            usuarios (nome, telefone, email, senha) VALUES (?, ?, ?, ?)');
            $insereUsuario->bind_param('ssss', $nome, $telefone, $email, $senha);
            $insereUsuario->execute();
            return true;
        }
    }

    public function exibirTodosUsuarios(): array
    {
        $todos = $this->mysql->query('SELECT nome, email, telefone From usuarios');

        $todosUsuarios = $todos->fetch_all(MYSQLI_ASSOC);

        return $todosUsuarios;
    }

    public function exibirPorId(string $id): array
    {
        $retornaUsuario = $this->mysql->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $retornaUsuario->bind_param('s', $id);
        $retornaUsuario->execute();
        $usuario = $retornaUsuario->get_result()->fetch_assoc(); // converte para um array

        return $usuario;
    }

    public function exibirNomePorId(string $id): array
    {
        $retornaUsuario = $this->mysql->prepare("SELECT nome FROM usuarios WHERE id_usuario = ?");
        $retornaUsuario->bind_param('s', $id);
        $retornaUsuario->execute();
        $usuario = $retornaUsuario->get_result()->fetch_assoc(); // converte para um array

        return $usuario;
    }

    public function atualizar(string $nome, string $telefone, string $email, string $senha, string $id)
        {
            $senha = md5($senha); // criptografa a senha
            $editaUsuario = $this->mysql->prepare('UPDATE usuarios 
            SET nome = ?, telefone = ?, email = ?, senha = ? WHERE id_usuario = ?');
            $editaUsuario->bind_param('sssss', $nome, $telefone, $email, $senha, $id);
            $editaUsuario->execute();
        }

    public function logar($email, $senha)
    {
        // verificar se o email e a senha estao cadastrados, se sim:
        $senha = md5($senha); // criptografa a senha
        $retornaUsuario = $this->mysql->prepare("SELECT id_usuario FROM usuarios
        WHERE email = ? AND senha = ?");
        $retornaUsuario->bind_param('ss', $email, $senha);
        $retornaUsuario->execute();
        $usuario = $retornaUsuario->get_result()->fetch_assoc(); // converte para um array

        if(!empty($usuario)) // veio algum usuário
        {
            session_start(); // inicia a session
            $_SESSION['id_usuario'] = $usuario['id_usuario']; // cria uma váriavel id e recebe o valor do id
            $_SESSION['email'] = $email;
            return true; // logado com sucesso
        }
        else {
            $_SESSION['id_usuario'] = null;
            return false; // nao foi possível logar
        }
    }

}

?>