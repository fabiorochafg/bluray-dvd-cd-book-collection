<? include "files/conection.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
<head>
<? include "inc.head.php"; ?>
<script type="text/javascript" src="files/jquery.masonry.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#boxes').masonry({
		itemSelector: '.box-item',
		isReasizable: true
	});
});
</script>
</head>

<body>
<div class="container">
    <? include "inc.top.php"; ?>
	<?php
	// Visualizar itens
	$tipo = $_GET['tipo'];
	switch ($tipo) {
		case 0: $filme = "DVD"; break;
		case 1: $filme = "Blu-ray"; break;
	}
	$consulta = mysql_query('SELECT titulo,diretor,ano,especificacoes,preco,imagem,id_filme
		FROM filme
		WHERE tipo='.$tipo.'
		ORDER BY ano');
	$n = mysql_num_rows($consulta);
	echo '<div id="content">
	<h2>Lista de '.$filme.'s ('.$n.' itens)</h2>';	
	if (isset($_GET['msg'])) {
		switch ($_GET['msg']) {
			case 1: echo "<p class='msg success'>Filme atualizado com sucesso!</p>"; break;
			case 2: echo "<p class='msg error'>Não foi possível atualizar este filme.</p>"; break;
		}
	}
	echo '</div>
	<div id="boxes">';
		while ($dados = mysql_fetch_row($consulta)) {
			echo "<div class='box-item'>
			<h3>".$dados[0]."</h3>
			<h4>".$dados[2]."</h4>
			<div>
				<img src='photos/".$dados[5]."' alt='".$dados[0]."' />
				<dl class='oculto'>";
				if ($dados[1] != "") {
					echo "<dt>Diretor:</dt>
					<dd>".$dados[1]."</dd>";				
				}
				if ($dados[3] != "") {
					echo "<dt>Especificações:</dt>
					<dd>".$dados[3]."</dd>";				
				}
				if ($dados[4] != "") {
					echo "<dt>Preço:</dt>
					<dd>R$ ".$dados[4]."</dd>";				
				}			
				echo '</dl>
				<ul>
					<li><a href="edit.movie.php?cod=1&id='.$dados[6].'">Editar</a></li>
					<li><a href="edit.movie.php?cod=3&id='.$dados[6].'" class="danger">Excluir</a></li>
				</ul>
				</div>
			</div>';
		}
	echo '</div>';
	?>    
</div>
<? include "inc.footer.php"; ?>
</body>
</html>
