<?php
	require_once '../core/core.init';
	require_once '../helpers/helpers.php';
	if(isset($_GET['id'])){
		$id = sanitize($_GET['id']);
		$arte = mysqli_fetch_assoc($db->query("SELECT arte.id_arte, arte.id_artista, arte.tecnica, arte.descricao, arte.ano, artista.artista, m.museu, m.id_museu, i.caminho, g.genero FROM arte, artista, museu AS m, imagem AS i, genero AS g WHERE g.id_genero = arte.id_genero AND m.id_museu = arte.id_museu AND i.id_imagem = arte.id_imagem AND arte.id_artista = artista.id_artista AND arte.id_arte = '$id'"));
	}

	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container">
	<div class="row" style="padding-top: 40px">
		<img src="<?=$arte['caminho'];?>" class="mx-auto d-block arte">
	</div>
	<hr>
	<div class="row">
		<b>Nome:&nbsp;</b> <?=$arte['artista'];?>
	</div>
	<div class="row">
		<b>Data:&nbsp;</b> <?=format_date($arte['ano']);?>
	</div>
	<div class="row">
		<b>Genero:&nbsp;</b> <?=$arte['genero'];?>
	</div>
	<div class="row">
		<b>Tecnica usada:&nbsp;</b> <?=$arte['tecnica'];?>
	</div>
	<div class="row">
		<b>Artista:&nbsp;</b> <a href="/arterepo/artista/artista.php?id=<?=$arte['id_artista'];?>"><?=$arte['artista'];?></a>
	</div>
	<div class="row">
		<b>Museu:&nbsp;</b> <a href="/arterepo/museu/museu.php?id=<?=$arte['id_museu'];?>"><?=$arte['museu'];?></a>
	</div>
	<div class="row">
		<b>Descrição:</b> <?=$arte['descricao'];?>
	</div>
</div>

<?php include '../includes/footer.php'; ?>