<?php

    //ficheiro para visualizar/imprimir um registo da tabela tarefas

    //vamos verificar se existe um GET
    if($_SERVER["REQUEST_METHOD"] == "GET") {

        //vamos verificar se é passado um valor numerico do id
        if(isset($_GET["id"]) && is_numeric($_GET["id"])) {

            //definimos uma variavel
            $idProduto = $_GET["id"];

            //incluimos o ficheiro db.php
            include_once("db.php");

            //vamos verificar se existe o id na base de dados
            $query = "select * from produtos where id_produto=$idProduto";
            
            //executamos a consulta
            $resultado = mysqli_query($conexao, $query);

            //atribuimos a variavel o numero de registos encontrados na query
            $produtoEncontrada = mysqli_num_rows($resultado);

            //vamos obter um array com os valores do registo
            $produto = mysqli_fetch_array($resultado);
            $codigoProduto = $produto[1];
            $id_supplier = $produto[2];
            $produtoProduto = $produto[3];
            $barcodeProduto = $produto[4];
            $obsProduto = $produto[5];

            //limpar a variavel resultado
            mysqli_free_result($resultado);

            //se existir od id, vamos tratar de mostrar dos dados tarefa
            if($produtoEncontrada > 0) {

                //vamos trabalhar a pagina de apresentação dos dados da tarefa
            ?>

                <!DOCTYPE html>
                <html lang="pt-PT" xmlns:mso="urn:schemas-microsoft-com:office:office" xmlns:msdt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>natex</title>
                    <!-- Bootstrap -->
                    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
                    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
                </head>

                <body onload="window.print();">


                
                    <div class="jumbotron">
                        <p><?php
                
                        $query2 = "select nome from suppliers WHERE id_supplier = " . $id_supplier;

                        //executamos a consulta
                        $resultado2 = mysqli_query($conexao, $query2);

                        //obtemos uma variavel  com o numero de registos
                        $registos2 = mysqli_num_rows($resultado2);

                        if(!empty($registos2)) {

                            while($produto2 = mysqli_fetch_assoc($resultado2)){
                                echo "<h1>" . $produto2["nome"] . "</h1>";
                            }
                        }
                
                ?></p>
                        <p><?php echo $codigoProduto; ?></p>
                    </div>

                    <div class="container-fluid">
                    <div class="row">
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-6 col-lg-4 col-xl-2">
                                <p><strong>Produto</strong></p>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-8 col xl-10">
                                <p><?=$produtoProduto?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 col-md-6 col-lg-4 col-xl-2">
                                <p><strong>BarCode</strong></p>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-8 col xl-10">
                                <p><?=$barcodeProduto?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 col-md-6 col-lg-4 col-xl-2">
                                <p><strong>Observações</strong></p>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-8 col xl-10">
                                <p><?=$obsProduto?></p>
                            </div>
                        </div>

                    </div>

                    <div class="footer">
                        <hr>
                        <div class="container">
                            <p><b>&copy; 2023 - Natex - <span style="font-size: 125%; color: #4CB204">Mais</span> por <span style="font-size: 75%; color: #FF0000">menos</span></b></p>
                        </div>        
                    </div>

                </body>
                </html>

            <?php
            } else {

                header("location: suppliers.php?msg=4");
            }

            //fechar a ligação ao mysql
            mysqli_close($conexao);
        }
    }

?>