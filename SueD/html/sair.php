<?php 
// terminando a sessão
session_start(); // vamos iniciar a secção
session_unset(); // vamos limpar a secção
session_destroy();// vamos destruir a secção
header('Location:../index.php'); // vamos mandar o usuário para a pagina inicial


?>