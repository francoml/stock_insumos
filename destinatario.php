<?php ob_start();
  $page_title = 'Lista de Destinatarios';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  
  $all_destinatarios = find_all('destinatarios')
?>
<?php
 if(isset($_POST['add_dest']))
 {
   $req_field = array('destinatario-nombre');
   validate_fields($req_field);
   $dest_nombre = remove_junk($db->escape($_POST['destinatario-nombre']));
   if(empty($errors))
   {
      $sql  = "INSERT INTO destinatarios (nombredest)";
      $sql .= " VALUES ('{$dest_nombre}')";
      if($db->query($sql))
	  {
        $session->msg("s", "Destinatario agregado.");
        redirect('destinatario.php',false);
      } 
	  else 
	  {
        $session->msg("d", "No se pudo agregar el Destinatario.");
        redirect('destinatario.php',false);
      }
   } 
   else 
   {
     $session->msg("d", $errors);
     redirect('destinatario.php',false);
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
            <span>Agregar nuevo destinatario a la lista</span>
         </strong>
        </div>
        <div class="panel-body">
          <form method="post" action="destinatario.php">
            <div class="form-group">
                <input type="text" class="form-control" name="destinatario-nombre" autocomplete="off" placeholder="Nombre">
            </div>
            <button type="submit" name="add_dest" class="btn btn-primary">Agregar destinatario</button>
        </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
    <div class="panel panel-default box">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Lista de Destinatarios</span>
       </strong>
      </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Destinatario</th>
                    <th class="text-center" style="width: 100px;">Modificar</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_destinatarios as $dest):?>
                <tr>
                    <td class="text-center"><?php echo count_id();?></td>
                    <td><?php echo remove_junk(ucfirst($dest['nombredest'])); ?></td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="edit_destinatario.php?id=<?php echo (int)$dest['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a href="delete_destinatario.php?id=<?php echo (int)$dest['id'];?>"  class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
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
