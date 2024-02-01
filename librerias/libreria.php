<?php

function inicio_sesion($parametros) {
    $SQLSelect = $parametros[0] -> query("SELECT * FROM `usuarios`");
    while ($tabla = $SQLSelect -> fetch(PDO::FETCH_ASSOC)) 
    {
        if($tabla["Cod_usuario"] == $parametros[1] && password_verify($parametros[2], $tabla["Clave"])) 
        {
            $_SESSION["Cod_usuario"] = $tabla["Cod_usuario"];
            $_SESSION["Clave"] = $tabla["Clave"];

            echo "<div class='alert alert-success' style='margin-top: 30px;' role='alert'>Bienvenido de vuelta <b>" . $_SESSION["Cod_usuario"] . "</b> seras rederigido en 3 segundos...</div>";
            header( "Refresh:3; url='productos.php'");
        }
        else
        {
            echo "<div class='alert alert-danger' style='margin-top: 30px;' role='alert'> El usuario no existe..</div>";
        }
    }
}

function comprobar($parametros) {
    try 
    {
        $SQLread = $parametros[0] -> prepare("SELECT COUNT(*) FROM `usuarios` WHERE `Cod_usuario` = :Cod_usuario OR `Nif` = :Nif OR `Telefono` = :Telefono OR `Mail` = :Mail");
        $SQLread -> execute(array(":Cod_usuario" => $parametros[1],
        ":Nif" => $parametros[4],
        ":Telefono" => $parametros[5],
        ":Mail" => $parametros[7]));

        $existe = $SQLread -> fetchColumn(0);
        if (!($existe > 0)) 
            return true;
    } 
    catch (Exception $e) 
    {
        echo "<div class='alert alert-danger' style='margin-top: 30px;' role='alert'> No se ha podido obtener la información de la tabla debido a un error de " . $e->getMessage() . "</div>";
    }

    return false;
}

function registrar($parametros) {
    try 
    {
        if(comprobar($parametros)) {
            $SQLinsert = $parametros[0]->prepare("INSERT INTO `usuarios` VALUES (:Cod_usuario, :Clave, :Nombre, :Nif, :Telefono, :Direccion, :Mail)");
            $SQLinsert->execute(array(":Cod_usuario" => $parametros[1],
            ":Clave" => $parametros[2],
            ":Nombre" => $parametros[3],
            ":Nif" => $parametros[4],
            ":Telefono" => $parametros[5],
            ":Direccion" => $parametros[6],
            ":Mail" => $parametros[7]));
            echo "<div class='alert alert-success' style='margin-top: 30px;' role='alert'>Se ha registrado correctamente</div>";
        }
        else
        {
            echo "<div class='alert alert-danger' style='margin-top: 30px;' role='alert'> El usuario insertado ya existe..</div>";
        }
    } 
    catch (Exception $e) 
    {
        echo "<div class='alert alert-danger' style='margin-top: 30px;' role='alert'> No se ha podido obtener la información de la tabla debido a un error de " . $e->getMessage() . "</div>";
    }
}

function eliminar_carrito($parametros) {
    try 
    {
        if($parametros[3] >= $parametros[4]) 
        {
            $SQLdelete = $parametros[0]->prepare("DELETE FROM `carrito` WHERE `Cod_usuario` = :Cod_usuario AND `Cod_prod` = :Cod_prod");
            $SQLdelete->execute(array(":Cod_prod" => $parametros[1],
                                            ":Cod_usuario" => $parametros[2]));
        }
        else
        {
            $SQLupdate = $parametros[0]->prepare("UPDATE `carrito` SET `Cantidad` = `Cantidad` - :Cantidad WHERE `Cod_usuario` = :Cod_usuario AND `Cod_prod` = :Cod_prod");
            $SQLupdate->execute(array(":Cod_prod" => $parametros[1],
                                            ":Cantidad" => $parametros[3],
                                            ":Cod_usuario" => $parametros[2]));
        }

        $SQLupdate = $parametros[0]->prepare("UPDATE `productos` SET `Stock` = `Stock` + :Cantidad WHERE `Cod_prod` = :Cod_prod");
        $SQLupdate->execute(array(":Cod_prod" => $parametros[1],
                                            ":Cantidad" => $parametros[3]));
    } 
    catch (Exception $e) 
    {
        echo "<div class='alert alert-danger' style='margin-top: 30px;' role='alert'> No se ha podido obtener la información de la tabla debido a un error de " . $e->getMessage() . "</div>";
    }
}

function añadir_carrito($parametros) {
    try 
    {
        $SQLread = $parametros[0] -> prepare("SELECT COUNT(*) FROM `carrito` WHERE `Cod_usuario` = :Cod_usuario AND `Cod_prod` = :Cod_prod");
        $SQLread -> execute(array(":Cod_usuario" => $parametros[4],
        ":Cod_prod" => $parametros[1]));

        $existe = $SQLread -> fetchColumn(0);
        if ($existe > 0) 
        {
            $SQLupdate = $parametros[0]->prepare("UPDATE `carrito` SET `Cantidad` = `Cantidad` + :Cantidad WHERE `Cod_usuario` = :Cod_usuario AND `Cod_prod` = :Cod_prod");
            $SQLupdate->execute(array(":Cod_prod" => $parametros[1],
                                    ":Cantidad" => $parametros[3],
                                    ":Cod_usuario" => $parametros[4]));
        }
        else
        {
            $SQLinsert = $parametros[0]->prepare("INSERT INTO `carrito` VALUES (:Cod_prod, :Nombre, :Cantidad, :Cod_usuario)");
            $SQLinsert->execute(array(":Cod_prod" => $parametros[1],
            ":Nombre" => $parametros[2],
            ":Cantidad" => $parametros[3],
            ":Cod_usuario" => $parametros[4]));
        }

        $SQLupdate = $parametros[0]->prepare("UPDATE `productos` SET `Stock` = `Stock` - :Cantidad WHERE `Cod_prod` = :Cod_prod");
        $SQLupdate->execute(array(":Cod_prod" => $parametros[1],
                                    ":Cantidad" => $parametros[3]));
    } 
    catch (Exception $e) 
    {
        echo "<div class='alert alert-danger' style='margin-top: 30px;' role='alert'> No se ha podido obtener la información de la tabla debido a un error de " . $e->getMessage() . "</div>";
    }
}

function precio_total_carrito($parametros) {
    $SQLSelect = $parametros[0] -> query("SELECT SUM(carrito.Cantidad*productos.Precio) as 'total' FROM `carrito` INNER JOIN `productos` ON productos.Cod_prod=carrito.Cod_prod WHERE `Cod_usuario`='" . $parametros[1] . "'");
                    
    while($datos = $SQLSelect -> fetch(PDO::FETCH_ASSOC)) 
    { 
        return $datos["total"];
    }
}

function finalizar_pedido($parametros) {
    $SQLSelect = $parametros[0] -> query("SELECT carrito.Cod_prod as 'Cod_prod_pedido', carrito.Cod_usuario, carrito.Cantidad*productos.Precio as 'total' FROM `carrito` INNER JOIN `productos` ON productos.Cod_prod=carrito.Cod_prod WHERE `Cod_usuario`='" . $parametros[1] . "'");
                    
    while($datos = $SQLSelect -> fetch(PDO::FETCH_ASSOC)) 
    { 
        $SQLinsert = $parametros[0]->prepare("INSERT INTO `pedidos` (`Fecha`, `Precio_total`, `Cod_prod`, `Cod_usuario`) VALUES (:Fecha, :Precio_total, :Cod_prod, :Cod_usuario)");

        $fecha_actual = date("Y-m-d H:i:s");
        $SQLinsert->execute(array(
            ":Fecha" => $fecha_actual,
            ":Precio_total" => $datos["total"],
            ":Cod_prod" => $datos["Cod_prod_pedido"],
            ":Cod_usuario" => $parametros[1]
        ));

        
        borrar_carrito( [ $parametros[0], $parametros[1] ]);

    }
}

function borrar_carrito($parametros) {
    $SQLdelete = $parametros[0]->prepare("DELETE FROM `carrito` WHERE `Cod_usuario` = :Cod_usuario");
        $SQLdelete->execute(array(":Cod_usuario" => $parametros[1]));
}