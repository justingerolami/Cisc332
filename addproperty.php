<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Qbnb - Add Property</title>  
</head>
<body>

<?php
include("session.php");
if($rank == -1){
   //User is not logged in. Redirect the browser to the login index.php page and kill this page.
   header("Location: index.php");
   die();
}

include_once 'sql.php';
$query = "SELECT * FROM features";
$stmt = $con->prepare($query);
$stmt->execute();
$features = $stmt->get_result();

//Check to see if the button was pressed
if(isset($_POST['Submit'])){
	
	 $priceint = (int)preg_replace("/([^0-9\\.])/i", "", $_POST['price']);
	 
	 $query1 = "SELECT `Property ID` FROM `property` WHERE Address=? AND `Supplier ID`=?";
	 
	 if($stmt1 = $con->prepare($query1)){
		 $stmt1->bind_Param("ss", $_POST['address'], $_SESSION['id']);
		 $stmt1->execute() OR die("Illegal field entries maybe idk ask the admin q1");
		 $result = $stmt1->get_result();
		// Get the number of rows returned
		$num = $result->num_rows;;
		if($num == 0){
			//Property does not exist in the database yet
			$query2 = "INSERT INTO `property` (`Supplier ID`, `Address`, `Type`, `Price`, `Other Features`, `Description`, `District`) VALUES (?, ?, ?, ?, ?, ?, ?)";
			if($stmt2 = $con->prepare($query2)){
		
				// bind the parameters. This is the best way to prevent SQL injection hacks.
				$stmt2->bind_Param("sssssss", $_SESSION['id'], $_POST['address'], $_POST['proptype'], $priceint, $_POST['features'], $_POST['description'], $_POST['districtsel']);
				// Execute the query
				$stmt2->execute() OR die("Illegal field entries maybe idk ask the admin q2" . $priceint . " " . $_POST['districtsel']);
				 
				$stmt1->execute() OR die("Illegal field entries maybe idk ask the admin q1 - 2");
				
				$result = $stmt1->get_result();
				// Get the number of rows returned
				$num = $result->num_rows;;
				if($num > 0){
					$myrow = $result->fetch_assoc();
					$propID = $myrow['Property ID'];
					
					if(isset($_POST['feature']) && !empty($_POST['feature']))
					{
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
					echo "insertion failed q2";
				}
				
			} else {
				echo "failed to prepare the SQL q1";
			}
		
		} else {
			//Property already in database
			echo "You have already added that property!";
		}
	 } else {
		 echo "failed to prepare the SQL";
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
			
<form name='addProperty' id='addProperty' action='addproperty.php' method='post'>
	<table border='0'>
		<tr>
			<td>Address:</td>
			<td><input type='text' name='address' id='address'  value="" required/></td>
		</tr>
		<tr>
			<td>Property Type:</td>
			<td><input type='text' name='proptype' id='proptype' value="" required/></td>
		</tr>
		<tr>
			<td>District:</td>
			<td><select required name='districtsel' id='districtsel' >
					<option value=""></option>
					<option value=1>Downtown</option>
					<option value=2>Waterfront</option>
					<option value=3>Yellow Light</option>
					<option value=4>Army Base</option>
				</select></td>
		</tr>
		<tr>
			<td>Features:</td>
			<td>Select all that apply<td>
		<tr>
		<tr>

<?php 
	while($row = $features->fetch_assoc()) {
		echo("<td></td><td><input type='checkbox' name='feature[]' value='".$row['Feature ID']."'>" . $row['Feature Name'] . "</td></tr><tr>");	
	}	
?>	

		</tr>
		<tr>
			<td>Other Features:</td>
			<td><input type='text' name='features' id='features' value="" /></td>
		</tr>
		<tr>
			<td>Price for one week:</td>
			<td><input type='text' name='price' id='price' value="" required/></td>
		</tr>
		<tr>
			<td>Property Description:</td>
		</tr>
		<tr>
			<td></td><td><textarea name='description' rows='8' cols='60' required></textarea></td>
		</tr>
		<tr>
			<td><input type='submit' name='Submit' value='Submit' /></td>
		</tr></table></form>
</div>
 <div class="main_bottom"></div>     
        </div>
         <?php include("footer.php"); ?>
		
</body>
</html>
