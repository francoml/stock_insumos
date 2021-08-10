<?php
ob_start();
  $page_title = 'Nueva Salida';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_productos = find_allASC('productos');
  $all_destinatarios = find_all('destinatarios');
  date_default_timezone_set('America/Argentina/Cordoba');
  $usuario = getIniciales();

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
			<span>Nueva Salida</span>
        </strong>
        </div>
		
		<div class="panel-body">
        <div class="col-md-20">
		
		<form method="post" action="add_salida2.php" class="clearfix">
		  
			<div class="col-md-3">
			<div class="input-group">
				<span class="input-group-addon">Usuario</span>
				<input readonly="readonly" type="text" class="form-control" style="text-align:center;" value="<?php echo $usuario['iniciales'];?>">
			</div>
			</div>
			
			<div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon">Fecha de Egreso</span>
                <input readonly="readonly" type="text" class="form-control" autocomplete="off"  style="text-align:center;" value="<?php echo date("d/m/Y");?>">
            </div>
            </div>

		</div>
		</div>
		
		<div class="panel-body">
        <div class="col-md-20">

			<div class="col-md-6">
			<select class="form-control" name="egreso-destinatario" tabindex="1">
			<option value="">Seleccione Destino</option>
			<?php  foreach ($all_destinatarios as $dest): ?>
			<option value="<?php echo (int)$dest['id'] ?>"> 
			<?php echo $dest['nombredest'] ?></option> <!--va a buscar el destinatario por su id, pero va a mostrar su nombre-->
			<?php endforeach; ?>
			</select>
			</div>	
		  
		</div>
		</div>
		
		<div class="panel-body">
        <div class="col-md-20">		
		
			<div class="col-md-7">
			<select class="form-control" name="egreso-producto" tabindex="2">
			<option value="">Seleccione Producto</option>
			<?php  foreach ($all_productos as $prod): ?>
			<option value="<?php echo (int)$prod['id'] ?>"> 
			<?php echo $prod['name'] ?></option> <!--va a buscar el producto por su id, pero va a mostrar su nombre-->
			<?php endforeach; ?>
			</select>
			</div>
					
			<div class="col-md-4">
            <div class="input-group">
            <span class="input-group-addon">Cantidad</span>
            <input type="number" class="form-control" autocomplete="off" name="egreso-cantidad" placeholder="" tabindex="3">
			
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
			<textarea name="egreso-observacion" cols="70" rows="5" tabindex="4"></textarea>
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
			<button type="submit" name="add_salida" class="btn btn-success" tabindex="5" <?php $bandera=1; ?>> AGREGAR SALIDA</button>
			</div>
			</div>
			</div>
			</div>
		</div>
			
	</form>
	

<?php include_once('layouts/footer.php'); ?>