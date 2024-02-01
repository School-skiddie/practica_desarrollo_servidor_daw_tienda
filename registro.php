<?php
$titulo = "Registro";
include "head.php";
?>
<body>
    <?php
    include "side.php";
    ?>
    <div class="container h-100">
        <?php
        if (isset($_POST["registrar"])) 
        {
            if(strlen($_POST["NIF"]) == 9) 
            {
                registrar([ $odb, $_POST["Cod_usuario"], password_hash($_POST["Clave"], PASSWORD_DEFAULT), $_POST["Nombre"], $_POST["NIF"], $_POST["Telefono"], $_POST["Direccion"], $_POST["Mail"] ]);
            }
            else
            {
                echo "<div class='alert alert-danger' style='margin-top: 30px;' role='alert'> El DNI es invalido</div>";
            }
        }
        ?>
        <form method="POST">
        <div class="card" style="margin-top: 30px; margin-bottom: 10px;">
                <div class="card-header"><b>Usuario</b></div>
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
        </div>
        <div class="card" style="margin-top: 30px; margin-bottom: 10px;">
                <div class="card-header">Registrarse <b>Formulario</b></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="Nombre" placeholder="Nombre" required>
                    </div>
                    <div class="form-group">
                        <label>NIF</label>
                        <input type="text" class="form-control" name="NIF" placeholder="Nif" required>
                    </div>
                    <div class="form-group">
                            <label>Teléfono</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-telephone-plus-fill"></i></span>
                                </div>
                                <input type="text" class="form-control" name="Telefono" placeholder="Teléfono" required>
                            </div>
                    </div>
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" class="form-control" name="Direccion" placeholder="Direccion" required>
                    </div>
                    <div class="form-group">
                        <label for="validationCustomUsername">Mail</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                            </div>
                            <input type="email" class="form-control" name="Mail" placeholder="Mail" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success" name="registrar"><i class="bi bi-box-arrow-right"></i> Registrarse</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>