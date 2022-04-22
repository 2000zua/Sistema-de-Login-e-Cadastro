<?php
// conexão 
require_once '../config/conexao.php';
require_once '../requires/header.php';
// secção
session_start();
// Verificação de saída
if(!isset($_SESSION['comfirmado'])):
    header('Location: ../index.php');
endif;

//acessando os dados do usuário no banco de dados
$id = $_SESSION['id'];
$sql = "SELECT * FROM usuario WHERE id = '$id'";
$resultado = mysqli_query($connect, $sql);
$dados = mysqli_fetch_array($resultado);
mysqli_close($connect);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SueД</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" type="text/css" href="../css/doc.css"><!--Css geral-->
	<link rel="stylesheet" type="text/css" href="../boot/bootstrap.min.css"><!--Css Bootstrap-->
	<link rel="stylesheet" type="text/css" href="../icons/all.min.css"><!--font icons-->
</head>
<body>
    <div class=" container mt-5 text-center">
    <h1 class=" display-4">Olá <?php echo $dados['nome'] ?> <?php echo $dados['sobrenome']; ?></h1>
    <a href="sair.php" class=" btn btn-danger">Sair</a>
    </div>

    <!--Seccção de js-->
    <script type="text/javascript" src="boot/popper.min.js"></script>
    <script type="text/javascript" src="boot/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/doc.js"></script>
</body>
</html>