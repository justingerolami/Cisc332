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
?>

    <div id="page">
		
        <div id="header">
        	<?php include ("header.php"); ?>
        </div>
  
        <div id="main">
        
        	<div class="main_top">
            	
            </div>
            
           	<div class="main_body">
 

 
 
<?php

if($rank == -1){
	header("Location: index.php");
	die();
}
 


if(isset($_POST['cReply'])){

    	// include database connection
    	include_once 'sql.php';
	

	$comments = $_POST['cReply'];
	
	foreach ($comments as $key => $comment) {
		if($comment != "") {
			$query = "INSERT INTO comment (Text, Property, `Member ID`, `Parent Comment`, Date) VALUES (?,?,?,?,?)";
			$stmt = $con->prepare($query);
			$stmt->bind_Param("sssss", $comment,$_POST['listing'],$userid,$key,time());
			$stmt->execute();
		}
	}

echo ("Replies added!<br>");
}

if(isset($_POST['text'])){
include_once 'sql.php';
	if(!empty($_POST['text'])) {
			$query = "INSERT INTO comment (Text, Property, `Member ID`, Date) VALUES (?,?,?,?)";
			$stmt = $con->prepare($query);
			$date = time();
			$stmt->bind_Param("ssss", $_POST['text'],$_POST['listing'],$userid,$date);
			$stmt->execute();
	}
echo ("Comment added!<br>");
}



//check if the login form has been submitted
if(isset($_GET['pid'])){

    	// include database connection
    	include_once 'sql.php';
	
	// SELECT query
        $query = "SELECT property.*, member.`First Name`, member.`Last Name`, district.`District Name` FROM property INNER JOIN member ON property.`Supplier ID` = member.`Member ID` INNER JOIN district ON property.District = district.`District ID` WHERE `Property ID`=?";
 
        // prepare query for execution
        if($stmt = $con->prepare($query)){

        	// bind the parameters. This is the best way to prevent SQL injection hacks.
        	$stmt->bind_Param("s", $_GET['pid']);
        	// Execute the query
		$stmt->execute();

		/* resultset */
		$result = $stmt->get_result();

		// Get the number of rows returned
		$num = $result->num_rows;
		
		if($num>0){
			//Read the proeprty details
			$myrow = $result->fetch_assoc();
			$propertyOwner = $myrow['Supplier ID'];

			$query = "SELECT * FROM features NATURAL JOIN property_has WHERE `Property ID`=?";
        		$stmt = $con->prepare($query);
        		$stmt->bind_Param("s", $_GET['pid']);
       			$stmt->execute();
 			$features = $stmt->get_result();
			$noFeatures = $features->num_rows;

			$query = "SELECT * FROM `point of interest` WHERE `District ID`=?";
        		$stmt = $con->prepare($query);
        		$stmt->bind_Param("s", $myrow['District']);
       			$stmt->execute();
 				$pois = $stmt->get_result();
				$noPois = $pois->num_rows;

			$query = "SELECT comment.*, member.`First Name`, member.`Last Name`, CONCAT(COALESCE(`Parent Comment`,''),`Comment ID`) as ord FROM comment NATURAL JOIN member WHERE Property=? ORDER BY ord";
        		$stmt = $con->prepare($query);
        		$stmt->bind_Param("s", $_GET['pid']);
       			$stmt->execute();
 			$comments = $stmt->get_result();
			$nocomments = $comments->num_rows;
			$indent = "";

			$query = "SELECT AVG(rating) as avg FROM booking WHERE booking.`Property ID`=?";
        		$stmt = $con->prepare($query);
        		$stmt->bind_Param("s", $_GET['pid']);
       			$stmt->execute();
 			$rateresult = $stmt->get_result();
			$rating = $rateresult->fetch_assoc()['avg'];
			$indent = "";

			$query = "SELECT * FROM booking WHERE `Property ID`=? AND `Member ID`=?";
        		$stmt = $con->prepare($query);
        		$stmt->bind_Param("ss", $_GET['pid'],$userid);
       			$stmt->execute();
 			$bookings = $stmt->get_result();
			$noBookings = $bookings->num_rows;
			
		} 
		else
		{
			die("Property not found");
		}

		
		//echo "Error<br>";
		
	}
 }
?>

<!-- dynamic content will be here -->

		<p>Supplier: <?php echo $myrow['First Name'] . ' ' . $myrow['Last Name']; ?> <br>
		Address: <?php echo $myrow['Address']; ?> <br>	
		Type: <?php echo $myrow['Type']; ?> <br>
		District: <?php echo $myrow['District Name']; 
						if($noPois > 0) {
							$has = array();
							while($row = $pois->fetch_assoc()) {
								$has[] = $row['Name'];
							}
							echo (" (Has: " . implode(", ",$has) . ")"); 
						}
					?> <br>
		Price: <?php echo '$'.$myrow['Price'] .'/week'; ?> <br>
		Rating: <?php if($rating != ""){
				echo number_format($rating,1) .'/5'; 
			      } 
			      else{
				echo('Not rated');
			      }
			?> <br><br>
		Features: <br> <?php while($row = $features->fetch_assoc()) {
					  echo ('&emsp;- ' . $row['Feature Name'] . '<br>');
				     }
				     if(!empty($myrow['Other Features'])) {
				     	echo ('&emsp;- ' . $myrow['Other Features'] . '<br>');
				     }
				     if($noFeatures == 0 && empty($myrow['Other Features'])) {
						echo "None<br>";
				     }
				     
			       ?> <br>
		<?php echo $myrow['Description']; ?> <br><br>
		
		<?php if($userid != $propertyOwner){ ?>
		<form name='book' id='book' action='book.php' method='get'> 
		<input type="hidden" name="pid" value=<?php echo $myrow['Property ID']; ?> ><p>
		<?php
			if(isset($_GET['dateerror'])){
				echo("<font color='red'>Please enter a date</font><br>");
			}
			if(isset($_GET['unavailable'])){
				echo("<font color='red'>Property not available on selected date</font><br>");
			}


		?>
		
		Start Date: <input type="date" name="date"><br>
		(Booking period is 1 week)<br>
		<input type='submit' value='Book Property' /></p>
                </form>
		<?php } ?>
		</p>
		<hr><br>
		<form name='reply' id='reply' action='viewlisting.php?pid= <?php echo $myrow['Property ID']; ?>' method='post'> 
		<input type="hidden" name="listing" value=<?php echo $myrow['Property ID']; ?> >
		<p>
		Comments<br>
		
		<?php while($row = $comments->fetch_assoc()) {
					  
				if($row['Parent Comment'] != ""){
					$indent .= '&emsp;&emsp;&emsp;';
				}
				else{
					echo '<br>';
					$indent = "";
				}
					 $datestring = date('D',$row['Date']) . ' ' . date('d',$row['Date']) . ' ' . date('M',$row['Date']) . ' ' . date('o',$row['Date']);
					 echo ($indent . $row['First Name'] . ' ' . $row['Last Name'] . '&emsp; (' . $datestring . ')<br>' );
					 echo ($indent .$row['Text'] . '<br>');
					 if($userid == $propertyOwner && $userid != $row['Member ID']){
						echo ("$indent <textarea name='cReply[" . $row['Comment ID'] . "]' rows='2' cols='15'></textarea> <input type='submit' name='Submit' value='Reply' />");
					 }
					 echo('<br>');
			}

			//If user has booking allow adding comment
			if($noBookings > 0){
				echo ("<textarea name='text' rows='2' cols='15'></textarea> <br><input type='submit' name='Submit' value='Leave Comment' />");
			}

		?>
		</p>
		</form>
		 </div>
            
           	<div class="main_bottom"></div>
            
        </div>
        
        
        
        <?php include("footer.php"); ?>
        
        </div>
</body>
</html>

