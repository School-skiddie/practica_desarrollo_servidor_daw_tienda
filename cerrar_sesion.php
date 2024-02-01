<?php
include "librerias/db.php";
include "librerias/libreria.php";

borrar_carrito([ $odb, $_SESSION["Cod_usuario"]]);

@session_destroy();
header( "Refresh:1; url='inicio_sesion.php'");
?>