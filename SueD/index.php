<?php 

//Conexão
require_once 'config/conexao.php';

//Seção
session_start();

//Segurança , vamos criar uma função para fazer a filtração e limpeza dos dados digitados pelo usuaário
// Segurança do site
function limpar($input){
    global $connect;
    //sql
    $var = mysqli_escape_string($connect, $input);
    //xss = um tipo de ataque haquer
    $var = htmlspecialchars($var);
    return $var;
}

// Secção para fazer o trado do dados digitados pelo usuário
if(isset($_POST['entrar'])):
    $erros = array();
    $email = limpar($_POST['email']);
    $senha = limpar($_POST['senha']);
    //Vamos verificar se os campos email e senha estão vazios
    if(empty($email) or empty($senha)):
        $erros[]="<li> Os campos email/senha devem ser preenchidos </li>"; 
    else:
		// Se os dados não forem fazios, vamos veriricar os dados inseridos com os dados do banco de dados
		$sql = "SELECT email FROM usuario WHERE email = '$email'";
		$resultado = mysqli_query($connect, $sql);
		if(mysqli_num_rows($resultado) > 0){
			$senhaN = md5($senha); // agora vamos criptográfar a senha do usuario para comparar com a senha do Banco de dados
			$sql = "SELECT*FROM usuario WHERE email = '$email' AND senha = '$senhaN'";
			$resultado = mysqli_query($connect , $sql);
			if(mysqli_num_rows($resultado) == 1): // Verificar se existe no banco de dados um linha aonde esses dados existe, se existir vamos dar acesso ao usuario a pagina inicial
				$resul_busca = mysqli_fetch_array($resultado);//pegando os dados da variavel $resultado
				mysqli_close($connect);// fechar a conexão com o banco de dados
				//Vamos criar a secção para guardar os dados encontrados
				$_SESSION['comfirmado'] = true;
				$_SESSION['id'] = $resul_busca['id'];
				header('Location: html/home.php');
			else:
				$erros[]="Email/senha invalida verifica os dados digitados";
			endif;
		}else{
			$erros[] ="Você não está cadastrado, faça o seu cadastramento agora";
		};
    endif;

endif;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SueD</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" type="text/css" href="../SueД/css/doc.css"><!--Css geral-->
	<link rel="stylesheet" type="text/css" href="boot/bootstrap.min.css"><!--Css Bootstrap-->
</head>
<body>
	<div class=" container mt-5 text-center">
		<div class=" form-signin w-50 m-auto">
			<form action="index.php" method="post" class=" d-block">

				<span class=" mb-3 display-2 p-2" style="border-radius: 15px; color:#5096feb0; font-weight: bold">SueD</span>
				<div class="form-floating mt-3 mb-3">
				<input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
				<label for="email">Email address</label>
				</div>
				<div class="form-floating mt-3 mb-3">
				<input type="password" class="form-control" name="senha" id="senha" placeholder="Password">
				<label for="senha">Password</label>
				</div>
				<button class="w-50 btn btn-lg btn-primary" type="submit" name="entrar">Sign in</button> <br>
				<a href="config/cadastrar.php" class="btn btn- mt-2 mb-5" name="cadastrar">Cadastrar-se</a>

				<p class="mt-5 mb-5 text-muted">&copy; Angelo Abreu Zua</p>
				
			</form>
		</div>
			<!--Erro ao cadastrara-->
			<?php if(!empty($erros)){
						foreach ($erros as $erro) {
								echo "<h4 style='color:#fff; background:#900;padding:5px; float:left;border:2px solid #ccc; border-radius: 12px; margin-top: -545px; margin-left:-50px'>$erro</h4>";
						}
			} 
			// Novo cadastro com sucesso
		if(isset($_SESSION['cadastrado'])){
			echo "<h2 style='color:#fff; background:#45cc67;padding:5px; float:left;border:2px solid #ccc; border-radius: 12px; margin-top: -548px; margin-left:-50px'>Cadastrado com sucesso, faça o login</h2>"; 
			session_unset();
		}?>

	</div>

	<!--Seccção de js-->
	<script type="text/javascript" src="boot/popper.min.js"></script>
	<script type="text/javascript" src="boot/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="js/doc.js"></script>
</body>
</html>
