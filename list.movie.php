<?php include "files/conection.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Lista de DVDs</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="97%" align="center">
<?php
$consulta=mysql_query("SELECT * FROM filme ORDER BY titulo");
$x=1;
while ($dados=mysql_fetch_array($consulta)) {
  echo "<tr><td width='5%'>".$x."</td><td colspan=1 width='95%'>".$dados['titulo']."</td></tr>";
  $x++;
}
?>
</table>
</body>
</html>