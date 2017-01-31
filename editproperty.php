<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Qbnb - Edit Property</title>  
</head>
<body>

<?php
include("session.php");


include_once 'sql.php';
$query = "SELECT * FROM features";
$stmt = $con->prepare($query);
$stmt->execute();
$features = $stmt->get_result();

if($rank >= 0){
	$query = "SELECT `Member ID`,`Account Name`, Password, `Email Address` FROM member WHERE `Member ID`=?";
 
        // prepare query for execution
    $stmt = $con->prepare($query);
       
       // bind the parameters. This is the best way to prevent SQL injection hacks.
    $stmt->bind_Param("s", $_SESSION['id']);
       // Execute the query
    $stmt->execute();
 
        // results 
    $result = $stmt->get_result();
     
        // Row data
    $myrow = $result->fetch_assoc();
    
        
} else {
    //User is not logged in. Redirect the browser to the login index.php page and kill this page.
   // header("Location: index.php");
    die("not logged in");
}
if(isset($_GET['pid'])){
	$query5 = "SELECT * FROM `property` WHERE `Property ID`=?";
	
	if($stmt5 = $con->prepare($query5)){
		$stmt5->bind_Param("s", $_GET['pid']);
		$stmt5->execute();
		$result5 = $stmt5->get_result();
		if($result5->num_rows == 1){
			
			
			$property = $result5->fetch_assoc();
			if($_SESSION['id'] != $property['Supplier ID']){
				header("Location: profile.php");
				die("You do not own that property!");
			}
				
			$query6 = "SELECT `Feature ID` FROM `property_has` WHERE `Property ID` =?";
			$stmt6 = $con->prepare($query6);
			$stmt6->bind_Param("s", $_GET['pid']);
			$stmt6->execute();
			$fetresult=$stmt6->get_result();
			$hasFeat = array();
			while ($fetrow = $fetresult->fetch_assoc()){
				$hasFeat[$fetrow['Feature ID']] = true;
			}
		} else {
			header("Location: addproperty.php?editnull=1");
			die();
		}
	} else {
		echo "Failed to prep sql for get";
		die();
	}
} else {
	//No property set, send to add page
	header("Location: addproperty.php");
	die();
}
//Check to see if the button was pressed
if(isset($_POST['Update'])){
	
	 $priceint = (int)preg_replace("/([^0-9\\.])/i", "", $_POST['price']);
	 
			$query2 = "UPDATE `property` SET `Address`= ?, `Type`=?, `Price`=?, `Other Features`=?, `Description`=?, `District`=? WHERE `Property ID`=?";

			if($stmt2 = $con->prepare($query2)){
		
				// bind the parameters. This is the best way to prevent SQL injection hacks.
				$stmt2->bind_Param("sssssss", $_POST['address'], $_POST['proptype'], $priceint, $_POST['features'], $_POST['description'], $_POST['districtsel'], $property['Property ID']);
				// Execute the query
				$stmt2->execute() OR die("Illegal field entries maybe idk ask the admin q2");
				
				
				$myrow = $result->fetch_assoc();
				$propID = $property['Property ID'];
				
				if(isset($_POST['feature']) && !empty($_POST['feature']))
				{
					$query = "DELETE FROM `property_has` WHERE `property_has`.`Property ID` = $propID";
					$stmt = $con->prepare($query);
					$stmt->execute();
					$features = $_POST['feature'];
					foreach ($features as $feature) {
						$query = "INSERT INTO `property_has` (`Property ID`, `Feature ID`) VALUES ($propID, $feature)";
						$stmt = $con->prepare($query);
						$stmt->execute();
					}
	
				}


				
			header("Location: profile.php?proplistsuccess=1");
			die();
				
			} else {
				echo "failed to prepare the SQL q1";
			}
	
	 
	
}
?>
    <div id="page">
        
        <div id="header">
            <?php include ("header.php"); ?>
        </div>
  
        <div id="main">
        
            <div class="main_top">
			    <h1><center>Property Details</center></h1>
			</div>
            
            <div class="main_body">
			
			
			<!-- Dynamic content begins here -->
			
<form name='editProperty' id='editProperty' action='editproperty.php?pid=<?php echo $property['Property ID']; ?>' method='post'>
	<table border='0'>
		<tr>
			<td>Address:</td>
			<td><input type='text' name='address' id='address'  value="<?php echo $property['Address']; ?>" required/></td>
		</tr>
		<tr>
			<td>Property Type:</td>
			<td><input type='text' name='proptype' id='proptype' value="<?php echo $property['Type']; ?>" required/></td>
		</tr>
		<tr>
			<td>District:</td>
			<td><select required name='districtsel' id='districtsel' >
					<option value=""></option>
					<option value=1 <?php if($property['District'] == 1) echo "selected"; ?> >Downtown</option>
					<option value=2 <?php if($property['District'] == 2) echo "selected"; ?> >Waterfront</option>
					<option value=3 <?php if($property['District'] == 3) echo "selected"; ?> >Yellow Light</option>
					<option value=4 <?php if($property['District'] == 4) echo "selected"; ?> >Army Base</option>
				</select></td>
		</tr>
		<tr>
			<td>Features:</td>
			<td>Select all that apply<td>
		<tr>
		<tr>
			<?php 
	while($row = $features->fetch_assoc()) {
		$selected = "";
		if(isset($hasFeat[$row['Feature ID']])) { $selected = "checked"; }
		echo("<td></td><td><input type='checkbox' name='feature[]' $selected value='".$row['Feature ID']."'>" . $row['Feature Name'] . "</td></tr><tr>");	
	}	
?>	
			<td>Other Features:</td>
			<td><input type='text' name='features' id='features' value="<?php echo $property['Other Features']; ?>" /></td>
		</tr>
		<tr>
			<td>Price for one week:</td>
			<td><input type='text' name='price' id='price' value="<?php echo $property['Price']; ?>" required/></td>
		</tr>
		<tr>
			<td>Property Description:</td>
		</tr>
		<tr>
			<td></td><td><textarea name='description' rows='8' cols='60'  required><?php echo $property['Description']; ?></textarea></td>
		</tr>
		<tr>
			<td><input type='submit' name='Update' value='Update' /></td>
		</tr></table></form>
</div>
 <div class="main_bottom"></div>     
      
        <?php include ("footer.php") ?>
		
</body>
</html>
