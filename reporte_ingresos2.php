<?php ob_start();
$page_title = 'Reporte de Ingresos';
$resultados = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php

if (isset($_POST['reporte'])) 
 { 
	$_SESSION['start-date'] = $_POST['start-date'];
	$_SESSION['end-date'] = $_POST['end-date'];
 } 
 
	$inicio= $_SESSION['start-date'];
	$fin= $_SESSION['end-date'];

  if(isset($_POST['reporte'])){
    $req_dates = array('start-date','end-date');
    validate_fields($req_dates);

    if(empty($errors)):
      $start_date   = remove_junk($db->escape($_POST['start-date']));
      $end_date     = remove_junk($db->escape($_POST['end-date']));
      $resultados      = salidas_desde_hasta2($start_date,$end_date); #results -> se imprime por pantalla mas abajo // find_sale_by_dates es una consulta sql
    else:
      $session->msg("d", $errors);
      redirect('reporte_ingresos.php', false);
    endif;

  } else {
    $session->msg("d", "Select dates");
    redirect('reporte_ingresos.php', false);
  }
?>
  <?php include_once('layouts/header.php'); ?>
  <div class="row">
  <div class="col-md-4">
    <div class="panel box">
 
      <div class="panel-body">
          <form class="clearfix" method="post" action="reporte_ingresos2.php">
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
  
  
  
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default box">
        <div class="panel-heading clearfix">
		<strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>HISTORIAL DE INGRESOS DEL "<?php echo $inicio;?>" AL "<?php echo $fin;?>"</span>
          </strong>

        </div>
        <div class="panel-body">
          <table class="table table-bordered">
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
              <?php foreach ($resultados as $resultado):?>
              <tr>
                <td class="text-center"> <?php echo count_id();?></td>              
				<td class="text-center"> <?php echo remove_junk($resultado['usuario']); ?></td>
                <td class="text-center"> <?php echo remove_junk($resultado['dateingreso']); ?></td>
                <td class="text-center"> <?php echo remove_junk($resultado['datecarga']); ?></td>
				<td class="text-center"> <?php echo remove_junk($resultado['nombre']); ?></td>
				<td class="text-center"> <?php echo remove_junk($resultado['remito']); ?></td>
                <td class="text-center"> <?php echo remove_junk($resultado['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($resultado['marca']); ?></td>
				<td class="text-center"> <?php echo remove_junk($resultado['datevencimiento']); ?></td>
				<td class="text-center"> <?php echo remove_junk($resultado['cantidad']); ?></td>
				<td class="text-center"> <?php echo remove_junk($resultado['observacion']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_reporte_ingresos.php?id=<?php echo (int)$resultado['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_reporte_ingresos.php?id=<?php echo (int)$resultado['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
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