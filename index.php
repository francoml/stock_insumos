<?php
  ob_start();
  $page_title = 'SGI-CBA';
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<?php include_once('layouts/header.php'); ?>

<div class="container col-md-4">
  <div class="row estiloHeader">
      <div class="col">
      <img src="pictures/sgilargo1.png" width="250" height="250" class="img-fluid" alt="">
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
        <br>
        <div class="form-group">
                <button type="submit" class="btn btn-info pull-right hoverInicio">Iniciar Sesión</button>
        </div>
      </form>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
