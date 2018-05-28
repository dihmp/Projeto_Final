<?php
	require_once '../core/core.init';
	require_once '../helpers/helpers.php';

	if($uid=='0'){
		header("Location: ../index.php");
	}
	if($permissao_usuario['editar_todas_artes']=='1'){
		$artesQ = $db->query("SELECT id_arte, arte FROM arte");
	}else if($permissao_usuario['editar_arte']=='1'){
		$artesQ = $db->query("SELECT id_arte, arte FROM arte WHERE id_usuario='$uid'");
	}else if($permissao_usuario['adicionar_arte']=='1'){
		
	}else{
		header("Location: ../index.php");
	}
	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container" style="padding-top: 40px">
	<h2 class="text-center">Minhas Artes</h2><hr>
	<?php if($permissao_usuario['adicionar_arte']=='1'){ ?>
		<div class="text-right" style="padding-bottom: 20px">
			<a href="/arterepo/arte/adicionar_arte.php" type="button" role="button" class="btn btn-outline-primary">
				Adicionar Arte
			</a>
		</div>
	<?php } ?>
	<?php if($permissao_usuario['editar_todas_artes']=='1' || $permissao_usuario['editar_arte']=='1'){ ?>
		<table class="table">
			<thead>
				<tr>
					<th>Menu</th>
					<th>Arte</th>
				</tr>
			</thead>
			<tbody>
				<?php while($a = mysqli_fetch_assoc($artesQ)) : ?>
					<tr>
						<td>
							<a href ="/arterepo/arte/editar_arte.php?id=<?=$a['id_arte'];?>" class="btn btn-xs btn-default">
	                            Editar Arte
	                        </a>
	                    </td>
						<td>
							<a href ="/arterepo/arte/arte.php?id=<?=$a['id_arte'];?>" class="btn btn-xs btn-default">
								<?=$a['arte'];?>
							</a>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	<?php } ?>
</div>
<?php include '../includes/footer.php'; ?>