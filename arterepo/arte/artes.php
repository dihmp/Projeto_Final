<?php
	require_once '../core/core.init';
	$artesQ = $db->query("SELECT a.id_arte, a.arte, i.caminho FROM arte AS a, imagem AS i WHERE i.id_imagem=a.id_imagem");

	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container">
	<div class="row equal" style="padding-top: 40px">
		<?php while ($a = mysqli_fetch_assoc($artesQ)) : ?>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
				<div class="container-fade artes">
					<a href="/arterepo/arte/arte.php?id=<?=$a['id_arte'];?>">
						<img src="<?=$a['caminho'];?>" alt="Artes" class="image img-responsive img-fluid">
						<div class="overlay">
				    		<div class="text"><?=$a['arte'];?></div>
				  		</div>
				  		<div class="text-center"><?=$a['arte'];?></div>
				  	</a>
		  		</div>
			</div>
		<?php endwhile;?>
	</div>
</div>

<?php include '../includes/footer.php'; ?>