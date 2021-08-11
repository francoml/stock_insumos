<?php
  require_once('includes/load.php');

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table));
   }
}

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table ta
/*--------------------------------------------------------------*/
function find_allASC($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table)." ORDER BY ta ASC");
   }
}
/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
 return $result_set;
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table))
	{
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id2($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table))
	{
          $sql = $db->query("SELECT id,usuario,DATE_FORMAT(dateegreso, '%d/%m/%Y') AS dateegreso,destinatario,prod,cantidad,observacion FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id3($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table))
	{
          $sql = $db->query("SELECT id,usuario,DATE_FORMAT(dateingreso, '%d/%m/%Y') AS dateingreso,DATE_FORMAT(datecarga, '%d/%m/%Y') AS datecarga,proveedor,remito,nombre,marca,DATE_FORMAT(datevencimiento, '%d/%m/%Y') AS datevencimiento,cantidad,observacion FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/

function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Determina si la tabla existe en la base de datos
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
      if($table_exit) {
        if($db->num_rows($table_exit) > 0)
              return true;
         else
              return false;
      }
  }
 /*--------------------------------------------------------------*/
 /* Login with the data provided in $_POST,
 /* coming from the login form.
/*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }
   return false;
  }
  /*--------------------------------------------------------------*/
  /* Login with the data provided in $_POST,
  /* coming from the login_v2.php form.
  /* If you used this method then remove authenticate function.
 /*--------------------------------------------------------------*/
   function authenticate_v2($username='', $password='') {
     global $db;
     $username = $db->escape($username);
     $password = $db->escape($password);
     $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
     $result = $db->query($sql);
     if($db->num_rows($result)){
       $user = $db->fetch_assoc($result);
       $password_request = sha1($password);
       if($password_request === $user['password'] ){
         return $user;
       }
     }
    return false;
   }


  /*--------------------------------------------------------------*/
  /* Find current log in user by session id
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $current_user = find_by_id('users',$user_id);
        endif;
      }
    return $current_user;
  }
  
  /*--------------------------------------------------------------*/
  /* Devuelve iniciales del Usuario
  /*--------------------------------------------------------------*/
  
  function find_iniciales($table,$id)
  {
  global $db;
  $id = (int)$id;
    if(tableExists($table))
	{
          $sql = $db->query("SELECT iniciales FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
  }
  
  function getIniciales()
  {
      static $getIniciales;
      global $db;
      if(!$getIniciales)
	  {
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $getIniciales = find_iniciales('users',$user_id);
        endif;
      }
    return $getIniciales;
  }

  /*--------------------------------------------------------------*/
  /* Find all user by
  /* Joining users table and user gropus table
  /*--------------------------------------------------------------*/
  function find_all_user(){
      global $db;
      $results = array();
      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
      $sql .="g.group_name ";
      $sql .="FROM users u ";
      $sql .="LEFT JOIN user_groups g ";
      $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
      $result = find_by_sql($sql);
      return $result;
  }
  /*--------------------------------------------------------------*/
  /* Function to update the last log in of a user
  /*--------------------------------------------------------------*/

 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
	}

  /*--------------------------------------------------------------*/
  /* Find all Group name
  /*--------------------------------------------------------------*/
  function find_by_groupName($val)
  {
    global $db;
    $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Find group level
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Function for cheaking which user level has access to page
  /*--------------------------------------------------------------*/
   function page_require_level($require_level){
     global $session;
     $current_user = current_user();
     $login_level = find_by_groupLevel($current_user['user_level']);
     //if user not login
     if (!$session->isUserLoggedIn(true)):
            $session->msg('d','Please login...');
            redirect('index.php', false);
      //if Group status Deactive
     elseif($login_level['group_status'] === '0'):
           $session->msg('d','This level user has been band!');
           redirect('home.php',false);
      //cheackin log in User level and Require level is Less than or equal to
     elseif($current_user['user_level'] <= (int)$require_level):
              return true;
      else:
            $session->msg("d", "Sorry! you dont have permission to view the page.");
            redirect('home.php', false);
        endif;

     }
   /*--------------------------------------------------------------*/
   /* Function for Finding all product name
   /* JOIN with categorie  and media database table
   /*--------------------------------------------------------------*/
  function join_product_table(){
     global $db;
     $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
    $sql  .=" AS categorie,m.file_name AS image";
    $sql  .=" FROM products p";
    $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
    $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
    $sql  .=" ORDER BY p.id ASC";
    return find_by_sql($sql);
   }
   /*--------------------------------------------------------------*/
   /* Function for Finding all product name
   /* JOIN with categorie  and media database table
   /*--------------------------------------------------------------*/
  function join_stock_table(){
    global $db;
    $sql  =" SELECT p.id,p.name,p.total";	
    $sql  .=" FROM productos p";
    $sql  .=" ORDER BY p.name ASC";
    return find_by_sql($sql);
   }
   /*--------------------------------------------------------------*/
   /* Function for Finding all product name
   /* JOIN with categorie  and media database table
   /*--------------------------------------------------------------*/
  function join_ingreso_table(){
    global $db;
    $sql  =" SELECT r.id,r.usuario,DATE_FORMAT(r.dateingreso, '%d/%m/%Y') AS dateingreso,DATE_FORMAT(r.datecarga, '%d/%m/%Y') AS datecarga,p.nombre,r.remito,c.name,r.marca,DATE_FORMAT(r.datevencimiento, '%d/%m/%Y') AS datevencimiento,r.cantidad,r.observacion";	
    $sql  .=" FROM remitos r";
	$sql  .=" LEFT JOIN productos c ON c.id =r.nombre"; #me mostro el nombre del producto!!
	$sql  .=" LEFT JOIN proveedores p ON p.id =r.proveedor"; 
    $sql  .=" ORDER BY r.id DESC";
    return find_by_sql($sql);
   }
   /*--------------------------------------------------------------*/
   /* Function for Finding all product name
   /* JOIN with categorie  and media database table
   /*--------------------------------------------------------------*/
  function join_salida_table(){
    global $db;
    $sql  =" SELECT s.id,s.usuario,DATE_FORMAT(s.dateegreso, '%d/%m/%Y') AS dateegreso,d.nombredest,p.name,s.cantidad,s.observacion";	
    $sql  .=" FROM salidas s";
	$sql  .=" LEFT JOIN productos p ON p.id =s.prod"; #me mostro el nombre del producto!!
	$sql  .=" LEFT JOIN destinatarios d ON d.id =s.destinatario"; 
    $sql  .=" ORDER BY s.id DESC";
    return find_by_sql($sql);
   }
  /*--------------------------------------------------------------*/
  /* Function for Finding all product name
  /* Request coming from ajax.php for auto suggest
  /*--------------------------------------------------------------*/

   function find_product_by_title($product_name){
     global $db;
     $p_name = remove_junk($db->escape($product_name));
     $sql = "SELECT name FROM products WHERE name like '%$p_name%' LIMIT 5";
     $result = find_by_sql($sql);
     return $result;
   }

  /*--------------------------------------------------------------*/
  /* Function for Finding all product info by product title
  /* Request coming from ajax.php
  /*--------------------------------------------------------------*/
  function find_all_product_info_by_title($title){
    global $db;
    $sql  = "SELECT * FROM products ";
    $sql .= " WHERE name ='{$title}'";
    $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
  /* Function for Update product quantity
  /*--------------------------------------------------------------*/
  function update_product_qty($qty,$p_id){
    global $db;
    $qty = (int) $qty;
    $id  = (int)$p_id;
    $sql = "UPDATE products SET quantity=quantity -'{$qty}' WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
  
    /*--------------------------------------------------------------*/
  /* Function for Update product quantity
  /*--------------------------------------------------------------*/
  function update_product_qty2($total,$p_id)
  {
    global $db;
    $qty = (int) $total;
    $id  = (int)$p_id;
    $sql = "UPDATE products SET quantity= '{$total}' WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
  /*--------------------------------------------------------------*/
  /* Function for Display Recent product Added
  /*--------------------------------------------------------------*/
 function find_recent_product_added($limit){
   global $db;
   $sql   = " SELECT p.id,p.name,p.sale_price,p.media_id,c.name AS categorie,";
   $sql  .= "m.file_name AS image FROM products p";
   $sql  .= " LEFT JOIN categories c ON c.id = p.categorie_id";
   $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
   $sql  .= " ORDER BY p.id DESC LIMIT ".$db->escape((int)$limit);
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for Find Highest saleing Product
 /*--------------------------------------------------------------*/
 function find_higest_saleing_product($limit){
   global $db;
   $sql  = "SELECT p.name, COUNT(s.product_id) AS totalSold, SUM(s.qty) AS totalQty";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON p.id = s.product_id ";
   $sql .= " GROUP BY s.product_id";
   $sql .= " ORDER BY SUM(s.qty) DESC LIMIT ".$db->escape((int)$limit);
   return $db->query($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for find all sales
 /*--------------------------------------------------------------*/
 function find_all_sale(){
   global $db;
   $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON s.product_id = p.id";
   $sql .= " ORDER BY s.date DESC";
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for Display Recent sale
 /*--------------------------------------------------------------*/
function find_recent_sale_added($limit){
  global $db;
  $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " ORDER BY s.date DESC LIMIT ".$db->escape((int)$limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function find_sale_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date, p.name,p.sale_price,p.buy_price,";
  $sql .= "COUNT(s.product_id) AS total_records,";
  $sql .= "SUM(s.qty) AS total_sales,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price,";
  $sql .= "SUM(p.buy_price * s.qty) AS total_buying_price ";	//multiplica (((precio-prod * cant) = total_buying_price) + total_saleing_price + total_sales) = total_records  
  $sql .= "FROM sales s ";										// From sales
  $sql .= "LEFT JOIN products p ON s.product_id = p.id";	//relacion prod id - sale id
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";	//entre fecha
  $sql .= " GROUP BY DATE(s.date),p.name";	//pname -> product name
  $sql .= " ORDER BY DATE(s.date) DESC";	//s.date -> date sale
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function salidas_desde_hasta($start_date,$end_date){
  global $db;

  $sql  =" SELECT s.id,s.usuario,DATE_FORMAT(s.dateegreso, '%d/%m/%Y') AS dateegreso,d.nombredest,p.name,s.cantidad,s.observacion";	
  $sql  .=" FROM salidas s";
  $sql  .=" LEFT JOIN productos p ON p.id =s.prod";
  $sql  .=" LEFT JOIN destinatarios d ON d.id =s.destinatario"; 
  $sql .= " WHERE s.dateegreso BETWEEN (STR_TO_DATE(REPLACE('{$start_date}','/','.') ,GET_FORMAT(date,'EUR'))) AND (STR_TO_DATE(REPLACE('{$end_date}','/','.') ,GET_FORMAT(date,'EUR')))";
  $sql .= " ORDER BY DATE(s.dateegreso), d.nombredest ASC";
  return $db->query($sql);
}
// (STR_TO_DATE(REPLACE('{$i_dateingreso}','/','.') ,GET_FORMAT(date,'EUR')))
// DATE_FORMAT(s.dateegreso, '%d/%m/%Y') AS dateegreso
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function salidas_desde_hasta2($start_date,$end_date){
  global $db;

  $sql  =" SELECT r.id,r.usuario,DATE_FORMAT(r.dateingreso, '%d/%m/%Y') AS dateingreso,DATE_FORMAT(r.datecarga, '%d/%m/%Y') AS datecarga,p.nombre,r.remito,c.name,r.marca,DATE_FORMAT(r.datevencimiento, '%d/%m/%Y') AS datevencimiento,r.cantidad,r.observacion";	
  $sql  .=" FROM remitos r";
  $sql  .=" LEFT JOIN productos c ON c.id =r.nombre";
  $sql  .=" LEFT JOIN proveedores p ON p.id =r.proveedor"; 
  $sql .= " WHERE r.datecarga BETWEEN (STR_TO_DATE(REPLACE('{$start_date}','/','.') ,GET_FORMAT(date,'EUR'))) AND (STR_TO_DATE(REPLACE('{$end_date}','/','.') ,GET_FORMAT(date,'EUR')))";
  $sql .= " ORDER BY DATE (r.datecarga), p.nombre ASC";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate Daily sales report
/*--------------------------------------------------------------*/
function  dailySales($year,$month){
  global $db;
  $sql  = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y-%m' ) = '{$year}-{$month}'";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%e' ),s.product_id";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate Daily sales report
/*--------------------------------------------------------------*/
function  salidasDiarias($year,$month,$day)
{
  global $db;
  /*$sql  =" SELECT s.id,s.usuario,DATE_FORMAT(s.dateegreso, '%d/%m/%Y') AS dateegreso,d.nombredest,p.name,s.cantidad,s.observacion";	
  $sql  .=" FROM salidas s";
  $sql  .=" LEFT JOIN productos p ON p.id =s.prod";
  $sql  .=" LEFT JOIN destinatarios d ON d.id =s.destinatario"; 
  $sql .= " WHERE DATE_FORMAT(s.dategreso, '%Y-%m-%d' ) = '{$year}-{$month}-{$day}'";
  $sql .= " GROUP BY DATE_FORMAT( s.dateegreso,  '%e' )"; */
  
  
 $sql  =" SELECT s.id,s.usuario,DATE_FORMAT(s.dateegreso, '%d/%m/%Y') AS dateegreso,d.nombredest,p.name,s.cantidad,s.observacion";	
  $sql  .=" FROM salidas s";
  $sql  .=" LEFT JOIN productos p ON p.id =s.prod";
  $sql  .=" LEFT JOIN destinatarios d ON d.id =s.destinatario"; 
  $sql .= " WHERE DATE_FORMAT(s.dateegreso, '%Y-%m-%d' ) = '{$year}-{$month}-{$day}'";
  $sql .= " ORDER BY s.id ASC";

  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Function for Generate Daily sales report
/*--------------------------------------------------------------*/
function  ingresosDiarios($year,$month,$day)
{
  global $db;
  
 $sql  =" SELECT r.id,r.usuario,DATE_FORMAT(r.dateingreso, '%d/%m/%Y') AS dateingreso,DATE_FORMAT(r.datecarga, '%d/%m/%Y') AS datecarga,p.nombre,r.remito,c.name,r.marca,DATE_FORMAT(r.datevencimiento, '%d/%m/%Y') AS datevencimiento,r.cantidad,r.observacion";	
  $sql  .=" FROM remitos r";
  $sql  .=" LEFT JOIN productos c ON c.id =r.nombre";
  $sql  .=" LEFT JOIN proveedores p ON p.id =r.proveedor"; 
  $sql .= " WHERE DATE_FORMAT(r.datecarga, '%Y-%m-%d' ) = '{$year}-{$month}-{$day}'";
  $sql .= " ORDER BY r.id ASC";

  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Function for Generate Monthly sales report
/*--------------------------------------------------------------*/
function  monthlySales($year){
  global $db;
  $sql  = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y' ) = '{$year}'";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%c' ),s.product_id";
  $sql .= " ORDER BY date_format(s.date, '%c' ) ASC";
  return find_by_sql($sql);
}

?>
