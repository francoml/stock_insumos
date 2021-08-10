<?php ob_start();
  $page_title = 'Editar Proveedor';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  //Display all catgories.
  $proveedor = find_by_id('proveedores',(int)$_GET['id']);
  if(!$proveedor){
    $session->msg("d","No se encuentra ID del Proveedor.");
    redirect('proveeedor.php');
  }
?>

<?php
if(isset($_POST['editar_prov']))
{
  $req_field = array('nombre-proveedor');
  validate_fields($req_field);
  $prov_nombre = remove_junk($db->escape($_POST['nombre-proveedor']));
  if(empty($errors))
  {
     $sql = "UPDATE proveedores SET nombre='{$prov_nombre}'";
     $sql .= " WHERE id='{$proveedor['id']}'";
     $result = $db->query($sql);
     if($result && $db->affected_rows() === 1) 
	 {
       $session->msg("s", "Proveedor modificado.");
       redirect('proveedor.php',false);
     } 
	 else 
	 {
       $session->msg("d", "No se pudo modificar.");
       redirect('proveedor.php',false);
     }
  } 
  else 
  {
    $session->msg("d", $errors);
    redirect('proveedor.php',false);
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
           <span>Modificando <?php echo remove_junk(ucfirst($proveedor['nombre']));?></span>
        </strong>
       </div>
       <div class="panel-body">	
         <form method="post" action="edit_proveedor.php?id=<?php echo (int)$proveedor['id'];?>">
           <div class="form-group">
               <input type="text" class="form-control" name="nombre-proveedor" value="<?php echo remove_junk(ucfirst($proveedor['nombre']));?>">
           </div>
           <button type="submit" name="editar_prov" class="btn btn-primary">Modificar Proveedor</button>
       </form>
       </div>
     </div>
   </div>
</div>



<?php include_once('layouts/footer.php'); ?>
