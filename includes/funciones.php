<?php

function incluirTemplate( string $nombre, bool $inicio = false )
{
    include TEMPLATES_URL . "/{$nombre}.php";
}

function mostrarValores($param_1)
{
    echo '<pre>';
    var_dump($param_1);
    echo '</pre>';
}   // Here End Function

function estaAutenticado() : bool
{
        // Start Session
        session_start();

        $auth = $_SESSION['login'];

        if($auth)
        {
            return true;
        }   // Here End If

        return false;
}   // Here End Function

function escaparHTML( $hmtl ) : string
{
    $sanitizado = htmlspecialchars($hmtl);
    return $sanitizado;
}   // Here End Function

function validarTipoContenido($tipo)
{
    $tipos = ['vendedor', 'propiedad'];

    return in_array( $tipo, $tipos );
}   // Here End Function

function mostrarNotificacion( $numero )
{
    switch( $numero )
    {
        case 1: $mensaje = 'Creado Correctamente'; break;
        case 2: $mensaje = 'Actualizado Correctamente'; break;
        case 3: $mensaje = 'Eliminado Correctamente'; break;
        default: $mensaje = false; break;
        return $mensaje;
    }   // Her End Switch

}   // Here End Function

?>