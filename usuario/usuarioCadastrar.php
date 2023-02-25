<?php

require_once 'Usuario.php';
require '../conexaoBanco.php';
/*** @var $mysql */ // vem do conexaoBanco
$u = new Usuario($mysql);

$camposVazio = false;
$senhasNCorrespode = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(!empty($_POST['nome'])&& !empty($_POST['telefone'])&& !empty($_POST['email'])&&
        !empty($_POST['senha'])&& !empty($_POST['confSenha']))
        {
        if ($_POST['senha'] == $_POST['confSenha']) {
            $u->adicionar(
                $_POST['nome'], $_POST['telefone'], $_POST['email'], $_POST['senha']);

            header("Location: ../index.php");
        } else {
            $senhasNCorrespode = true;
        }
    }
    else
    {
        $camposVazio = true;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="stylesheet" type="text/css" href="../reset.css">
        <link rel="stylesheet" type="text/css" href="../index_style.css">
        <meta charset="UTF-8">
        <title>SGB - Básico</title>
    </head>
    <body>
        <header>
            <div class="title"><h2>Cadastre-se | Preencha os seus dados</h2></div>
        </header>
            <main>
                <form method="post">
                    <input type="text" name="nome" placeholder="Nome Completo" maxlength="30">
                    <input type="text" name="telefone" placeholder="Telefone" maxlength="30">
                    <input type="email" name="email" placeholder="Usuário" maxlength="40">
                    <input type="password" name="senha" placeholder="Senha" maxlength="15">
                    <input type="password" name="confSenha" placeholder="Confirmar Senha" maxlength="15">
                    <input type="submit" value="CADASTRAR">
                    <a href="../index.php"><h2>Voltar para o inicio</h2></a>
                    <?php if ($camposVazio): ?>
                        <div class='msg-erro'>"Pre-encha todos os campos !"</div>
                        <?php endif;
                    if ($senhasNCorrespode): ?>
                        <div class='msg-erro'>"Senha e confirmar senha não coorespodem !"</div>
                        <?php endif; ?>
                </form>
            </main>
    </body>
</html>
