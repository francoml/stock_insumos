<?php ob_start();
$page_title = 'Reporte de Ingresos';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
?>
<?php include_once('layouts/header.php'); ?>

<div class="container-fluid col-9">
  <?php echo display_msg($msg); ?>
</div>

<form class="" method="post" action="reporte_ingresos2.php">

  <div class="container-fluid col-8 border border-light border-2 rounded box">

    <div class="row estiloHeader">
      <h2>Ingresos por Fecha</h2>
    </div>

    <br>

    <div class="row" style="text-align: center;">
      <div class="col-12">
        <h5>Rango de Fechas</h5>
      </div>
    </div>

    <div class="row flexColumna">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="input-group">
            <input type="text" class="datepicker form-control" name="start-date" autocomplete="off" placeholder="Desde">
            <span class="input-group-text" id="inputGroup-sizing-default"><i class="bi bi-arrow-right-circle-fill"></i></span>
            <input type="text" class="datepicker form-control" name="end-date" autocomplete="off" placeholder="Hasta">
          </div>
        </div>

        <div class="row col-md-8 justify-content-center">
          <button type="submit" name="reporte" class="btn btn-dark hoverAccept"><i class="bi bi-funnel"></i> FILTRAR</button>
        </div>
      </div>
      <br>
    </div>

  </div>

</form>
<?php include_once('layouts/footer.php'); ?>