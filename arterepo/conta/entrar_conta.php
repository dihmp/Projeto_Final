<?php
	require_once '../core/core.init';
	require_once '../helpers/helpers.php';
	$email = ((isset($_POST['email']) && $_POST['email']!='')?sanitize($_POST['email']):'');
	$senha = ((isset($_POST['senha']) && $_POST['senha']!='')?sanitize($_POST['senha']):'');
	$criado = false;

	$obrigatorios = array('email', 'senha');
	if($_POST && !empty($_POST)){
		foreach ($obrigatorios as $campo){
			if($_POST[$campo] == ''){
				$erros[] = 'Digite a sua senha e o seu email.';
				break;
			}
		}
		$conta = mysqli_fetch_assoc($db->query("SELECT id_usuario FROM usuario WHERE email='$email' AND senha='$senha'"));

		if($conta!=null){
			login($conta['id_usuario']);
		}else{
			$erros[] = 'Email ou senha incorretos.';
		}
	}
	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container">
	<div class="row">
		<div class="col-md-2 col-lg-2 col-xl-2"></div>
		<div class="col-md-8 col-lg-8 col-xl-8">
			<h2 class="text-center">Entrar na Conta</h2><hr>
			<form action="entrar_conta.php" method="POST" enctype="multipart/form-data">

				<div class="form-group">
					<label for="email">Email*:</label>
					<input type="text" id="email" name="email" class="form-control form-control-sm" value="<?=$email;?>" required>
				</div>

				<div class="form-group">
					<label for="senha">Senha*:</label>
					<input type="password" id="senha" name="senha" class="form-control form-control-sm" required>
				</div>

				<div class="text-right">
					<input type="submit" class="btn btn-success" value="Entrar">
				</div>
			</form>
		</div>
		<div class="col-md-2 col-lg-2 col-xl-2"></div>
	</div>
</div>
<?php include '../includes/footer.php' ?>