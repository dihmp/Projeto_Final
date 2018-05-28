<?php
	require_once '../core/core.init';
	require_once '../helpers/helpers.php';

	if(isset($_GET['id'])){
        $id = sanitize($_GET['id']);

        $museu = mysqli_fetch_assoc($db->query("SELECT m.id_usuario, m.museu, m.cidade, m.pais, m.descricao, i.caminho, i.id_imagem FROM museu AS m, imagem AS i WHERE m.id_imagem=i.id_imagem AND m.id_museu='$id'"));

        if($uid=='0'){
			header("Location: ../index.php");
		}
		if($permissao_usuario['editar_todos_museus']=='0'){
			if($permissao_usuario['editar_museu']=='0'){
				header("Location: ../index.php");
			}else if($permissao_usuario['editar_museu']=='1'){
				if($uid!=$museu['id_usuario']){
					header("Location: ../index.php");
				}
			}
		}

		$nome      = ((isset($_POST['nome'])      && $_POST['nome']     !='')?sanitize($_POST['nome'])     :$museu['museu']);
		$cidade    = ((isset($_POST['cidade'])    && $_POST['cidade']   !='')?sanitize($_POST['cidade'])   :$museu['cidade']);
		$pais      = ((isset($_POST['pais'])      && $_POST['pais']     !='')?sanitize($_POST['pais'])     :$museu['pais']);
		$descricao = ((isset($_POST['descricao']) && $_POST['descricao']!='')?sanitize($_POST['descricao']):$museu['descricao']);


		$caminhoTemporario = ((isset($_POST['caminho_temporario']) && $_POST['caminho_temporario'] != '')?sanitize($_POST['caminho_temporario']):$museu['caminho']);
		$caminhoTemporarioAntigo = $museu['caminho'];

		if(!empty($_FILES)){
			if($_FILES['foto']['name']!=''){
	            $foto     = $_FILES['foto'];
	            $caminhoTemporario = sprintf("data:image/png;base64,%s", base64_encode(file_get_contents($foto['tmp_name'])));
	        }
    	}

		$editado = false;
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
				$id_imagem = $museu['id_imagem'];
				if($salvar){
					if($_FILES['foto']['name']!='') {
			            $imagem = $_FILES['foto'];

			            $nomeImagem = $imagem['name'];
			            $nomeArray = explode('.', $nomeImagem);
			            $nomeArquivo = $nomeArray[0];
			            $extensaoArquivo = $nomeArray[1];

			            $uploadNome = md5(microtime()).'.'.$extensaoArquivo;
			            $uploadCaminho = $_SERVER['DOCUMENT_ROOT']."/arterepo/imagens/museus/".$uploadNome;
			            $imagemCaminho = "/arterepo/imagens/museus/".$uploadNome;
			            $uploadImagem = $imagem['tmp_name'];
			        }
			        if($caminhoTemporario!='' && $_FILES['foto']['name']==''){
		                $caminhoTemporario = str_replace('data:image/png;base64,', '', $caminhoTemporario);
		                $caminhoTemporario = str_replace(' ', '+', $caminhoTemporario);

		                $uploadNome = md5(microtime()).'.png';
		                $uploadPath = "/arterepo/imagens/museu/".$uploadNome;
		                $image_path = "/arterepo/imagens/museu/".$uploadName;
		                
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
				$db->query("UPDATE museu SET museu = '$nome', pais = '$pais', cidade = '$cidade', descricao = '$descricao', id_imagem = '$id_imagem' WHERE id_museu='$id'");
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
			<h2>Editar Museu</h2><hr>
			<?php if(!empty($erros)){
	            echo display_errors($erros);
	        }?>
		</div>
		<div class="row">
			<div class="col-md-2 col-lg-2 col-xl-2"></div>
			<div class="col-md-8 col-lg-8 col-xl-8">
				<form action="editar_museu.php?id=<?=$id;?>" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label for="nome">Nome*:</label>
						<input type="text" id="nome" name="nome" class="form-control form-control-sm" value="<?=$nome;?>" required>
					</div>

					<div class="form-group">
						<label for="pais">País:</label>
						<input type="text" id="pais" name="pais" class="form-control form-control-sm" value="<?=$pais;?>">
					</div>

					<div class="form-group">
						<label for="cidade">Cidade:</label>
						<input type="text" id="cidade" name="cidade" class="form-control form-control-sm" value="<?=$cidade;?>">
					</div>

					<div class="form-group">
						<label for="descricao">Descrição do Local:</label>
						<textarea id="descricao" name="descricao" class="form-control" rows="5" style="resize: none"><?=$descricao;?></textarea>
					</div>
					<div class="form-group">
						<label for="foto">Foto do Museu:</label>
		                <table class="table table-bordered">
		                    <td>
		                        <?php if($caminhoTemporario !==''){ ?>
		                        	<img src="<?=$caminhoTemporario;?>" id="uploaded_photo" class="img-responsive img-fluid"/>
		                        <?php }else{ ?>
		                        	<img id="imagem" class="img-responsive img-fluid"/>
		                        <?php } ?>
		                    </td>
		                </table>
						<img id="imagem" class="img-responsive img-fluid"/>
						<input type="file" name="foto" id="foto" class="form-control-file" onchange="preview_image(event)" value="$imagem">
					</div>
					<div class="text-right">
						<input type="hidden" name="caminho_temporario" value="<?=$caminhoTemporario;?>">
						<input type="submit" class="btn btn-success" value="Editar Museu">
					</div>
				</form>
			</div>
			<div class="col-md-2 col-lg-2 col-xl-2"></div>
		</div>
	<?php }else{ ?>
		Museu <?=$nome;?> editado com sucesso.
	<?php } ?>
</div>
<?php include '../includes/footer.php'; ?>