<?php

require_once '../livro/Livro.php';
require '../conexaoBanco.php';
/*** @var $mysql */ // vem do conexaoBanco
$l = new Livro($mysql);

session_start(); // inicia a session
require 'verificaGerente.php';

$preencheTodosCampo = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(!empty($_POST['nome'])&& !empty($_POST['ano'])&& !empty($_POST['paginas'])) {
        $cadastrado = $l->adicionarLivro(
            $_POST['nome'], $_POST['ano'], $_POST['paginas']);
        echo 'Livro cadastrado com sucesso';
        header("Location: gerenteCadastrarLivro.php");
    }
    else
    {
        $preencheTodosCampo = true;
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
            <div class="title"><h2>Sistema de gerênciamento de biblioteca - SGB - Gerência</h2></div>
            <div class="sair"><a href="../usuario/sairUsuario.php">Sair</a></div>
        </header>
        <section>
            <nav>
                <ul>
                    <li><a href="gerenteIndex.php">Inicio</a></li>
                    <li><a href="gerenteAtualizarDados.php">Atualizar Dados</a></li>
                    <li><a href="gerenteControlaEmprestimos.php">Controle Emprestimos</a></li>
                    <li><a href="gerenteCadastrarLivro.php">Cadastrar Livro</a></li>
                </ul>
            </nav>
            <main>
                <form method="post">
                    <input type="text" name="nome" placeholder="Nome do Livro" maxlength="60">
                    <input type="text" name="ano" placeholder="Ano de lançamento" maxlength="5">
                    <input type="number" name="paginas" placeholder="Numero de páginas" maxlength="4">
                    <input type="submit" value="CADASTRAR LIVRO">
                    <?php if($preencheTodosCampo): ?>
                        <a href="gerenteCadastrarLivro.php">Preencha todos os campos!!!</a>
                    <?php endif; ?>
                </form>
            </main>
        </section>

        <footer>
            <p class=".p_rodape"> Certificado de autenticidade - © todos os direitos reservados </p>
        </footer>
    </body>
</html>
