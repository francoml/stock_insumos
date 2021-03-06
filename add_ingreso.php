<?php
ob_start();
$page_title = 'Nuevo Ingreso';
require_once('includes/load.php');

//Chequea que nivel de usuario tiene permisos para ver esta página.
page_require_level(2);

$all_productos = find_allASC('productos');
$all_proveedores = find_all('proveedores');
$usuario = getIniciales();

date_default_timezone_set('America/Argentina/Cordoba');
?>

<?php include_once('layouts/header.php'); ?>

<!--Mensaje de error por falta de validación de datos-->
<div class="container-fluid col-9">
	<?php echo display_msg($msg); ?>
</div>


<form method="post" action="add_ingreso2.php" class="clearfix">

	<div class="container-fluid col-8 border border-light border-2 rounded box">

		<div class="row estiloHeader">
			<h2>Nuevo Ingreso</h2>
		</div>

		<div class="row">
			<div class="col-md-2">
				<br>
				<label for="inputUser" class="form-label">Usuario</label>
				<input readonly="readonly" type="text" class="form-control shadow-sm " id="inputUser" value="<?php echo $usuario['iniciales']; ?>">
			</div>
			<div class="col-md-4">
				<br>
				<label for="inputdate" class="form-label">Fecha de Carga</label>
				<input readonly="readonly" type="text" class="form-control shadow-sm" autocomplete="off" value="<?php echo date("d/m/Y"); ?>">
			</div>
			<div class="col-md-4">
				<br>
				<label for="inputdate" class="form-label ">Fecha de Ingreso</label>
				<input type="text" class="form-control shadow-sm datepicker" name="ingreso-dateingreso" autocomplete="off" placeholder="" tabindex="1">
			</div>
		</div>

		<br>

		<div class="row">
			<div class="col-md-6">
				<label for="inputdate" class="form-label">Proveedor</label>
				<select class="form-control shadow-sm" name="ingreso-proveedor" tabindex="2">
					<option value="">Seleccione Proveedor</option>
					<?php foreach ($all_proveedores as $prov) : ?>
						<option value="<?php echo (int)$prov['id'] ?>">
							<?php echo $prov['nombre'] ?></option>
						<!--va a buscar el proveedor por su id, pero va a mostrar su nombre-->
					<?php endforeach; ?>
				</select>
			</div> 
			<div class="col-md-5">
				<label for="inputdate" class="form-label">Remito</label>
				<input type="text" class="form-control shadow-sm" name="ingreso-remito" placeholder="" tabindex="3">
			</div>
		</div>

		<br>
		
		<div class="row justify-content-between">
			<div class="col-md-6">
				<label for="inputdate" class="form-label">Producto</label>
				<select class="form-control shadow-sm" name="ingreso-nombre" tabindex="4">
					<option value="">Seleccione Producto</option>
					<?php foreach ($all_productos as $prod) : ?>
						<option value="<?php echo (int)$prod['id'] ?>">
							<?php echo $prod['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-md-3">
				<label for="inputdate" class="form-label">Marca</label>
				<input type="text" class="form-control shadow-sm" name="ingreso-marca" placeholder="" tabindex="5">
			</div>
			<div class="col-md-3">
				<label for="inputdate" class="form-label">Vencimiento</label>
				<input type="text" class="datepicker form-control shadow-sm" name="ingreso-datevencimiento" autocomplete="off" placeholder="" tabindex="6">
			</div>
		</div>

		<br>

		<div class="row justify-content-between">
			<div class="col-md-2">
				<label for="inputdate" class="form-label">Cantidad</label>
				<input type="number" min="1" class="form-control shadow-sm" autocomplete="off" name="ingreso-cantidad" placeholder="" tabindex="7">
			</div>
			<div class="col-md-6">
				<label for="inputdate" class="form-label">Observaciones</label>
				<textarea class="form-control shadow-sm" name="ingreso-observacion" rows="3" tabindex="8"></textarea>
			</div>
		</div>

		<br><br>

		<div class="row justify-content-start">
			<div class="col-md-6">
				<a href="home.php" class="btn btn-dark hoverDeny" tabindex=""><i class="bi bi-x-square"></i> CANCELAR</a>
			</div>
			<br> <br>
			<div class="col-md-3">
				<button type="submit" name="add_ingreso" class="btn btn-dark hoverAccept" tabindex="9"><i class="bi bi-plus-square"></i> CARGAR REMITO</button>
			</div>
		</div>
		<br>
	</div>
</form>

<?php include_once('layouts/footer.php'); ?>