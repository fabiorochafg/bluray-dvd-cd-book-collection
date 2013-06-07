<?php include "files/conection.php"; ?>
<?php include "files/inc.functions.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
<head>
<? include "inc.head.php"; ?>
</head>

<body>
<div class="container">
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

				$consulta=mysql_query("INSERT INTO filme (titulo,diretor,ano,imagem,especificacoes,preco,tipo) values ('".$filme."','".$diretor."','".$ano."','".$arquivo."','".$especificacoes."','".$preco."', ".$tipo.")");
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
			<label for="Filme">* Filme</label>
			<input type="text" id="Filme" name="filme" />
			<label for="">* Diretor</label>
			<input type="text" name="diretor" />
			<label for="">* Ano</label>
			<input type="text" name="ano" class="input_mini" />
			<label for="imagem">* Imagem <span>(Somente arquivos .jpg ou .gif. A imagem será visualizada com largura de 180 pixels.)</span></label>
			<input id="imagem" name="imagem" type="file" />
			<label for="">Especificações</label>
			<input type="text" name="especificacoes" class="nao-obrigatorio" />
			<label for="">Preço (R$)</label>
			<input type="text" name="preco" class="input_mini nao-obrigatorio" />
			<input type="hidden" name="tipo" value="<?php echo $_GET['tipo']; ?>" />
			<input type="submit" value="Adicionar" />
			</form>
		<?php
		}
		?>
	</div>    
</div>
<? include "inc.footer.php"; ?>
</body>
</html>