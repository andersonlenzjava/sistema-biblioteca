<?php

if(!isset($_SESSION['id_usuario'])) // se não se logar redirecionada
{
    header("location: ../index.php");
    exit();
}
