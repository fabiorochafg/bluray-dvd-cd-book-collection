<?php include "arquivos/conexao.php"; ?>
<?php include "arquivos/inc.functions.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
<head>
<? include "arquivos/inc.head.php"; ?>
</head>

<body>
<div class="container">
    <? include "arquivos/inc.top.php"; ?>
    <div class="box box6">
        <?php
        $total = mysql_num_rows(mysql_query('SELECT titulo FROM filme WHERE tipo=1'));
        echo '<h3>Blu-rays</h3>';
        if ($total > 0) {
            echo '<h4>'.$total.'</h4>
            <ul class="list list33">';
            $consulta = mysql_query("SELECT titulo,imagem FROM filme WHERE tipo=1 ORDER BY rand() LIMIT 0,3");
            while ($dados = mysql_fetch_row($consulta)) {
                echo '<li><img src="fotos/'.$dados[1].'" alt="'.$dados[0].'" /></li>';
            }
            echo '</ul>';
        }        
        ?>
        <ul class="action action50">
            <li><a href="add.movie.php?tipo=1">Novo</a></li>
            <li><a href="view.movie.php?tipo=1">Lista</a></li>
        </ul>
    </div>
    <div class="box box6">        
        <?php
        $total = mysql_num_rows(mysql_query('SELECT titulo FROM filme WHERE tipo=0'));
        echo '<h3>DVDs</h3>';
        if ($total > 0) {
            echo '<h4>'.$total.'</h4>
            <ul class="list list33">';
            $consulta = mysql_query('SELECT titulo,imagem FROM filme WHERE tipo=0 ORDER BY rand() LIMIT 0,3');
            while ($dados = mysql_fetch_row($consulta)) {
                echo '<li><img src="fotos/'.$dados[1].'" alt="'.$dados[0].'" /></li>';
            }
            echo '</ul>';
        }
        ?>
        <ul class="action action50">
            <li><a href="add.movie.php?tipo=0">Novo</a></li>
            <li><a href="view.movie.php?tipo=0">Lista</a></li>
            <!-- <li><a href="listas/lista_dvds.php">Lista Simples</a></li> -->
            <!-- <li><a href="relatorios/dvds1.php">Relatórios</a></li> -->
        </ul>
    </div>
    <!-- <div class="box box6"> -->
        <?php
        // $total = mysql_num_rows(mysql_query('SELECT album FROM cd'));
        // echo '<h3>CDs</h3>';
        // if ($total > 0) {
        //     echo '<h4>'.$total.'</h4>
        //     <dl>';
        //     $consulta = mysql_query('SELECT album FROM cd ORDER BY id_cd DESC LIMIT 0,14');
        //     while ($dados = mysql_fetch_row($consulta)) {
        //         echo '<dd>'.$dados[0].'</dd>';
        //     }
        //     echo '<dd>(...)</dd>
        //     </dl>';
        // }
        ?>
        <!-- <ul class="action action50">
            <li><a href="cadastros/cad_cds.php">Novo</a></li>
            <li><a href="alteracoes/alt_cds1.php">Lista</a></li>
        </ul> -->
    <!-- </div> -->
    <!-- <div class="box box6"> -->
        <?php
        // $total = mysql_num_rows(mysql_query('SELECT titulo FROM livro'));
        // echo '<h3>Livros</h3>';
        // if ($total > 0) {
        //     echo '<h4>'.$total.'</h4>
        //     <dl>';
        //     $consulta = mysql_query('SELECT titulo FROM livro ORDER BY id_livro DESC LIMIT 0,10');
        //     while ($dados = mysql_fetch_row($consulta)) {
        //         echo '<dd>'.$dados[0].'</dd>';
        //     }
        //     echo '<dd>(...)</dd>
        //     </dl>';
        // }
        ?>
        <!-- <ul class="action action33">
            <li><a href="cadastros/cad_livros.php">Novo</a></li>
            <li><a href="alteracoes/alt_livros1.php">Lista</a></li>
            <li><a href="listas/lista_livros1.php">Relatórios</a></li>
        </ul> -->
    <!-- </div>     -->
</div>
<? include "arquivos/inc.footer.php"; ?>
</body>
</html>