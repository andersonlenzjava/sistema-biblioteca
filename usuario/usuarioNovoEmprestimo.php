<?php
require '../conexaoBanco.php';
require_once 'Usuario.php';
require_once '../livro/Livro.php';
require_once '../emprestimo/Emprestimo.php';

/*** @var $mysql */ // vem do conexaoBanco
$l = new Livro($mysql);
$livros = $l->exibirTodosLivrosSemEmprestimo();

session_start(); // inicia a session
$u = new Usuario($mysql);
require_once 'verificaLogin.php';

$usu = $u->exibirPorId($_SESSION['id_usuario']);

$e = new Emprestimo($mysql);

$hoje = new DateTimeImmutable();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if((!empty($_POST['livro'])) && (!empty($_POST['dias'])) && (!empty($_SESSION['id_usuario'])))
        {
            $e->adicionarEmprestimo($_POST['livro'], $_SESSION['id_usuario'], ($hoje->format('Y/m/d')), $_POST['dias']);
            $l->ligaEmprestimo($_SESSION['id_usuario'], $_POST['livro']);
            header("Location: usuarioNovoEmprestimo.php");
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
                    <select type="number" name="livro">
                        <?php foreach ($livros as $livro): ?>
                        <option value="<?php echo $livro['id_livro']; ?>"><?php echo $livro['id_livro'].' - '.$livro['nome'].' - '.$livro['ano'].' - '.$livro['paginas']."p"; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="dias">
                        <option value="7">7 - Dias</option>
                        <option value="14">14 - Dias</option>
                        <option value="21">21 - Dias</option>
                    </select>
                    <input type="submit" value="EMPRESTAR">
                </form>
            </main>
        </section>

        <footer>
            <p class=".p_rodape"> Certificado de autenticidade - © todos os direitos reservados </p>
        </footer>
    </body>
</html>
