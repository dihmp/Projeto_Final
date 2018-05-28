<?php
	require_once '../core/core.init';
	require_once '../helpers/helpers.php';

	if($uid=='0'){
		header("Location: ../index.php");
	}
	if($permissao_usuario['editar_todos_museus']=='1'){
		$museuQ = $db->query("SELECT id_museu, museu FROM museu WHERE id_museu!=0");
	}else if($permissao_usuario['editar_museu']=='1'){
		$museuQ = $db->query("SELECT id_museu, museu FROM museu WHERE id_museu!=0 AND id_usuario='$uid'");
	}else if($permissao_usuario['adicionar_museu']=='1'){

	}else{
		header("Location: ../index.php");
	}

	
	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container" style="padding-top: 40px">
	<h2 class="text-center">Meus Museus</h2><hr>
	<?php if($permissao_usuario['adicionar_museu']=='1'){ ?>
		<div class="text-right" style="padding-bottom: 20px">
			<a href="/arterepo/museu/adicionar_museu.php" type="button" role="button" class="btn btn-outline-primary">
				Adicionar Museu
			</a>
		</div>
	<?php } ?>
	<?php if($permissao_usuario['editar_museu']=='1' || $permissao_usuario['editar_todos_museus']=='1'){ ?>
		<table class="table">
			<thead>
				<tr>
					<th>Menu</th>
					<th>Museu</th>
				</tr>
			</thead>
			<tbody>
				<?php while($m = mysqli_fetch_assoc($museuQ)) : ?>
					<tr>
						<td>
							<a href ="/arterepo/museu/editar_museu.php?id=<?=$m['id_museu'];?>" class="btn btn-xs btn-default">
	                            Editar Museu
	                        </a>
	                    </td>
						<td>
							<a href ="/arterepo/museu/museu.php?id=<?=$m['id_museu'];?>" class="btn btn-xs btn-default">
								<?=$m['museu'];?>
							</a>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	<?php } ?>
</div>
<?php include '../includes/footer.php'; ?>