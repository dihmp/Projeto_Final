<?php
	require_once '../core/core.init';
	require_once '../helpers/helpers.php';
	if(isset($_GET['id'])){
        $id = sanitize($_GET['id']);
		$editado = false;

		$profissoesQ = $db->query("SELECT id_profissao, profissao FROM profissao");

		$artista = mysqli_fetch_assoc($db->query("SELECT a.id_artista, a.id_usuario, a.artista, a.id_profissao, a.dt_nasc, a.biografia, a.nacionalidade, i.id_imagem, i.caminho FROM artista AS a, imagem AS i WHERE a.id_imagem=i.id_imagem AND a.id_artista='$id'"));

		if($uid=='0'){
			header("Location: ../index.php");
		}
		if($permissao_usuario['editar_todos_artistas']=='0'){
			if($permissao_usuario['editar_artista']=='0'){
				header("Location: ../index.php");
			}else if($permissao_usuario['editar_artista']=='1'){
				if($uid!=$artista['id_usuario']){
					header("Location: ../index.php");
				}
			}
		}

		$nome          = ((isset($_POST['nome'])          && $_POST['nome']         !='')?sanitize($_POST['nome']):$artista['artista']);
		$data          = ((isset($_POST['data'])          && $_POST['data']         !='')?sanitize($_POST['data']):format_date($artista['dt_nasc']));
		$profissao     = ((isset($_POST['profissao'])     && $_POST['profissao']    !='')?sanitize($_POST['profissao']):$artista['id_profissao']);
		$nacionalidade = ((isset($_POST['nacionalidade']) && $_POST['nacionalidade']!='')?sanitize($_POST['nacionalidade']):$artista['nacionalidade']);
		$biografia     = ((isset($_POST['biografia'])     && $_POST['biografia']    !='')?sanitize($_POST['biografia']):$artista['biografia']);
		$caminhoTemporario = ((isset($_POST['caminho_temporario']) && $_POST['caminho_temporario'] != '')?sanitize($_POST['caminho_temporario']):$artista['caminho']);
		$caminhoTemporarioAntigo = $artista['caminho'];
		if(!empty($_FILES)){
			if($_FILES['foto']['name']!=''){
	            $foto     = $_FILES['foto'];
	            $caminhoTemporario = sprintf("data:image/png;base64,%s", base64_encode(file_get_contents($foto['tmp_name'])));
	        }
    	}
		$imagemCaminho = '';
	    $uploadCaminho = '';
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
					if($caminhoTemporario!='' && $caminhoTemporario!=$caminhoTemporarioAntigo){
						$salvar = true;
					}
				}
			}
			if(empty($erros)){
				$id_imagem = $artista['id_imagem'];
				if($salvar){
					if($_FILES['foto']['name']!='') {
			            $imagem = $_FILES['foto'];

			            $nomeImagem = $imagem['name'];
			            $nomeArray = explode('.', $nomeImagem);
			            $nomeArquivo = $nomeArray[0];
			            $extensaoArquivo = $nomeArray[1];

			            $uploadNome = md5(microtime()).'.'.$extensaoArquivo;
			            $uploadCaminho = $_SERVER['DOCUMENT_ROOT']."/arterepo/imagens/artistas/".$uploadNome;
			            $imagemCaminho = "/arterepo/imagens/artistas/".$uploadNome;
			            $uploadImagem = $imagem['tmp_name'];
			        }
			        if($caminhoTemporario!='' && $_FILES['foto']['name']==''){
		                $caminhoTemporario = str_replace('data:image/png;base64,', '', $caminhoTemporario);
		                $caminhoTemporario = str_replace(' ', '+', $caminhoTemporario);

		                $uploadNome = md5(microtime()).'.png';
		                $uploadPath = "/arterepo/imagens/artistas/".$uploadNome;
		                $image_path = "/arterepo/imagens/artistas/".$uploadName;
		                
		                $uploadImagem = base64_decode($caminhoTemporario);
		                file_put_contents($uploadCaminho, $uploadImagem);
		            }else{
		                move_uploaded_file($_FILES['foto']['tmp_name'], $uploadCaminho);
		            }
		            unlink($_SERVER['DOCUMENT_ROOT'].$caminhoTemporarioAntigo);
		            $db->query("DELETE FROM image WHERE id_image='$id_image'");
		            $db->query("INSERT INTO imagem (caminho) VALUES ('$imagemCaminho')");
		            $id_imagem = $db->insert_id;
				}
				$dbData = explode("/", $data);
    			$data = $dbData[2].'-'.$dbData[0].'-'.$dbData[1];
				$db->query("UPDATE artista SET artista='$nome', id_profissao='$profissao', dt_nasc='$data', biografia='$biografia', nacionalidade='$nacionalidade', id_imagem='$id_imagem' WHERE id_artista='$id'");
				echo("Error description: " . mysqli_error($db));
				$editado = true;
			}
		}
	}
	include '../includes/head.php';
	include '../includes/navbar.php';
?>
<div class="container">
	<?php if(!$editado) { ?>
		<div class="text-center">
			<h2>Editar Artista</h2><hr>
			<?php if(!empty($erros)){
	            echo display_errors($erros);
	        }?>
		</div>
		<div class="row">
			<div class="col-md-2 col-lg-2 col-xl-2"></div>
			<div class="col-md-8 col-lg-8 col-xl-8">
				<form action="editar_artista.php?id=<?=$id;?>" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label for="nome">Nome do Artista: *</label>
						<input type="text" id="nome" name="nome" class="form-control form-control-sm" value="<?=$nome;?>">
					</div>

					<div class="form-group">
						<label for="data">Data de Nascimento:</label>
						<input type="text" id="datepicker" name="data" class="form-control form-control-sm" value="<?=$data;?>">
					</div>

					<div class="form-group">
						<label for="profissao">Profissão:</label>
						<select id="profissao" name="profissao" class="selectpicker" style="width: 100%">
							<?php while($p = mysqli_fetch_assoc($profissoesQ)) : ?>
								<option value="<?=$p['id_profissao'];?>"<?=(($profissao == $p['id_profissao'])?'selected':'');?>><?=$p['profissao'];?></option>
							<?php endwhile; ?>
						</select>
					</div>

					<div class="form-group">
						<label for="nacionalidade">Nacionalidade:</label>
						<input type="text" id="nacionalidade" name="nacionalidade" class="form-control form-control-sm" value="<?=$nacionalidade;?>">
					</div>

					<div class="form-group">
						<label for="biografia">Biografia:</label>
						<textarea id="biografia" name="biografia" class="form-control" rows="5" style="resize: none"><?=$biografia;?></textarea>
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
						<input type="submit" class="btn btn-success" value="Editar Artista" >
					</div>
				</form>
			</div>
			<div class="col-md-2 col-lg-2 col-xl-2"></div>
		</div>
	<?php }else{ ?>
		<div class="text-center">
			Artista <?=$nome;?> editado com sucesso.
		</div>
	<?php } ?>
</div>
<?php include '../includes/footer.php'; ?>