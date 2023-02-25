<?php

require_once 'Usuario.php';
require '../conexaoBanco.php';
/*** @var $mysql */ // vem do conexaoBanco
$u = new Usuario($mysql);

session_start(); // inicia a session
require_once 'verificaLogin.php';

$usu = $u->exibirPorId($_SESSION['id_usuario']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if($_POST['senha'] == $_POST['confSenha']) {
        $u->atualizar(
            $_POST['nome'], $_POST['telefone'], $_POST['email'], $_POST['senha'], $_SESSION['id_usuario']);

        header("Location: usuarioAtualizarDados.php");
    }
    else
    {
        // imprime mensagem de erro dentro do corpo do html
        ?>
        <div class='msg-erro'>
            "Senha e confirmar senha não coorespodem !"
        </div>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="stylesheet" type="text/css" href="../reset.css">
        <link rel="stylesheet" type="text/css" href="../style.css">
        <meta charset="UTF-8">
        <title>SGB - Básico</title>
    </head>
    <body>
        <header>
            <div class="title"><h2>Sistema de Gestao de Bibliotecas - Usuario : <?php echo $usu['nome'] ?></h2></div>
            <div class="sair"><a href="sairUsuario.php">Sair</a></div>
        </header>
        <section>
            <nav>
                <ul>
                    <li><a href="usuarioIndexEmprestimos.php">Inicio</a></li>
                    <li><a href="usuarioAtualizarDados.php">Atualizar Dados</a></li>
                    <li><a href="usuarioNovoEmprestimo.php">Novo Empréstimo</a></li>
                </ul>
            </nav>
            <main>
                <form method="post">
                    <input type="text" name="nome" placeholder="Nome Completo" maxlength="30" value="<?php echo $usu['nome']; ?>">
                    <input type="text" name="telefone" placeholder="Telefone" maxlength="30" value="<?php echo $usu['telefone']; ?>">
                    <input type="email" name="email" placeholder="Usuário" maxlength="40" value="<?php echo $usu['email']; ?>">
                    <input type="password" name="senha" placeholder="Senha" maxlength="15">
                    <input type="password" name="confSenha" placeholder="Confirmar Senha" maxlength="15">
                    <input type="submit" value="ATUALIZAR">
                </form>
            </main>
        </section>

        <footer>
            <p class=".p_rodape"> Certificado de autenticidade - © todos os direitos reservados </p>
        </footer>
    </body>
</html>
