<?php ob_start();
  $page_title = 'Editar Destinatario';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  //Display all catgories.
  $destinatario = find_by_id('destinatarios',(int)$_GET['id']);
  if(!$destinatario)
  {
    $session->msg("d","No se encuentra ID del Destinatario.");
    redirect('destinatario.php');
  }
?>

<?php
if(isset($_POST['editar_dest']))
{
  $req_field = array('nombre-destinatario');
  validate_fields($req_field);
  $dest_nombre = remove_junk($db->escape($_POST['nombre-destinatario']));
  if(empty($errors))
  {
     $sql = "UPDATE destinatarios SET nombredest='{$dest_nombre}'";
     $sql .= " WHERE id='{$destinatario['id']}'";
     $result = $db->query($sql);
     if($result && $db->affected_rows() === 1) 
	 {
       $session->msg("s", "Destinatario modificado.");
       redirect('destinatario.php',false);
     } 
	 else 
	 {
       $session->msg("d", "No se pudo modificar.");
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
   <div class="col-md-5">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Modificando <?php echo remove_junk(ucfirst($destinatario['nombredest']));?></span>
        </strong>
       </div>
       <div class="panel-body">	
         <form method="post" action="edit_destinatario.php?id=<?php echo (int)$destinatario['id'];?>">
           <div class="form-group">
               <input type="text" class="form-control" name="nombre-destinatario" value="<?php echo remove_junk(ucfirst($destinatario['nombredest']));?>">
           </div>
           <button type="submit" name="editar_dest" class="btn btn-primary">Modificar Destinatario</button>
       </form>
       </div>
     </div>
   </div>
</div>



<?php include_once('layouts/footer.php'); ?>
