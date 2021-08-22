<?php ob_start();
$page_title = 'Reporte de Salidas';
$results = '';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
?>
<?php

if (isset($_POST['reporte'])) {
  $_SESSION['start-date'] = $_POST['start-date'];
  $_SESSION['end-date'] = $_POST['end-date'];
}

$inicio = $_SESSION['start-date'];
$fin = $_SESSION['end-date'];

if (isset($_POST['reporte'])) {
  $req_dates = array('start-date', 'end-date');
  validate_fields($req_dates);

  if (empty($errors)) :
    $start_date   = remove_junk($db->escape($_POST['start-date']));
    $end_date     = remove_junk($db->escape($_POST['end-date']));
    $results      = salidas_desde_hasta($start_date, $end_date); #results -> se imprime por pantalla mas abajo // find_sale_by_dates es una consulta sql
  else :
    $session->msg("d", $errors);
    redirect('reporte_salidas.php', false);
  endif;
} else {
  $session->msg("d", "Elija las fechas.");
  redirect('reporte_salidas.php', false);
}
?>
<?php include_once('layouts/header.php'); ?>

<form class="" method="post" action="reporte_salidas2.php">
  <div class="container-fluid col-8 border border-light border-2 rounded box">
    <br>
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
<br>

<div class="container-fluid col-9">
  <?php echo display_msg($msg); ?>
</div>

<!-- TABLA -->

<div class="container-fluid col-12 border border-light border-2 rounded box">

  <div class="row estiloHeader">
    <h2>HISTORIAL DE SALIDAS DEL "<?php echo $inicio; ?>" AL "<?php echo $fin; ?>"</h2>
  </div>

  <br>

  <div class="table-responsive">
    <table class="table table-dark table-striped">
      <thead>
        <tr>
          <th class="text-center">#</th>
          <th class="text-center">Usuario</th>
          <th class="text-center">Fecha de Egreso</th>
          <th class="text-center">Destinatario</th>
          <th class="text-center">Producto</th>
          <th class="text-center">Cantidad</th>
          <th class="text-center">Observación</th>
          <th class="text-center">Modificar</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($results as $result) : ?>
          <tr>
            <td class="text-center"> <?php echo count_id(); ?></td>
            <td class="text-center"> <?php echo remove_junk($result['usuario']); ?></td>
            <td class="text-center"> <?php echo remove_junk($result['dateegreso']); ?></td>
            <td class="text-center"> <?php echo remove_junk($result['nombredest']); ?></td>
            <td class="text-center"> <?php echo remove_junk($result['name']); ?></td>
            <td class="text-center"> <?php echo remove_junk($result['cantidad']); ?></td>
            <td class="text-center"> <?php echo remove_junk($result['observacion']); ?></td>
            <td class="text-center">
              <div class="btn-group">
                <a href="edit_reporte_salidas.php?id=<?php echo (int)$result['id']; ?>" class="btn btn-info btn-sm" title="Editar" data-toggle="tooltip">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <a href="delete_reporte_salidas.php?id=<?php echo (int)$result['id']; ?>" class="btn btn-danger btn-sm" title="Eliminar" data-toggle="tooltip">
                  <i class="bi bi-trash"></i>
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>