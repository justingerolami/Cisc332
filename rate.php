
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

if($rank == -1){
	header("Location: index.php");
	die();			
}

if(isset($_POST['rate'])){
	$query = "UPDATE booking SET rating = ? WHERE `Booking ID`=?";
	$stmt = $con->prepare($query);
	$stmt->bind_Param("ss", $_POST['rate'], $_POST['bid']);
	$stmt->execute();
	header("Location: viewbookings.php?success");
	die();
}







if(!isset($_GET['bid'])){
	header("Location: viewbookings.php");
	die();		
}



?>

<div id="page">
	<div id="header">
            <?php include ("header.php"); ?>
        </div>
  
        <div id="main">
        
            <div class="main_top">
                <h1><center>Feedback</center></h1>
            </div>
            
            <div class="main_body">
			
		<table border = 0>
			
		
			<?php 
			$query = "SELECT * FROM booking NATURAL JOIN property WHERE `Booking ID`=? AND rating IS NULL AND booking.`Member ID`=$userid";
			$stmt = $con->prepare($query);
			$stmt->bind_Param("s", $_GET['bid']);
			$stmt->execute();
			$booking = $stmt->get_result()->fetch_assoc();

			if(!isset($booking['Address'])){
				header("Location: viewbookings.php");
				die();	
			}

			?>
					<td> Rate your stay at <?php echo $booking['Address']; ?> on <?php echo date('D d M o',$booking['Date']); ?>:  
<form name = 'giveRating' action='rate.php' method='post'>
<input type="hidden" name="bid" value=<?php echo $_GET['bid']; ?>>
<select name='rate'>
  <option value=1>1</option>
  <option value=2>2</option>
  <option value=3>3</option>
  <option value=4>4</option>
  <option value=5>5</option>
</select>
<input type='submit' value='Rate'>
</form> </td>
		
		</table>
	    </div>
            
            <div class="main_bottom">
	    </div>
            
        </div>
        
       <?php include("footer.php"); ?>
        
</div>
</body>
</html>







