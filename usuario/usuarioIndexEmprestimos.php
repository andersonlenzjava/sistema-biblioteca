<?php

require_once '../livro/Livro.php';
require '../conexaoBanco.php';
require_once '../usuario/Usuario.php';
require_once '../emprestimo/Emprestimo.php';
require_once '../emprestimo/retornaLivrosStatus.php';
require_once '../emprestimo/estadoDoEmprestimo.php';
require_once 'imprimeLivros.php';

/*** @var $mysql */ // vem do conexaoBanco
$l = new Livro($mysql);
$u = new Usuario($mysql);
$e = new Emprestimo($mysql);

session_start(); // inicia a session
require_once 'verificaLogin.php';

$usu = $u->exibirPorId($_SESSION['id_usuario']);

// Retorna os emprestimos, os livros e os dados dos emprestimos com mais de 7 dias para devolver
$emprestimosEmDiaMaisDeSete = livrosEmprestimos(
        $_SESSION['id_usuario'], $e, $l, EstadoDoEmprestimo::MaisDeSeteDiasEmDia);
$livrosEmDiaMaisDeSete = retornaLivros($emprestimosEmDiaMaisDeSete, $l);
$dadosEmprestimoMaisDeSete = retornaDetalhesEmprestimos($emprestimosEmDiaMaisDeSete);
//======================================================================================================

// Retorna os emprestimos, os livros e os dados dos emprestimos com menos de 7 dias para devolver
$emprestimosEmDiaMenosDeSete = livrosEmprestimos(
    $_SESSION['id_usuario'], $e, $l, EstadoDoEmprestimo::MenosDeSeteDias);
$livrosEmDiaMenosDeSete = retornaLivros($emprestimosEmDiaMenosDeSete, $l);
$dadosEmprestimoMenosDeSete = retornaDetalhesEmprestimos($emprestimosEmDiaMenosDeSete);
//======================================================================================================

// Retorna os emprestimos, os livros e os dados dos emprestimos com menos de 7 dias para devolver
$emprestimosVencidos = livrosEmprestimos(
    $_SESSION['id_usuario'], $e, $l, EstadoDoEmprestimo::Vecidos);
$livrosVencidos = retornaLivros($emprestimosVencidos, $l);
$dadosEmprestimoVencido = retornaDetalhesEmprestimos($emprestimosVencidos);
//======================================================================================================

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
                <?php if((sizeof($livrosVencidos)) > 0) { ?>
                <div class="vencidos"><p>Emprestimos vencidos!!</p></div><?php } ?>
                <section><?php imprimeLivros($livrosVencidos, $dadosEmprestimoVencido); ?></section>

                <?php if((sizeof($livrosEmDiaMaisDeSete)) > 0) { ?>
                <div class="proxPrazo"><p>Emprestimos em dia com mais de 7 dias de prazo</p></div> <?php } ?>
                <section><?php imprimeLivros($livrosEmDiaMaisDeSete, $dadosEmprestimoMaisDeSete); ?></section>

                <?php if((sizeof($livrosEmDiaMenosDeSete)) > 0) { ?>
                <div class="noPrazo"><p>Emprestimos em dia com menos de 7 dias de prazo</p></div> <?php } ?>
                <section><?php imprimeLivros($livrosEmDiaMenosDeSete, $dadosEmprestimoMenosDeSete); ?></section>
            </main>
        </section>

        <footer>
            <p class=".p_rodape"> Certificado de autenticidade - © todos os direitos reservados </p>
        </footer>
    </body>
</html>
