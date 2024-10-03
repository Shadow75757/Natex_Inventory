<?php


    //vamos verificar se temos umget
    if($_SERVER["REQUEST_METHOD"] == "GET") {

        //vamos verificar se e passado um valor no id e se e mesmo é numerico (ex: id=1)
        if(isset($_GET["id"]) && is_numeric($_GET["id"])) {

            //incluimos o ficheiro db.phpque faz a ligação a base de dados mysql
            include_once("db.php");

            //definimos a variavel idTarefa
            $idProduto = $_GET["id"];

            //efetuamos uma consulta select apenas para a tarefa com o respectivo id
            $query = "select * from produtos where id_produto=$idProduto";

            //executamos a consulta
            $resultado = mysqli_query($conexao, $query);

            //obtemos uma variavel com o numero de registos encontrados na consulta
            $registos = mysqli_num_rows($resultado);  
            
            //vamos retornar uma variavel tarefa com o resultado em formato de array
            $produto = mysqli_fetch_row($resultado);
            $codigoProduto = $produto[1];
            $idSupplier = $produto[2];
            $produtoProduto = $produto[3];
            $barcodeProduto = $produto[4];
            $obsProduto = $produto[5];
            $estadoProduto = $produto[6];
            $obsEstadoProduto = $produto[7];

        } else {

            //se não temos um id colocamos as variaveis em empty
            $idProduto = "";
            
            //gerar codigo de produto
            $codigoProduto = "";
            $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            for($i = 0; $i <= 5; $i++) {
                $index = rand(0, strlen($caracteres) - 1);
                $codigoProduto .= $caracteres[$index];
            }

            $idSupplier = "";
            $produtoProduto = "";
            $barcodeProduto = "";
            $obsProduto = "";
            $estadoProduto = "";
            $obsEstadoProduto = "";
        }
    }
        
    //vamos verificar se existe um POST (que é quando o botao editar / guardar e carregado)
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        //incluimos o ficheiro db.php
        include_once("db.php");

        //de outra forma com if ternário
        $idProduto = (!empty($_POST["idProduto"])) ? $_POST["idProduto"] : "";
        $codigoProduto = (!empty($_POST["codigoProduto"])) ? $_POST["codigoProduto"] : "";
        $idSupplier = (!empty($_POST["idSupplier"])) ? $_POST["idSupplier"] : "";
        $produtoProduto = (!empty($_POST["produtoProduto"])) ? $_POST["produtoProduto"] : "";
        $barcodeProduto = (!empty($_POST["barcodeProduto"])) ? $_POST["barcodeProduto"] : "";
        $obsProduto = (!empty($_POST["obsProduto"])) ? $_POST["obsProduto"] : "";
        $estadoProduto = (!empty($_POST["estadoProduto"])) ? $_POST["estadoProduto"] : "";
        $obsEstadoProduto = (!empty($_POST["obsEstadoProduto"])) ? $_POST["obsEstadoProduto"] : "";


        
        //inserir uma nova tarefa ou editar uma existente
        //se tivermos um ID estamos a editar, sem ID estamos a adicionar uma nova
        if(empty($idProduto)) {  

            //query para inserir nova tarefa
            $query = "insert into produtos (codigo_produto, id_supplier, produto, barcode, obs, estado, obs_estado) values('$codigoProduto', '$idSupplier', '$produtoProduto', '$barcodeProduto', '$obsProduto', '$estadoProduto', '$obsEstadoProduto')";

            //executamos a consulta
            $resultado = mysqli_query($conexao, $query); 

            //se o resultado retornar um true encaminhamos para a página tarefas com msg=1
            if($resultado) {
                header("location: home.php?msg=1");
            }

        } else {

            //query para editar tarefa existente
            $query = "update produtos set produto = '$produtoProduto', barcode='$barcodeProduto', obs='$obsProduto', estado='$estadoProduto', obs_estado='$obsEstadoProduto' where id_produto=$idProduto";
            
            //executamos a consulta 
            $resultado = mysqli_query($conexao, $query);

            //se o resultado retornar um true encaminhamos a pagina para o tarefas.php com uma msg=2
            if($resultado) {

                header("location: home.php?msg=2");
            }

            $codigoProduto = $resultado["codigo_produto"];
        }
    }

    //incluimos o ficheiro header.inc.php
    include_once("header.inc.php");

?>

<div class="container">
    <h2>New Stock</h2>
    <hr>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group row">
            <label for="codigoProduto" class="col-sm-3 col-form-label">Product code</label>
            <div class="col-sm-7">
            <input type="text" name="codigoProduto" id="codigoProduto" class="form-control" value="<?=$codigoProduto?>" readonly required>
            </div>
        </div>
        <div class="form-group row">
            <label for="idSupplier" class="col-sm-3 col-form-label">Supplier</label>
            <div class="col-sm-7 text-left">
                <select class="form-control" name="idSupplier" id="idSupplier" required>
                <option value="">Select the supplier</option>
                <?php
                    include_once("db.php");
                    
                    $query = "select * from suppliers";

                    //executamos a consulta
                    $resultado = mysqli_query($conexao, $query);
            
                    //obtemos uma variavel com o numero de registos encontrados na consulta
                    $registos = mysqli_num_rows($resultado);

                    if(!empty($registos)) {
                        while($supplier = mysqli_fetch_assoc($resultado)) {  ?>   
                            <option value="<?=$supplier["id_supplier"]?>" <?php if($idSupplier==$supplier["id_supplier"]) echo "selected"; ?>><?=$supplier["nome"]?></option>
                    <?php  
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="produtoProduto" class="col-sm-3 col-form-label">Product</label>
            <div class="col-sm-7">
            <input type="text" name="produtoProduto" id="produtoProduto" class="form-control" placeholder="Insert the new product" value="<?=$produtoProduto?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="barcodeProduto" class="col-sm-3 col-form-label">BarCode</label>
            <div class="col-sm-7">
            <input type="text" pattern="[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]" name="barcodeProduto" id="barcodeProduto" class="form-control" placeholder="Scan the product" value="<?=$barcodeProduto?>" required maxlength="13">
            </div>
        </div>
        <div class="form-group row">
            <label for="obsProduto" class="col-sm-3 col-form-label">Observations</label>
            <div class="col-sm-7">
            <textarea type="text" name="obsProduto" id="obsProduto" class="form-control" placeholder="*optional*" value=""><?=$obsProduto?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-5 text-left">
                <label for="estadoProduto" class="col-sm-3 col-form-label" style="padding-left: 0;">State</label>
                    <select class="form-control" name="estadoProduto" id="estadoProduto" required>
                    <option value="">Select the current state</option> 
                    <option value="1" <?php if($estadoProduto==1) echo "selected"; ?>>No Stock</option>
                    <option value="2" <?php if($estadoProduto==2) echo "selected"; ?>>Low Stock</option>
                    <option value="3" <?php if($estadoProduto==3) echo "selected"; ?>>Enough Stock</option>
                    <option value="4" <?php if($estadoProduto==4) echo "selected"; ?>>Waiting for supplier</option>
                    <option value="5" <?php if($estadoProduto==5) echo "selected"; ?>>In Delivery</option>
                    <option value="6" <?php if($estadoProduto==6) echo "selected"; ?>>Canceled</option>
                    </select>
            </div>

            <div class="col-5 text-left">
                <label for="descricaoProduto" class="col-sm-3 col-form-label" style="max-width: 60%; padding-left: 0;">State Observations</label>
                    <input type="text" name="obsEstadoProduto" id="obsEstadoProduto" class="form-control" value="<?=$obsEstadoProduto?>" placeholder="Ex: Waiting for payment | Being shipped | ...">
            </div>
        </div>  
        <div class="form-group row">
        <div class="col-sm-2">
                <input type="hidden" name="idProduto" value="<?=$idProduto?>">
                <button type="submit" name="enviar" class="btn btn-dark">Save</button>&nbsp<a href="home.php"><button type="button" class="btn btn-light">Cancel</button></a>
            </div>
        </div>
    </form>
</div>

<?php
//incluímos o ficheiro footer.inc.php
include_once("footer.inc.php");
?>