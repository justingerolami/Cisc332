<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Queen's B&B</title>
</head>

<body>
 <?php
//check if the register form has been submitted
include("session.php");
$rank = -1;
//Destroy the user's session.
$_SESSION = array();
session_destroy();
if(isset($_POST['Submit'])){
 
    // include database connection
    include_once 'sql.php';
        
        if(empty($_POST['deg1']) and empty($_POST['deg2']) and empty($_POST['deg3']) and empty($_POST['deg4'])){
            //User selected no degrees
            header("Location: register.php?nodegrees='1'");
            die();
        }

        if($_POST['password'] != $_POST['confirmPassword']){
            header("Location: register.php?passworderror");
            die();
        }
    

    // SELECT query
        $query1 = "SELECT `Member ID`  FROM member WHERE `Account Name`=?";
 
        // prepare query for execution
        if($stmt = $con->prepare($query1)){
        
        // bind the parameters. This is the best way to prevent SQL injection hacks.
        $stmt->bind_Param("s", $_POST['username']);
        // Execute the query
        $stmt->execute();
 
        /* resultset */
        $result = $stmt->get_result();
        // Get the number of rows returned
        $num = $result->num_rows;;
        
        if($num>0){
            //If the username/password matches a user in our database
            //Read the user details
            $myrow = $result->fetch_assoc();
            //Create a session variable that holds the user's id
            $_SESSION['id'] = $myrow['Member ID'];
            //Redirect the browser to the profile editing page and kill this page.
            ?><h3 id="msg"><font color="red"><center>Account Name Already Exists</center></font></h3><br/><?php
            header("Location: register.php?nameerror='1'");
            die();
        }
        } else {
            echo "failed to prepare the SQL";
        }
         $query = "SELECT `Account Name`  FROM member WHERE `Email Address`=?";
 
        // prepare query for execution
        if($stmt = $con->prepare($query)){
        
        // bind the parameters. This is the best way to prevent SQL injection hacks.
        $stmt->bind_Param("s", $_POST['email']);
        // Execute the query
        $stmt->execute();
 
        /* resultset */
        $result = $stmt->get_result();
        // Get the number of rows returned
        $num = $result->num_rows;;
        
        if($num>0){
            //If the username/password matches a user in our database
            //Read the user details
            $myrow = $result->fetch_assoc();
            //Create a session variable that holds the user's id
            $_SESSION['id'] = $myrow['Member ID'];
            //Redirect the browser to the profile editing page and kill this page.
            echo "Account name already exists";
            header("Location: register.php?mailerror='1'");
            die();
        }
        } else {
            echo "failed to prepare the SQL";
        }
        $query = "INSERT INTO `member` (`Account Name`, `Email Address`, `Phone Number`, `First Name`, `Last Name`, `Password`, `Member ID`, `Is_admin`) VALUES (?, ?, ?, ?, ?, ?, NULL, '0')";
 
        // prepare query for execution
        if($stmt = $con->prepare($query)){
        
        // bind the parameters. This is the best way to prevent SQL injection hacks.
        $stmt->bind_Param("ssssss", $_POST['username'], $_POST['email'], $_POST['phonenum'], $_POST['firstname'], $_POST['lastname'], crypt($_POST['password']));
        // Execute the query
        $stmt->execute() OR die("Illegal field entries maybe idk ask the admin");
        
        if($stmt = $con->prepare($query1)){
        
            // bind the parameters. This is the best way to prevent SQL injection hacks.
            $stmt->bind_Param("s", $_POST['username']);
            // Execute the query
            $stmt->execute();
            
            $result = $stmt->get_result();
            // Get the number of rows returned
            $num = $result->num_rows;;
            if($num > 0){
                $myrow = $result->fetch_assoc();
                $memID = $myrow['Member ID'];
                if(!empty($_POST['deg1'])){
                    $degdate = $_POST['deg1'];
                    $query3 = "INSERT INTO `has_earned` (`Member ID`, `Degree ID`, Year) VALUES ($memID, 1, $degdate)";
                    if($stmt3 = $con->prepare($query3)){
                        $stmt3->execute();
                    } else {
                        echo "failed to prepare the SQL";
                    } 
                }
                if(!empty($_POST['deg2'])){
                    $degdate = $_POST['deg2'];
                    $query3 = "INSERT INTO `has_earned` (`Member ID`, `Degree ID`, Year) VALUES ($memID, 2, $degdate)";
                    if($stmt3 = $con->prepare($query3)){
                        $stmt3->execute();
                    } else {
                        echo "failed to prepare the SQL";
                    } 
                }
                if(!empty($_POST['deg3'])){
                    $degdate = $_POST['deg3'];
                    $query3 = "INSERT INTO `has_earned` (`Member ID`, `Degree ID`, Year) VALUES ($memID, 3, $degdate)";
                    if($stmt3 = $con->prepare($query3)){
                        $stmt3->execute();
                    } else {
                        echo "failed to prepare the SQL";
                    } 
                }
                if(!empty($_POST['deg4'])){
                    $degdate = $_POST['deg4'];
                    $query3 = "INSERT INTO `has_earned` (`Member ID`, `Degree ID`, Year) VALUES ($memID, 4, $degdate)";
                    if($stmt3 = $con->prepare($query3)){
                        $stmt3->execute();
                    } else {
                        echo "failed to prepare the SQL";
                    } 
                }
            } else {
                echo "Insertion failed";
                die();
            }
        } else {
            echo "Failed to prep query1";
            die();
        }
        
        header("Location: index.php?registersuccess=1");
        die();
        } else {
            echo "failed to prepare the SQL";
        }
 }
 
if(isset($_GET['mailerror'])){
    ?><h3 id="msg"><font color="red"><center>Unable to create account: Account already exists with that email address!</center></font></h3><br/><?php
    
}

if(isset($_GET['passworderror'])){
    ?><h3 id="msg"><font color="red"><center>Unable to create account: Passwords do not match!</center></font></h3><br/><?php
    
}
if(isset($_GET['nameerror'])){
    
    ?><h3 id="msg"><font color="red"><center>Unable to create account: Account name already taken!</center></font></h3><br/><?php
}
if(isset($_GET['nodegrees'])){
    ?><h3 id="msg"><font color="red"><center>Unable to create account: Please select your degree!</center></font></h3><br/><?php
    
}
 ?>
 
     <div id="page">
        
        <div id="header">
            <?php include ("header.php"); ?>
        </div>
  
        <div id="main">
        
            <div class="main_top">
                <h1><center>Register for Qbnb</center></h1>
            </div>
            
            <div class="main_body">

<p>Please insert your information below, fields with '*' are required</p>
            
<form name='register' id='register' action='register.php' method='post'>
    
    <table border='0'>
        
        <tr>
            <td>Username*</td>
            <td><input type='text' name='username' id='username' value=""  maxlength="20" required/></td>
        </tr>
        <tr>
            <td>Password*</td>
             <td><input type='password' name='password' id='password'  value="" maxlength="50" required/></td>
        </tr>
         <tr>
            <td>Confirm Password*</td>
             <td><input type='password' name='confirmPassword' id='confirmPassword'  value="" maxlength="50" required/></td>
        </tr>
        <tr>
            <td>Email*</td>
            <td><input type='text' name='email' id='email'  value="" maxlength="50" required/></td>
        </tr>
        <tr>
            <td>First Name*</td>
            <td><input type='text' name='firstname' id='firstname' value="" maxlength="20" required/></td>
        </tr>
        <tr>
            <td>Last Name*</td>
            <td><input type='text' name='lastname' id='lastname' value=""  maxlength="20" required/></td>
        </tr>
        <tr>
            <td>Phone number</td>
            <td><input type='text' name='phonenum' id='phonenum' value="" maxlength="15" /></td>
        </tr>
        <tr>
            <td>Degrees earned from Queens:</td>
            <td>Please record the year of all that you have earned<td>
        <tr>
        <tr>
            <td>HBSC</td>
            <td><input type="number" name="deg1" min = "1930" max = "2016"></td>
        </tr>
        <tr>
            <td>MSC</td>
            <td><input type="number" name="deg2" min = "1930" max = "2016"></td>
        </tr>
        <tr>
            <td>BEng</td>
            <td><input type="number" name="deg3" min = "1930" max = "2016"></td>
        </tr>
        <tr>
            <td>BCom</td>
            <td><input type="number" name="deg4" min = "1930" max = "2016"></td>
        </tr>
        
        <tr>
        <td></td>
            <td>
                <input type='submit' name='Submit' id='Submit' value='Register' /> 
            </td>
        </tr>
    </table>
</form>

</div>
<div class="main_bottom"></div>
            
        </div>
        
        
        
        <div id="footer">
        <p>
        </p>
        </div>
 
</fieldset>
</form>
</body>
</html>
