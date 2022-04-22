<?php
//Secção
session_start();

//Conexão com banco de dados
require_once 'conexao.php';

// header ou cabeçário
require_once '../requires/header.php';

// Segurança do site
function limpar($input){
    global $connect;
    //sql
    $var = mysqli_escape_string($connect, $input);
    //xss = um tipo de ataque haquer
    $var = htmlspecialchars($var);
    return $var;
}
//Verificar se o usário clicou no botão cadastrar

if(isset($_POST['cadastrar'])):
   
    $erros = array(); // erros
    
    // Pegar os dados digitados
    $nome = limpar($_POST['nome']); 
    $sobrenome = limpar($_POST['sobrenome']); 
    $email = limpar($_POST['email']); 
    $senha = limpar($_POST['senha']); 
    $senha1 = limpar($_POST['senha1']);
    $contato = limpar($_POST['contato']); 
    $nacionalidade = limpar($_POST['nacionalidade']); 
    $nascimento = limpar($_POST['nascimento']); 
    $profissao = limpar($_POST['profissao']); 

    // verificar se os dados inseridos estão vazios
    if (empty($nome) or empty($sobrenome) or empty($email) or empty($senha) or empty($contato)
    or empty($nacionalidade) or empty($nascimento) or empty($profissao)){
        $erros[] ="Os campos devem ser todos preenchidos";
    }else{
        if ($senha != $senha1){
            $erros[] ="As senhas são incompativeis";
        }else {
            $senhaN = md5($senha);
            //verificar se os dados j+a existe
            $sql ="SELECT email, contato FROM usuario WHERE email ='$email'";
            $svg = " SELECT contato FROM usuario WHERE contato = '$contato'";
            $resultado1 = mysqli_query($connect , $sql);
            $resultado2 = mysqli_query($connect, $svg);
            if (mysqli_num_rows($resultado1) > 0 or mysqli_num_rows($resultado2)) {
                $erros[]="Este usuário já está registrado no sistema";
            }else{
                // Se os dados não estiverem fazios vamos aplicar as seguintes instruções
                $sql = "INSERT INTO usuario(nome, sobrenome, email, senha, contato, nacionalidade, nascimento, profissao) VALUES ('$nome','$sobrenome','$email','$senhaN', '$contato','$nacionalidade','$nascimento','$profissao')";
                $resultado = mysqli_query($connect , $sql);
                $_SESSION['cadastrado']=true;
                mysqli_close($connect);//fechar o banco de dados
                header('Location: ../index.php');   
            }
        }
    }

endif;

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
    <h2 class=" display-4">Cadastrar novo membro</h2>
    <form action="cadastrar.php" method="post">
        <div class=" form-floating mt-3 mb-3 m-auto w-75">
            <input type="text" name="nome" class=" form-control" id="nome" >
            <label for="nome">Primeiro nome:</label>
        </div>
        <div class=" form-floating mt-3 mb-3 m-auto w-75">
            <input type="text" name="sobrenome" class=" form-control" id="sobrenome" >
            <label for="sobrenome">Ultimo nome:</label>
        </div>
        <div class=" form-floating mt-3 mb-3 m-auto w-75">
            <input type="email" name="email" class=" form-control" id="email" >
            <label for="email">Digite o seu email</label>
        </div>
        <div class=" form-floating mt-3 mb-3 m-auto w-75">
            <input type="password" name="senha1" class=" form-control" id="password" >
            <label for="password">Digite a sua senha:</label>
        </div>
        <div class=" form-floating mt-3 mb-3 m-auto w-75">
            <input type="password" name="senha" class=" form-control" id="senha" >
            <label for="senha">Digite novamente a sua senha:</label>
        </div>
        <div class=" form-floating mt-3 mb-3 m-auto w-75">
            <input type="text" name="contato" class=" form-control" id="contato" >
            <label for="contato">Digite o seu contato</label>
        </div>
        <div class=" form-floating mt-3 mb-3 m-auto w-75">
            <input type="text" name="nacionalidade" class=" form-control" id="nacionalidade" >
            <label for="nacionalidade">Sua nacionalidade</label>
        </div>
        <div class=" form-floating mt-3 mb-3 m-auto w-75">
            <input type="datatime" name="nascimento" class=" form-control" id="nascimento" >
            <label for="nascimento">Data de nascimento: ano/mes/dia</label>
        </div>
        <div class=" form-floating mt-3 mb-3 m-auto w-75">
            <input type="text" name="profissao" class=" form-control" id="profissao" >
            <label for="profissao">Profissão</label>
        </div>
        <button name="cadastrar" type="submit" class="btn btn-info mt-3 w-50">Cadastrar</button>
        <a href="../index.php" class=" btn btn-primary mt-3 mb-3 w-50">Login</a>       
    </form>
    <?php if(!empty($erros)){
						foreach ($erros as $erro) {
								echo "<h4 style='color:#fff; background:#900;padding:5px; float:left;border:2px solid #ccc; border-radius: 12px; margin-top: -905px; margin-left:-50px'>$erro</h4>";
						}
			} ?>
            <a href="../index.php" class="  mt-1 mb-5 me-5">Voltar</a>
        </div>

    <!--Seccção de js-->
    <script type="text/javascript" src="../boot/popper.min.js"></script>
    <script type="text/javascript" src="../boot/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../js/doc.js"></script>
</body>
</html>
