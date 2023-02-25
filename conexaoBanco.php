<?php

$msgErro = "";
$mysql = "";

try{
    $mysql = new mysqli('localhost','root', '', 'sgb_basico');
    $mysql->set_charset('utf8');
} catch (Exception $e){
    $msgErro = $e->getMessage();
}

if ($mysql){
} else {
    echo "Erro: ". $msgErro;
}
?>