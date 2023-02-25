<?php

require_once '../livro/Livro.php';
require '../conexaoBanco.php';
/*** @var $mysql */ // vem do conexaoBanco
$l = new Livro($mysql);
$livros = $l->exibirTodosLivros();

session_start(); // inicia a session
require 'verificaGerente.php';

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
        <table title="Livros" class="tabelaIndexGerente">
            <tr><th colspan="5">Todos os Livros</th></tr>
            <tr>
                <th>id</th>
                <th>Livro</th>
                <th>Ano</th>
                <th>n° de Paginas</th>
            </tr>
            <?php foreach ($livros as $livro): ?>
                <tr>
                    <th><?php echo $livro['id_livro']; ?></th>
                    <th><?php echo $livro['nome']; ?></th>
                    <th><?php echo $livro['ano']; ?></th>
                    <th><?php echo $livro['paginas']; ?></th>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
</section>

<footer>
    <p class=".p_rodape"> Certificado de autenticidade - © todos os direitos reservados </p>
</footer>
</body>
</html>
