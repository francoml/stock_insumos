<?php ob_start();
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php
  $all_productos = find_all('productos');
  $producto = find_by_id('remitos',(int)$_GET['id']);
  
  if(!$producto)
  {
    $session->msg("d","No se encuentra ID del Producto.");
    redirect('ingreso.php');
  }
?>
<?php
  $delete_id = delete_by_id('remitos',(int)$producto['id']);
  if($delete_id)
  {  
		foreach ($all_productos as $prod):
			if($prod['id'] == $producto['nombre'])
			{			
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "stock_insumos";

				$total = 0;
				$total = $prod['total'] - $producto['cantidad'];
				$id_producto = $producto['nombre'];

				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) 
				{
					die("Connection failed: " . $conn->connect_error);
				}

				$sql = "UPDATE productos SET total = '{$total}' WHERE id = '{$id_producto}'";

				if ($conn->query($sql) === TRUE) {
					echo "Record updated successfully";
				} else {
					echo "Error updating record: " . $conn->error;
				}

				$conn->close();
						
			}	
		endforeach;	 	  	

      $session->msg("s","Producto borrado.");
      redirect('ingreso.php');
  } 
  else 
  {
      $session->msg("d","No se pudo borrar el Producto.");
      redirect('ingreso.php');
  }
?>
