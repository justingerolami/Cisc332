
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
                <h1><center>Update Your Information</center></h1>
            </div>
            
            <div class="main_body">


 
 <?php
 if(isset($_GET['pid'])){
    include_once 'sql.php';
     // SELECT query
        $id = $_GET['pid'];
        $query = "DELETE FROM property WHERE `property`.`Property ID` = $id";

        // prepare query for execution
        $stmt = $con->prepare($query);
        // Execute the query
        if($stmt->execute()){
            ?><h3 id="msg"><font color="red"><center>Successfully deleted.</center></font></h3><br/><?php
        }
 }
 if(isset($_POST['updateBtn']) && isset($_SESSION['id'])){
  // include database connection
    include_once 'sql.php'; 
    
    if(empty($_POST['password'])) {
    $query = "UPDATE member SET `First Name` =?, `Last Name` =?, `Phone Number`=? WHERE `Member ID`=?";
    $stmt = $con->prepare($query);  $stmt->bind_param('ssss', $_POST['first'],$_POST['last'],$_POST['phone'],$_SESSION['id']);
    }
    else{
    $query = "UPDATE member SET Password='".crypt($_POST['password'])."',`First Name` =?, `Last Name` =?, `Phone Number`=? WHERE `Member ID`=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ssss',$_POST['first'],$_POST['last'],$_POST['phone'],$_SESSION['id']);
    }
// Execute the query
    if($stmt->execute()){
        ?><h3 id="msg"><font color="red"><center>User information was updated.</center></font></h3><br/><?php
        $query = "SELECT `member id` from member where `member id`=?";
        $memid = $myrow['Member ID'];
        if(!empty($_POST['deg1'])){
            $degdate = $_POST['deg1'];
            $query = "INSERT INTO `has_earned`(`Member ID`, `Degree ID`, Year) VALUES ($memid, 1, $degdate)";
            if($stmt = $con->prepare($query)){
                $stmt->execute();
                ?><h3 id="msg"><font color="red"><center>HBSC Added.</center></font></h3><br/><?php
            }
            else{
                ?><h3 id="msg"><font color="red"><center>Failed to add HBSC.</center></font></h3><br/><?php
            }
        }
        if(!empty($_POST['deg2'])){
            $degdate = $_POST['deg2'];
            $query = "INSERT INTO `has_earned`(`Member ID`, `Degree ID`, Year) VALUES ($memid, 2, $degdate)";
            if($stmt = $con->prepare($query)){
                $stmt->execute();
            ?><h3 id="msg"><font color="red"><center>MSC Added.</center></font></h3><br/><?php
            }
            else{
                ?><h3 id="msg"><font color="red"><center>Failed to add MSC.</center></font></h3><br/><?php
            }
        }
        if(!empty($_POST['deg3'])){
            $degdate = $_POST['deg3'];
            $query = "INSERT INTO `has_earned`(`Member ID`, `Degree ID`, Year) VALUES ($memid, 3, $degdate)";
            if($stmt = $con->prepare($query)){
                $stmt->execute();
                ?><h3 id="msg"><font color="red"><center>BEng Added.</center></font></h3><br/><?php
            }
            else{
                ?><h3 id="msg"><font color="red"><center>Failed to add BEng.</center></font></h3><br/><?php
            }
        }
        if(!empty($_POST['deg4'])){
            $degdate = $_POST['deg4'];
            $query = "INSERT INTO `has_earned`(`Member ID`, `Degree ID`, Year) VALUES ($memid, 4, $degdate)";
            if($stmt = $con->prepare($query)){
                $stmt->execute();
                ?><h3 id="msg"><font color="red"><center>BComm Added.</center></font></h3><br/><?php
            }
            else{
                ?><h3 id="msg"><font color="red"><center>Failed to add BComm.</center></font></h3><br/><?php
            }
        }
    }else{
        ?><h3 id="msg"><font color="red"><center>Failed to update record.</center></font></h3><br/><?php
    }
 }
 
 ?>
 
 <?php
if(isset($_SESSION['id'])){
   // include database connection
    include_once 'sql.php'; 
    // SELECT query
        $query = "SELECT `member`.`Member ID`,`Account Name`, Password, `Email Address`, `First Name`, `Last Name`, `Phone Number`, `has_earned`.`Degree ID`, `Year`,`Type` FROM `has_earned` INNER JOIN `member` ON `member`.`Member ID` = `has_earned`.`Member ID` INNER JOIN `degree` ON `has_earned`.`Degree ID` = `degree`.`Degree ID` WHERE `member`.`Member ID`=?";
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
       // $query = "SELECT has_earned.Year,degree.`Degree ID`, degree.Type FROM degree, member, has_earned WHERE `member`.`Member ID` = `has_earned`.`Member ID` and has_earned.`Degree ID` = degree.`Degree ID` and `member`.`Member ID` =?";
         //   $stmt = $con->prepare($query);
           // $stmt->bind_Param("s", $_SESSION['id']);
            //$stmt->execute();
        //$deg = $stmt->get_result();
} else {
    //User is not logged in. Redirect the browser to the login index.php page and kill this page.
    header("Location: index.php");
    die();
}
?>
 
<!-- dynamic content will be here -->
<form name='editProfile' id='editProfile' action='profile.php' method='post'>
    <table border='0'>
        <tr>
            <td>Username</td>
            <td><input type='text' name='username' id='username' disabled  value="<?php echo $myrow['Account Name']; ?>"  /></td>
        </tr>
        <tr>
            <td>Password</td>
             <td><input type='text' name='password' id='password'  value="" /></td>
        </tr>
        <tr>
            <td>First name</td>
            <td><input type='text' name='first' id='first' value="<?php echo $myrow['First Name']; ?>"  /></td>
        </tr>
        <tr>
            <td>Last name</td>
            <td><input type='text' name='last' id='last' value="<?php echo $myrow['Last Name']; ?>"  /></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type='text' name='email' id='email'  disabled value="<?php echo $myrow['Email Address']; ?>" /></td>
        </tr>
        <tr>
            <td>Phone Number</td>
            <td><input type='text' name='phone' id='phone'  value="<?php echo $myrow['Phone Number']; ?>" /></td>
        </tr>
        <tr>
            <td>Degrees:</td>
        </tr>
        <tr>
            <?php
            include_once 'sql.php'; 
            $query = "SELECT has_earned.Year,degree.`Degree ID`, degree.Type FROM degree, member, has_earned WHERE `member`.`Member ID` = `has_earned`.`Member ID` and has_earned.`Degree ID` = degree.`Degree ID` and `member`.`Member ID` =?";
            $stml = $con->prepare($query);
            $stmt->bind_Param("s", $_SESSION['id']);
            // Execute the query
             $stmt->execute();
             $result = $stmt->get_result();
             $i = 0;
             foreach($result as $deg){ 
                if($i == 4){ ?>
                    </tr>
                    <tr>
                    
                    <?php $i=0; } ?>
                    <td></td>
                <td><input type='text' name='Degrees' id='Degrees' disabled value="<?php
                    echo $deg['Type']. ": ";
                    echo $deg['Year'] . "";
                    $i++;
                ?>"/></td></tr>
                <?php }
                ?>
        
        <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
        <tr>
            <td>Add a degree:</td>
        </tr>
        <tr>
            <td>HBSC</td>
            <td><input type="number" name="deg1" min = "1930" max = "2016" /></td>
        </tr>
        <tr>
            <td>MSC</td>
            <td><input type="number" name="deg2" min = "1930" max = "2016" /></td>
        </tr>
        <tr>
            <td>BEng</td>
            <td><input type="number" name="deg3" min = "1930" max = "2016" /></td>
        </tr>
        <tr>
            <td>BCom</td>
            <td><input type="number" name="deg4" min = "1930" max = "2016" /></td>
        </tr>
        <tr>
            
            <td></td><td>
                <input type='submit' name='updateBtn' id='updateBtn' value='Update' /> 
            </td>

        </tr>
    </table>
</form>

 <form action="cancel.php" method="get">
 <table border='0'>
    <tr>
        <td></td>
        <td><input type='submit' name='cancelBtn' id='cancelBtn' value='Cancel Account' /></td>
    </tr><tr></table></form>
        <br/><br/>

<h1><center>Property Management</center></h1>
<table border='0'>

    <?php
        $id = $_SESSION['id'];
        $query = "SELECT property.* from property, member where `member`.`Member ID` = `property`.`Supplier ID` and `property`.`Supplier ID` = $id";
        if($stmt = $con->prepare($query)){
            $stmt->execute();
            $ownedresult = $stmt->get_result();
            $ownedresultnum = $ownedresult->num_rows;
        } else {
            echo ("Failed statement");
        }
          
        if ($ownedresultnum > 0){
            while($row = $ownedresult->fetch_assoc()){
                echo "<tr><td><a href ='editproperty.php?pid=".$row['Property ID']."'><button>".$row['Address']."</button></a></td>";
                echo "<td><a href ='profile.php?pid=".$row['Property ID']."'><button>Delete</button></a></td></tr>";
                
            }
        } 
        else{
            ?><h3 id="msg"><font color="red"><center>No properties available</center></font></h3><br/><?php
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