
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Queen's B&B</title>
</head>

<body>

<?php
include("session.php");
include_once 'sql.php'; 
if (isset($_POST['Update'])){
	$query = "UPDATE `booking` SET `Status` = ? WHERE `booking`.`Booking ID` = ?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_Param("ss", $_POST['statussel'], $_POST['bookid']);
		$stmt->execute();
	}
}
if (isset($_POST['Cancel'])){
	$query = "UPDATE `booking` SET `Status` = 4 WHERE `booking`.`Booking ID` = ?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_Param("s", $_POST['bookid']);
		$stmt->execute();
	}
}
if (isset($_POST['Remove'])){
	$query = "DELETE FROM `booking` WHERE `booking`.`Booking ID` = ?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_Param("s", $_POST['bookid']);
		$stmt->execute();
	}
}
if($rank >= 0){
		
		$query = "SELECT DISTINCT `Address`, `Booking ID`, `Account Name`, `Date`, `Status` FROM `booking` JOIN `property` ON `booking`.`Property ID` = `property`.`Property ID` JOIN `member` ON `booking`.`Member ID` = `member`.`Member ID` WHERE booking.`Member ID` = member.`Member ID` and property.`Supplier ID` = $userid";
        
		if($stmt = $con->prepare($query)){
			
			$stmt->execute();
			
			$ownedresult = $stmt->get_result();
			
			$ownedresultnum = $ownedresult->num_rows;
		} else {
			echo ("Failed statement 1");
		}
		
		$query = "SELECT DISTINCT booking.`Property ID`, `Booking ID`, `Address`, member.`Email Address`, `Date`, `Status`, rating FROM `booking` JOIN `property` ON `booking`.`Property ID`= `property`.`Property ID` JOIN `member` ON `member`.`Member ID` = `property`.`Supplier ID` WHERE booking.`Member ID` = $userid";

        
		if($stmt = $con->prepare($query)){
			
			$stmt->execute();
			
			$requestedresult = $stmt->get_result();
			
			$requestedresultnum = $requestedresult->num_rows;
		} else {
			echo ("Failed statement 2");
		}
		
} else {
    //User is not logged in. Redirect the browser to the login index.php page and kill this page.
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
                <h1><center>Bookings</center></h1>
            </div>
            
            <div class="main_body">
			
<!-- dynamic content will be here -->
<?php 


?>

		<table border = 0>
		<tr>
		<?php
		if (isset($_GET['requestsent'])){
			echo "<th colspan = 4>Your booking request has been sent! Check back for updates here</tr><tr>";
		}

		if (isset($_GET['success'])){
			echo "<th colspan = 4>Rating saved</tr><tr>";
		}
		?>
			<th colspan = "4"><h2>Bookings on your listed properties:</h2></th>
		</tr>
		
		<?php 
		
		if ($ownedresultnum > 0){
			while($row = $ownedresult->fetch_assoc()) {
				echo "<form name = 'updatebooking' action='viewbookings.php' method='post'>";
				echo "<td>".$row['Account Name']."</td><td>".date('D',$row['Date']) . " " . date('d',$row['Date']) . " " . date('M',$row['Date']) . " " . date('o',$row['Date'])."</td>";
				echo "<td>".$row['Address']."</td>";
				echo "<td><input type='hidden' name=bookid value=".$row['Booking ID']."/></td>";
				if($row['Status'] == 1){
					echo "<td><select name='statussel' disabled><option value=1 selected>Rejected</option>";
					echo "<option value=2>Pending</option><option value=3>Accepted</option></select></td>";
					echo "<td><input type='submit' name='Update' value='Update' disabled/></td></tr>";
				} else if ($row['Status'] == 2) {
					echo "<td><select name='statussel'><option value=1>Rejected</option>";
					echo "<option value=2 selected>Pending</option><option value=3>Accepted</option></select></td>";
					echo "<td><input type='submit' name='Update' value='Update'/></td></tr>";
				} else if ($row['Status'] == 3) {
					echo "<td><select name='statussel' disabled><option value=1>Rejected</option>";
					echo "<option value=2>Pending</option><option value=3 selected>Accepted</option></select></td>";
					echo "<td><input type='submit' name='Update' value='Update' disabled/></td></tr>";
				} else {
					echo "<td>Cancelled</td>";
					echo "<td><input type='submit' name='Remove' value='Remove'/></td></tr>";
				}
				echo "</form>";
			}
			
		} else {
			echo "<tr><th colspan = "."4".">You do not have any bookings on your listed properties!</th></tr>";
		}
		?>
		<tr></tr><th colspan = "4"><h2>Bookings you have requested on other properties:</h2><th></tr>
		<?php
		if ($requestedresultnum > 0){
			while($row = $requestedresult->fetch_assoc()){
				echo "<tr><td>".$row['Address']."</td><td>".date('D',$row['Date']) . " " . date('d',$row['Date']) . " " . date('M',$row['Date']) . " " . date('o',$row['Date'])."</td>";
				if($row['Status'] == 1){
					echo "<td>Rejected</td><td><form name = 'removebooking' action='viewbookings.php' method='post'><input type='hidden' name='bookid' value=".$row['Booking ID']."/></td>";
					echo "<td><input type='submit' name='Remove' value='Remove'/></td></form><td><a href ='viewlisting.php?pid=".$row['Property ID']."'><button>Visit Property Page</button></a></td>";
				} else if($row['Status'] == 2) {
					echo "<td>Pending</td><td><form name = 'cancelbooking' action='viewbookings.php' method='post'><input type='hidden' name=bookid value=".$row['Booking ID']."/></td>";
					echo "<td><input type='submit' name='Cancel' value='Cancel'/></td></form><td><a href ='viewlisting.php?pid=".$row['Property ID']."'><button>Visit Property Page</button></a></td>";
				} else if ($row['Status'] == 3) {
					echo "<td>Accepted! Contact via:</td>";
					echo "<td>".$row['Email Address']."<form name = 'cancelbooking' action='viewbookings.php' method='post'><input type='hidden' name=bookid value=".$row['Booking ID']."/></td>";
					echo "<td><input type='submit' name='Cancel' value='Cancel'/></td></form><td><a href ='viewlisting.php?pid=".$row['Property ID']."'><button>Visit Property Page</button></a></td>";
				} else {
					echo "<td>Cancelled</td><td></td><td></td><td><a href ='viewlisting.php?pid=".$row['Property ID']."'><button>Visit Property Page</button></a></td>";
				}

				if($row['Status'] == 3 && empty($row['rating']))
					echo "<td><a href='rate.php?bid=". $row['Booking ID'] ."'><input type='button' value='Rate Stay'></a></td></tr>";
				echo "</tr>";
			}
			
		} else {
			echo "<tr><th colspan = "."4".">You have not requested bookings on any properties!</th></tr>";
		}
		?>
		</table>
				 </div>
            
           	<div class="main_bottom"></div>
            
        </div>
        
        
        
        <?php include("footer.php"); ?>
        
        </div>
</body>
</html>
</body>
</html>






