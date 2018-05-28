<?php
	require_once '../core/core.init';
	require_once '../helpers/helpers.php';
	$nome      = ((isset($_POST['nome'])  && $_POST['nome']     !='')?sanitize($_POST['nome']):'');
	$email = ((isset($_POST['email']) && $_POST['email']!='')?sanitize($_POST['email']):'');
	$senha = ((isset($_POST['senha']) && $_POST['senha']!='')?sanitize($_POST['senha']):'');
	$confirmar = ((isset($_POST['confirmar']) && $_POST['confirmar']!='')?sanitize($_POST['confirmar']):'');
	$criado = false;

	$obrigatorios = array('nome', 'email', 'senha', 'confirmar');
	if($_POST && !empty($_POST)){
		foreach ($obrigatorios as $campo){
			if($_POST[$campo] == ''){
				$erros[] = 'Todos os campos marcados com asteristicos são obrigatorios.';
				break;
			}
		}
		if($senha!=$confirmar){
			$erros[] = 'As senhas devem ser iguais.';
		}
		$emails = $db->query("SELECT * FROM usuario WHERE email='$email'");
		if(mysqli_num_rows($emails)>0){
			$erros[] = 'Esse email ja foi cadastrado.';
		}
		if(empty($erros)){
			$db->query("INSERT INTO usuario (nome, email, senha, id_permissao) VALUES ('$nome', '$email', '$senha', '2')");
			$criado = true;
		}
	}
	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container">
	<?php if(!$criado) { ?>
		<div class="row">
			<div class="col-md-2 col-lg-2 col-xl-2"></div>
			<div class="col-md-8 col-lg-8 col-xl-8">
				<h2 class="text-center">Criar Conta</h2><hr>
				<form action="criar_conta.php" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label for="nome">Nome*:</label>
						<input type="text" id="nome" name="nome" class="form-control form-control-sm" value="<?=$nome;?>" required>
					</div>

					<div class="form-group">
						<label for="email">Email*:</label>
						<input type="text" id="email" name="email" class="form-control form-control-sm" value="<?=$email;?>" required>
					</div>

					<div class="form-group">
						<label for="senha">Senha*:</label>
						<input type="password" id="senha" name="senha" class="form-control form-control-sm" required>
					</div>

					<div class="form-group">
						<label for="confirmar">Confirmar Senha*:</label>
						<input type="password" id="confirmar" name="confirmar" class="form-control form-control-sm" required>
					</div>

					<div class="text-right">
						<input type="submit" class="btn btn-success" value="Criar Conta">
					</div>
				</form>
			</div>
			<div class="col-md-2 col-lg-2 col-xl-2"></div>
		</div>
	<?php }else{ ?>
		A sua conta foi criada com sucesso.
	<?php } ?>
</div>
<?php include '../includes/footer.php' ?>