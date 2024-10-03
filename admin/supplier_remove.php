<?php

    // File to remove records from the tasks table

    // Let's check if a GET request exists
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        // Let's check if a numeric value is passed in the id
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {

            // Define a variable
            $idSupplier = $_GET["id"];

            // Include the db.php file
            include_once("db.php");

            // Check if the ID exists in the database
            $query = "select * from suppliers where id_supplier=$idSupplier";

            // Execute the query
            $resultado = mysqli_query($conexao, $query);

            // Assign the number of records returned by the query to the variable
            $supplierEncontrado = mysqli_num_rows($resultado);

            // Clear the resultado variable
            mysqli_free_result($resultado);

            // If the id exists, we can remove it
            if ($supplierEncontrado > 0) {

                // Perform a query
                $query = "delete from suppliers where id_supplier=$idSupplier";

                // Execute the query
                $resultado = mysqli_query($conexao, $query);

                // If the resultado returns true, redirect with message 3
                if ($resultado) {

                    header("location: suppliers.php?msg=3");
                }
            } else {

                header("location: suppliers.php?msg=4");
            }

            // Close the connection to MySQL
            mysqli_close($conexao);
        }
    }

?>
