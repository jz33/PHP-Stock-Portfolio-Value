<?php
// set for 600x800 screen
$table_width='760';

function do_html_header($title='') {
  global $table_width;
?>
  <!DOCTYPE html>  
  <head>
  <meta content="en-us" http-equiv="Content-Language" />
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
  <title>Portfolio Values</title>
  <style type="text/css">
  .head_image{
      text-align: center;
  }
  .mat{
      position: absolute;
      top: 300px;
      left: 400px
  }
  .table{
      text-align: left;
      border-spacing: 0;
      padding: 25px 50px 75px 100px;
  }
  .symbol_menu {
	  position: absolute;
      top: 90px;
      left: 120px;
  }
  .portfolio{
      position: absolute;
      top: 120px;
      left: 400px;
      border-spacing: 0;
  }
  </style>
  </head><body>
   <p class = "head_image">
     <img src="pics/Header_RenderTech.png" alt="RenderTech Inc."/>
   </p>
<?php
   $form = "<form method=\"post\" action=\"index.php\">";
   echo $form;
?>
     <center><input type="submit" value="Reset!" /></center>
   </form>
<?php
}

function do_html_footer() {
  global $table_width;
?>
  </body></html>
<?php
}

function print_symbol_menu($syms){
?>
    <div class = "symbol_menu">
      <table align = "center" cellspacing = "0" cellpadding = "0">
        <tr><th>Symbol List <?php echo $symbol ?></th></tr>
<?php
    foreach($syms as $r){
        $url  = "index.php?action=$r";
	    echo "<tr><td><a href = ".$url.">".$r."</a></td></tr>";
	}
?>
      </table>
    </div>
<?php
}

function form_portf($syms = 0, $symbol = 'AAPL', $mon = 'oct', $day = '1', $yea = '2013', $value = 0){
  $form = "<form method=\"post\" action=\"index.php?action=".$symbol."
    +".$mon."+".$day."+".$yea."\">";
  echo $form;
?>
    <div class = "portfolio">
      <!--<table align = "left" cellspacing = "0" cellpadding = "6">-->
      <table>
        <tr align = "left"><th>Portfolio Values</th></tr>
        <tr align = "left">
          <th>Choose your Symbol & Date: </th>
        </tr>
        <tr>
          <th>Symbol</th>
          <td>
            <select name = "symbol">
<?php
      foreach($syms as $s) echo "<option value=\"".$s."\">".$s."</option>";
?>
            </select>
          </td>
        </tr>
        <tr>
          <th>Month</th>
          <td>
            <select name = "mon">
              <option value="jan">JANUARY</option>
              <option value="feb">FEBRUARY</option>
              <option value="mar">MARCH</option>
              <option value="apr">APR</option>
              <option value="may">MAY</option>
              <option value="jun">JUNE</option>
              <option value="jul">JULY</option>
              <option value="aug">AUGUST</option>
              <option value="sep">SEPTEMBER</option>
              <option value="oct" selected>OCTOBER</option>
              <option value="nov">NOVEMBER</option>
              <option value="dec">DECEMBER</option>              
            </select>
          </td>
        </tr>
        <tr>
          <th>Day</th>
          <td><input type="text" name="day" size="10" value="18" /></td>
        </tr>
        <tr>
          <th>Year</th>
          <td><input type="text" name="yea" size="10" value="2013" /></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="Get Feedback!" /></td>
        </tr>
        <tr></tr>
        <tr align = "left">
          <th>Symbol <?php echo $symbol ?>:</th>
          <th><?php echo $mon.' '.$day.' '.$yea ?></th>
        </tr>
        <tr align = "left">
          <th>Portfolio Value</th>
          <td><?php echo $value ?></td>
        </tr>
      </table>
    </div>
   </form>
<?php
}

function print_mat($symbol = 'AAPL', $mat = 0){
  $form = "<form method=\"post\" action=\"index.php?action=".$symbol."\">";
  echo $form;
?>
    <div class = "mat">
    <table>
      <tr><th>Historical Record of <?php echo $symbol ?></th></tr>
		<tr align = "left">
			<th>Date</th>
			<th>Open</th>
			<th>High</th>
			<th>Low</th>
			<th>Close</th>
			<th>Volume</th>
			<th>Adj Close</th>
		</tr>
<?php
	array_unshift($mat,null);
	$mat = call_user_func_array('array_map', $mat);
	foreach($mat as $r){
	    echo "<tr>";
	    foreach($r as $c){
	       echo "<td>".$c."</td>";
	    }
	    echo "</tr>";
	}
	echo "</table></div></form>";
}
?>

