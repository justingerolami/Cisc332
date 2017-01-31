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
            
           	<div class="main_body"><p>

<?php

$bindParam = new BindParam(); 
$searchParams = array(); 
$query = "SELECT * FROM property WHERE";
$searchParams[] = ' 1';

if(isset($_GET['districts']) && !empty($_GET['districts']))
{
	$searchParams[] = ' District=' . $_GET['districts'];
	//$bindParam->add('s', $_GET['districts'] ); 
	//echo 'set to id ' . $_GET['districts'];
}

if(isset($_GET['priceLower']) && !empty($_GET['priceLower']))
{
	$searchParams[] = ' Price>=' . $_GET['priceLower'];
	//$bindParam->add('s', $_GET['districts'] ); 
	//echo 'set to id ' . $_GET['districts'];
}


if(isset($_GET['priceUpper']) && !empty($_GET['priceUpper']))
{
	$searchParams[] = ' Price<=' . $_GET['priceUpper'];
	//$bindParam->add('s', $_GET['districts'] ); 
	//echo 'set to id ' . $_GET['districts'];
}

if(isset($_GET['type']) && !empty($_GET['type']))
{
	$searchParams[] = " Type='" . $_GET['type'] . "'";
	//$bindParam->add('s', $_GET['districts'] ); 
	//echo 'set to id ' . $_GET['districts'];
}
$searchOnFeatures=false;
if(isset($_GET['feature']) && !empty($_GET['feature']))
{
	$featParams = array(); 
	$searchOnFeatures=true;
	$query = "SELECT property . * FROM property NATURAL JOIN property_has WHERE";
	$features = $_GET['feature'];
	$noSearchFeatures=0;
	
	foreach ($features as $feature) {
		$featParams[] = '`Feature ID`=' . $feature;
		$noSearchFeatures++;
	}
	
	$searchParams[] = '(' . implode(' OR ', $featParams) . ')'; 
	
	//$bindParam->add('s', $_GET['districts'] ); 
	//echo 'set to id ' . $_GET['districts'];
}

$query .= implode(' AND ', $searchParams); 

if($searchOnFeatures){
	$query .= " GROUP BY  `Property ID` HAVING COUNT(  `Property ID` ) =$noSearchFeatures";
}

//echo $query . '<br/>'; 
$stmt = $con->prepare($query) or die("Error preparing");

//var_dump($bindParam->get()); 

//call_user_func_array( array($stmt, 'bind_Param'), $bindParam->get()); 
$stmt->execute() or die("Error executing: " . $stmt->error);


$properties = $stmt->get_result();
$noProperties = $properties->num_rows;


echo "<table border = 0><td>There are $noProperties properties matching your search criteria</td></table><br><br>";

echo '<table border = 0>';
while($row = $properties->fetch_assoc()) {
	echo "<tr><td>".$row['Address']."</td>";
	echo "<td>  ".$row['Type']."&emsp;</td>";
	echo "<td>  ".$row['Description']."  </td>";
	echo "<td>$".$row['Price']."/week</td>";
	echo "<td><a href='viewlisting.php?pid=". $row['Property ID'] ."'><input type='button' value='View'></a></td></tr>";
}



?>
</table>

<!-- dynamic content will be here -->
		</p> </div>
            
           	<div class="main_bottom"></div>
            
        </div>
        
        
        
        <?php include("footer.php"); ?>
        
        </div>
</body>
</html>



<?php

class BindParam{ 
    private $values = array(), $types = ''; 
    
    public function add( $type, &$value ){ 
        $this->values[] = $value; 
        $this->types .= $type; 
    } 
    
    public function get(){ 
        return array_merge(array($this->types), $this->values); 
    } 
} 
?>

