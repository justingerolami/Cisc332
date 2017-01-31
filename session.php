<?php
//ini_set("session.cookie_secure", 1);
//ini_set("session.cookie_httponly", 1);

session_start();

$rank = -1;
$admin =0;
if(isset($_SESSION['id'])){

	if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'] || $_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']) {
		$_SESSION = array();
		session_destroy();
		die();
	}
	$accountname = $_SESSION['uname'];
	$userid = $_SESSION['id'];		//Rank will be -1 for not logged in
	$rank = $_SESSION['rank'];		//		0 for regular user
						//		1 for admin
	if(isset($_SESSION['admin'])){					
		$admin = $_SESSION['admin'];
		
	}
}



?>
