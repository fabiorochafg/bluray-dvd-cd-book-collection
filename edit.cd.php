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
				$consulta = mysql_query("SELECT album,artista,ano,especificacoes,imagem FROM cd WHERE id_cd = $id");
				$dados = mysql_fetch_row($consulta);
				echo '<h2>Editando CD</h2>
				<form method="post" action="edit.cd.php?cod=2" enctype="multipart/form-data">
				<p class="msg-obrigatorio">Os campos obrigatórios estão marcados com asterisco.</p>
				<label for="album">* Álbum</label>
				<input type="text" id="album" name="album" value="'.$dados[0].'" />
				<label for="artista">* Artista</label>
				<input type="text" id="artista" name="artista" value="'.$dados[1].'" />				
				<label for="ano">* Ano</label>
				<input type="text" id="ano" name="ano" value="'; if ($dados[2] != 0) { echo $dados[2]; } echo '" class="input_mini" />
				<label>Imagem atual</label>
				<img src="photos/'.$dados[4].'" alt="'.$dados[0].'" />
				<label for="imagem">Substituir imagem <span>Somente arquivos .jpg ou .gif.</span><span>A imagem será visualizada com largura de 180 pixels.</span></label>
				<input id="imagem" name="imagem" type="file" class="nao-obrigatorio" />
				<label for="especificacoes">Especificações</label>
				<input type="text" id="especificacoes" name="especificacoes" value="'.$dados[3].'" class="nao-obrigatorio" />
				<input type="hidden" name="id" value="'.$id.'" />
				<input type="submit" value="Salvar alterações" />
				</form>';
			} else if ($_GET['cod']==2) {
				// UPDATE
				$id = $_POST['id'];
				$album = $_POST['album'];
				$artista = $_POST['artista'];
				$ano = $_POST['ano'];
				$especificacoes = $_POST['especificacoes'];
							  	
				if (is_uploaded_file($_FILES['imagem']['tmp_name']) && (
					strtolower(end(explode('.', $_FILES['imagem']['name'])))=='jpg' || 
					strtolower(end(explode('.', $_FILES['imagem']['name'])))=='jpeg' || 
					strtolower(end(explode('.', $_FILES['imagem']['name'])))=='gif')) {

					$arquivo = date("Y-m-d")."_".date("His")."_".strtolower(preg_replace(array('/([`\?!^~\'"])/','/([^a-z0-9])/i','/(-+)/'),array('','-','-'),iconv('UTF-8', 'ASCII//TRANSLIT', $filme))).".".end(explode('.', $_FILES['imagem']['name']));
					move_uploaded_file($_FILES['imagem']['tmp_name'], "photos/".$arquivo);
					criarThumbnail($arquivo, 180, "photos/", "photos/");
					
					// Consulta existência de arquivo anteriormente
					$consulta=mysql_query("SELECT imagem FROM cd WHERE id_cd = $id");
					if ($dados=mysql_fetch_row($consulta)) {
						// Apaga arquivo anterior
						unlink("photos/".$dados[0]);
					}
					$update=mysql_query("UPDATE cd
						SET album='".$album."', artista='".$artista."', ano=".$ano.", especificacoes='".$especificacoes."', imagem='".$arquivo."', data=now()
						WHERE id_cd = $id");
				} else {
					$update=mysql_query("UPDATE cd
						SET album='".$album."', artista='".$artista."', ano=".$ano.", especificacoes='".$especificacoes."', data=now()
						WHERE id_cd = $id");
				}				
				if ($update) {
					echo '<script>
					document.location="view.cd.php?msg=1";
					</script>';
				} else {
					echo '<script>
					document.location="view.cd.php?msg=2";
					</script>';
				}				
			} else if ($_GET['cod']==3) {
				// DELETE
				$id = $_GET['id'];
				$consulta=mysql_query("SELECT imagem FROM cd WHERE id_cd = $id");
				if ($dados=mysql_fetch_row($consulta)) {
					// Apaga arquivo anterior
					unlink("photos/".$dados[0]);
				}
				$delete=mysql_query("DELETE FROM cd WHERE id_cd = $id");
				echo '<script>
				document.location="view.cd.php?msg=3";
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