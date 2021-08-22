<?php
ob_start();
$page_title = 'Stock Actual';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
$stock_actual = join_stock_table();
?>

<?php include_once('layouts/header.php'); ?>

<div class="container-fluid col-9">
	<?php echo display_msg($msg); ?>
</div>

<div class="container-fluid col-8 border border-light border-2 rounded box">


	<div class="row estiloHeader">
		<h2>STOCK AL DIA DE LA FECHA</h2>
	</div>

	<br>

	<div class="row">
		<div class="col-md-12">
			<div class="input-group flex-nowrap">
				<span class="input-group-text" id="addon-wrapping"><i class="bi bi-search"></i></span>
				<input type="text" class="form-control" id="miInput" placeholder="Buscar...">
			</div>
		</div>
	</div>

	<div class="table-responsive">
		<table class="table table-dark table-striped">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Producto</th>
					<th class="text-center">Cantidad</th>
				</tr>
			</thead>
			<tbody id="miTabla">
				<?php foreach ($stock_actual as $stock) : ?>
					<tr>
						<td class="text-center"> <?php echo count_id(); ?></td>
						<td class="text"> <?php echo remove_junk($stock['name']); ?></td>
						<td class="text-center"> <?php echo remove_junk($stock['total']); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<?php include_once('layouts/footer.php'); ?>