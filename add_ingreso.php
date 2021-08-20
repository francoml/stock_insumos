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

<div class="row">
	<div class="col-md-12">
		<?php echo display_msg($msg); ?>
	</div>
</div>

<form method="post" action="add_ingreso2.php" class="clearfix">
	<div class="container-fluid col-md-8 border border-dark border-2 rounded box">
		<div class="panel panel-default">
			<div class="panel-heading text-dark fw-bolder">
				<strong>
					<span class="glyphicon glyphicon-th"></span>
					<h3 style="text-align: center;">Nuevo Ingreso</h3>
				</strong>
			</div>
			<br>
		</div>
		<div class="row justify-content-between">
			<div class="col-md-1">
				<label for="inputUser" class="form-label">Usuario</label>
				<input readonly="readonly" type="text" class="form-control shadow-sm " id="inputUser" value="<?php echo $usuario['iniciales']; ?>">
			</div>
			<div class="col-md-3">
				<label for="inputdate" class="form-label">Fecha de Carga</label>
				<input readonly="readonly" type="text" class="form-control shadow-sm" autocomplete="off" value="<?php echo date("d/m/Y"); ?>">
			</div>
			<div class="col-md-3">
				<label for="inputdate" class="form-label">Fecha de Ingreso</label>
				<input type="text" class="datepicker form-control shadow-sm" name="ingreso-dateingreso" autocomplete="off" placeholder="" tabindex="1">
			</div>
		</div>
		<br>
		<div class="row justify-content-between">
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
		<div class="row justify-content-around">				
			<div class="col-md-2">
				<label for="inputdate" class="form-label">Cantidad</label>
				<input type="number" min="1" class="form-control shadow-sm" autocomplete="off" name="ingreso-cantidad" placeholder="" tabindex="7">
			</div>
			<div class="col-md-6">
				<label for="inputdate" class="form-label">Observaciones</label>
				<textarea class="form-control shadow-sm" name="ingreso-observacion" rows="3" tabindex="8"></textarea>
			</div>
		</div>
		<br>
		<div class="row justify-content-around">				
			<div class="col-md-4">
				<button type="submit" name="add_ingreso" class="btn btn-dark" tabindex="9">AGREGAR INGRESO</button>
			</div>
		</div>
		<br>
	</div>
</form>
<br>

<!--<form method="post" action="add_ingreso2.php" class="clearfix">

	<div class="panel panel-default">
		<div class="panel-heading">
			<strong>
				<span class="glyphicon glyphicon-th"></span>
				<span>Nuevo Ingreso</span>
			</strong>
		</div>

		<br>

		<div class="panel-body">
			<div class="col-12">

				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon">Usuario</span>
						<input readonly="readonly" type="text" class="form-control" style="text-align:center;" value="<?php echo $usuario['iniciales']; ?>">
					</div>
				</div>

				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon">Fecha de Ingreso</span>
						<input type="text" class="datepicker form-control" name="ingreso-dateingreso" autocomplete="off" placeholder="" tabindex="2">
					</div>
				</div>

				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon">Fecha de Carga</span>
						<input readonly="readonly" type="text" class="form-control" autocomplete="off" style="text-align:center;" value="<?php echo date("d/m/Y"); ?>">
					</div>
				</div>


			</div>
		</div>

		<div class="panel-body">
			<div class="col-12">

				<div class="col-md-6">
					<select class="form-control" name="ingreso-proveedor" tabindex="4">
						<option value="">Seleccione Proveedor</option>
						<?php foreach ($all_proveedores as $prov) : ?>
							<option value="<?php echo (int)$prov['id'] ?>">
								<?php echo $prov['nombre'] ?></option>
							<!--va a buscar el proveedor por su id, pero va a mostrar su nombre
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-md-6">
					<div class="input-group">
						<span class="input-group-addon">Nº Remito</span>
						<input type="text" class="form-control" name="ingreso-remito" placeholder="" tabindex="5">
					</div>
				</div>

			</div>
		</div>

		<div class="panel-body">
			<div class="col-12">
				<div class="col-md-6">

					<select class="form-control" name="ingreso-nombre" tabindex="6">
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
			<div class="col-12">
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon">Marca</span>
						<input type="text" class="form-control" name="ingreso-marca" placeholder="" tabindex="7">
					</div>
				</div>

				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon">Vencimiento</span>
						<input type="text" class="datepicker form-control" name="ingreso-datevencimiento" autocomplete="off" placeholder="" tabindex="8">
					</div>
				</div>

				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon">Cantidad</span>
						<input type="number" min="1" class="form-control" autocomplete="off" name="ingreso-cantidad" placeholder="" tabindex="9">
					</div>
				</div>
			</div>
		</div>

		<div class="panel-body">
			<div class="col-12">
				<div class="col-md-6">
					<div class="input-group">
						<span class="input-group-addon">Observacion</span>
						<textarea class="form-control" name="ingreso-observacion" rows="5" tabindex="10"></textarea>
					</div>
				</div>
			</div>
		</div>

		<div class="panel-body">
			<div class="col-12">
				<div class="col-md-4">
					<div class="form-group">
						<button type="submit" name="add_ingreso" class="btn btn-success" tabindex="11">AGREGAR INGRESO</button>
					</div>
				</div>
			</div>
		</div>

	</div>

</form>-->

<?php include_once('layouts/footer.php'); ?>