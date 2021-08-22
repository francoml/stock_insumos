<?php ob_start();
$page_title = 'Lista de Productos';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);

$all_productos = find_allASC('productos');
?>
<?php
if (isset($_POST['add_prod'])) {
  $req_field = array('producto-nombre');
  validate_fields($req_field);
  $prod_nombre = remove_junk($db->escape($_POST['producto-nombre']));
  if (empty($errors)) {
    $sql  = "INSERT INTO productos (name)";
    $sql .= " VALUES ('{$prod_nombre}')";
    if ($db->query($sql)) {
      $session->msg("s", "Producto agregado.");
      redirect('producto.php', false);
    } else {
      $session->msg("d", "No se pudo agregar el producto.");
      redirect('producto.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('producto.php', false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="container-fluid col-9">
  <?php echo display_msg($msg); ?>
</div>

<form method="post" action="producto.php">

  <div class="container-fluid col-10 border border-light border-2 rounded box ">

    <div class="row">
      <label for="inputdate" class="form-label"><strong>Agregar nuevo producto a la lista</strong></label>
    </div>

    <div class="row">
      <div class="col-sm-5 col-md-6">
        <input type="text" name="producto-nombre" class="form-control" autocomplete="off" tabindex="1" placeholder="Nombre...">
      </div>

      <div class="col-sm-5 col-md-4">
        <button type="submit" name="add_prod" class="btn btn-dark hoverAccept" tabindex="2"><i class="bi bi-plus-square"></i> AGREGAR PRODUCTO</button>
      </div>
      </div>
</form>


<br>

<div class="row estiloHeader">
  <h2>Lista de Productos Validados</h2>
</div>
<br>

<div class="table-responsive">
  <table class="table table-dark table-striped">
    <thead>
      <tr>
        <th class="text-center">#</th>
        <th>Insumos Biomedicos</th>
        <th class="text-center">Modificar</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($all_productos as $prod) : ?>
        <tr>
          <td class="text-center"><?php echo count_id(); ?></td>
          <td><?php echo remove_junk(ucfirst($prod['name'])); ?></td>
          <td class="text-center">
            <div class="btn-group">
              <a href="edit_producto.php?id=<?php echo (int)$prod['id']; ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Editar">
                <i class="bi bi-pencil-square"></i>
              </a>
              <a href="delete_producto.php?id=<?php echo (int)$prod['id']; ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar">
                <i class="bi bi-trash"></i>
              </a>
            </div>
          </td>

        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</div>

<?php include_once('layouts/footer.php'); ?>