<?php
	require_once '../core/core.init';
	require_once '../helpers/helpers.php';

	if($uid=='0'){
		header("Location: ../index.php");
	}
	if($permissao_usuario['editar_profissao']=='1'){
		$profissaoQ = $db->query("SELECT id_profissao, profissao FROM profissao WHERE id_profissao!=0");
	}else if($permissao_usuario['adicionar_profissao']=='1'){

	}else{
		header("Location: ../index.php");
	}

	
	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container" style="padding-top: 40px">
	<h2 class="text-center">Profissões</h2><hr>
	<?php if($permissao_usuario['adicionar_profissao']=='1'){ ?>
		<div class="text-right" style="padding-bottom: 20px">
			<a href="/arterepo/profissao/adicionar_profissao.php" type="button" role="button" class="btn btn-outline-primary">
				Adicionar Profissão
			</a>
		</div>
	<?php } ?>
	<?php if($permissao_usuario['editar_profissao']=='1'){ ?>
		<table class="table">
			<thead>
				<tr>
					<th>Profissão</th>
				</tr>
			</thead>
			<tbody>
				<?php while($p = mysqli_fetch_assoc($profissaoQ)) : ?>
					<tr>
						<td>
							<a href ="/arterepo/profissao/editar_profissao.php?id=<?=$m['id_museu'];?>" class="btn btn-xs btn-default">
								<?=$p['profissao'];?>
							</a>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	<?php } ?>
</div>
<?php include '../includes/footer.php'; ?>