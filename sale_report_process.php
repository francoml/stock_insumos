<?php ob_start();
$page_title = 'Sales Report';
$results = '';
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
      $results      = salidas_desde_hasta($start_date,$end_date); #results -> se imprime por pantalla mas abajo // find_sale_by_dates es una consulta sql
    else:
      $session->msg("d", $errors);
      redirect('sales_report.php', false);
    endif;

  } else {
    $session->msg("d", "Select dates");
    redirect('sales_report.php', false);
  }
?>
  <?php include_once('layouts/header.php'); ?>
  <div class="row">
  <div class="col-md-4">
    <div class="panel">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
          <form class="clearfix" method="post" action="sale_report_process.php">
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
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
		<strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>HISTORIAL DEL "<?php echo $inicio;?>" AL "<?php echo $fin;?>"</span>
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
              <?php foreach ($results as $result):?>
              <tr>
                <td class="text-center"> <?php echo count_id();?></td>              
				<td class="text-center"> <?php echo remove_junk($result['usuario']); ?></td>
                <td class="text-center"> <?php echo remove_junk($result['dateegreso']); ?></td>
                <td class="text-center"> <?php echo remove_junk($result['nombredest']); ?></td>
				<td class="text-center"> <?php echo remove_junk($result['name']); ?></td>
				<td class="text-center"> <?php echo remove_junk($result['cantidad']); ?></td>
                <td class="text-center"> <?php echo remove_junk($result['observacion']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_salida.php?id=<?php echo (int)$result['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_salida.php?id=<?php echo (int)$result['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
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