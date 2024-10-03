<?php

    //ficheiro para efetuar logout

    //iniciamos a sessão
    session_start();

    //efetuamos um unset de todas as variáveis de sessão existentes
    $_SESSION = array();

    //destruimos a sessão
    session_destroy();

    //encaminhamos para a página de login
    header("location: index.php");
    exit;

?>