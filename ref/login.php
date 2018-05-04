<?php

/*
 * Check if the user exists in the database
 */

require_once("functions.php");

$q = $db->prepare("SELECT id FROM users WHERE email=? AND password=?");
$q->bind_param("ss",$_POST['email'],chash($_POST['password']));
$q->execute();
$q = $q->get_result();

if ($q->num_rows == 1) {
	echo json_encode(array("success"=>1,"message"=>""));
	$_SESSION['id'] = $q->fetch_assoc()['id'];
} else {
	echo json_encode(array("success"=>0,"message"=>"Failed to log in"));
}

?>
