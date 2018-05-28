<?php
	require_once '../core/core.init';
	require_once '../helpers/helpers.php';
	if(isset($_GET['id'])){
		$id = sanitize($_GET['id']);
		$artista = mysqli_fetch_assoc($db->query("SELECT a.artista, a.dt_nasc, a.biografia, a.nacionalidade, p.profissao, i.caminho FROM artista AS a, profissao AS p, imagem AS i WHERE a.id_profissao = p.id_profissao AND a.id_artista='$id' AND i.id_imagem=a.id_imagem"));
		$artesQ = $db->query("SELECT a.arte, a.id_arte, i.caminho FROM arte AS a, imagem AS i WHERE a.id_imagem = i.id_imagem");
	}

	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container">
	<div class="row" style="padding-top: 40px">
		<img src="<?=$artista['caminho'];?>" class="mx-auto d-block artista">
	</div>
	<hr>
	<div class="row">
		<b>Nome:&nbsp;</b><?=$artista['artista'];?>
	</div>
	<div class="row">
		<b>Data de Nascimento:&nbsp;</b><?=format_date($artista['dt_nasc']);?>
	</div>
	<div class="row">
		<b>Profissão:&nbsp;</b><?=$artista['profissao'];?>
	</div>
	<div class="row">
		<b>Nacionalidade:&nbsp;</b><?=$artista['nacionalidade'];?>
	</div>
	<div class="row">
		<b>Biografia:</b> <?=$artista['biografia'];?>
	</div>
	<hr>
	<div class="row">
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