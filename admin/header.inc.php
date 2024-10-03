<?php

  //incluir o ficheiro para validar login
  include_once("check_session.php");

?>
<!DOCTYPE html>
<html lang="pt-PT" xmlns:mso="urn:schemas-microsoft-com:office:office" xmlns:msdt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Natex - Admin System</title>
    <!-- jQuery -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <!--Font awesome  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">

</head>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark mb-4">
  <a class="navbar-brand h5" href="home.php">Natex - Admin area</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto h5">

      <!-- Dropdown Reparações -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Stock</a>
        <div class="dropdown-menu" style="text-align: center">
          <a class="dropdown-item" href="home.php">Product List</a>
          <a class="dropdown-item" href="product.php">New Product</a>
        </div>
      </li>

      <!-- Dropdown suppliers -->
      <li class="nav-item dropdown ml-5">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Suppliers</a>
        <div class="dropdown-menu" style="text-align: center">
          <a class="dropdown-item" href="suppliers.php">Suppliers List</a>
          <a class="dropdown-item" href="supplier.php">New Supplier</a>
        </div>
      </li>

      <li class="nav-item ml-5">
        <a class="nav-link" href="logout.php">Logout as: <?php if(isset($_SESSION["username"])) { echo $_SESSION["username"];} ?></a>
      </li>

    </ul>
  </div>
</nav>

<body>