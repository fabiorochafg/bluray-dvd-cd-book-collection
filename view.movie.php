<? include "files/conection.php"; ?>
<!DOCTYPE HTML>
<html lang="pt-BR" dir="ltr">
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
					<ul>
						<li><a href='edit.movie.php?cod=1&id='".$dados[6]."'>Editar</a></li>
						<li><a href='edit.movie.php?cod=3&id='".$dados[6]."' class='danger'>Excluir</a></li>
					</ul>
				</div>
			</div>";
		}
	echo '</div>';
	?>    
</div>
<? include "inc.nav.php"; ?>
<? include "inc.footer.php"; ?>
</body>
</html>