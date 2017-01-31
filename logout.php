<?php

session_start();
//Destroy the user's session.
$_SESSION = array();
session_destroy();
header("Location: index.php");
die();

?>
