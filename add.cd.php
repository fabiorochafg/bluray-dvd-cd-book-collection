<?php include "files/conection.php"; ?>
<?php include "files/inc.functions.php"; ?>
<!DOCTYPE HTML>
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
            $album = $_POST['album'];
            $artista = $_POST['artista'];
            $ano = $_POST['ano'];
            $especificacoes = $_POST['especificacoes'];

            $consulta = mysql_query("SELECT album FROM cd WHERE album='".$album."' AND artista='".$artista."'");
            if (mysql_num_rows($consulta) > 0) {
                echo '<script>
                document.location="add.cd.php?msg=2";
                </script>';
            } else if (is_uploaded_file($_FILES['imagem']['tmp_name']) && (
                strtolower(end(explode('.', $_FILES['imagem']['name'])))=='jpg' || 
                strtolower(end(explode('.', $_FILES['imagem']['name'])))=='jpeg' || 
                strtolower(end(explode('.', $_FILES['imagem']['name'])))=='gif')) {

                $arquivo = date("Y-m-d")."_".date("His")."_".strtolower(preg_replace(array('/([`\?!^~\'"])/','/([^a-z0-9])/i','/(-+)/'),array('','-','-'),iconv('UTF-8', 'ASCII//TRANSLIT', $filme))).".".end(explode('.', $_FILES['imagem']['name']));
                move_uploaded_file($_FILES['imagem']['tmp_name'], "photos/".$arquivo);
                criarThumbnail($arquivo, 180, "photos/", "photos/");

                $consulta=mysql_query("INSERT INTO cd (album,imagem,artista,ano,especificacoes,data) values ('".$album."','".$arquivo."','".$artista."','".$ano."','".$especificacoes."',now())");
                echo '<script>
                document.location="add.cd.php?msg=1";
                </script>';
            } else {
                echo '<script type="text/javascript">
                document.location="add.cd.php?msg=3";
                </script>';
            }
        } else {
        ?>
            <h2>Adicionando CD</h2>
            <?php
            if (isset($_GET['msg'])) {
                switch ($_GET['msg']) {
                    case 1: echo "<p class='msg success'>Cadastro realizado com sucesso!</p>"; break;
                    case 2: echo "<p class='msg error'>Este CD já foi cadastrado.</p>"; break;
                    case 3: echo "<p class='msg error'>Não foi possível cadastrar a imagem para o CD.</p>"; break;
                }
            }
            ?>          
            <form method="post" action="add.cd.php?cod=1" enctype="multipart/form-data">
            <p class="msg-obrigatorio">Os campos obrigatórios estão marcados com asterisco.</p>
            <label for="album">* Álbum</label>
            <input type="text" id="album" name="filme" />
            <label for="artista">* Artista</label>
            <input type="text" id="artista" name="artista" />
            <label for="ano">* Ano</label>
            <input type="text" id="ano" name="ano" class="input_mini" />
            <label for="imagem">* Imagem <span>(Somente arquivos .jpg ou .gif. A imagem será visualizada com largura de 180 pixels.)</span></label>
            <input id="imagem" name="imagem" type="file" />
            <label for="">Especificações</label>
            <input type="text" name="especificacoes" class="nao-obrigatorio" />
            <input type="submit" value="Adicionar" />
        <?php
        }
        ?>
    </div>    
</div>
<? include "inc.footer.php"; ?>
</body>
</html>