<?php
  ob_start();
  $page_title = 'Nueva Salida';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_productos = find_allASC('productos');
  $all_destinatarios = find_all('destinatarios');
  $usuario = getIniciales();

?>

<?php

	date_default_timezone_set('America/Argentina/Cordoba');
	$fechaegreso= date("d/m/Y");

 if (isset($_POST['add_salida'])) 
 { 
	$_SESSION['egreso-destinatario'] = $_POST['egreso-destinatario'];
	$_SESSION['egreso-observacion'] = $_POST['egreso-observacion'];
	//$e_observacion = $_POST['egreso-observacion'];
 } 
 else
 {
	 $e_observacion = " ";
 }
 
 if (isset($_POST['add_salida2']))
	 $_SESSION['egreso-observacion'] = $_POST['egreso-observacion'];	 
 else
	 $e_observacion = " ";

	$e_destinatario= $_SESSION['egreso-destinatario'];
	$e_observacion= $_SESSION['egreso-observacion'];

 if(isset($_POST['add_salida']))
 {
   $req_fields = array('egreso-destinatario','egreso-producto', 'egreso-cantidad');
   
   validate_fields($req_fields);
   if(empty($errors))
   {
	$e_producto  = remove_junk($db->escape($_POST['egreso-producto']));
	$e_cantidad  = remove_junk($db->escape($_POST['egreso-cantidad']));
	//$e_observacion  = remove_junk($db->escape($_POST['egreso-observacion']));	
	
	//RESTA CANTIDAD A DB
	foreach ($all_productos as $prod):
		if($prod['id'] == $e_producto)
		{			
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "stock_insumos";

			$total = 0;
			$total = $prod['total'] - $e_cantidad;

			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) 
			{
				die("Connection failed: " . $conn->connect_error);
			}

			$sql = "UPDATE productos SET total = '{$total}' WHERE id = '{$e_producto}'";

			if ($conn->query($sql) === TRUE) {
				echo "Record updated successfully";
			} else {
				echo "Error updating record: " . $conn->error;
			}

			$conn->close();
					
		}	
	endforeach;	
	 
    $query  = "INSERT INTO salidas (";
    $query .= "usuario,dateegreso,destinatario,prod,cantidad,observacion";
    $query .=") VALUES (";
    $query .=" '{$usuario['iniciales']}',(STR_TO_DATE(REPLACE('{$fechaegreso}','/','.') ,GET_FORMAT(date,'EUR'))), '{$e_destinatario}', '{$e_producto}', '{$e_cantidad}', '{$e_observacion}'";
    $query .=")";

    if($db->query($query))
	 {
       $session->msg('s',"Salida cargada.");
       redirect('add_salida2.php', false);
     } 
	 else 
	 {
       $session->msg('d','No se pudo agregar la Salida.');
       redirect('add_salida.php', false);
     }
	} 
	else
	{
		$session->msg("d", $errors);
		redirect('add_salida.php',false);
	}  
 } 
 

 if(isset($_POST['add_salida2']))
 {
	 
   $req_fields = array('egreso-producto','egreso-cantidad');

   validate_fields($req_fields);
   if(empty($errors))
   {
	$e_producto  = remove_junk($db->escape($_POST['egreso-producto']));
	$e_cantidad  = remove_junk($db->escape($_POST['egreso-cantidad']));
	$e_observacion  = remove_junk($db->escape($_POST['egreso-observacion']));
	
	//RESTA CANTIDAD A DB
	foreach ($all_productos as $prod):
		if($prod['id'] == $e_producto)
		{			
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "stock_insumos";

			$total = 0;
			$total = $prod['total'] - $e_cantidad;

			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) 
			{
				die("Connection failed: " . $conn->connect_error);
			}

			$sql = "UPDATE productos SET total = '{$total}' WHERE id = '{$e_producto}'";

			if ($conn->query($sql) === TRUE) {
				echo "Record updated successfully";
			} else {
				echo "Error updating record: " . $conn->error;
			}

			$conn->close();
					
		}	
	endforeach;	
	
    $query  = "INSERT INTO salidas (";
    $query .= "usuario,dateegreso,destinatario,prod,cantidad,observacion";
    $query .=") VALUES (";
    $query .=" '{$usuario['iniciales']}',(STR_TO_DATE(REPLACE('{$fechaegreso}','/','.') ,GET_FORMAT(date,'EUR'))), '{$e_destinatario}', '{$e_producto}', '{$e_cantidad}', '{$e_observacion}'";
    $query .=")";


    if($db->query($query))
	 {
       $session->msg('s',"Salida cargada.");
       redirect('add_salida2.php', false);
     } 
	 else 
	 {
       $session->msg('d','No se pudo agregar la Salida.');
       redirect('add_salida2.php', false);
     }
	} 
	else
	{
		$session->msg("d", $errors);
		redirect('add_salida2.php',false);
	}
    
 }
?>
<?php include_once('layouts/header.php'); ?>

	<div class="row">
	<div class="col-md-12">
    <?php echo display_msg($msg); ?>
	</div>
	</div>

		<div class="row">
		<div class="col-md-10">
		<div class="panel panel-default">
        <div class="panel-heading">
        <strong>
			<span class="glyphicon glyphicon-th"></span>
			<span>Agregar Nueva Salida</span>
        </strong>
        </div>
		
		<div class="panel-body">
        <div class="col-md-20">

	<form method="post" action="add_salida2.php" class="clearfix">

		<div class="panel-body">
        <div class="col-md-20">		
		
			<div class="col-md-7">
			<select class="form-control" name="egreso-producto" tabindex="1">
			<option tabindex="0" value="">Seleccione Producto</option>
			<?php  foreach ($all_productos as $prod): ?>
			<option value="<?php echo (int)$prod['id'] ?>"> 
			<?php echo $prod['name'] ?></option> <!--va a buscar el producto por su id, pero va a mostrar su nombre-->
			<?php endforeach; ?>
			</select>
			</div>
					
			<div class="col-md-4">
            <div class="input-group">
            <span class="input-group-addon">Cantidad</span>
            <input type="number" class="form-control" autocomplete="off" name="egreso-cantidad" placeholder="" tabindex="2">
            </div>
            </div>	
		
		</div>
		</div>		

		
		<div class="panel-body">
			<div class="col-md-12">
			<div class="form-group">
			<div class="row">
			
			<div class="col-md-10">
			<div class="input-group">
			<span class="input-group-addon">Observación</span>
			<textarea name="egreso-observacion"cols="70" rows="5" tabindex="3"></textarea>
			</div>
			</div>

			</div>
			</div>
			</div>
		</div>
		
			<div class="panel-body">
			<div class="col-md-12">
			<div class="form-group">
				
			<div class="col-md-20">
			<button type="submit" name="add_salida2" class="btn btn-success" tabindex="4">AGREGAR SALIDA</button>
			</div>
			</div>
			</div>
			</div>
			
			
		</div>
			
  
  
	</form>
	
	<div class="panel-body">
	<div class="col-md-12">
	<div class="form-group">
				
	<div class="col-md-20">
	<input type="button" value="COMENZAR NUEVA SALIDA" name="B4" class="btn btn-primary" tabindex="5" OnClick=location.href='http://192.168.0.186/stock_insumos/add_salida.php'>
	</div>
	</div>
	</div>
	</div>
	
	


<?php include_once('layouts/footer.php'); ?>


