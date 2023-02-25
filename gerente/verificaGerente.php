<?php

if (!($_SESSION['email'] === 'gerente@gerente.com'))
{
    unset($_SESSION['id_usuario']);
    header("location: ../index.php");
    exit();
}

?>