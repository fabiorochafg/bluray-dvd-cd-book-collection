<?php include "files/conection.php"; ?>
<?php include "files/inc.functions.php"; ?>
<!DOCTYPE HTML>
<html lang="pt-BR" dir="ltr">
<head>
<? include "inc.head.php"; ?>
</head>

<body>
<section>
    <? include "inc.top.php"; ?>
	<div id="content">
		<?php
		if (isset($_GET['cod'])) {
			if ($_GET['cod']==1) {
				$id = $_GET['id'];		
				$consulta = mysql_query("SELECT titulo,diretor,ano,especificacoes,preco,imagem,tipo FROM filme WHERE id_filme = $id");
				$dados = mysql_fetch_row($consulta);
				echo '<h2>Editando Filme</h2>
				<form method="post" action="edit.movie.php?cod=2" enctype="multipart/form-data">
				<p class="msg-obrigatorio">Os campos obrigatórios estão marcados com asterisco.</p>
				<label for="filme">* Filme</label>
				<input type="text" id="filme" name="filme" value="'.$dados[0].'" />
				<label for="diretor">* Diretor</label>
				<input type="text" id="diretor" name="diretor" value="'.$dados[1].'" />				
				<label for="ano">* Ano</label>
				<input type="text" id="ano" name="ano" value="'; if ($dados[2] != 0) { echo $dados[2]; } echo '" class="input_mini" />
				<label>Imagem atual</label>
				<img src="photos/'.$dados[5].'" alt="'.$dados[0].'" />
				<label for="imagem">Substituir imagem <span>Somente arquivos .jpg ou .gif.</span><span>A imagem será visualizada com largura de 180 pixels.</span></label>
				<input id="imagem" name="imagem" type="file" class="nao-obrigatorio" />
				<label for="especificacoes">Especificações</label>
				<input type="text" id="especificacoes" name="especificacoes" value="'.$dados[3].'" class="nao-obrigatorio" />
				<label for="preco">Preço (R$)</label>
				<input type="text" id="preco" name="preco" value="'.$dados[4].'" class="input_mini nao-obrigatorio" />
				<input type="hidden" name="id" value="'.$id.'" />
				<input type="hidden" name="tipo" value="'.$dados[6].'" />
				<input type="submit" value="Salvar alterações" />
				</form>';
			} else if ($_GET['cod']==2) {
				// UPDATE
				$id = $_POST['id'];
				$filme = $_POST['filme'];
				$diretor = $_POST['diretor'];
				$ano = $_POST['ano'];
				$especificacoes = $_POST['especificacoes'];
				$preco = $_POST['preco'];
				$tipo = $_POST['tipo'];
							  	
				if (is_uploaded_file($_FILES['imagem']['tmp_name']) && (
					strtolower(end(explode('.', $_FILES['imagem']['name'])))=='jpg' || 
					strtolower(end(explode('.', $_FILES['imagem']['name'])))=='jpeg' || 
					strtolower(end(explode('.', $_FILES['imagem']['name'])))=='gif')) {

					$arquivo = date("Y-m-d")."_".date("His")."_".strtolower(preg_replace(array('/([`\?!^~\'"])/','/([^a-z0-9])/i','/(-+)/'),array('','-','-'),iconv('UTF-8', 'ASCII//TRANSLIT', $filme))).".".end(explode('.', $_FILES['imagem']['name']));
					move_uploaded_file($_FILES['imagem']['tmp_name'], "photos/".$arquivo);
					criarThumbnail($arquivo, 180, "photos/", "photos/");
					
					// Consulta existência de arquivo anteriormente
					$consulta=mysql_query("SELECT imagem FROM filme WHERE id_filme = $id");
					if ($dados=mysql_fetch_row($consulta)) {
						// Apaga arquivo anterior
						unlink("photos/".$dados[0]);
					}
					$update=mysql_query("UPDATE filme 
						SET titulo='".$filme."',diretor='".$diretor."',ano=".$ano.",especificacoes='".$especificacoes."',preco='".$preco."',imagem='".$arquivo."',data=now()
						WHERE id_filme = $id");
				} else {
					$update=mysql_query("UPDATE filme 
						SET titulo='".$filme."',diretor='".$diretor."',ano=".$ano.",especificacoes='".$especificacoes."',preco='".$preco."',data=now()
						WHERE id_filme = $id");
				}				
				if ($update) {
					echo '<script>
					document.location="view.movie.php?msg=1&tipo='.$tipo.'";
					</script>';
				} else {
					echo '<script>
					document.location="view.movie.php?msg=2&tipo='.$tipo.'";
					</script>';
				}				
			} else if ($_GET['cod']==3) {
				// DELETE
				$id = $_GET['id'];
				$consulta=mysql_query("SELECT imagem,tipo FROM filme WHERE id_filme = $id");
				if ($dados=mysql_fetch_row($consulta)) {
					// Apaga arquivo anterior
					unlink("photos/".$dados[0]);
				}
				$delete=mysql_query("DELETE FROM filme WHERE id_filme = $id");
				echo '<script>
				document.location="view.movie.php?msg=3&tipo='.$dados[1].'";
				</script>';
			}
		} else {
			echo '<p class="msg error">Esta página não existe. Volte à <a href="index.php">página inicial</a>.</p>';
		}
		?>
	</div>
</section>
<? include "inc.nav.php"; ?>
<? include "inc.footer.php"; ?>
</body>
</html>