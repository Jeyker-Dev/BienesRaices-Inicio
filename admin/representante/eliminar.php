<?php

// Include a Template
require '../../includes/app.php';
    require '../../includes/funciones.php';
    incluirTemplate('header');

    // Import Conecction
    require '../../includes/config/database.php';

    // Database
    $database = conectarDB();
    
    // Dialogo
    require '../../includes/template/dialogos.php';

    // Start Session
    $auth = estaAutenticado();

    //Write Query
    $query = "SELECT * FROM representante";

    // Consult Database
    $resultadoConsulta = mysqli_query($database, $query);

     // Get Id from Url
     $id = $_GET['id'];

     // Validate URL
     $id = filter_var($id, FILTER_VALIDATE_INT);

     if($_SERVER['REQUEST_METHOD'] === 'POST')
     {
         // Delete Data From Database
         if($id)
         {
             // Delete A Data from table
             $query = "DELETE FROM representante WHERE id = {$id}";
             $resultado = mysqli_query($database, $query);
 
             if($resultado)
             {
                 header('Location: /admin/representante/index.php?resultado=3');
             }   // Here End If

         }   // Here End If

     }   // Here End If

?>

                        <form id="confirmForm" action="" method="POST" class="w-100">
                            <h1>CONFIRME LA ELIMINACION</h1>
                            <style>form{height: 220px; } h1{margin-bottom: 50px;}</style>
                        <!-- <input type="hidden" name="id" value=" <?php /*echo $propiedad['id']; */?> " /> -->
                        <label for="btn-confirm" class="boton-rojo-block">Eliminar</label>
                        </form>

                        <?php
    // Include Footer
    mysqli_close($database);
    incluirTemplate('footer');

?>