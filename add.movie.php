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
			$filme = $_POST['filme'];
			$diretor = $_POST['diretor'];
			$ano = $_POST['ano'];
			$especificacoes = $_POST['especificacoes'];
			$preco = $_POST['preco'];
			$tipo=$_POST['tipo'];

		  	$consulta = mysql_query("SELECT titulo FROM filme WHERE titulo='".$filme."' AND tipo=".$tipo);
		  	if (mysql_num_rows($consulta) > 0) {
		  		echo '<script>
			  	document.location="add.movie.php?msg=2&tipo='.$tipo.'";
				</script>';
			} else if (is_uploaded_file($_FILES['imagem']['tmp_name']) && (
				strtolower(end(explode('.', $_FILES['imagem']['name'])))=='jpg' || 
				strtolower(end(explode('.', $_FILES['imagem']['name'])))=='jpeg' || 
				strtolower(end(explode('.', $_FILES['imagem']['name'])))=='gif')) {

				$arquivo = date("Y-m-d")."_".date("His")."_".strtolower(preg_replace(array('/([`\?!^~\'"])/','/([^a-z0-9])/i','/(-+)/'),array('','-','-'),iconv('UTF-8', 'ASCII//TRANSLIT', $filme))).".".end(explode('.', $_FILES['imagem']['name']));
				move_uploaded_file($_FILES['imagem']['tmp_name'], "photos/".$arquivo);
				criarThumbnail($arquivo, 180, "photos/", "photos/");

				$consulta=mysql_query("INSERT INTO filme (titulo,diretor,ano,imagem,especificacoes,preco,tipo,data) values ('".$filme."','".$diretor."','".$ano."','".$arquivo."','".$especificacoes."','".$preco."', ".$tipo.",now())");
				echo '<script>
				document.location="add.movie.php?msg=1&tipo='.$tipo.'";
				</script>';
			} else {
				echo '<script type="text/javascript">
				document.location="add.movie.php?msg=3&tipo='.$tipo.'";
				</script>';
			}
		} else {
		?>
			<h2>Adicionando Filme</h2>
			<?php
			if (isset($_GET['msg'])) {
				switch ($_GET['msg']) {
					case 1: echo "<p class='msg success'>Cadastro realizado com sucesso!</p>"; break;
					case 2: echo "<p class='msg error'>Este filme já foi cadastrado.</p>"; break;
					case 3: echo "<p class='msg error'>Não foi possível cadastrar a imagem para o filme.</p>"; break;
				}
			}
			?>			
			<form method="post" action="add.movie.php?cod=1" enctype="multipart/form-data">
			<p class="msg-obrigatorio">Os campos obrigatórios estão marcados com asterisco.</p>
			<label for="filme">* Filme</label>
			<input type="text" id="filme" name="filme" />
			<label for="diretor">* Diretor</label>
			<input type="text" id="diretor" name="diretor" />
			<label for="ano">* Ano</label>
			<input type="text" id="ano" name="ano" class="input_mini" />
			<label for="imagem">* Imagem <span>(Somente arquivos .jpg ou .gif. A imagem será visualizada com largura de 180 pixels.)</span></label>
			<input id="imagem" name="imagem" type="file" />
			<label for="especificacoes">Especificações</label>
			<input type="text" id="especificacoes" name="especificacoes" class="nao-obrigatorio" />
			<label for="preco">Preço (R$)</label>
			<input type="text" id="preco" name="preco" class="input_mini nao-obrigatorio" />
			<input type="hidden" name="tipo" value="<?php echo $_GET['tipo']; ?>" />
			<input type="submit" value="Adicionar" />
			</form>
		<?php
		}
		?>
	</div>    
</section>
<? include "inc.nav.php"; ?>
<? include "inc.footer.php"; ?>
</body>
</html>