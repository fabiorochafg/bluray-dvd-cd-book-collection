<?php include "files/conection.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Lista de DVDs</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body>
<?php
$tipo = $_GET['tipo'];
switch ($tipo) {
	case 0: echo "<h2>DVDs</h2>"; break;
	case 1: echo "<h2>Blu-rays</h2>"; break;
}
echo '<table width="97%" align="center">';
$consulta = mysql_query("SELECT titulo FROM filme WHERE tipo=".$tipo." ORDER BY titulo");
$x = 1;
while ($dados = mysql_fetch_row($consulta)) {
	echo "<tr>
		<td width='5%'>".$x."</td>
		<td colspan=1 width='95%'>".$dados[0]."</td>
	</tr>";
	$x++;
}
echo '</table>';
?>
</body>
</html>