<?php
  include_once('simple_html_dom.php');
  
  function getHTML($symbol = 'AAPL'){
      $url  = "http://finance.yahoo.com/q/hp?s=".$symbol."+Historical+Prices";
      $html = file_get_html($url) or die ('Failed to open ' . $url); //echo $html;
      return $html;
  }
  
  function getContentsInStrings($sta_str, $end_str, $html){
      $matches = array();
      $pattern = "|$sta_str([a-zA-Z0-9~!@#$%\^&*()_+{}\|:\"<>?\-=\[\]\\;\',\./ 	]*)$end_str|"; //All chars
      preg_match_all($pattern, $html, $matches) or die("No matching for $'sta_str' & '$end_str'<br/>");
      return $matches[1];
  }
  
  function getTable($html){
      $table = array();
      
      $classname = 'yfnc_datamodoutline1';
      $sta_str = 'Adj Close*';
      $end_str = 'Close price adjusted for dividends and splits.';
      $html = getContentsInStrings($sta_str, $end_str, $html); 
      $html = implode($html);

      $dom = new DOMDocument();
      $dom->loadHTML($html);
      $rows = $dom->getElementsByTagName("tr");
      for($i=0, $j=0; $i < $rows->length;$i++,$j++) {
          $cells = $rows->item($i)->getElementsByTagName('td');
          $table['Date'][$j]      = $cells->item(0)->nodeValue; $table['Date'][$j] = date("Y-m-d",strtotime($table['Date'][$j]));
          $table['Open'][$j]      = $cells->item(1)->nodeValue; 
          $table['High'][$j]      = $cells->item(2)->nodeValue; 
          $table['Low'][$j]       = $cells->item(3)->nodeValue; 
          $table['Close'][$j]     = $cells->item(4)->nodeValue; 
          $table['Volume'][$j]    = $cells->item(5)->nodeValue; $table['Volume'][$j] = str_replace(",","",$table['Volume'][$j]);
          $table['Adj Close'][$j] = $cells->item(6)->nodeValue; 
  
      #Check data valid
      if( $table['Date'][$j] == '' ||
          $table['Open'][$j] == '' || 
          $table['High'][$j] == '' ||
          $table['Low'][$j]  == '' ||
          $table['Close'][$j]== '' ||
          $table['Volume'][$j] == '' ||
          $table['Adj Close'][$j] == '')
      {
          unset($table['Date'][$j]);
          unset($table['Open'][$j]);
          unset($table['High'][$j]);
          unset($table['Low'][$j]);
          unset($table['Close'][$j]);
          unset($table['Volume'][$j]);
          unset($table['Adj Close'][$j]);
          $j--;
      }
      }
    #Convert associative array to numerical array
    $mat = array_values($table);
    return $mat;
  }
     
  function compute_portfolio($row){
      $value = $row['Adj_Price']*$row['Volume'];
      return $value;
  }
?>
