<?php
$usuario = "root";
$senha = "";
$servidor = "localhost";
$bd = "atividade3_qts";
$conexao = new PDO("mysql:host=".$servidor.";dbname=".$bd,
            $usuario,
            $senha,		
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "
                SET NAMES utf8"));
?>