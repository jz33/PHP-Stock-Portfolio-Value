<?php

function getSymbols($tablename = "positions"){
      
      $conn = new mysqli('127.0.0.1', 'root', '', 'elle') or die("Failed to connect MySQL");     
      $query = "select distinct symbol from $tablename where SecType = 'S' order by symbol";
      $res = $conn->query($query) or die("Query:<br/>".$query."<br/>Failed!");
      
      $num_results = $res->num_rows;
      $syms = array();
      if($num_results === 0){
         array_push($syms, 'AAPL');
         array_push($syms, 'ACAD');
         return $syms;
      }     
      for ($i=0; $i <$num_results; $i++) {
         $row = $res->fetch_assoc();
         array_push($syms, $row['symbol']);
      }
      $conn->close();
      return $syms;
}
  
function storeMat($symbol = 'AAPL',$mat = 0, $tablename = 'Portfolio'){
  #Connect db, the database name is 'elle'
  $conn = new mysqli('127.0.0.1', 'root', '', 'elle') or die("Failed to connect MySQL");

  #Create table
  $query = "drop table if exists $tablename";
  $conn->query($query) or die("Query:<br/>".$query."<br/>Failed!");
  $query = "
    Create table $tablename(
    price_id int(4) auto_increment,
    Date date,  
    Open decimal(9,2),
    High decimal(9,2),
    Low  decimal(9,2),
    Close decimal(9,2),
    Volume int(12),
    Adj_Price decimal(9,2),
    Primary key(price_id)
  )";
  $conn->query($query) or die("Query:<br/>".$query."<br/>Failed!");
  $query = "truncate $tablename";
  $conn->query($query) or die("Query:<br/>".$query."<br/>Failed!");

  #Insert table
  $num_cols = count($mat); 
  $num_rows = count($mat[0]);
  for($i = 0; $i < $num_rows; $i++){
    $query = "Insert into $tablename(Date, Open, High, Low, Close, Volume, Adj_Price) values(";
    $query .="'".$mat[0][$i]."',";
    for($j = 1; $j < $num_cols; $j++){
        $query .= " ".$mat[$j][$i].",";
    }
  $query = substr($query, 0, strlen($query)-1); //echo $query."<br/>";
  $query .= ")";
  $conn->query($query) or die("Query:<br/>".$query."<br/>Failed!");
  }
  $conn->close();
}

function getRow($mon, $day, $yea, $tablename = 'Portfolio'){
  #Connect db, the database name is 'elle'
  $conn = new mysqli('127.0.0.1', 'root', '', 'elle') or die("Failed to connect MySQL");  
  
  #Currently only 2013
  $yea = '2013';
  $query = "select* from $tablename where Date = str_to_date('".$mon.' '.$day.' '.$yea."','%b %d %Y')"; //echo "$query";
  $res = $conn->query($query) or die("Query:<br/>".$query."<br/>Failed!");
  if($res === null) echo 'The date '.$mon.' '.$day.' '.$yea.' is not found at '.$tablename;
  $row = $res->fetch_assoc();
  $conn->close();
  return $row;
}

?>