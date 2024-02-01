<?php
$titulo = "Carrito";
include "head.php";

if(!isset($_SESSION["Cod_usuario"])) {
    header( "Refresh:0; url='inicio_sesion.php'");
    exit();
}
?>
<body>
    <?php
    include "side.php";
    ?>
    <div class="container h-100">
        <?php
        if (isset($_POST["finalizar"])) 
        {
            echo "<div class='alert alert-success' style='margin-top: 30px;' role='alert'>Se ha realizado el pedido...</div>";
            finalizar_pedido([ $odb, $_SESSION["Cod_usuario"]]);
        }
        if(isset($_POST["eliminar"]))
        {
            eliminar_carrito([ $odb, $_POST["Cod_prod"], $_SESSION["Cod_usuario"], $_POST["Cantidad"], $_POST["Cantidad_actual"]]);
            echo "<div class='alert alert-danger' style='margin-top: 30px;' role='alert'>Se ha eliminado " . $_POST["Cantidad"] . " <b>(Cantidad)</b> del producto " . $_POST["Nombre"] . " </div>";
        }
        ?>
        <form method="POST">
        <div class="card" style="margin-top: 30px; margin-bottom: 10px;">
                <div class="card-header"><b>Carrito de la compra</b></div>
                <div class="card-body">
                <table class="table caption-top">
                <caption>Mi carrito</caption>
                    <thead>
                        <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Cantidad que de sea eliminar</th>
                        <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $SQLSelect = $odb -> query("SELECT * FROM `carrito` INNER JOIN `productos` ON productos.Cod_prod=carrito.Cod_prod WHERE `Cod_usuario`='" . $_SESSION["Cod_usuario"] . "'");
                    
                    while($datos = $SQLSelect -> fetch(PDO::FETCH_ASSOC)) { 
                    ?>
                        <form method="POST">
                        <tr>
                        <td><img style="height: 30px;" src="fotos/<?php echo $datos["Foto"] ?>"></img></td>
                        <td><?php echo $datos["Nombre"] ?></td>
                        <td><?php echo $datos["Cantidad"] ?></td>
                        <td><input type="number" name="Cantidad" placeholder="Cantidad" value="1" min="1" max="<?php echo $datos["Cantidad"] ?>"></input></td>
                        <td><button type="submit" class="btn btn-danger" name="eliminar"><i class="bi bi-trash-fill"></i></button></td>
                        </tr>
                        <input type="hidden" name="Cod_prod" value="<?php echo $datos["Cod_prod"]; ?>"></input>
                        <input type="hidden" name="Cantidad_actual" value="<?php echo $datos["Cantidad"]; ?>"></input>
                        <input type="hidden" name="Nombre" value="<?php echo $datos["Nombre"]; ?>"></input>
                        </form>
                    <?php 
                    }
                    ?>
                    </tbody>
                </table>
                </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info text-white" name="finalizar" <?php if(empty(precio_total_carrito([ $odb, $_SESSION["Cod_usuario"] ]))) echo "disabled='disabled'" ?>><i class="bi bi-check2-all"></i> Finalizar pedido</button>
                <label style="float: right;">
                
                <?php if(empty(precio_total_carrito([ $odb, $_SESSION["Cod_usuario"] ]))) { echo "No hay nada en el carrito.."; } else { echo "<b>Precio total: </b>" . precio_total_carrito([ $odb, $_SESSION["Cod_usuario"] ]) . "€";  }?></label>
            </div>
            </form>
        </div>
    </div>
</body>

</html>