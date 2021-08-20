<?php ob_start();
$page_title = 'Reporte de Salidas';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-4 box">
    <div class="panel">

      <div class="panel-body">
          <form class="clearfix" method="post" action="reporte_salidas2.php">
            <div class="form-group">
              <label class="form-label">Rango de Fechas</label>
                <div class="input-group">
                  <input type="text" class="datepicker form-control" name="start-date" autocomplete="off" placeholder="Desde">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" name="end-date" autocomplete="off" placeholder="Hasta">
                </div>
            </div>
            <div class="form-group">
                 <button type="submit" name="reporte" class="btn btn-primary">Filtrar</button>
            </div>
          </form>
      </div>

    </div>
  </div>

</div>
<?php include_once('layouts/footer.php'); ?>
