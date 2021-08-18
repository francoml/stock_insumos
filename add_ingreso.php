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

<body>

	<div class="row">
		<div class="col-md-12">
			<?php echo display_msg($msg); ?>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<strong>
				<span class="glyphicon glyphicon-th"></span>
				<span>Nuevo Ingreso</span>
			</strong>
		</div>

		<div class="panel-body">
			<div class="col-md-20">

				<form method="post" action="add_ingreso2.php" class="clearfix">

					<div class="col-md-3">
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
			<div class="col-md-20">

				<div class="col-md-6">
					<select class="form-control" name="ingreso-proveedor" tabindex="4">
						<option value="">Seleccione Proveedor</option>
						<?php foreach ($all_proveedores as $prov) : ?>
							<option value="<?php echo (int)$prov['id'] ?>">
								<?php echo $prov['nombre'] ?></option>
							<!--va a buscar el proveedor por su id, pero va a mostrar su nombre-->
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-md-5">
					<div class="input-group">
						<span class="input-group-addon">Nº Remito</span>
						<input type="text" class="form-control" name="ingreso-remito" placeholder="" tabindex="5">
					</div>
				</div>

			</div>
		</div>

		<div class="panel-body">
			<div class="col-md-20">
				<div class="col-md-7">

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
			<div class="col-md-12">
				<div class="form-group">
					<div class="row">


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
			</div>
		</div>

		<div class="panel-body">
			<div class="col-md-12">
				<div class="form-group">
					<div class="row">

						<div class="col-md-10">
							<div class="input-group">
								<span class="input-group-addon">Observación</span>
								<textarea name="ingreso-observacion" cols="70" rows="5" tabindex="10"></textarea>
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
						<button type="submit" name="add_ingreso" class="btn btn-success" tabindex="11">AGREGAR INGRESO</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	</form>

</body>

<?php include_once('layouts/footer.php'); ?>