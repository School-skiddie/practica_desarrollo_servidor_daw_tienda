<?php
$titulo = "Productos";
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
    <div class="container">
        <?php
        if (isset($_POST["añadir_cesta"])) 
        {

            if($_POST["Cantidad"] > $_POST["Stock"]) 
            {
                echo "<div class='alert alert-danger' style='margin-top: 30px;' role='alert'> No hay suficiente en stock </div>";
            }
            else
            {
                añadir_carrito([ $odb, $_POST["Cod_prod"], $_POST["Nombre"], $_POST["Cantidad"], $_SESSION["Cod_usuario"] ]);

                /* DEBUG */
                // echo $_POST["Cod_prod"] . " " . $_POST["Nombre"] . " " . $_POST["Cantidad"] . " " . $_SESSION["Cod_usuario"];

                echo "<div class='alert alert-success' style='margin-top: 30px;' role='alert'> Se ha añadido el producto " . $_POST["Cod_prod"] . " al carrito </div>";
            }
        }
        ?>
        <div class="row">        
        <?php 
        $SQLSelect = $odb -> query("SELECT * FROM `productos`");
        
        while($datos = $SQLSelect -> fetch(PDO::FETCH_ASSOC)) { 
        ?>
                <div class="col-sm">
                    <form method="POST">
                    <div class="card" style="width: 19rem; margin-top: 25px; margin-bottom: 10px;">
                        <?php if ($datos["Stock"] == 0) { ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            Fuera de stock
                            </span>
                        <?php } else { ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                            <?php echo $datos["Stock"]; ?> en stock
                            </span>
                        <?php } ?>
                        <img class="card-img-top" src="fotos/<?php echo $datos["Foto"]; ?>" style="height: 250px;" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $datos["Nombre"]; ?></h5>
                            <h6 class="card-title">Precio: <?php echo $datos["Precio"]; ?>€</h6>
                            <p class="card-text">
                                <?php echo $datos["Descripcion"]; ?>
                            </p>
                            <input type="hidden" name="Cod_prod" value="<?php echo $datos["Cod_prod"]; ?>"></input>
                            <input type="hidden" name="Nombre" value="<?php echo $datos["Nombre"]; ?>"></input>
                            <input type="hidden" name="Stock" value="<?php echo $datos["Stock"]; ?>"></input>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success" name="añadir_cesta" <?php if ($datos["Stock"] == 0) { echo "disabled='disabled'"; } ?>><i class="bi bi-cart-plus-fill"></i> Añadir a la cesta</button>
                            <input type="number" style="width: 90px;" name="Cantidad" value="1" placeholder="Cantidad" min="1" max="<?php echo $datos["Stock"]; ?>"></input>
                        </div>
                     </div>
                    </form>
                </div>
        <?php } ?>
        </div>
    </div>
</body>
</html>