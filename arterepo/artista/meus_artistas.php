<?php
	require_once '../core/core.init';
	require_once '../helpers/helpers.php';

	if($uid=='0'){
		header("Location: ../index.php");
	}
	if($permissao_usuario['editar_todos_artistas']=='1'){
		$artistaQ = $db->query("SELECT id_artista, artista FROM artista WHERE id_artista!=0");
	}else if($permissao_usuario['editar_arte']=='1'){
		$artistaQ = $db->query("SELECT id_artista, artista FROM artista WHERE id_artista!=0 AND id_usuario='$uid'");
	}else if($permissao_usuario['adicionar_artista']=='1'){

	}else{
		header("Location: ../index.php");
	}
	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container" style="padding-top: 40px">
	<h2 class="text-center">Meus Artistas</h2><hr>
	<?php if($permissao_usuario['adicionar_artista']=='1'){ ?>
		<div class="text-right" style="padding-bottom: 20px">
			<a href="/arterepo/artista/adicionar_artista.php" type="button" role="button" class="btn btn-outline-primary">
				Adicionar Artista
			</a>
		</div>
	<?php } ?>
	<?php if($permissao_usuario['editar_arte']=='1' || $permissao_usuario['editar_todos_artistas']=='1') { ?>
		<table class="table">
			<thead>
				<tr>
					<th>Menu</th>
					<th>Artista</th>
				</tr>
			</thead>
			<tbody>
				<?php while($a = mysqli_fetch_assoc($artistaQ)) : ?>
					<tr>
						<td>
							<a href ="/arterepo/artista/editar_artista.php?id=<?=$a['id_artista'];?>" class="btn btn-xs btn-default">
	                            Editar Artista
	                        </a>
	                    </td>
						<td>
							<a href ="/arterepo/artista/artista.php?id=<?=$a['id_artista'];?>" class="btn btn-xs btn-default">
								<?=$a['artista'];?>
							</a>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	<?php } ?>
</div>
<?php include '../includes/footer.php'; ?>