
<?php ob_start();
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
?>
<?php
  $d_sale = find_by_id('proveedores',(int)$_GET['id']);
  if(!$d_sale){
    $session->msg("d","No se pudo encontrar el Proveedor.");
    redirect('proveedor.php');
  }
?>
<?php
  $delete_id = delete_by_id('proveedores',(int)$d_sale['id']);
  if($delete_id){
      $session->msg("s","Proveedor borrado.");
      redirect('proveedor.php');
  } else {
      $session->msg("d","No se pudo borrar el Proveedor.");
      redirect('proveedor.php');
  }
?>
