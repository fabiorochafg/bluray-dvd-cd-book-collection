<? include "files/conection.php"; ?>
<!DOCTYPE HTML>
<html lang="pt-BR" dir="ltr">
<head>
<? include "inc.head.php"; ?>
</head>

<body>
<section>
    <? include "inc.top.php"; ?>
	<?php
	echo '<div id="content">';
	$tipo = $_GET['tipo'];
	switch ($tipo) {
		case 0: echo "<h2>DVDs</h2>"; break;
		case 1: echo "<h2>Blu-rays</h2>"; break;
	}
	echo '<table>
		<thead>
			<tr>
				<th>Nº</th>
				<th>Título</th>
				<th>Ano</th>
				<th>Diretor</th>
				<th>Especificações</th>
				<th>Preço</th>
			</tr>
		</thead>
		<tbody>';
			$consulta = mysql_query("SELECT titulo,ano,diretor,especificacoes,preco FROM filme WHERE tipo=".$tipo." ORDER BY titulo");
			$x = 1;
			while ($dados = mysql_fetch_row($consulta)) {
				echo "<tr>
					<td>".$x."</td>
					<td class='negrito'>".$dados[0]."</td>
					<td>".$dados[1]."</td>
					<td>".$dados[2]."</td>
					<td>".$dados[3]."</td>
					<td>".$dados[4]."</td>
				</tr>";
				$x++;
			}
	echo '</tbody>
	</table>
	</div>';
	?>
</section>
<? include "inc.nav.php"; ?>
<? include "inc.footer.php"; ?>
</body>
</html>