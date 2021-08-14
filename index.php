<?php
  ob_start();
  $page_title = 'SGI HNST CBA';
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<?php include_once('layouts/header2.php'); ?>
<!-- <li>
<body>

<nav id="mainNavbar">
  <ul>

    <li>
      <a href="admin.php">
        <i class="glyphicon glyphicon-home"></i>
        <span>ADMIN.PHP</span>
      </a>
    </li>

    <li>
      <a href="#" class="submenu-toggle">
        <i class="glyphicon glyphicon-user"></i>
        <span>USUARIOS</span>
      </a>
      <ul class="nav submenu">
        <li><a href="users.php">Lista de Usuarios</a> </li>
        <li><a href="group.php">Lista de Grupos</a> </li>
      </ul>
    </li>

    <li>
      <ul>
        <a href="index.php">
          <i class="glyphicon glyphicon-home"></i>
          <span>INICIO</span>
        </a>
      </ul>
    </li>

    <li>
      <a href="#" class="submenu-toggle">
        <i class="glyphicon glyphicon-plus"></i>
        <span>INGRESOS</span>
      </a>
      <ul class="nav submenu">
        <li><a href="add_ingreso.php">Agregar Ingresos</a> </li>
        <li><a href="ingresos_diarios.php">Ingresos de Hoy</a> </li>
        <li><a href="ingreso.php">Historial de Ingresos</a> </li>
        <li><a href="reporte_ingresos.php">Ingresos por Fecha</a> </li>
        <li><a href="product.php">Historial de Ingresos*</a> </li>
       <li><a href="add_product.php">Agregar Ingreso*</a> </li> 
      </ul>
    </li>

    <li>
      <a href="#" class="submenu-toggle">
        <i class="glyphicon glyphicon-minus"></i>
        <span>SALIDAS</span>
      </a>
      <ul class="nav submenu">
        <li><a href="add_salida.php">Agregar Salida</a> </li>
        <li><a href="salidas_diarias.php">Salidas de Hoy</a> </li>
        <li><a href="salidas.php">Historial de Salidas</a> </li>
        <li><a href="reporte_salidas.php">Salidas por Fecha</a> </li>
         <li><a href="sales.php">Historial de Salidas*</a> </li> 
         <li><a href="add_sale.php">Agregar Salida*</a> </li>
      </ul>
    </li>

    <li>
      <ul>
        <a href="stock_actual.php">
          <i class="glyphicon glyphicon-list-alt"></i>
          <span>STOCK ACTUAL</span>
        </a>
      </ul>
    </li>

    <li>
      <a href="#" class="submenu-toggle">
        <i class="glyphicon glyphicon-ok"></i>
        <span>LISTAS VALIDACIÓN</span>
      </a>
      <ul class="nav submenu">
        <li><a href="producto.php">Lista de Productos</a> </li>
        <li><a href="proveedor.php">Lista de Proveedores</a> </li>
        <li><a href="destinatario.php">Lista de Destinatarios</a> </li>
      </ul>
    </li>

    <li>
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
  </li> 

  </ul> -->
</nav>

<div class="login-page">
    <div class="text-center">
       <h1>Bienvenido</h1>
       <p>Sistema de Gestión de Insumos</p>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="auth.php" class="clearfix">
        <div class="form-group">
              <label for="username" class="control-label">Usuario</label>
              <input type="name" class="form-control" name="username" placeholder="">
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Contraseña</label>
            <input type="password" name= "password" class="form-control" placeholder="">
        </div>
        <div class="form-group">
                <button type="submit" class="btn btn-info  pull-right">Iniciar Sesión</button>
        </div>
    </form>
</div>
</body>
<?php include_once('layouts/footer.php'); ?>
