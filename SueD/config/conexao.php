<?php
/*Secção para fazer a conexão com a banco de dados*/

$servidor = "localhost";
$usuario ="root";
$password = "";
$bdnome= "sued";
$connect = mysqli_connect($servidor, $usuario, $password, $bdnome);
if(mysqli_connect_error()):
    echo "Erro na conexão com a banco de dados".mysqli_connect_error();
endif;

//email:admin@admin.com senha: admin

