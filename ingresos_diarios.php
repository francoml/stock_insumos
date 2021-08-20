<?php ob_start();
  $page_title = 'Ingresos de Hoy';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>

<?php
date_default_timezone_set('America/Argentina/Cordoba');
 $year  = date('Y');
 $month = date('m');
 $day = date('d');
 $ingresos = ingresosDiarios($year,$month,$day);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12 box">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Ingresos de hoy</span>
          </strong>
        </div>
        <div class="panel-body" style="overflow:auto;">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 2%;">#</th>
                <th class="text-center" style="width: 1%;"> Usuario</th>
                <th class="text-center" style="width: 10%;"> Fecha de Ingreso </th>
				<th class="text-center" style="width: 10%;"> Fecha de Carga </th>
				<th class="text-center" style="width: 10%;"> Proveedor </th>
				<th class="text-center" style="width: 10%;"> Remito </th>
                <th class="text-center" style="width: 10%;"> Producto </th>
                <th class="text-center" style="width: 10%;"> Marca </th>
                <th class="text-center" style="width: 10%;"> Vencimiento </th>
				<th class="text-center" style="width: 2%;"> Cantidad</th>
				<th class="text-center" style="width: 10%;"> Observación</th>
                <th class="text-center" style="width: 1%;"> Modificar </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($ingresos as $ingreso):?>
              <tr>
                <td class="text-center"> <?php echo count_id();?></td>              
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
                    <a href="edit_ingresos_diarios.php?id=<?php echo (int)$ingreso['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_ingresos_diarios.php?id=<?php echo (int)$ingreso['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach;?>
           </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
