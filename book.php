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
	header("Location: login.php");
	die();
}
 


if(isset($_GET['date']) && !empty($_GET['date'])){

    	// include database connection
    	include_once 'sql.php';
	
	
	$startDate = strtotime($_GET['date']);
	$endDate = strtotime("+7 day",$startDate);
	$query = "SELECT * FROM booking WHERE $startDate >= date AND date+604800 <=$endDate AND Status=3 AND `Property ID`=?";
	$stmt = $con->prepare($query);
	$stmt->bind_Param("s", $_GET['pid']);
	//die($query);
	$stmt->execute();
 	$bookings = $stmt->get_result();
	$noBookings = $bookings->num_rows;

	if($noBookings >0){
		header("Location: viewlisting.php?pid=" . $_GET['pid'] . "&unavailable");
		die();
	}


	$query = "INSERT INTO booking (`Member ID`, Date, Status, `Property ID`) VALUES (?,?,2,?)";
	$stmt = $con->prepare($query);
	$stmt->bind_Param("sss", $userid, $startDate, $_GET['pid']);
	$stmt->execute();
	
	header("Location: viewbookings.php?requestsent=1");
	die();
	

}else{
	header("Location: viewlisting.php?pid=" . $_GET['pid'] . "&dateerror=1");
	die();
}


?>


 </div>
            
           	<div class="main_bottom"></div>
            
        </div>
        
        
        
        <?php include("footer.php"); ?>
        
        </div>
</body>
</html>

