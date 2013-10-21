<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
include ('include_fns.php');

do_html_header();

$action = $_GET['action'];
$symbol = $_POST['symbol']; //echo $symbol."<br/>";
$mon = $_POST['mon']; //echo $mon."<br/>";
$day = $_POST['day']; //echo $day."<br/>";
$yea = $_POST['yea']; //echo $yea."<br/>";

$syms = getSymbols();//print_symbol_menu($syms);
if(!isset($action)){
  form_portf($syms);
}
else{
  $html = getHTML($symbol);
  $mat = getTable($html);
  storeMat($symbol,$mat);
  $row = getRow($mon,$day,$yea);
  
  $value = compute_portfolio($row);
  form_portf($syms, $symbol, $mon, $day, $yea, $value);
}

do_html_footer();
?>