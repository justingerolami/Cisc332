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
                <h1>Are you sure you want to remove this property?</h1>
            </div>
            <div class="main_body">
 <?php
 
 if(isset($_POST['removeBtn'])){
  // include database connection
    include_once 'sql.php'; 
    $query = "DELETE FROM property WHERE `Property ID`=?";
    $stmt = $con->prepare($query);
    $stmt->bind_Param("s", $_POST['pid']);
    $stmt->execute();
    header("Location: manageproperties.php?success");
    die();
    }
 ?>
 
<!-- dynamic content will be here -->
 <form action="removeproperty.php" method="post">
 <table border='0'><tr>
            <td></td><td>
		<input type='submit' name='removeBtn' id='removeBtn' value='Remove Property' /> 
                <input type='hidden' name='pid' id='pid' value='<? echo $_GET['pid']; ?>' /> 
            </td>
        </tr></table></form>

            </div>
            
            <div class="main_bottom"></div>
            
        </div>
        <div id="footer">
        <p>
        </p>
        </div>
        </div>
</body>
</html>
