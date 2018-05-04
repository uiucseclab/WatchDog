<?php

/*
 * return a JSON response of current nodes
 */

require_once("functions.php");


//check if logged in

if (empty($_SESSION['id'])) {
	echo json_encode(array());
	die();
}


$q = $db->prepare("SELECT * FROM scans ORDER BY date DESC");
$q->execute();
$q = $q->get_result();

$scans = array();

while ($scan = $q->fetch_assoc()) {
	$scans[] = array("id"=>$scan['id'],"date"=>$scan['date']);
}

echo json_encode($scans);

?>

