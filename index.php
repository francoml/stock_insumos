<?php
  ob_start();
  $page_title = 'SGI HNST CBA';
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<?php include_once('layouts/header2.php'); ?>
<body>

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
