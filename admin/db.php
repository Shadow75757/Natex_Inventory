<?php

    //ligação ao servidor de mysql

    //definição de dados de acesso através de constantes
    define("DBSERVER", "localhost");
    define("DBUSER", "root");
    define("DBPWD", "");
    define("DBNAME", "natex");

    $conexao = mysqli_connect(DBSERVER, DBUSER, DBPWD, DBNAME);

    //verificar a ligação
    if($conexao == false) {

        die("Erro: " . mysqli_connect_erro());
    }
    else {

        //echo "Ligação estabelecida com sucesso<br>";
        //echo mysqli_get_host_info($conexao);
    }

?>