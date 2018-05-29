<?php
	require_once '../core/core.init';
	require_once '../helpers/helpers.php';
	if(isset($_GET['id'])){
		$id = sanitize($_GET['id']);
		$museu = mysqli_fetch_assoc($db->query("SELECT m.museu, m.pais, m.cidade, m.Ano, m.descricao, i.caminho FROM museu AS m, imagem AS i WHERE m.id_museu='$id' AND i.id_imagem=m.id_imagem"));
		$artesQ = $db->query("SELECT a.arte, a.id_arte, i.caminho FROM arte AS a, imagem AS i WHERE a.id_imagem = i.id_imagem AND a.id_museu='$id'");
	}

	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container">
	<div class="row" style="padding-top: 20px">
		<img src="<?=$museu['caminho'];?>" class="mx-auto d-block museu">
	</div>
	<hr>
	<div class="row">
		<b>Nome:&nbsp;</b><?=$museu['museu'];?>
	</div>
	<div class="row">
		<b>País:&nbsp;</b><?=$museu['pais'];?>
	</div>
	<div class="row">
		<b>Cidade:&nbsp;</b><?=$museu['cidade'];?>
	</div>
	<div class="row">
		<b>Ano de Criação:&nbsp;</b><?=$museu['Ano'];?>
	</div>
	<div class="row">
		<b>Descrição:</b> <?=$museu['descricao'];?>
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