<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <?php
      if(!isset($_SESSION["Cod_usuario"])) {
      ?>
      <li class="nav-item active">
        <a class="nav-link" href="registro.php">Registrarse</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="inicio_sesion.php">Iniciar sesión</a>
      </li>
      <?php
      }
      else
      {
      ?>
      <li class="nav-item active">
        <a class="nav-link" href="productos.php"><i class="bi bi-bag-fill"></i> Productos</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="carrito.php"><i class="bi bi-cart-fill"></i> Carrito</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="cerrar_sesion.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesion</a>
      </li>
      <?php
      }
      ?>
    </ul>
  </div>
</nav>