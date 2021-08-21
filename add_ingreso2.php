<?php
ob_start();
$page_title = 'Nuevo Ingreso';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
$all_productos = find_allASC('productos');
$all_proveedores = find_all('proveedores');
$usuario = getIniciales();

?>

<?php

date_default_timezone_set('America/Argentina/Cordoba');
$fechacarga = date("d/m/Y");

if (isset($_POST['add_ingreso'])) {
	$_SESSION['ingreso-proveedor'] = $_POST['ingreso-proveedor'];
	$_SESSION['ingreso-remito'] = $_POST['ingreso-remito'];
	$_SESSION['ingreso-dateingreso'] = $_POST['ingreso-dateingreso'];
	$_SESSION['ingreso-observacion'] = $_POST['ingreso-observacion'];
} else {
	$i_observacion = " ";
}

if (isset($_POST['add_ingreso2'])) {
	$_SESSION['ingreso-observacion'] = $_POST['ingreso-observacion'];
} else {
	$i_observacion = " ";
}

$i_proveedor = $_SESSION['ingreso-proveedor'];
$i_remito = $_SESSION['ingreso-remito'];
$i_dateingreso = $_SESSION['ingreso-dateingreso'];
$i_observacion = $_SESSION['ingreso-observacion'];

if (isset($_POST['add_ingreso'])) {
	$req_fields = array(
		'ingreso-proveedor', 'ingreso-remito', 'ingreso-dateingreso',
		'ingreso-nombre', 'ingreso-marca', 'ingreso-datevencimiento', 'ingreso-cantidad'
	);

	validate_fields($req_fields);
	if (empty($errors)) {
		$i_nombre  = remove_junk($db->escape($_POST['ingreso-nombre']));
		$i_marca  = remove_junk($db->escape($_POST['ingreso-marca']));
		$i_datevencimiento  = remove_junk($db->escape($_POST['ingreso-datevencimiento']));
		$i_cantidad  = remove_junk($db->escape($_POST['ingreso-cantidad']));

		//AGREGAR CANTIDAD A DB
		foreach ($all_productos as $prod) :
			if ($prod['id'] == $i_nombre) {
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "stock_insumos";

				$total = 0;
				$total = $prod['total'] + $i_cantidad;

				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				$sql = "UPDATE productos SET total = '{$total}' WHERE id = '{$i_nombre}'";

				if ($conn->query($sql) === TRUE) {
					echo "Record updated successfully";
				} else {
					echo "Error updating record: " . $conn->error;
				}

				$conn->close();
			}
		endforeach;

		$query  = "INSERT INTO remitos (";
		$query .= "usuario,dateingreso,datecarga,proveedor,remito,nombre,marca,datevencimiento,cantidad,observacion";
		$query .= ") VALUES (";
		$query .= " '{$usuario['iniciales']}',(STR_TO_DATE(REPLACE('{$i_dateingreso}','/','.') ,GET_FORMAT(date,'EUR'))),(STR_TO_DATE(REPLACE('{$fechacarga}','/','.') ,GET_FORMAT(date,'EUR'))), '{$i_proveedor}', '{$i_remito}',  '{$i_nombre}', '{$i_marca}',(STR_TO_DATE(REPLACE('{$i_datevencimiento}','/','.') ,GET_FORMAT(date,'EUR'))), '{$i_cantidad}', '{$i_observacion}'";
		$query .= ")";

		if ($db->query($query)) {
			$session->msg('s', "Ingreso cargado ");
			redirect('add_ingreso2.php', false);
		} else {
			$session->msg('d', ' Lo siento, no se pudo realizar el ingreso :( ');
			redirect('ingreso.php', false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('add_ingreso.php', false);
	}
}


if (isset($_POST['add_ingreso2'])) {
	$req_fields = array('ingreso-nombre', 'ingreso-marca', 'ingreso-datevencimiento', 'ingreso-cantidad');

	validate_fields($req_fields);
	if (empty($errors)) {
		$i_nombre  = remove_junk($db->escape($_POST['ingreso-nombre']));
		$i_marca  = remove_junk($db->escape($_POST['ingreso-marca']));
		$i_datevencimiento  = remove_junk($db->escape($_POST['ingreso-datevencimiento']));
		$i_cantidad  = remove_junk($db->escape($_POST['ingreso-cantidad']));

		//AGREGAR CANTIDAD A DB
		foreach ($all_productos as $prod) :
			if ($prod['id'] == $i_nombre) {
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "stock_insumos";

				$total = 0;
				$total = $prod['total'] + $i_cantidad;

				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				$sql = "UPDATE productos SET total = '{$total}' WHERE id = '{$i_nombre}'";

				if ($conn->query($sql) === TRUE) {
					echo "Record updated successfully";
				} else {
					echo "Error updating record: " . $conn->error;
				}

				$conn->close();
			}
		endforeach;

		$query  = "INSERT INTO remitos (";
		$query .= "usuario,dateingreso,datecarga,proveedor,remito,nombre,marca,datevencimiento,cantidad,observacion";
		$query .= ") VALUES (";
		$query .= " '{$usuario['iniciales']}',(STR_TO_DATE(REPLACE('{$i_dateingreso}','/','.') ,GET_FORMAT(date,'EUR'))),(STR_TO_DATE(REPLACE('{$fechacarga}','/','.') ,GET_FORMAT(date,'EUR'))), '{$i_proveedor}', '{$i_remito}',  '{$i_nombre}', '{$i_marca}', (STR_TO_DATE(REPLACE('{$i_datevencimiento}','/','.') ,GET_FORMAT(date,'EUR'))), '{$i_cantidad}', '{$i_observacion}'";
		$query .= ")";

		if ($db->query($query)) {
			$session->msg('s', "Ingreso cargado ");
			redirect('add_ingreso2.php', false);
		} else {
			$session->msg('d', ' Lo siento, no se pudo agregar el ingreso :( ');
			redirect('ingreso.php', false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('add_ingreso2.php', false);
	}
}

?>
<?php include_once('layouts/header.php'); ?>

<div class="container-fluid col-9">
	<?php echo display_msg($msg); ?>
</div>


<form method="post" action="add_ingreso2.php" class="clearfix">

	<div class="container-fluid col-8 border border-light border-2 rounded box">


		<div class="row estiloHeader">
			<h2>Remito N° <?php echo $i_remito; ?></h2>
		</div>

		<br>
		<div class="row justify-content-between">
			<div class="col-md-6">
				<label for="inputdate" class="form-label">Producto</label>
				<select class="form-control shadow-sm" name="ingreso-nombre" tabindex="1">
					<option value="">Seleccione Producto</option>
					<?php foreach ($all_productos as $prod) : ?>
						<option value="<?php echo (int)$prod['id'] ?>">
							<?php echo $prod['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-md-3">
				<label for="inputdate" class="form-label">Marca</label>
				<input type="text" class="form-control shadow-sm" name="ingreso-marca" placeholder="" tabindex="2">
			</div>
			<div class="col-md-3">
				<label for="inputdate" class="form-label">Vencimiento</label>
				<input type="text" class="datepicker form-control shadow-sm" name="ingreso-datevencimiento" autocomplete="off" placeholder="" tabindex="3">
			</div>
		</div>
		<br>
		<div class="row justify-content-between">
			<div class="col-md-2">
				<label for="inputdate" class="form-label">Cantidad</label>
				<input type="number" min="1" class="form-control shadow-sm" autocomplete="off" name="ingreso-cantidad" placeholder="" tabindex="4">
			</div>
			<div class="col-md-6">
				<label for="inputdate" class="form-label">Observaciones</label>
				<textarea class="form-control shadow-sm" name="ingreso-observacion" rows="3" tabindex="5"></textarea>
			</div>
		</div>
		<br><br>
		<div class="row justify-content-end">
			<div class="col-md-2">
				<a href="home.php" class="btn btn-dark hoverDeny" tabindex=""><i class="bi bi-x-square"></i>    FINALIZAR</a>
			</div>
			<br> <br>
			<div class="col-md-3">
				<button type="submit" name="add_ingreso2" class="btn btn-dark hoverAccept" tabindex="9"><i class="bi bi-plus-square"></i>   AGREGAR PRODUCTO</button>
			</div>
		</div>
	</div>
</form>




<!--
<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong>
					<span class="glyphicon glyphicon-th"></span>
					<span>Agregar Nuevo Ingreso</span>
				</strong>
			</div>

			<div class="panel-body">
				<div class="col-md-20">

					<form method="post" action="add_ingreso2.php" class="clearfix">

						<div class="panel-body">
							<div class="col-md-20">
								<div class="col-md-7">
									<select class="form-control" name="ingreso-nombre" tabindex="1">
										<option value="">Seleccione Producto</option>
										<?php foreach ($all_productos as $prod) : ?>
											<option value="<?php echo (int)$prod['id'] ?>">
												<?php echo $prod['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>

						<div class="panel-body">
							<div class="col-md-12">
								<div class="form-group">
									<div class="row">

										<div class="col-md-4">
											<div class="input-group">
												<span class="input-group-addon">Marca</span>
												<input type="text" class="form-control" name="ingreso-marca" placeholder="" tabindex="2">
											</div>
										</div>

										<div class="col-md-4">
											<div class="input-group">
												<span class="input-group-addon">Vencimiento</span>
												<input type="text" class="datepicker form-control" name="ingreso-datevencimiento" autocomplete="off" placeholder="" tabindex="3">
											</div>
										</div>

										<div class="col-md-4">
											<div class="input-group">
												<span class="input-group-addon">Cantidad</span>
												<input type="number" class="form-control" autocomplete="off" name="ingreso-cantidad" placeholder="" tabindex="4">
											</div>
										</div>

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
												<textarea name="ingreso-observacion" cols="70" rows="5" tabindex="5"></textarea>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>

						<div class="panel-body">
							<div class="col-md-12">


								<button type="submit" name="add_ingreso2" class="btn btn-success" tabindex="6">AGREGAR INGRESO</button>

							</div>
						</div>






					</form>
				</div>

				<div class="panel-body">
					<div class="col-md-12">
						<div class="form-group">

							<div class="col-md-20">
								<input type="button" value="COMENZAR NUEVO REMITO" name="B4" class="btn btn-primary" tabindex="7" OnClick=location.href='http://192.168.0.186/stock_insumos/add_ingreso.php'>
							</div>
						</div>
					</div>
				</div>
										
										-->

				<?php include_once('layouts/footer.php'); ?>