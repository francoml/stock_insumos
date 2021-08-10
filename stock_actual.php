<?php
  ob_start();
  $page_title = 'Stock Actual';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $stock_actual = join_stock_table();
?>

<?php include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="panel panel-warning">
	<div class="panel-heading"><b>STOCK AL DIA DE LA FECHA</b></div>
	<div class="container">

		<div class="panel-body">    
			<br/>		  
			<div class="input-group">
				<input class="form-control" id="miInput" type="text" placeholder="Buscar..." style="width: 481%">
			</div>
	
	  <table class="table table-striped table-bordered" style="width: 85%">
		<thead>
		  <tr>
			<th style="text-align:center">#</th>
			<th style="text-center">Producto</th>
			<th style="text-align:center">Cantidad</th>
		  </tr>
		</thead>
				<tbody id="miTabla">
				  <?php foreach ($stock_actual as $stock):?>
				  <tr>
					<td class="text-center" style="width:1%"> <?php echo count_id();?></td>              
					<td class="tex" style="width:50%" > <?php echo remove_junk($stock['name']); ?></td>
					<td class="text-center" style="width: 2%;"> <?php echo remove_junk($stock['total']); ?></td>
				  </tr>
				 <?php endforeach; ?>
				</tbody>
	  </table>
	  </div>
	</div>
	</div>

	<script>
	$(document).ready(function(){
	  $("#miInput").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#miTabla tr").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	  });
	});
	</script>

</body>
</html>

<?php include_once('layouts/footer.php'); ?>



