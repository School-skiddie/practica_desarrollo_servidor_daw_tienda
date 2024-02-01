<?php
$titulo = "Inicio sesión";
include "head.php";
?>
<body>
    <?php
    include "side.php";
    ?>
    <div class="container h-100">
        <?php
        if (isset($_POST["iniciar_sesion"])) 
        {
            inicio_sesion([ $odb, $_POST["Cod_usuario"], $_POST["Clave"] ]);
        }
        ?>
        <form method="POST">
            <div class="card" style="margin-top: 30px; margin-bottom: 10px;">
                    <div class="card-header">Iniciar sesión</div>
                    <div class="card-body">
                        <div class="form-group">
                                <label>Usuario</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-person-circle"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="Cod_usuario" placeholder="Usuario" required>
                                </div>
                        </div>
                        <div class="form-group">
                                <label>Contraseña</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-key-fill"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="Clave" placeholder="Clave" required>
                                </div>
                        </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success" name="iniciar_sesion"><i class="bi bi-box-arrow-right"></i> Iniciar sesión</button>
            </div>
            </form>
        </div>
    </div>
</body>

</html>