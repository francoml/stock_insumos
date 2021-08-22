<?php ob_start();
$page_title = 'Salidas de Hoy';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
?>

<?php
date_default_timezone_set('America/Argentina/Cordoba');
$year  = date('Y');
$month = date('m');
$day = date('d');
$salidas = salidasDiarias($year, $month, $day);
?>
<?php include_once('layouts/header.php'); ?>

<div class="container-fluid col-9">
	<?php echo display_msg($msg); ?>
</div>

<div class="container-fluid col-12 border border-light border-2 rounded box">

  <div class="estiloHeader">
    <h2>Salidas del Día</h2>
  </div>

  <br>
  <div class="table-responsive">
    <table class="table table-dark table-striped">
      <thead>
        <tr>
          <th class="text-center">#</th>
          <th class="text-center"> Usuario </th>
          <th class="text-center"> Fecha de Egreso </th>
          <th class="text-center"> Destinatario </th>
          <th class="text-center"> Producto </th>
          <th class="text-center"> Cantidad </th>
          <th class="text-center"> Observación </th>
          <th class="text-center"> Modificar </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($salidas as $salida) : ?>
          <tr>
            <td class="text-center"> <?php echo count_id(); ?></td>
            <td class="text-center"> <?php echo remove_junk($salida['usuario']); ?></td>
            <td class="text-center"> <?php echo remove_junk($salida['dateegreso']); ?></td>
            <td class="text-center"> <?php echo remove_junk($salida['nombredest']); ?></td>
            <td class="text-center"> <?php echo remove_junk($salida['name']); ?></td>
            <td class="text-center"> <?php echo remove_junk($salida['cantidad']); ?></td>
            <td class="text-center"> <?php echo remove_junk($salida['observacion']); ?></td>
            <td class="text-center">
              <div class="btn-group">
                <a href="edit_salidas_diarias.php?id=<?php echo (int)$salida['id']; ?>" class="btn btn-info btn-sm" title="Editar" data-toggle="tooltip">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <a href="delete_salidas_diarias.php?id=<?php echo (int)$salida['id']; ?>" class="btn btn-danger btn-sm" title="Eliminar" data-toggle="tooltip">
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