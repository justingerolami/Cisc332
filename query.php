<?php

include("sql.php");

$query = "SELECT Text FROM comment";
$result = $conn->query($query);

if($result) {
	$result->data_seek(0);
	while($row = $result->fetch_assoc()){
   		 echo $row['Text'] . '<br>';
	}
}

$result->free();


$conn->close();

?>