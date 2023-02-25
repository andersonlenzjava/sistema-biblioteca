<?php

require_once 'usuario/Usuario.php';
require 'conexaoBanco.php';
/*** @var $mysql */ // vem do conexaoBanco
$u = new Usuario($mysql);

$emailSenhaIncorretos = false;
$preenchaTodosCampos = false;


if(isset($_POST['email']))
{
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if(!empty($email) && !empty($senha))
    {
        if($u->logar($email, $senha))
        {
            if($email == 'gerente@gerente.com')
            {
                //VERIFICAÇÃO DO ADMINISTRADOR
                header("Location: gerente/gerenteIndex.php");
            }
            else{
                header("Location: usuario/usuarioIndexEmprestimos.php");
            }
        }
        else {$emailSenhaIncorretos = true;}
    }
    else {$preenchaTodosCampos = true;}
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="index_style.css">
        <meta charset="UTF-8">
        <title>SGB - Básico</title>
    </head>
    <body>
        <header>
            <div class="title"><h2>Sistema de gerênciamento de biblioteca - SGB</h2></div>
        </header>
        <main>
            <div id="corpo-form">
                <form method="post">
                    <input type="email" name="email" placeholder="Usuário">
                    <input type="password" name="senha" placeholder="Senha">
                    <input type="submit" value="ACESSAR!">
                    <a href="usuario/usuarioCadastrar.php">Ainda não é inscrito?<strong> Cadastre-se!</strong></a>
                    <?php if ($emailSenhaIncorretos): ?>
                        <a href="index.php">Email e/ou senha estão incorretos!!</a>
                    <?php endif; ?>
                    <?php if($preenchaTodosCampos): ?>
                        <a class="msgE" href="index.php">Preencha todos os campos!!</a>
                    <?php endif; ?>
                </form>
            </div>
        </main>
    </body>
</html>
