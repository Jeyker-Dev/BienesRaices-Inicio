<?php

function conectarDB() : mysqli
{
    $database = mysqli_connect('localhost', 'root', 'J0K3R1178', 'bienesraices_crud');

    if(!$database)
    {
        echo "No se Pudo Conectar A La Base de Datos";
        exit;
    }   // Here End If

    return $database;
}   // Here End Function
?>