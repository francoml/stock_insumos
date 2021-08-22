<?php ob_start();
$page_title = 'Edit product';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
?>
<?php
$remito = find_by_id3('remitos', (int)$_GET['id']); #almaceno "remitos"
$all_productos = find_allASC('productos');
$all_proveedores = find_all('proveedores');

if (!$remito) {
	$session->msg("d", "No se encuentra ID del Producto.");
	redirect('ingreso.php');
}
?>
<?php
if (empty($remito['observacion'])) {
	$remito['observacion'] = " ";
}

if (isset($_POST['remito'])) {
	$req_fields = array(
		'ingreso-usuario', 'ingreso-proveedor', 'ingreso-remito', 'ingreso-dateingreso', 'ingreso-datecarga',
		'ingreso-nombre', 'ingreso-marca', 'ingreso-datevencimiento', 'ingreso-cantidad', 'ingreso-observacion'
	);
	validate_fields($req_fields);

	if (empty($errors)) {

		$i_usuario  = remove_junk($db->escape($_POST['ingreso-usuario']));
		$i_proveedor   = remove_junk($db->escape($_POST['ingreso-proveedor']));
		$i_remito   = remove_junk($db->escape($_POST['ingreso-remito']));
		$i_dateingreso   = remove_junk($db->escape($_POST['ingreso-dateingreso']));
		$i_datecarga  = remove_junk($db->escape($_POST['ingreso-datecarga']));
		$i_nombre  = remove_junk($db->escape($_POST['ingreso-nombre']));
		$i_marca  = remove_junk($db->escape($_POST['ingreso-marca']));
		$i_datevencimiento  = remove_junk($db->escape($_POST['ingreso-datevencimiento']));
		$i_cantidad  = remove_junk($db->escape($_POST['ingreso-cantidad']));
		$i_observacion  = remove_junk($db->escape($_POST['ingreso-observacion']));

		//MODIFICA LAS CANTIDADES CORRESPONDIENTES A LOS TOTALES DE PRODUCTOS EN LA DB

		foreach ($all_productos as $prod) :
			if ($prod['id'] == $i_nombre) //COMPARO MI LISTA DE PRODUCTOS CON EL PRODUCTO (NUEVO O NO)
			{
				if ($remito['nombre'] != $i_nombre) //CAMBIO MI PRODUCTO, ES DISTINTO AL QUE SE HABIA DESCARGADO?
				{
					foreach ($all_productos as $prod2) :
						if ($prod2['id'] == $remito['nombre']) //BUSCO EL ID DE MI VIEJO PRODUCTO
						{
							$total1 = 0;
							$id_prod = $remito['nombre'];
							$total1 = $prod2['total'] - $remito['cantidad']; //ACTUALIZO LA CANTIDAD QUE SE LE HABIA CARGADO AL VIEJO PRODUCTO

							$total2 = 0;
							$total2 = $prod['total'] + $i_cantidad; //SUMO LA CANTIDAD DEL PRODUCTO QUE REALMENTE SALIO

							$servername = "localhost";
							$username = "root";
							$password = "";
							$dbname = "stock_insumos";

							// Create connection
							$conn = new mysqli($servername, $username, $password, $dbname);
							// Check connection
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
							}

							$sql = "UPDATE productos SET total = '{$total1}' WHERE id = '{$id_prod}'"; //MODIFICO EL VIEJO PRODUCTO
							$sql2 = "UPDATE productos SET total = '{$total2}' WHERE id = '{$i_nombre}'"; //MODIFICO EL NUEVO PRODUCTO TAMBIEN, AMBOS SUFREN CAMBIOS

							if ($conn->query($sql) === TRUE) {
								echo "Record updated successfully";
							} else {
								echo "Error updating record: " . $conn->error;
							}

							if ($conn->query($sql2) === TRUE) {
								echo "Record updated successfully";
							} else {
								echo "Error updating record: " . $conn->error;
							}

							$conn->close();
						}
					endforeach;
				} else		//EL CASO EN EL QUE EL PRODUCTO NO SE HAYA MODIFICADO SINO ALGUN OTRO DATO QUE NO INFLUYE EN LOS TOTALES DE MI "TABLA PRODUCTOS" EN LA DB
				{
					$servername = "localhost";
					$username = "root";
					$password = "";
					$dbname = "stock_insumos";

					$total = 0;
					$total = $prod['total'] - $remito['cantidad'] + $i_cantidad;

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
			}
		endforeach;



		$query   = "UPDATE remitos SET";
		$query  .= " usuario ='{$i_usuario}', dateingreso =(STR_TO_DATE(REPLACE('{$i_dateingreso}','/','.') ,GET_FORMAT(date,'EUR'))),";
		$query  .= " datecarga =(STR_TO_DATE(REPLACE('{$i_datecarga}','/','.') ,GET_FORMAT(date,'EUR'))), proveedor ='{$i_proveedor}', remito ='{$i_remito}', nombre ='{$i_nombre}',";
		$query  .= " marca ='{$i_marca}', datevencimiento =(STR_TO_DATE(REPLACE('{$i_datevencimiento}','/','.') ,GET_FORMAT(date,'EUR'))), cantidad ='{$i_cantidad}', observacion ='{$i_observacion}'";
		$query  .= " WHERE id ='{$remito['id']}'";
		$result = $db->query($query);
		
		if ($result && $db->affected_rows() === 1) {
			$session->msg('s', "Ingreso modificado.");
			redirect('ingreso.php', false);
		} else {
			$session->msg('d', 'No se pudo modificar.');
			redirect('edit_ingreso.php?id=' . $remito['id'], false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('edit_ingreso.php?id=' . $remito['id'], false);
	}
}

?>
<?php include_once('layouts/header.php'); ?>


<div class="container-fluid col-9">
	<?php echo display_msg($msg); ?>
</div>


<form method="post" action="edit_ingreso.php?id=<?php echo (int)$remito['id'] ?>">
	<div class="container-fluid col-8 border border-light border-2 rounded box">

		<div class="row estiloHeader">
			<h2>Modificar Ingreso</h2>
		</div>

		<div class="row">
			<div class="col-md-2">
				<br>
				<label for="inputUser" class="form-label">Usuario</label>
				<input type="text" class="form-control shadow-sm" name="ingreso-usuario" tabindex="1" value="<?php echo remove_junk($remito['usuario']); ?>">
			</div>
			<div class="col-md-4">
				<br>
				<label for="inputdate" class="form-label">Fecha de Carga</label>
				<input type="text" class="datepicker form-control shadow-sm" name="ingreso-datecarga" autocomplete="off" tabindex="2" value="<?php echo remove_junk($remito['datecarga']); ?>">
			</div>
			<div class="col-md-4">
				<br>
				<label for="inputdate" class="form-label ">Fecha de Ingreso</label>
				<input type="text" class="datepicker form-control shadow-sm" name="ingreso-dateingreso" autocomplete="off" tabindex="3" value="<?php echo remove_junk($remito['dateingreso']); ?>">
			</div>
		</div>

		<br>

		<div class="row">
			<div class="col-md-6">
				<label for="inputdate" class="form-label">Proveedor</label>
				<select class="form-control shadow-sm" name="ingreso-proveedor" tabindex="4">
					<option value="">Seleccione Proveedor</option>
					<?php foreach ($all_proveedores as $prov) : ?>
						<option value="<?php echo (int)$prov['id'] ?>" <?php if ($remito['proveedor'] === $prov['id']) : echo "selected";
																		endif; ?>>
							<?php echo remove_junk($prov['nombre']); ?></option>
						<!--va a buscar el proveedor por su id, pero va a mostrar su nombre-->
					<?php endforeach; ?>
				</select>
				</select>
			</div>
			<div class="col-md-5">
				<label for="inputdate" class="form-label">Remito</label>
				<input type="text" class="form-control shadow-sm" name="ingreso-remito" tabindex="5" value="<?php echo remove_junk($remito['remito']); ?>">
			</div>
		</div>

		<br>

		<div class="row justify-content-between">
			<div class="col-md-6">
				<label for="inputdate" class="form-label shadow-sm">Producto</label>
				<select class="form-control" name="ingreso-nombre" tabindex="6">
					<option value="">Seleccione Producto</option>
					<?php foreach ($all_productos as $prod) : ?>
						<option value="<?php echo (int)$prod['id'] ?>" <?php if ($remito['nombre'] === $prod['id']) : echo "selected";
																		endif; ?>>
							<?php echo remove_junk($prod['name']); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-md-3">
				<label for="inputdate" class="form-label">Marca</label>
				<input type="text" class="form-control shadow-sm" name="ingreso-marca" tabindex="7" value="<?php echo remove_junk($remito['marca']); ?>">
			</div>
			<div class="col-md-3">
				<label for="inputdate" class="form-label">Vencimiento</label>
				<input type="text" class="datepicker form-control shadow-sm" name="ingreso-datevencimiento" autocomplete="off" tabindex="8" value="<?php echo remove_junk($remito['datevencimiento']); ?>">
			</div>
		</div>

		<br>

		<div class="row justify-content-between">
			<div class="col-md-2">
				<label for="inputdate" class="form-label">Cantidad</label>
				<input type="number" class="form-control shadow-sm" autocomplete="off" name="ingreso-cantidad" tabindex="9" value="<?php echo remove_junk($remito['cantidad']); ?>">
			</div>
			<div class="col-md-6">
				<label for="inputdate" class="form-label">Observaciones</label>
				<textarea class="form-control shadow-sm" name="ingreso-observacion" rows="3" tabindex="10"><?php echo remove_junk($remito['observacion']); ?></textarea>
			</div>
		</div>

		<br><br>

		<div class="row justify-content-end">
			<div class="col-md-2">
				<a href="home.php" class="btn btn-dark hoverDeny" tabindex=""><i class="bi bi-x-square"></i> CANCELAR</a>
			</div>
			<br> <br>
			<div class="col-md-3">
				<button type="submit" name="remito" class="btn btn-dark hoverAccept" tabindex="11"><i class="bi bi-pencil-square"></i></i> MODIFICAR</button>
			</div>
		</div>
		<br>
	</div>
</form>

<?php include_once('layouts/footer.php'); ?>