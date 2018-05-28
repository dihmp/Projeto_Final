<?php
	require_once '../core/core.init';
	$museusQ = $db->query("SELECT m.id_museu, m.museu, i.caminho FROM museu AS m, imagem AS i WHERE i.id_imagem=m.id_imagem");

	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container">
	<div class="row equal" style="padding-top: 40px">
		<?php while ($m = mysqli_fetch_assoc($museusQ)) : ?>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
				<div class="container-fade museus">
					<a href="/arterepo/museu/museu.php?id=<?=$m['id_museu'];?>">
						<img src="<?=$m['caminho'];?>" alt="Museu" class="image img-responsive img-fluid mx-auto d-block">
						<div class="overlay">
				    		<div class="text"><?=$m['museu'];?></div>
				  		</div>
				  		<div class="text-center"><?=$m['museu'];?></div>
				  	</a>
		  		</div>
			</div>
		<?php endwhile;?>
	</div>
</div>

<?php include '../includes/footer.php'; ?>