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
$fechaegreso = date("d/m/Y");

if (isset($_POST['add_salida'])) {
	$_SESSION['egreso-destinatario'] = $_POST['egreso-destinatario'];
	$_SESSION['egreso-observacion'] = $_POST['egreso-observacion'];
	//$e_observacion = $_POST['egreso-observacion'];
} else {
	$e_observacion = " ";
}

if (isset($_POST['add_salida2']))
	$_SESSION['egreso-observacion'] = $_POST['egreso-observacion'];
else
	$e_observacion = " ";

$e_destinatario = $_SESSION['egreso-destinatario'];
$e_observacion = $_SESSION['egreso-observacion'];


foreach ($all_destinatarios as $dest) :
	if ($dest['id'] == $e_destinatario) {
		$destino = $dest['nombredest'];
	}
endforeach;


if (isset($_POST['add_salida'])) {
	$req_fields = array('egreso-destinatario', 'egreso-producto', 'egreso-cantidad');

	validate_fields($req_fields);
	if (empty($errors)) {
		$e_producto  = remove_junk($db->escape($_POST['egreso-producto']));
		$e_cantidad  = remove_junk($db->escape($_POST['egreso-cantidad']));
		//$e_observacion  = remove_junk($db->escape($_POST['egreso-observacion']));	

		//RESTA CANTIDAD A DB
		foreach ($all_productos as $prod) :
			if ($prod['id'] == $e_producto) {
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "stock_insumos";

				$total = 0;
				$total = $prod['total'] - $e_cantidad;

				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
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
		$query .= ") VALUES (";
		$query .= " '{$usuario['iniciales']}',(STR_TO_DATE(REPLACE('{$fechaegreso}','/','.') ,GET_FORMAT(date,'EUR'))), '{$e_destinatario}', '{$e_producto}', '{$e_cantidad}', '{$e_observacion}'";
		$query .= ")";

		if ($db->query($query)) {
			$session->msg('s', "Salida cargada.");
			redirect('add_salida2.php', false);
		} else {
			$session->msg('d', 'No se pudo agregar la Salida.');
			redirect('add_salida.php', false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('add_salida.php', false);
	}
}


if (isset($_POST['add_salida2'])) {

	$req_fields = array('egreso-producto', 'egreso-cantidad');

	validate_fields($req_fields);
	if (empty($errors)) {
		$e_producto  = remove_junk($db->escape($_POST['egreso-producto']));
		$e_cantidad  = remove_junk($db->escape($_POST['egreso-cantidad']));
		$e_observacion  = remove_junk($db->escape($_POST['egreso-observacion']));

		//RESTA CANTIDAD A DB
		foreach ($all_productos as $prod) :
			if ($prod['id'] == $e_producto) {
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "stock_insumos";

				$total = 0;
				$total = $prod['total'] - $e_cantidad;

				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
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
		$query .= ") VALUES (";
		$query .= " '{$usuario['iniciales']}',(STR_TO_DATE(REPLACE('{$fechaegreso}','/','.') ,GET_FORMAT(date,'EUR'))), '{$e_destinatario}', '{$e_producto}', '{$e_cantidad}', '{$e_observacion}'";
		$query .= ")";


		if ($db->query($query)) {
			$session->msg('s', "Salida cargada.");
			redirect('add_salida2.php', false);
		} else {
			$session->msg('d', 'No se pudo agregar la Salida.');
			redirect('add_salida2.php', false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('add_salida2.php', false);
	}
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="container-fluid col-9">

	<?php echo display_msg($msg); ?>
</div>
<form method="post" action="add_salida2.php" class="clearfix">

	<div class="container-fluid col-8 border border-light border-2 rounded box">


		<div class="row estiloHeader">
			<h2>Destinatario: <?php echo $destino ?> </h2>
		</div>

		<div class="row">
			<div class="col-md-6">
				<br>
				<label for="inputdate" class="form-label">Producto</label>
				<select class="form-control shadow-sm" name="egreso-producto" tabindex="1">
					<option value="">Seleccione Producto</option>
					<?php foreach ($all_productos as $prod) : ?>
						<option value="<?php echo (int)$prod['id'] ?>">
							<?php echo $prod['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-md-3">
				<br>
				<label for="inputdate" class="form-label">Cantidad</label>
				<input type="number" min="1" class="form-control shadow-sm" autocomplete="off" name="egreso-cantidad" placeholder="" tabindex="2">
			</div>
		</div>

		<br>

		<div class="row">
			<div class="col-md-6">
				<label for="inputdate" class="form-label">Observaciones</label>
				<textarea class="form-control shadow-sm" name="egreso-observacion" rows="3" tabindex="3"></textarea>
			</div>
		</div>

		<br><br>

		<div class="row justify-content-end">
			<div class="col-md-2">
				<a href="home.php" class="btn btn-dark hoverDeny" tabindex=""><i class="bi bi-x-square"></i> FINALIZAR</a>
			</div>
			<br> <br>
			<div class="col-md-3">
				<button type="submit" name="add_salida2" class="btn btn-dark hoverAccept" tabindex="4"><i class="bi bi-plus-square"></i> AGREGAR SALIDA</button>
			</div>
		</div>
		<br>
	</div>
</form>

<?php include_once('layouts/footer.php'); ?>