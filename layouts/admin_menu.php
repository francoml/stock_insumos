<div class="collapse navbar-collapse" id="navbarNavDropdown">
  <a class="navbar-brand" href="home.php">Gestion de Insumos</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    <ul class="navbar-nav">

      <li class="nav-item active">
        <a class="nav-link" href="home.php">HOME<span class="sr-only"></span>
        </a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">INGRESOS</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="add_ingreso.php">Agregar Ingresos</a>
          <a class="dropdown-item" href="ingresos_diarios.php">Ingresos de Hoy</a>
          <a class="dropdown-item" href="ingreso.php">Historial de Ingresos</a>
          <a class="dropdown-item" href="reporte_ingresos.php">Ingresos por Fecha</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">SALIDAS</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="add_ingreso.php">Agregar Salidas</a>
          <a class="dropdown-item" href="ingresos_diarios.php">Salidas de Hoy</a>
          <a class="dropdown-item" href="ingreso.php">Historial de Salidas</a>
          <a class="dropdown-item" href="reporte_ingresos.php">Salidas por Fecha</a>
        </div>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="stock_actual.php">STOCK ACTUAL<span class="sr-only"></span>
        </a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="producto.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">LISTA VALIDACION</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="producto.php">Lista de Productos</a>
          <a class="dropdown-item" href="proveedor.php">Lista de Proveedores</a>
          <a class="dropdown-item" href="destinatario.php">Lista de Destinatarios</a>
        </div>



      <li class="nav-item active">
        <strong><?php echo get_date_spanish(time()); ?></strong>
      </li>

      <li>
        <ul class="info-menu pull-right">
          <li class="profile">
            <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
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
      </li>



      <!-- <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-signal"></i>
       <span>REPORTES</span>
      </a>
      <ul class="nav submenu">
        <li><a href="sales_report.php">Salidas por fecha</a></li>
		<li><a href="reporte_salidas.php">Salidas por fecha*</a></li>
		<li><a href="reporte_ingreso.php">Ingresos por fecha*</a></li>
        <li><a href="monthly_sales.php">Salidas Mensuales</a></li>
        <li><a href="daily_sales.php">Salidas Diarias</a> </li>
      </ul>
  </li>
  <li>
    <a href="media.php" >
      <i class="glyphicon glyphicon-picture"></i>
      <span>IMÁGENES</span>
    </a>
  </li> -->
    </ul>
</div>