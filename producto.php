<?php ob_start();
  $page_title = 'Lista de Productos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  
  $all_productos = find_allASC('productos');
?>
<?php
 if(isset($_POST['add_prod'])){
   $req_field = array('producto-nombre');
   validate_fields($req_field);
   $prod_nombre = remove_junk($db->escape($_POST['producto-nombre']));
   if(empty($errors)){
      $sql  = "INSERT INTO productos (name)";
      $sql .= " VALUES ('{$prod_nombre}')";
      if($db->query($sql)){
        $session->msg("s", "Producto agregado.");
        redirect('producto.php',false);
      } else {
        $session->msg("d", "No se pudo agregar el producto.");
        redirect('producto.php',false);
      }
   } else {
     $session->msg("d", $errors);
     redirect('producto.php',false);
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
    <div class="col-md-5">
      <div class="panel panel-default box">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Agregar nuevo producto a la lista</span>
         </strong>
        </div>
        <div class="panel-body">
          <form method="post" action="producto.php">
            <div class="form-group">
                <input type="text" class="form-control" name="producto-nombre" autocomplete="off" placeholder="Nombre">
            </div>
            <button type="submit" name="add_prod" class="btn btn-primary">Agregar producto</button>
        </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading box">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Lista de Productos Validados</span>
       </strong>
      </div>
        <div class="panel-body box">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Insumos Biomedicos</th>
                    <th class="text-center" style="width: 100px;">Modificar</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_productos as $prod):?>
                <tr>
                    <td class="text-center"><?php echo count_id();?></td>
                    <td><?php echo remove_junk(ucfirst($prod['name'])); ?></td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="edit_producto.php?id=<?php echo (int)$prod['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a href="delete_producto.php?id=<?php echo (int)$prod['id'];?>"  class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
                          <span class="glyphicon glyphicon-trash"></span>
                        </a>
                      </div>
                    </td>

                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
       </div>
    </div>
    </div>
   </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
