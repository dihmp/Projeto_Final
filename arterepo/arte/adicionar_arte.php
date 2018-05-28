<?php
	require_once '../core/core.init';
	require_once '../helpers/helpers.php';
	
	if($uid=='0'){
		header("Location: ../index.php");
	}
	if($permissao_usuario['adicionar_arte']=='0'){
		header("Location: ../index.php");
	}

	$adicionado = false;
	$generoArteQ = $db->query("SELECT id_genero, genero FROM genero");
	$museuQ = $db->query("SELECT id_museu, museu FROM museu");
	$artistaQ    = $db->query("SELECT a.id_artista, a.artista, a.nacionalidade, p.profissao FROM artista AS a, profissao AS p WHERE a.id_profissao = p.id_profissao");

	$nome      = ((isset($_POST['nome'])      && $_POST['nome']     !='')?sanitize($_POST['nome'])     :'');
	$tecnica   = ((isset($_POST['tecnica'])   && $_POST['tecnica']  !='')?sanitize($_POST['tecnica'])  :'');
	$data      = ((isset($_POST['data'])      && $_POST['data']     !='')?sanitize($_POST['data'])     :'');
	$artista   = ((isset($_POST['artista'])   && $_POST['artista']  !='')?sanitize($_POST['artista'])  :'');
	$genero    = ((isset($_POST['genero'])    && $_POST['genero']   !='')?sanitize($_POST['genero'])   :'');
	$museu     = ((isset($_POST['museu'])     && $_POST['museu']    !='')?sanitize($_POST['museu'])    :'');
	$descricao = ((isset($_POST['descricao']) && $_POST['descricao']!='')?sanitize($_POST['descricao']):'');

	$caminhoTemporario = ((isset($_POST['caminho_temporario']) && $_POST['caminho_temporario'] != '')?sanitize($_POST['caminho_temporario']):'');

	$obrigatorios = array('nome');

	if($_POST && !empty($_POST)){
		$salvar = false;
		foreach ($obrigatorios as $campo){
			if($_POST[$campo] == ''){
				$erros[] = 'Todos os campos marcados com asteristicos são obrigatorios.';
					break;
			}
		}
		if(!empty($_FILES)){
			if($_FILES['foto']['name']!=''){
				if(isset($_FILES['foto'])){
					if(getimagesize($_FILES['foto']['tmp_name']) == false){
						$erros[] = "O arquivo não é uma imagem.";
					}
					if ($_FILES['foto']['size'] > 5000000) {
						$erros[] = "O arquivo é muito grande.";
					}
					$imagemTipo = strtolower(pathinfo($_FILES['foto']['name'],PATHINFO_EXTENSION));
					if($imagemTipo != "jpg" && $imagemTipo != "png" && $imagemTipo != "jpeg") {
						$erros[] = "Somente imagens .jpg, .png e .jpeg são permitidas.";
					}
					if(empty($erros)){
						$salvar = true;
					}	
				}
			}else{
				if($caminhoTemporario!=''){
					$salvar = true;
				}
			}
		}
		if(empty($erros)){
			$id_imagem = 0;
			if($salvar){
				if($_FILES['foto']['name']!='') {
		            $imagem = $_FILES['foto'];

		            $nomeImagem = $imagem['name'];
		            $nomeArray = explode('.', $nomeImagem);
		            $nomeArquivo = $nomeArray[0];
		            $extensaoArquivo = $nomeArray[1];

		            $uploadNome = md5(microtime()).'.'.$extensaoArquivo;
		            $uploadCaminho = $_SERVER['DOCUMENT_ROOT']."/arterepo/imagens/artes/".$uploadNome;
		            $imagemCaminho = "/arterepo/imagens/artes/".$uploadNome;
		            $uploadImagem = $imagem['tmp_name'];
		        }
		        if($caminhoTemporario!='' && $_FILES['foto']['name']==''){
	                $caminhoTemporario = str_replace('data:image/png;base64,', '', $caminhoTemporario);
	                $caminhoTemporario = str_replace(' ', '+', $caminhoTemporario);

	                $uploadNome = md5(microtime()).'.png';
	                $uploadPath = "/arterepo/imagens/artes/".$uploadNome;
	                $image_path = "/arterepo/imagens/artes/".$uploadName;
	                
	                $uploadImagem = base64_decode($caminhoTemporario);
	                file_put_contents($uploadCaminho, $uploadImagem);
	            }else{
	                move_uploaded_file($_FILES['foto']['tmp_name'], $uploadCaminho);
	            }
	            $db->query("INSERT INTO imagem (caminho) VALUES ('$imagemCaminho')");
	            $id_imagem = $db->insert_id;
			}
			$dbData = explode("/", $data);
    		$data = $dbData[2].'-'.$dbData[1].'-'.$dbData[0];
			$db->query("INSERT INTO arte (id_genero, id_usuario, arte, ano, id_artista, descricao, id_museu, tecnica, id_imagem) VALUES ('$genero', '$uid', '$nome', '$data', '$artista', '$descricao', '$museu', '$tecnica', '$id_imagem')");
			$adicionado = true;
		}
	}
	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container">
	<?php if(!$adicionado) { ?>
		<div class="text-center">
			<h2>Adicionar Obra de Arte</h2><hr>
			<?php if(!empty($erros)){
	            echo display_errors($erros);
	        }?>
		</div>
		<div class="row">
			<div class="col-md-2 col-lg-2 col-xl-2"></div>
			<div class="col-md-8 col-lg-8 col-xl-8">
				<form action="adicionar_arte.php" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label for="nome">Nome da Obra:</label>
						<input type="text" id="nome" name="nome" class="form-control form-control-sm" value="<?=$nome;?>">
					</div>

					<div class="form-group">
						<label for="tecnica">Tecnica usada na Obra:</label>
						<input type="text" id="tecnica" name="tecnica" class="form-control form-control-sm" value="<?=$tecnica;?>">
					</div>

					<div class="form-group">
						<label for="data">Data da Obra:</label>
						<input type="text" id="datepicker" name="data" class="form-control form-control-sm" value="<?=$data;?>">
					</div>

					<div class="form-group">
						<label for="artista">Artista da Obra:</label>
						<select id="artista" name="artista" class="selectpicker" style="width: 100%">
							<?php while($a = mysqli_fetch_assoc($artistaQ)) : ?>
								<option value="<?=$a['id_artista'];?>" <?=(($artista == $a['id_artista'])?'selected':'');?>><?=$a['artista'];?></option>
							<?php endwhile; ?>
						</select>
					</div>

					<div class="form-group">
						<label for="genero">Genero da Obra:</label>
						<select id="genero" name="genero" class="selectpicker" style="width: 100%">
							<?php while($g = mysqli_fetch_assoc($generoArteQ)) : ?>
								<option value="<?=$g['id_genero'];?>" <?=(($genero == $g['id_genero'])?'selected':'');?>><?=$g['genero'];?></option>
							<?php endwhile; ?>
						</select>
					</div>

					<div class="form-group">
						<label for="museu">Museu da Obra:</label>
						<select id="museu" name="museu" class="selectpicker" style="width: 100%">
							<?php while($m = mysqli_fetch_assoc($museuQ)) : ?>
								<option value="<?=$m['id_museu'];?>" <?=(($museu == $m['id_museu'])?'selected':'');?>><?=$m['museu'];?></option>
							<?php endwhile; ?>
						</select>
					</div>

					<div class="form-group">
						<label for="descricao-arte">Descrição Obra:</label>
						<textarea id="descricao" name="descricao" class="form-control" rows="5" style="resize: none"><?=$descricao;?></textarea>
					</div>

					<div class="form-group">
						<label for="foto">Foto do Artista:</label>
		                <table class="table table-bordered">
		                    <td>
		                        <img id="imagem" class="img-responsive img-fluid"/>
		                        <?php if($caminhoTemporario !==''){ ?>
		                        	<img src="<?=$caminhoTemporario;?>" id="uploaded_photo" class="img-responsive img-fluid"/>
		                        <?php } ?>
		                    </td>
		                </table>
						<img id="imagem" class="img-responsive img-fluid"/>
						<input type="file" name="foto" id="foto" class="form-control-file" onchange="preview_image(event)" value="$imagem">
					</div>

					<div class="text-right">
						<input type="hidden" name="caminho_temporario" value="<?=$caminhoTemporario;?>">
						<input type="submit" class="btn btn-success" value="Adicionar Arte" >
					</div>
				</form>
			</div>
			<div class="col-md-2 col-lg-2 col-xl-2"></div>
		</div>
	<?php } else{ ?>
		Arte <?=$nome;?> adicionada com sucesso.
	<?php } ?>
</div>
<?php include '../includes/footer.php'; ?>