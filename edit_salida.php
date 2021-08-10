<?php ob_start();
  $page_title = 'Editar Salida';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$salida = find_by_id2('salidas',(int)$_GET['id']); #almaceno "salidas"
$all_productos = find_allASC('productos');
$all_destinatarios = find_all('destinatarios');

if(!$salida)
{
  $session->msg("d","No se encuentra ID de la Salida.");
  redirect('salidas.php');
}
?>
<?php
 if(empty($salida['observacion']))
 {
	 $salida['observacion']= " ";
 }
 
 if(isset($_POST['salidas']))
 {
    $req_fields = array('egreso-usuario','egreso-dateegreso','egreso-destinatario','egreso-producto', 'egreso-cantidad',
	'egreso-observacion');
    validate_fields($req_fields);

   if(empty($errors))
   {
	   
	   $e_usuario  = remove_junk($db->escape($_POST['egreso-usuario']));
	   $e_dateegreso  = remove_junk($db->escape($_POST['egreso-dateegreso']));
	   $e_destinatario   = remove_junk($db->escape($_POST['egreso-destinatario']));
	   $e_producto   = remove_junk($db->escape($_POST['egreso-producto']));
	   $e_cantidad  = remove_junk($db->escape($_POST['egreso-cantidad']));
	   $e_observacion  = remove_junk($db->escape($_POST['egreso-observacion']));
	   
		//MODIFICA LAS CANTIDADES CORRESPONDIENTES A LOS TOTALES DE PRODUCTOS EN LA DB
		
		foreach ($all_productos as $prod):
		if($prod['id'] == $e_producto) //COMPARO MI LISTA DE PRODUCTOS CON EL PRODUCTO (NUEVO O NO)
		{
			if($salida['prod']!=$e_producto) //CAMBIO MI PRODUCTO, ES DISTINTO AL QUE SE HABIA DESCARGADO?
			{
				foreach ($all_productos as $prod2):
				if($prod2['id']==$salida['prod']) //BUSCO EL ID DE MI VIEJO PRODUCTO
				{
					$total1= 0;
					$id_prod= $salida['prod'];
					$total1= $prod2['total'] + $salida['cantidad']; //RESTAURO LA CANTIDAD QUE SE LE HABIA DESCARGADO AL VIEJO PRODUCTO
					
					$total2= 0;
					$total2= $prod['total'] - $e_cantidad; //RESTO LA CANTIDAD DEL PRODUCTO QUE REALMENTE SALIO
					
					$servername = "localhost";
					$username = "root";
					$password = "";
					$dbname = "stock_insumos";
					
					// Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
					// Check connection
					if ($conn->connect_error) 
					{
						die("Connection failed: " . $conn->connect_error);
					}

					$sql = "UPDATE productos SET total = '{$total1}' WHERE id = '{$id_prod}'"; //MODIFICO EL VIEJO PRODUCTO
					$sql2 = "UPDATE productos SET total = '{$total2}' WHERE id = '{$e_producto}'"; //MODIFICO EL NUEVO PRODUCTO TAMBIEN, AMBOS SUFREN CAMBIOS

					if ($conn->query($sql) === TRUE) 
					{
						echo "Record updated successfully";
					} else 
					{
						echo "Error updating record: " . $conn->error;
					}
					
					if ($conn->query($sql2) === TRUE) 
					{
						echo "Record updated successfully";
					} else 
					{
						echo "Error updating record: " . $conn->error;
					}
					
					$conn->close();
				}
				endforeach;
			}
			else		//EL CASO EN EL QUE EL PRODUCTO NO SE HAYA MODIFICADO SINO ALGUN OTRO DATO QUE NO INFLUYE EN LOS TOTALES DE MI TABLA PRODUCTOS EN LA DB
			{
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "stock_insumos";

				$total = 0;
				$total = $prod['total'] + $salida['cantidad'] - $e_cantidad;

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
		}
		endforeach;  
	   
	   
       $query   = "UPDATE salidas SET";
       $query  .=" usuario ='{$e_usuario}', dateegreso =(STR_TO_DATE(REPLACE('{$e_dateegreso}','/','.') ,GET_FORMAT(date,'EUR'))),";
       $query  .=" destinatario ='{$e_destinatario}', prod ='{$e_producto}', cantidad ='{$e_cantidad}', observacion ='{$e_observacion}'";
       $query  .=" WHERE id ='{$salida['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1)
			   {
                 $session->msg('s',"Salida modificada.");
                 redirect('salidas.php', false);
               } else {
                 $session->msg('d','No se pudo modificar.');
                 redirect('edit_salida.php?id='.$salida['id'], false);
               }

   }
   else
   {
       $session->msg("d", $errors);
       redirect('edit_salida.php?id='.$salida['id'], false);
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
			<span>Modificar Salida</span>
        </strong>
        </div>
		
		<div class="panel-body">
        <div class="col-md-20">
		 
           <form method="post" action="edit_salida.php?id=<?php echo (int)$salida['id'] ?>">
			
			<div class="col-md-3">
			<div class="input-group">
				<span class="input-group-addon">Usuario</span>
				<input type="text" class="form-control" name="egreso-usuario" value="<?php echo remove_junk($salida['usuario']); ?>">
			</div>
			</div>
			
			<div class="col-md-4">
            <div class="input-group">
                 <span class="input-group-addon">Fecha de Egreso</span>
                 <input type="text" class="datepicker form-control" name="egreso-dateegreso" autocomplete="off" value="<?php echo remove_junk($salida['dateegreso']); ?>">
            </div>
			</div>
				   
		</div>
		</div>

	
		
		<div class="panel-body">
        <div class="col-md-20">

			<div class="col-md-6">
			<select class="form-control" name="egreso-destinatario">
			<option value="">Seleccione Destino</option>
			<?php  foreach ($all_destinatarios as $dest): ?>
			<option value="<?php echo (int)$dest['id'] ?>"<?php if($salida['destinatario'] === $dest['id']): echo "selected"; endif; ?>> 
			<?php echo remove_junk($dest['nombredest']); ?></option>
			<?php endforeach; ?>
			</select>
			</div>	
		  
		</div>
		</div>
		
		<div class="panel-body">
        <div class="col-md-20">		
		
			<div class="col-md-7">
			<select class="form-control" name="egreso-producto">
			<option value="">Seleccione Producto</option>
			<?php  foreach ($all_productos as $prod): ?>
			<option value="<?php echo (int)$prod['id'] ?>"<?php if($salida['prod'] === $prod['id']): echo "selected"; endif; ?>> 
			<?php echo remove_junk($prod['name']); ?></option> <!--va a buscar el proveedor por su id, pero va a mostrar su nombre-->
			<?php endforeach; ?>
			</select>
			</div>	
					
			<div class="col-md-4">
            <div class="input-group">
            <span class="input-group-addon">Cantidad</span>
            <input type="number" class="form-control" autocomplete="off" name="egreso-cantidad" value="<?php echo remove_junk($salida['cantidad']); ?>">
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
			<textarea name="egreso-observacion"cols="70" rows="5"><?php echo remove_junk($salida['observacion']); ?></textarea>
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
			<button type="submit" name="salidas" class="btn btn-success" >MODIFICAR</button>
			</div>
			</div>
			</div>
			</div>
		</div>
			
      </form>
 

<?php include_once('layouts/footer.php'); ?>
