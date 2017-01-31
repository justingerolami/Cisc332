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
 ?>

    <div id="page">
		
        <div id="header">
        	<?php include ("header.php"); ?>
        </div>
  
        <div id="main">
        
        	<div class="main_top">
            	<h1>Please enter your username and password to continue.</h1>
            </div>
            
           	<div class="main_body">
 

 
 
 <?php
 //check if the user is already logged in and has an active session
if($rank >= 0){
	//Redirect the browser to the profile editing page and kill this page.
	header("Location: profile.php");
	die();
}
 ?>
 
 <?php

 
//check if the login form has been submitted
if(isset($_POST['loginBtn'])){
 
    // include database connection
    include_once 'sql.php';
	
	// SELECT query
        $query = "SELECT * FROM member WHERE `Account Name`=?";
 
        // prepare query for execution
        if($stmt = $con->prepare($query)){
		
        // bind the parameters. This is the best way to prevent SQL injection hacks.
        $stmt->bind_Param("s", $_POST['username']);


         
        // Execute the query
		$stmt->execute();
		/* resultset */
		$result = $stmt->get_result();

		// Get the number of rows returned
		$num = $result->num_rows;;
		
		if($num>0){
			//If the username matches a user in our database
			
			//Read the user details
			$myrow = $result->fetch_assoc();

			//Check password

			//if (hash_equals($myrow['Password'], crypt($_POST['password'], '$2a$07$uy&utbf(&OSscAZE$'))) {
			if ($myrow['Password'] == crypt($_POST['password'], $myrow['Password'])) {
			//Create a session variable that holds the user's id
			session_regenerate_id(true);
			$_SESSION['id'] = $myrow['Member ID'];
			$_SESSION['uname'] = $myrow['Account Name'];
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
			$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['rank'] = $myrow['Is_admin'];

			//Redirect the browser to the profile editing page and kill this page.
			echo "Logging in... please wait";
			header("Location: profile.php");
			die();
			}
		} 

		
		//If the username/password doesn't matche a user in our database
		// Display an error message and the login form
		?><h3 id="msg"><font color="red"><center>Failed to login</center></font></h3><?php
		
	}
 }
 
if(isset($_GET['registersuccess'])){
	?><h3 id="msg"><font color="red"><center>Account created successfully! You may now log in.</center></font></h3><?php
	//echo "Account Created Successfully! You may now log in.";
	 
 }
?>

<!-- dynamic content will be here -->
 <form name='login' id='login' action='index.php' method='post'>
    <table border='0'>
        <tr>
            <td>Username</td>
            <td><input type='text' name='username' id='username' /></td>
        </tr>
        <tr>
            <td>Password</td>
             <td><input type='password' name='password' id='password' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' id='loginBtn' name='loginBtn' value='Log In' /> 
            </td>
        </tr>
    </table>
</form>

                 </div>
            
           	<div class="main_bottom"></div>
            
        </div>
        
        
        
        <?php include("footer.php"); ?>
        
        </div>
</body>
</html>
