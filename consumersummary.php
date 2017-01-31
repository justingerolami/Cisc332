
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

if($rank != 1 || $admin == 0){
	header("Location: index.php");
	die();			
}
if(!isset($_GET['uid'])){
	header("Location: manageusers.php");
	die();		
}

$query = "SELECT DISTINCT `Account Name` FROM member WHERE `Member ID` =?";
$stmt = $con->prepare($query);
$stmt->bind_Param("s", $_GET['uid']);
$stmt->execute();
$memberResults = $stmt->get_result()->fetch_assoc();
$memberName = $memberResults['Account Name'];


?>

<div id="page">
	<div id="header">
            <?php include ("header.php"); ?>
        </div>
  
        <div id="main">
        
            <div class="main_top">
                <h1><center>Consumer Bookings Summary for <?php echo $memberName; ?></center></h1>
            </div>
            
            <div class="main_body">
			
		<table border = 0>
		
<?php 

$query = "SELECT booking.Date, booking.Status, booking.rating, supplier.`Account Name` as supplierName, address FROM booking NATURAL JOIN member booker NATURAL JOIN property INNER JOIN member supplier ON supplier.`Member ID` = property.`Supplier ID` WHERE booker.`Member ID` =? ORDER BY address";

$stmt = $con->prepare($query);
$stmt->bind_Param("s", $_GET['uid']);
$stmt->execute();
$bookings = $stmt->get_result();
$noBookings = $bookings->num_rows;

if(isset($_GET['success'])){
	echo '<h3 id="msg"><font color="red"><center>Property removed.</center></font></h3>';
}

if ($noBookings > 0){
	echo '</tr><th>Supplier</th><th>address</th><th>Date</th><th>Status</th><th>Rating</th></tr>';
	while($row = $bookings->fetch_assoc()) {

		switch($row['Status']) {
			case 1:
				$status = "Rejected";
				break;
			case 2:
				$status = "Pending";
				break;
			case 3:
				$status = "Accepted";
				break;
		}
		echo "<tr><td>".$row['supplierName']."&emsp;</td>";
		echo "<td>".$row['address']."&emsp;</td>";
		echo "<td>". date('D d M o',$row['Date']) ."&emsp;</td>";
		echo "<td>$status&emsp;</td>";
		if(empty($row['rating'])){
			echo "<td>Not Rated&emsp;</td></tr>";
		}else{
			echo "<td>".$row['rating']."/5&emsp;</td></tr>";
		}
	}
}
else {
echo ('<td> This user has made no bookings </td>');
}
?>
		
		</table>
<br><br><br>

	    </div>
            
            <div class="main_bottom">
	    </div>
            
        </div>
        
       <?php include("footer.php"); ?>
        
</div>
</body>
</html>







