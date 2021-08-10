<?php
 $errors = array();
/*--------------------------------------------------------------*/
/* Funcion para fecha en español
/*--------------------------------------------------------------*/
function get_date_spanish( $time, $part = false, $formatDate = '' )
{
	ini_set('date.timezone','America/Argentina/Cordoba');
	#Declare n compatible arrays    
	$month = array("","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	#n    
	$month_execute = "n"; 
	#format for array month    
	$month_mini = array("","ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "DIC");
	#n    
	$month_mini_execute = "n"; 
	#format for array month    
	$day = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"); 
	#w    
	$day_execute = "w";        
	$day_mini = array("DOM","LUN","MAR","MIE","JUE","VIE","SAB"); 
	#w    
	$day_mini_execute = "w";
	/*Other examples:    Whether it's a leap year    
	$leapyear = array("Este año febrero tendrá 28 días"."Si, estamos en un año bisiesto, un día más para trabajar!"); 
	#l     $leapyear_execute = "L";*/    
	#Content array exception print "HOY", position content the name array. Duplicate value and key for optimization in comparative    
	$print_hoy = array("month"=>"month", "month_mini"=>"month_mini");    
	if( $part === false )
	{
		return $day[date("w",$time)] . " " . date("j", $time) . " de " . $month[date("n",$time)];    
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
