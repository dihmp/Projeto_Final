<?php
	require_once '../core/core.init';
	require_once '../helpers/helpers.php';

	if($uid=='0'){
		header("Location: ../index.php");
	}
	if($permissao_usuario['editar_genero']=='1'){
		$generoQ = $db->query("SELECT id_genero, genero FROM genero WHERE id_genero!=0");
	}else if($permissao_usuario['adicionar_genero']=='1'){

	}else{
		header("Location: ../index.php");
	}

	
	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container" style="padding-top: 40px">
	<h2 class="text-center">Generos</h2><hr>
	<?php if($permissao_usuario['adicionar_genero']=='1'){ ?>
		<div class="text-right" style="padding-bottom: 20px">
			<a href="/arterepo/genero/adicionar_genero.php" type="button" role="button" class="btn btn-outline-primary">
				Adicionar Genero
			</a>
		</div>
	<?php } ?>
	<?php if($permissao_usuario['editar_genero']=='1') { ?>
		<table class="table">
			<thead>
				<tr>
					<th>Genero</th>
				</tr>
			</thead>
			<tbody>
				<?php while($g = mysqli_fetch_assoc($generoQ)) : ?>
					<tr>
						<td>
							<a href ="/arterepo/genero/editar_genero.php?id=<?=$g['id_genero'];?>" class="btn btn-xs btn-default">
								<?=$g['genero'];?>
							</a>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	<?php } ?>
</div>
<?php include '../includes/footer.php'; ?>