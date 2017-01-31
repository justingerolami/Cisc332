<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Queen's B&B</title>
</head>

<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
 include("session.php");
include_once 'sql.php';

if($rank == -1){
	header("Location: index.php");
	die();
}
?>

    <div id="page">
		
        <div id="header">
        	<?php include ("header.php"); ?>
        </div>
  
        <div id="main">
        
        	<div class="main_top">
		<h1><center>Search for accomodation</center></h1>
            	
            </div>
            
           	<div class="main_body">

<?php


$query = "SELECT * FROM district";
$stmt = $con->prepare($query);
$stmt->execute();
$districts = $stmt->get_result();

$query = "SELECT * FROM features";
$stmt = $con->prepare($query);
$stmt->execute();
$features = $stmt->get_result();


?>

<!-- dynamic content will be here -->
		<form name='search' id='search' action='viewsearch.php' method='get'> 
		<p>
		District: 
		<select name='districts' id='districts' >
		<option value=""></option>
		<?php 
					while($row = $districts->fetch_assoc()) {
						echo("<option value=" . $row['District ID'] . ">" . $row['District Name'] . "</option>");	
					}		
				?>	
		</select><br>
		Type: <input type='text' name='type' id='type' style="width:50px;" />		<br>
		Features:<br> <?php 
						while($row = $features->fetch_assoc()) {
							echo("&emsp;<input type='checkbox' name='feature[]' value='".$row['Feature ID']."'>" . $row['Feature Name'] . "<br>");	
						}	
					?>	
		Price:
		Between $<input type='text' name='priceLower' id='priceLower' style="width:30px;" /> and $<input type='text' style="width:30px;" name='priceUpper' id='priceUpper' />
		<br>
		<br>
		<input type='submit' value='Search' /></p>
		</p>
		</form>
		 </div>
            
           	<div class="main_bottom"></div>
            
        </div>
        
        
        
        <?php include("footer.php"); ?>
        
        </div>
</body>
</html>

