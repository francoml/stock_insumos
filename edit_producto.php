<?php ob_start();
$page_title = 'Editar Proveedor';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
?>
<?php
//Display all catgories.
$producto = find_by_id('productos', (int)$_GET['id']);
if (!$producto) {
  $session->msg("d", "No se encuentra ID del Producto.");
  redirect('producto.php');
}
?>

<?php
if (isset($_POST['editar_prod'])) {
  $req_field = array('name-prod');
  validate_fields($req_field);
  $prod_name = remove_junk($db->escape($_POST['name-prod']));
  if (empty($errors)) {
    $sql = "UPDATE productos SET name='{$prod_name}'";
    $sql .= " WHERE id='{$producto['id']}'";
    $result = $db->query($sql);
    if ($result && $db->affected_rows() === 1) {
      $session->msg("s", "Producto modificado.");
      redirect('producto.php', false);
    } else {
      $session->msg("d", "No se pudo modificar.");
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


<div class="container-fluid col-6 border border-light border-2 rounded box">

  <div class="row">
    <form method="post" action="edit_producto.php?id=<?php echo (int)$producto['id']; ?>">

      <div class="row">
        <label for="inputdate" class="form-label"><strong>Modificando '<?php echo remove_junk(ucfirst($producto['name'])); ?>'</strong></label>
      </div>

      <div class="row">
        <div class="col-sm-5 col-md-8">
          <input type="text" name="name-prod" class="form-control" autocomplete="off" tabindex="1" value="<?php echo remove_junk(ucfirst($producto['name'])); ?>">
        </div>

        <div class="col-sm-5 col-md-4">
          <button type="submit" name="editar_prod" class="btn btn-dark hoverAccept" tabindex="2"><i class="bi bi-check-square"></i> ACEPTAR</button>
        </div>
      </div>
    </form>
  </div>

</div>


<?php include_once('layouts/footer.php'); ?>