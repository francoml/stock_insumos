<?php ob_start();
  $page_title = 'Historial de Salidas';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $salidas = join_salida_table();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
		<strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>HISTORIAL DE SALIDAS</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 2%;">#</th>
                <th class="text-center" style="width: 1%;"> Usuario</th>
                <th class="text-center" style="width: 10%;"> Fecha de Egreso </th>
				<th class="text-center" style="width: 10%;"> Destinatario </th>
				<th class="text-center" style="width: 10%;"> Producto </th>
				<th class="text-center" style="width: 1%;"> Cantidad </th>
                <th class="text-center" style="width: 10%;"> Observación </th>
				<th class="text-center" style="width: 1%;"> Modificar </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($salidas as $salida):?>
              <tr>
                <td class="text-center"> <?php echo count_id();?></td>              
				<td class="text-center"> <?php echo remove_junk($salida['usuario']); ?></td>
                <td class="text-center"> <?php echo remove_junk($salida['dateegreso']); ?></td>
                <td class="text-center"> <?php echo remove_junk($salida['nombredest']); ?></td>
				<td class="text-center"> <?php echo remove_junk($salida['name']); ?></td>
				<td class="text-center"> <?php echo remove_junk($salida['cantidad']); ?></td>
                <td class="text-center"> <?php echo remove_junk($salida['observacion']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_salida.php?id=<?php echo (int)$salida['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_salida.php?id=<?php echo (int)$salida['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
