<?php

    //ficheiro para visualizar/imprimir um registo da tabela tarefas

    //vamos verificar se existe um GET
    if($_SERVER["REQUEST_METHOD"] == "GET") {

        //vamos verificar se é passado um valor numerico do id
        if(isset($_GET["id"]) && is_numeric($_GET["id"])) {

            //definimos uma variavel
            $idSupplier = $_GET["id"];

            //incluimos o ficheiro db.php
            include_once("db.php");

            //vamos verificar se existe o id na base de dados
            $query = "select * from suppliers where id_supplier=$idSupplier";

            //executamos a consulta
            $resultado = mysqli_query($conexao, $query);

            //atribuimos a variavel o numero de registos encontrados na query
            $supplierEncontrado = mysqli_num_rows($resultado);

            //vamos obter um array com os valores do registo
            $supplier = mysqli_fetch_array($resultado);
            $nomeSupplier = $supplier[1];
            $moradaSupplier = $supplier[2];
            $telemovelSupplier = $supplier[3];
            $emailSupplier = $supplier[4];
            $obsSupplier = $supplier[5];

            //limpar a variavel resultado
            mysqli_free_result($resultado);

            //se existir od id, vamos tratar de mostrar dos dados tarefa
            if($supplierEncontrado > 0) {

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
                        <h1><?php echo $nomeSupplier; ?></h1>
                    </div>

                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-sm-4 col-md-6 col-lg-4 col-xl-2">
                                <p><strong>Morada</strong></p>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-8 col xl-10">
                                <p><?=$moradaSupplier?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 col-md-6 col-lg-4 col-xl-2">
                                <p><strong>Telemóvel</strong></p>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-8 col xl-10">
                                <p><?=$telemovelSupplier?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 col-md-6 col-lg-4 col-xl-2">
                                <p><strong>E-mail</strong></p>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-8 col xl-10">
                                <p><?=$emailSupplier?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 col-md-6 col-lg-4 col-xl-2">
                                <p><strong>Observações</strong></p>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-8 col xl-10">
                                <p><?=$obsSupplier?></p>
                            </div>
                        </div>

                    </div>

                    <div class="footer">
                        <hr>
                        <div class="container">
                            <p>&copy; 2022 - natex - Gestão de Reparações</p>
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