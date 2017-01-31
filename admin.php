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

	if($admin == 0 && $rank == 1){	
		session_regenerate_id(true);				
		$_SESSION['admin'] = 1;
		header("Location: manageusers.php");
		die();
	}
	else{
		session_regenerate_id(true);				
		$_SESSION['admin'] = 0;
		header("Location: index.php");
		die();
	}



?>

<!-- dynamic content will be here -->

		
		<p></p>
             
		 </div>
            
           	<div class="main_bottom"></div>
            
        </div>
        
        
        
        <?php include("footer.php"); ?>
        
        </div>
</body>
</html>

