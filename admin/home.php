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

    $query = "select count(*) from produtos";
    $resultado = mysqli_query($conexao, $query);
    $totalRegistos = mysqli_fetch_array($resultado)[0];
    $totalPaginas = ceil($totalRegistos / $nRegistosPagina);

    //echo "Total Registos: $totalRegistos <br>";
    //echo "Total Paginas: $totalPaginas";


    $query = "SELECT r.id_produto, r.codigo_produto, r.id_supplier, r.produto, r.estado, c.nome AS nomeSupplier from produtos r JOIN suppliers c ON r.id_supplier = c.id_supplier limit $regInicial, $nRegistosPagina";

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
                    $info = "Product successfully inserted";
                    $alert = "alert-success";
                    break;
                case 2:
                    $info = "Product successfully updated";
                    $alert = "alert-info";
                    break;
                case 3:
                    $info = "Product deleted successfully";
                    $alert = "alert-danger";
                    break;
                case 4:
                    $info = "This ID does not exist in the DataBase";
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
            <h2>Existing Stock</h2>  
        </div>
        <div class="col-6 text-right">
            <a href="product.php"><button type="button" class="btn btn-dark" >+ New Product</button></a>
            <a href="home.php"><button type="button" class="btn btn-light">Refresh</button></a>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Product Code</th>
                <th scope="col">Supplier</th>
                <th scope="col">Product</th>
                <th scope="col">State</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php

                //codigo para listar os registos encontrados na tabela produtos
                if(!empty($registos)) {

                    while($produto = mysqli_fetch_assoc($resultado)) {

            ?>
            <tr>
                <td scope="row"><?=$produto["codigo_produto"]?></td> 
                <td scope="row"><?=$produto["nomeSupplier"]?></td> 
                <td scope="row"><?=$produto["produto"]?></td> 
                <td scope="row">
                    
                    <?php
                        //mostrar um botão em função do estado concluido

                        //definicao de variaveis 
                        $idProduto = $produto["id_produto"];
                        $estado = $produto["estado"];

                        //mostrar o botão em função do valor $estado
                        switch($estado) {

                            case 1:
                                echo "<button  type=\"button\" class=\"btn btn-danger btn-sm\">No Stock</button>";
                                echo "</a>";
                                break;
                            case 2:
                                echo "<button type=\"button\" class=\"btn btn-warning btn-sm\">Low Stock</button>";
                                echo "</a>";
                                break;
                            case 3:
                                echo "<button type=\"button\" class=\"btn btn-success btn-sm\">Enough Stock</button>";
                                echo "</a>";
                                break;
                            case 4:
                                echo "<button type=\"button\" class=\"btn btn-info btn-sm\">Waiting for supplier</button>";
                                echo "</a>";
                                break;
                            case 5:
                                echo "<button type=\"button\" class=\"btn btn-primary\">In Delivery</button>";
                                echo "</a>";
                                break;
                            case 6:
                                echo "<button type=\"button\" class=\"btn btn-dark btn-sm\">Canceled</button>";
                                echo "</a>";
                                break;
                        }
                    ?>


                </td>
                <td scope="row">
                    <a href="product_view.php?id=<?=$produto["id_produto"]?>"><button type="button" class="btn btn-dark btn-sm mr-1"><i class="fa fa-print text-white"></i></a>
                    <a href="product.php?id=<?=$produto["id_produto"]?>"><button type="button" class="btn btn-dark btn-sm mr-1"><i class="fa fa-pencil text-white"></i></a>
                    <a href="product_remove.php?id=<?=$produto["id_produto"]?>" onclick="javascript:return confirm('Deseja remover o registo');"><button type="button" class="btn btn-dark btn-sm mr-1"><i class="fa fa-trash text-white"></i></a>
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