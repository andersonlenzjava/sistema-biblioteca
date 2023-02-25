<?php

require_once '../livro/Livro.php';
require '../conexaoBanco.php';
require_once '../usuario/Usuario.php';
require_once '../emprestimo/Emprestimo.php';

/*** @var $mysql */ // vem do conexaoBanco
$l = new Livro($mysql);
$livros = $l->exibirTodosLivrosComEmprestimo();

$u = new Usuario($mysql);

session_start(); // inicia a session
require 'verificaGerente.php';

$usu = $u->exibirPorId($_SESSION['id_usuario']);

$e = new Emprestimo($mysql);

$hoje = new DateTimeImmutable();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if((!empty($_POST['livro'])) && (!empty($_SESSION['id_usuario'])))
        {
            $l->desligaEmprestimo($_POST['livro']);
            header("Location: gerenteControlaEmprestimos.php");
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
                <form method="post" class="LivrosELocador">
                    <select type="number" name="livro" class="LivrosELocador">
                        <?php foreach ($livros as $livro): ?>
                        <option value="<?php echo $livro['id_livro']; ?>">
                            <?php
                            $usuario = $u->exibirPorId($livro['id_usuario']);
                            echo $livro['id_livro'].' - '.$livro['nome'].' - '.$livro['ano'].
                                ' - '.$livro['paginas']."p".' - Locador atual: '.$usuario['nome'];
                            ?>
                        </option>
                        <?php endforeach;
                        ?>
                        <input type="submit" value="DEVOLVER LIVRO" class="LivrosELocador">
                    </select>
                </form>
            </main>
        </section>

        <footer>
            <p class=".p_rodape"> Certificado de autenticidade - © todos os direitos reservados </p>
        </footer>
    </body>
</html>
