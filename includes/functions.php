<?php
 $errors = array();
 
/*----------------------------------------------------------------*/
/* Función para mostrar fecha en español - Utilizada en el header
/*----------------------------------------------------------------*/
function get_date_spanish( $time, $part = false, $formatDate = '' ){
	ini_set('date.timezone','America/Argentina/Cordoba');
	  
	$month = array("","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	$month_execute = "n"; 
  # Donde 'n' es un parametro del tipo cadena format y servira para retornar -> la representación numérica del mes sin ceros iniciales

	$month_mini = array("","ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "DIC");
	$month_mini_execute = "n"; 
	# Donde 'n' es un parametro del tipo cadena format y servira para retornar -> la representación numérica del mes sin ceros iniciales   

	$day = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"); 
	$day_execute = "w";   
  # Donde 'w' es un parametro del tipo cadena format y servira para retornar -> la representación numérica del día de la semana

	$day_mini = array("DOM","LUN","MAR","MIE","JUE","VIE","SAB"); 
	$day_mini_execute = "w";
  # Donde 'w' es un parametro del tipo cadena format y servira para retornar -> la representación numérica del día de la semana

	$print_hoy = array("month"=>"month", "month_mini"=>"month_mini");
  /*
    Tambien pudo haber sido definido de la siguiente forma y estariamos definiendo lo mismo con un indice diferente:
      $sprint_hoy = array("month", "month_mini");   ó
      $sprint_hoy = array(0 => "month", 1 => "month_mini");
  */


  # Para entender mejor lo de abajo ver el manual php de date
	if( $part === false )
	{
		return $day[date("w",$time)] . " " . date("j", $time) . " de " . $month[date("n",$time)];
    # w -> número del 0 al 6
    # j -> número del 1 al 31
    # n -> número del 1 al 12 (como observación podemos notar que nunca devolverá 0, por ese motivo la posición 0 del array month esta vacía)    
	}
	elseif( $part === true )
	{
		if( ! empty( $print_hoy[$formatDate] ) && date("w-d-m-Y", $time ) == date("w-d-m-Y") ) 
			return "HOY"; 
		#Exception HOY        
		if( ! empty( ${$formatDate} ) && !empty( ${$formatDate}[date(${$formatDate.'_execute'},$time)] ) ) 
			return ${$formatDate}[date(${$formatDate.'_execute'},$time)];        
		else 
			return date($formatDate, $time);    
	}
	else
	{        
		return date("d-m-Y", $time);   
	}
}

 /*--------------------------------------------------------------*/
 /* Function for Remove escapes special
 /* characters in a string for use in an SQL statement
 /*--------------------------------------------------------------*/
function real_escape($str){
  global $con;
  $escape = mysqli_real_escape_string($con,$str);
  return $escape;
}
/*--------------------------------------------------------------*/
/* Function for Remove html characters
/*--------------------------------------------------------------*/
function remove_junk($str){
  $str = nl2br($str);
  $str = htmlspecialchars(strip_tags($str, ENT_QUOTES));
  return $str;
}
/*--------------------------------------------------------------*/
/* Function for Uppercase first character
/*--------------------------------------------------------------*/
function first_character($str){
  $val = str_replace('-'," ",$str);
  $val = ucfirst($val);
  return $val;
}
/*--------------------------------------------------------------*/
/* Function for Checking input fields not empty
/*--------------------------------------------------------------*/
function validate_fields($var){
  global $errors;
  foreach ($var as $field) {
    $val = remove_junk($_POST[$field]);
    if(isset($val) && $val==''){
      $errors = $field ." no puede estar en blanco.";
      return $errors;
    }
  }
}
/*--------------------------------------------------------------*/
/* Function for Display Session Message
   Ex echo displayt_msg($message);
/*--------------------------------------------------------------*/
function display_msg($msg =''){
   $output = array();
   if(!empty($msg)) {
      foreach ($msg as $key => $value) {
         $output  = "<div class=\"alert alert-{$key}\">";
         $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
         $output .= remove_junk(first_character($value));
         $output .= "</div>";
      }
      return $output;
   } else {
     return "" ;
   }
}
/*--------------------------------------------------------------*/
/* Function for redirect
/*--------------------------------------------------------------*/
function redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
      header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
/*--------------------------------------------------------------*/
/* Function for find out total saleing price, buying price and profit
/*--------------------------------------------------------------*/
function total_price($totals){
   $sum = 0;
   $sub = 0;
   foreach($totals as $total ){
     $sum += $total['total_saleing_price'];
     $sub += $total['total_buying_price'];
     $profit = $sum - $sub;
   }
   return array($sum,$profit);
}
/*--------------------------------------------------------------*/
/* Function for Readable date time
/*--------------------------------------------------------------*/
function read_date($str){
     if($str)
      return date('F j, Y, g:i:s a', strtotime($str));
     else
      return null;
  }
/*--------------------------------------------------------------*/
/* Function for  Readable Make date time
/*--------------------------------------------------------------*/
function make_date(){
  return strftime("%Y-%m-%d %H:%M:%S", time());
}
/*--------------------------------------------------------------*/
/* Function for  Readable date time
/*--------------------------------------------------------------*/
function count_id(){
  static $count = 1;
  return $count++;
}
/*--------------------------------------------------------------*/
/* Function for Creting random string
/*--------------------------------------------------------------*/
function randString($length = 5)
{
  $str='';
  $cha = "0123456789abcdefghijklmnopqrstuvwxyz";

  for($x=0; $x<$length; $x++)
   $str .= $cha[mt_rand(0,strlen($cha))];
  return $str;
}


?>
