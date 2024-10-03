<?php

//iniciamos uma sessao
session_start();

//verificar se o utilizador esta com login efetuado, se sim encaminhar para a pagina home.php
if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {

    header("location: home.php");
    exit;
}

//carregar o ficheiro db.php responsável pelo acesso à bd
include_once("db.php");

//verificar se há um post
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //verificar os campos username e password
    if (empty($_POST["username"]) || empty($_POST["password"])) {

        //redirecionamos para a página index.php com o código de erro = 1
        header("location: index.php?erro=1");
    } else {

        //definimos as variáveis
        $username = $_POST["username"];
        $password = $_POST["password"];

        //consulta à base de dados
        $query = "select * from staff where username='$username'";

        //executar a consulta 
        $resultado = mysqli_query($conexao, $query);

        //se o resultado resultar num true...
        if ($resultado) {

            $utilizador = mysqli_fetch_row($resultado);
            $idUtilizador = $utilizador[0];
            $usernameUtilizador = $utilizador[1];
            $passwordUtilizador = $utilizador[2];

            //verificar a password
            if (password_verify($password, $passwordUtilizador)) {

                //se a password estiver correta iniciamos uma sessão
                session_start();

                //guardar dados em variaveis de sessao
                $_SESSION["login"] = true;
                $_SESSION["id"] = $idUtilizador;
                $_SESSION["username"] = $usernameUtilizador;

                //redirecionamos para a pagina home.php
                header("location: home.php");
            } else {

                //no caso da password inválida redirecionamos para o index.php com erro 2
                header("location: index.php?erro=2");
            }
        }

        //fechar a ligação ao mysql
        mysqli_close($conexao);
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title>Natex - Restricted</title>
    <!-- jQuery -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom CSS neste caso para diminuir o tamanho do container em ecrãs de menor resolução -->
    <style>
        body {
            background-color: rgb(32, 32, 32);
            background-image: linear-gradient(45deg, black 25%, transparent 25%, transparent 75%, black 75%, black), linear-gradient(45deg, black 25%, transparent 25%, transparent 75%, black 75%, black), linear-gradient(to bottom, rgb(8, 8, 8), rgb(32, 32, 32));
            background-size: 10px 10px, 10px 10px, 10px 5px;
            background-position: 0px 0px, 5px 5px, 0px 0px;
        }

        .container {
            background-color: #B9B9B9;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        h5 {
            color: #ff0000;
        }

        @media screen and (min-width: 900px) {

            .container {
                max-width: 40% !important;
            }
        }
    </style>

<body>

    <div class="container">

        <h2 style="text-align:center"><b>Admin Restricted Area</b></h2>
        <br>
        <p><b>
                <h5><u>Disclaimer:</u></h5>The access to this area is strictly limited to authorized system
                administrators and staff members.</p>
        <p>Any unauthorized attempts to access this area may result in legal actions against the trespasser.</b></p>

        <form action="index.php" method="post">

            <div class="form-group">

                <label>Username:</label>
                <input type="text" name="username" class="form-control" value="">

            </div>

            <div class="form-group">

                <label>Password:</label>
                <input type="password" name="password" class="form-control">

            </div>

            <div class="form-group">

                <input type="submit" class="btn btn-danger" value="Login">

            </div>

        </form>

        <?php

        //tratar as mensagens de erro
        if (!empty($_GET["erro"])) {

            $erro = $_GET["erro"];

            //em função do código do erro apresentamos uma mensagem
            switch ($erro) {

                case 1:
                    $erro_descricao = "Invalid username/password!";
                    break;

                case 2:
                    $erro_descricao = "Incorrect username/password!";
                    break;
            }
        }

        //apresentar a mensagem de erro
        if (isset($erro)) {
            ?>
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>
                    <?= $erro_descricao ?>
                </strong>
            </div>
            <?php
        }
        ?>

    </div>

</body>

<head>

</html>