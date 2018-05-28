<?php
	require_once '../core/core.init';
	require_once '../helpers/helpers.php';

	if($uid=='0'){
		header("Location: ../index.php");
	}
	if($permissao_usuario['editar_profissao']=='0'){
		header("Location: ../index.php");
	}
	
	if(isset($_GET['id'])){
		$id = sanitize($_GET['id']);

		$profissao = mysqli_fetch_assoc($db->query("SELECT profissao FROM profissao WHERE id_profissao = '$id'"));

		$nome = ((isset($_POST['nome']) && $_POST['nome'] != '')?sanitize($_POST['nome']):$profissao['profissao']);
		$editado = false;
		$obrigatorios = array('nome');

		if($_POST && !empty($_POST)){
			foreach ($obrigatorios as $campo){
				if($_POST[$campo] == ''){
					$erros[] = 'Todos os campos marcados com asteristicos são obrigatorios.';
					break;
				}
			}
		
			if(empty($erros)){
				$editado = true;
				$db->query("UPDATE profissao SET profissao='$nome' WHERE id_profissao='$id_profissao'");
			}
		}
	}
	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container">
	<?php if(!$editado) { ?>
		<div class="text-center">
			<h2>Editar Profissão</h2><hr>
			<?php if(!empty($erros)){
	            echo display_errors($erros);
	        }?>
		</div>
		<div class="row">
			<div class="col-md-2 col-lg-2 col-xl-2"></div>
			<div class="col-md-8 col-lg-8 col-xl-8">
				<form action="editar_profissao.php" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label for="nome">Profissão*:</label>
						<input type="text" id="nome" name="nome" class="form-control form-control-sm" value ="<?=$nome?>" required>
					</div>

					<div class="text-right">
						<input type="submit" class="btn btn-success" value="Editar Profissão">
					</div>
				</form>
			</div>
			<div class="col-md-2 col-lg-2 col-xl-2"></div>
		</div>
	<?php }else{ ?>
		<div class="text-center">
			Profissão <?=$nome;?> editado com sucesso.
		</div>
	<?php } ?>
</div>
<?php include '../includes/footer.php'; ?>