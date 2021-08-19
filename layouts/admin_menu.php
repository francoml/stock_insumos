<div class="navbar-header">
  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
    <span class="sr-only"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="home.php">SGI-CBA</a>
</div>

<div class="collapse navbar-collapse midNavBar" id="bs-example-navbar-collapse-1">

  <ul class="nav navbar-nav">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">INGRESOS <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="add_ingreso.php">Agregar Ingresos</a></li>
        <li><a href="ingresos_diarios.php">Ingresos de Hoy</a></li>
        <li><a href="ingreso.php">Historial de Ingresos</a></li>
        <li><a href="reporte_ingresos.php">Ingresos por Fecha</a></li>
      </ul>
    </li>

    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SALIDAS <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="add_salida.php">Agregar Salidas</a></li>
        <li><a href="salidas_diarias.php">Salidas de Hoy</a></li>
        <li><a href="salidas.php">Historial de Salidas</a></li>
        <li><a href="reporte_salidas.php">Salidas por Fecha</a></li>
      </ul>
    </li>

    <li><a href="stock_actual.php">STOCK ACTUAL</a></li>

    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">LISTA VALIDACION <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="producto.php">Lista de Productos</a></li>
        <li><a href="proveedor.php">Lista de Proveedores</a></li>
        <li><a href="destinatario.php">Lista de Destinatarios</a></li>
      </ul>
    </li>
  </ul>

</div>

<div class="userFecha">
  <ul style="list-style-type: none;">
    <li class="fecha"><strong><?php echo get_date_spanish(time()); ?></strong></li>
    <li class="dropdown">
      <a href="#" class="perfil dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <img src="uploads/users/<?php echo $user['image']; ?>" alt="user-image" class="img-circle img-inline">
        <span><?php echo remove_junk(ucfirst($user['name'])); ?> <i class="caret"></i></span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a href="profile.php?id=<?php echo (int)$user['id']; ?>">
            <i class="glyphicon glyphicon-user"></i>
            Perfil
          </a>
        </li>
        <li>
          <a href="edit_account.php" title="edit account">
            <i class="glyphicon glyphicon-cog"></i>
            Opciones
          </a>
        </li>
        <li class="last">
          <a href="logout.php">
            <i class="glyphicon glyphicon-off"></i>
            Salir
          </a>
        </li>
      </ul>
    </li>
  </ul>
</div>