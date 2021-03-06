<? include "files/conection.php"; ?>
<!DOCTYPE HTML>
<html lang="pt-BR" dir="ltr">
<head>
<? include "inc.head.php"; ?>
<script src="files/jquery.masonry.min.js"></script>
<script>
function startMasonry() {
    var container = document.querySelector('#boxes');
    var msnry = new Masonry( container, {
        columnWidth: 45,
        itemSelector: '.box-item'
    });
}
$(function() {

    startMasonry();
    
    $(".tabs a").on('click',function (e) {
        e.preventDefault();
        var ano = $(this).attr("data-year");
        $(".tabs a").removeClass("active");
        $(this).addClass("active");
        if (ano == "Todos") {
            $('.box-item').show();
        } else {
            $('.box-item').each(function() {
                if ($(this).attr("data-year") == ano) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
        startMasonry();
    });
});
</script>
</head>

<body>
<section>
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
        ORDER BY ano DESC');
    $n = mysql_num_rows($consulta);
    echo '<div id="content">
    <h2>Lista de '.$filme.'s ('.$n.' itens)</h2>';  
    if (isset($_GET['msg'])) {
        switch ($_GET['msg']) {
            case 1: echo "<p class='msg success'>Filme atualizado com sucesso!</p>"; break;
            case 2: echo "<p class='msg error'>Não foi possível atualizar este filme.</p>"; break;
        }
    }
    $consultaAno = mysql_query('SELECT ano FROM filme WHERE tipo='.$tipo.' GROUP BY ano ORDER BY ano DESC');
    echo '<ul class="tabs">';
    while ($dadosAno = mysql_fetch_row($consultaAno)) {
        echo '<li><a href="#" data-year="'.$dadosAno[0].'">'.$dadosAno[0].'</a></li>';
    }
    echo '<li><a href="#" data-year="Todos" class="active">Todos</a></li>
    </ul>
    </div>
    <div id="boxes" class="js-masonry">';
        while ($dados = mysql_fetch_row($consulta)) {
            echo "<div class='box-item' data-year='".$dados[2]."'>
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
</section>
<? include "inc.nav.php"; ?>
<? include "inc.footer.php"; ?>
</body>
</html>