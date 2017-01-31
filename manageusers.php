
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
?>

<div id="page">
	<div id="header">
            <?php include ("header.php"); ?>
        </div>
  
        <div id="main">
        
            <div class="main_top">
                <h1><center>Manage Users</center></h1>
            </div>
            
            <div class="main_body">
			
		<table border = 0>
	
		
			<?php 
			$query = "SELECT * FROM member";
			$stmt = $con->prepare($query);
			$stmt->execute();
			$members = $stmt->get_result();
			$noMembers = $members->num_rows;

			if(isset($_GET['success'])){
				echo '<h3 id="msg"><font color="red"><center>User removed.</center></font></h3>';
			}
			if ($noMembers > 0){
				while($row = $members->fetch_assoc()) {
					echo "<td>".$row['Account Name']."&emsp;</td>";
					echo "<td>".$row['Email Address']."&emsp;</td>";
					echo "<td>".$row['Phone Number']."&emsp;</td>";
					echo "<td>".$row['First Name']. ' ' . $row['Last Name'] ."</td>";
					echo "<td><a href='suppliersummary.php?uid=". $row['Member ID'] ."'><input type='button' value='Bookings Recieved'></a></td>";
					echo "<td><a href='consumersummary.php?uid=". $row['Member ID'] ."'><input type='button' value='Bookings Made'></a></td>";
					echo "<td><a href='removeuser.php?uid=". $row['Member ID'] ."'><input type='button' value='Remove User'></a></td></tr>";
				}
			}
			?>
		
		</table>
	    </div>
            
            <div class="main_bottom">
	    </div>
            
        </div>
        
       <?php include("footer.php"); ?>
        
</div>
</body>
</html>







