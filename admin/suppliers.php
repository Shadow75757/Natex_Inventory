<?php

    //incluimos o ficheiro header.inc.php
    include_once("header.inc.php");

    //incluimos o ficheiro db.php
    include_once("db.php");

    //verificar se temos um argumento pagina no GET
    if(isset($_GET["pagina"])) {

        $pagina = $_GET["pagina"];
    } else {

        $pagina = 1;
    }

    //definir o número de registos por pagina
    $nRegistosPagina = 10;
    $regInicial = ($pagina - 1) * $nRegistosPagina;

    $query = "select count(*) from suppliers";
    $resultado = mysqli_query($conexao, $query);
    $totalRegistos = mysqli_fetch_array($resultado)[0];
    $totalPaginas = ceil($totalRegistos / $nRegistosPagina);

    //echo "Total Registos: $totalRegistos <br>";
    //echo "Total Paginas: $totalPaginas";



    //vamos efetuar uma consulta/query na tabela de tarefas da bd
    $query = "select * from suppliers limit $regInicial, $nRegistosPagina";

    //executamos a consulta
    $resultado = mysqli_query($conexao, $query);

    //obtemos uma variavel  com o numero de registos
    $registos = mysqli_num_rows($resultado);

?>

<div class="container">

    <?php

        //mensagens de erro e de sucesso
        if(!empty($_GET["msg"])) {

            $msg = $_GET["msg"];

            //em função do codigo da msg vamos mostrar uma informação
            switch($msg) {

                case 1: 
                    $info = "Supplier inserido com sucesso.";
                    $alert = "alert-success";
                    break;
                case 2:
                    $info = "Supplier atualizado com sucesso.";
                    $alert = "alert-info";
                    break;
                case 3:
                    $info = "Supplier removido com sucesso.";
                    $alert = "alert-danger";
                    break;
                case 4:
                    $info = "O ID não existe na base de dados!";
                    $alert = "alert-danger";
            }
        }

        //se a variavel $info tiver um valor vamos mostrar no ecra 
        if(isset($msg)) {

            ?>

                <div class="alert <?=$alert?> alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><?=$info?></strong>
                </div>

            <?php
        }

    ?>

    <div class ="row">
        <div class="col-6">
            <h2>Suppliers</h2>  
        </div>
        <div class="col-6 text-right">
            <a href="supplier.php"><button type="button" class="btn btn-dark" >+ New Supplier</button></a>
            <a href="suppliers.php"><button type="button" class="btn btn-light">Refresh</button></a>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">E-mail</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php

                //codigo para listar os registos encontrados na tabela tarefas
                if(!empty($registos)) {

                    while($supplier = mysqli_fetch_assoc($resultado)) {

            ?>
            <tr>
                <td scope="row"><?=$supplier["id_supplier"]?></td> 
                <td scope="row"><?=$supplier["nome"]?></td> 
                <td scope="row"><?=$supplier["telemovel"]?></td> 
                <td scope="row"><?=$supplier["email"]?></td>            
                <td scope="row">
                    <a href="supplier_view.php?id=<?=$supplier["id_supplier"]?>"><button type="button" class="btn btn-dark btn-sm mr-1"><i class="fa fa-print text-white"></i></a>
                    <a href="supplier.php?id=<?=$supplier["id_supplier"]?>"><button type="button" class="btn btn-dark btn-sm mr-1"><i class="fa fa-pencil text-white"></i></a>
                    <a href="supplier_remove.php?id=<?=$supplier["id_supplier"]?>" onclick="javascript:return confirm('Would you like to remove the registry?');"><button type="button" class="btn btn-dark btn-sm mr-1"><i class="fa fa-trash text-white"></i></a>
                </td> 
            </tr>
            <?php
                //fecho do if e do while
                    }
                }

            ?>
        </tbody>
    </table>

    <nav aria-label="paginacao">
        <ul class="pagination">
            <li class="page-item <?php if($pagina <=1) { echo "disabled"; } ?>">
                <a class="page-link" href="<?php if($pagina <= 1) { echo "#"; } else { echo "?pagina=".($pagina-1); } ?>">Back</a>
            </li>
            <?php
                //ciclo para efetuar a paginação 1, 2, 3...
                for($i = 1; $i <= $totalPaginas; $i++) {
            ?>
            <li class="page-item <?php if($pagina == $i) { echo "active"; } ?>">
                <a class="page-link" href="?pagina=<?=$i?>"><?=$i?></a>
            </li>
            <?php
                }
            ?>
            <li class="page-item <?php if($pagina == $totalPaginas) { echo "disabled"; } ?>">
                <a class="page-link" href="<?php if($pagina != $totalPaginas) { echo "?pagina=".($pagina+1); } ?>">Next</a>
            </li>
        </ul>
    </nav>

</div>

<?php

    //incluimos o ficheiro footer.inc.php
    include_once("footer.inc.php");

?>