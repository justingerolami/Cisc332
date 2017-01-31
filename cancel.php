<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Queen's B&B</title>
</head>
<body>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("session.php");

if($rank >= 0){
   // include database connection
    include_once 'sql.php'; 
    // SELECT query
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
?>

    <div id="page">
        <div id="header">
            <?php include ("header.php"); ?>
        </div>
        <div id="main">
            <div class="main_top">
                <h1>Are you sure you want to cancle your subscription?</h1>
            </div>
            <div class="main_body">
 <?php
 
 if(isset($_POST['cancelBtn'])){
  // include database connection
    include_once 'sql.php'; 
    $memid = $myrow['Member ID'];
    $query = "DELETE FROM member WHERE `member`.`member ID`=$memid";
    $stmt = $con->prepare($query);
    $stmt->execute();
    header("Location: logout.php");
    die();
    }
 ?>
 
<!-- dynamic content will be here -->
 <form action="cancel.php" method="post">
 <table border='0'><tr>
            <td></td><td>
                <input type='submit' name='cancelBtn' id='cancelBtn' value='Cancel Account' /> 
            </td>
        </tr></table></form>

            </div>
            
            <div class="main_bottom"></div>
            
         <?php include("footer.php"); ?>
        </div>
</body>
</html>
