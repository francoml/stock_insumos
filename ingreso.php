<?php ob_start();
$page_title = 'Historial de Ingresos';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
$ingresos = join_ingreso_table();
?>
<?php include_once('layouts/header.php'); ?>

<div class="container-fluid col-9">
  <?php echo display_msg($msg); ?>
</div>

<div class="container-fluid col-12 border border-light border-2 rounded box">

  <div class="col-md-3">
    <a href="add_ingreso.php" class="btn btn-dark hoverAccept"><i class="bi bi-plus-square"></i> AGREGAR NUEVO INGRESO</a>
  </div>

  <br>

  <div class="row estiloHeader">
    <h2>Historial de Ingresos</h2>
  </div>

  <br>

  <div class="table-responsive">
    <table class="table table-dark table-striped">
      <thead>
        <tr>
          <th class="text-center"">#</th>
          <th class=" text-center">Usuario</th>
          <th class="text-center">Fecha de Ingreso</th>
          <th class="text-center">Fecha de Carga</th>
          <th class="text-center">Proveedor</th>
          <th class="text-center">Remito</th>
          <th class="text-center">Producto</th>
          <th class="text-center">Marca</th>
          <th class="text-center">Vencimiento</th>
          <th class="text-center">Cant</th>
          <th class="text-center">Observación</th>
          <th class="text-center">Modificar</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($ingresos as $ingreso) : ?>
          <tr>
            <td class="text-center"> <?php echo count_id(); ?></td>
            <td class="text-center"> <?php echo remove_junk($ingreso['usuario']); ?></td>
            <td class="text-center"> <?php echo remove_junk($ingreso['dateingreso']); ?></td>
            <td class="text-center"> <?php echo remove_junk($ingreso['datecarga']); ?></td>
            <td class="text-center"> <?php echo remove_junk($ingreso['nombre']); ?></td>
            <td class="text-center"> <?php echo remove_junk($ingreso['remito']); ?></td>
            <td class="text-center"> <?php echo remove_junk($ingreso['name']); ?></td>
            <td class="text-center"> <?php echo remove_junk($ingreso['marca']); ?></td>
            <td class="text-center"> <?php echo remove_junk($ingreso['datevencimiento']); ?></td>
            <td class="text-center"> <?php echo remove_junk($ingreso['cantidad']); ?></td>
            <td class="text-center"> <?php echo remove_junk($ingreso['observacion']); ?></td>
            <td class="text-center">
              <div class="btn-group">
                <a href="edit_ingreso.php?id=<?php echo (int)$ingreso['id']; ?>" class="btn btn-info btn-sm" title="Editar" data-toggle="tooltip">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <a href="delete_ingreso.php?id=<?php echo (int)$ingreso['id']; ?>" class="btn btn-danger btn-sm" title="Eliminar" data-toggle="tooltip">
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