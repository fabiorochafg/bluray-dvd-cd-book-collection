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
	$consulta = mysql_query('SELECT album,artista,ano,especificacoes,imagem,id_cd
		FROM cd
		ORDER BY ano');
	$n = mysql_num_rows($consulta);
	echo '<div id="content">
	<h2>Lista de CDs ('.$n.' itens)</h2>';	
	if (isset($_GET['msg'])) {
		switch ($_GET['msg']) {
			case 1: echo "<p class='msg success'>CD atualizado com sucesso!</p>"; break;
			case 2: echo "<p class='msg error'>Não foi possível atualizar este CD.</p>"; break;
		}
	}
	echo '</div>
	<div id="boxes">';
		while ($dados = mysql_fetch_row($consulta)) {
			echo "<div class='box-item'>
			<h3>".$dados[0]."</h3>
			<h4>".$dados[1]."</h4>
			<h5>".$dados[2]."</h5>
			<div>
				<img src='photos/".$dados[4]."' alt='".$dados[0]."' />
				<dl class='oculto'>";
				if ($dados[3] != "") {
					echo "<dt>Especificações:</dt>
					<dd>".$dados[3]."</dd>";				
				}		
				echo '</dl>
				<ul>
					<li><a href="edit.cd.php?cod=1&id='.$dados[5].'">Editar</a></li>
					<li><a href="edit.cd.php?cod=3&id='.$dados[5].'" class="danger">Excluir</a></li>
				</ul>
				</div>
			</div>';
		}
	echo '</div>';
	?>    
</div>
<? include "inc.nav.php"; ?>
<? include "inc.footer.php"; ?>
</body>
</html>