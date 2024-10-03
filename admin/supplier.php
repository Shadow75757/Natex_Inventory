<?php

    //vamos verificar se temos umget
    if($_SERVER["REQUEST_METHOD"] == "GET") {

        //vamos verificar se e passado um valor no id e se e mesmo é numerico (ex: id=1)
        if(isset($_GET["id"]) && is_numeric($_GET["id"])) {

            //incluimos o ficheiro db.phpque faz a ligação a base de dados mysql
            include_once("db.php");

            //definimos a variavel idTarefa
            $idSupplier = $_GET["id"];

            //efetuamos uma consulta select apenas para a tarefa com o respectivo id
            $query = "select * from suppliers where id_supplier=$idSupplier";

            //executamos a consulta
            $resultado = mysqli_query($conexao, $query);

            //obtemos uma variavel com o numero de registos encontrados na consulta
            $registos = mysqli_num_rows($resultado);  
            
            //vamos retornar uma variavel tarefa com o resultado em formato de array
            $supplier = mysqli_fetch_row($resultado);
            $nomeSupplier = $supplier[1];
            $moradaSupplier = $supplier[2];
            $telemovelSupplier = $supplier[3];
            $emailSupplier = $supplier[4];
            $obsSupplier = $supplier[5];
        } else {

            //se não temos um id colocamos as variaveis em empty
            $idSupplier = "";
            $nomeSupplier = "";
            $moradaSupplier = "";
            $telemovelSupplier = "";
            $emailSupplier = "";
            $obsSupplier = "";
        }
    }

    //vamos verificar se existe um POST (que é quando o botao editar / guardar e carregado)
    if($_SERVER["REQUEST_METHOD"] == "POST") {
               
        //incluimos o ficheiro db.php
        include_once("db.php");

        //vamos verificar se os campos estão preenchidos e definimos as variaveis
        if(!empty($_POST["nomeSupplier"])) {
            $nomeSupplier = $_POST["nomeSupplier"];
        } else {
            $nomeSupplier = "";
        }

        //de outra forma com if ternário
        $idSupplier = (!empty($_POST["idSupplier"])) ? $_POST["idSupplier"] : "";
        $moradaSupplier = (!empty($_POST["moradaSupplier"])) ? $_POST["moradaSupplier"] : "";
        $telemovelSupplier = (!empty($_POST["telemovelSupplier"])) ? $_POST["telemovelSupplier"] : "";
        $emailSupplier = (!empty($_POST["emailSupplier"])) ? $_POST["emailSupplier"] : "";
        $obsSupplier = (!empty($_POST["obsSupplier"])) ? $_POST["obsSupplier"] : "";
        
        //inserir uma nova tarefa ou editar uma existente
        //se tivermos um ID estamos a editar, sem ID estamos a adicionar uma nova
        if(empty($idSupplier)) {

            //query para inserir nova tarefa
            $query = "insert into suppliers (nome, morada, telemovel, email, obs) values('$nomeSupplier', '$moradaSupplier', '$telemovelSupplier', '$emailSupplier', '$obsSupplier')";

            //executamos a consulta 
            $resultado = mysqli_query($conexao, $query);

            //se o resultado retornar um true encaminhamos para a página tarefas com msg=1
            if($resultado) {
                header("location: suppliers.php?msg=1");
            }

        } else {

            //query para editar tarefa existente
            $query = "update suppliers set nome='$nomeSupplier', morada='$moradaSupplier', telemovel='$telemovelSupplier', email='$emailSupplier', obs='$obsSupplier' where id_supplier=$idSupplier";
            
            //executamos a consulta 
            $resultado = mysqli_query($conexao, $query);

            //se o resultado retornar um true encaminhamos a pagina para o tarefas.php com uma msg=2
            if($resultado) {

                header("location: suppliers.php?msg=2");
            }
        }
    }

    //incluimos o ficheiro header.inc.php
    include_once("header.inc.php");

?>

<div class="container">
    <h2>Supplier</h2> 
    <hr>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group row">
            <label for="nomeSupplier" class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-7">
            <input type="text" name="nomeSupplier" id="nomeSupplier" class="form-control" placeholder="Nome" value="<?=$nomeSupplier?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="moradaSupplier" class="col-sm-3 col-form-label">Adress</label>
            <div class="col-sm-7">
            <input type="text" name="moradaSupplier" id="moradaSupplier" class="form-control" placeholder="Company adress" value="<?=$moradaSupplier?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="telemovelSupplier" class="col-sm-3 col-form-label">Phone</label>
            <div class="col-sm-7">
            <input type="text" name="telemovelSupplier" id="telemovelSupplier" class="form-control" placeholder="Phone" value="<?=$telemovelSupplier?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="emailSupplier" class="col-sm-3 col-form-label">E-mail</label>
            <div class="col-sm-7">
            <input type="text" name="emailSupplier" id="emailSupplier" class="form-control" placeholder="E-mail" value="<?=$emailSupplier?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="obsSupplier" class="col-sm-3 col-form-label">Observations</label>
            <div class="col-sm-7">
            <input type="text" name="obsSupplier" id="obsSupplier" class="form-control" placeholder="Personal observations about the supplier" value="<?=$obsSupplier?>">
            </div>
        </div>
        <div class="col-sm-2">
                <input type="hidden" name="idSupplier" value="<?=$idSupplier?>">
                <button type="submit" name="enviar" class="btn btn-dark">Save</button>&nbsp<a href="suppliers.php"><button type="button" class="btn btn-light">Cancel</button></a>
            </div>
        </div>
    </form>
</div>

<?php

    //incluimos o ficheiro footer.inc.php
    include_once("footer.inc.php");

?>