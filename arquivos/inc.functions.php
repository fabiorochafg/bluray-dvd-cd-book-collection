<?php
function criarThumbnail($imagem, $x, $thumbs, $servidor) {
	$extensao = explode(".",$imagem);
	$extensao = strtoupper(end($extensao));
	
	if (($extensao=="JPG") OR ($extensao=="JPEG")) {
		$tipo = "JPEG";
	} else if ($extensao=="GIF") {
		$tipo = "GIF";
	} else if ($extensao=="PNG") {
		$tipo = "PNG";
	} else {
		$tipo = "NULL";
	}
	
	$CriarImagemDe = 'ImageCreateFrom'.$tipo;
	$img = $CriarImagemDe($servidor.$imagem);
	
	$qualidade = "100";
	
	$largura = ImageSX($img);
	$altura = ImageSY($img);
	$img_largura = $x;
	$img_altura = $altura * $x / $largura;
	
	$img_nova = imagecreatetruecolor($x,$img_altura);
	imagecopyresampled($img_nova,$img,0,0,0,0,$img_largura,$img_altura,$largura,$altura);
	
	ImageInterlace($img_nova,1);
	$Image = "Image".$tipo;
	$Image($img_nova,$thumbs.$imagem,"$qualidade");
	ImageDestroy($img_nova);
	ImageDestroY($img);
}
?>