<?php

    //ficheiro para remover os registos da tabela tarefas

    //vamos verificar se existe um GET
    if($_SERVER["REQUEST_METHOD"] == "GET") {

        //vamos verificar se é passado um valor numerico no id
        if(isset($_GET["id"]) && is_numeric($_GET["id"])) {

           //definir uma variavel
           $idProduto = $_GET["id"];

           //incluimos o ficheiro db.php
           include_once("db.php");

           //vamos verificar se existe o ID na base de dados
           $query = "select * from produtos where id_produto=$idProduto";

           //executamos a consulta
           $resultado = mysqli_query($conexao, $query);

           //atribuimos à variável o numero de registos retornado pela query
           $produtoEncontrada = mysqli_num_rows($resultado);

           //limpar a variavel resultado
           mysqli_free_result($resultado);

           //se existir o id, podemos remove-lo
           if($produtoEncontrada > 0) {

                //efetuamos uma consulta
                $query = "delete from produtos where id_produto=$idProduto";

                //executamos a consulta
                $resultado = mysqli_query($conexao, $query);

                //se resultado retornar true, encaminhamos com msg 3
                if($resultado) {

                    header("location: home.php?msg=3");
                }
           }
           else {

                header("location: home.php?msg=4");
           }

           //fechamos a ligação ao mysql
           mysqli_close($conexao);
        }
    }

?>