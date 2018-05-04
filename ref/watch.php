<?php


/*
 * Sets the watch status of the provided ip
 */

require_once("functions.php");



if (empty($_SESSION['id'])) {
	echo json_encode(array());
	die();
}



$user_id = intval($_SESSION['id']);
$watch = intval($_POST['watch']);
$ip = $_POST['ip'];



if ($watch == 1) {
	//mark as watching
	$q = $db->prepare("INSERT INTO watching (user_id,ip) VALUES (?,?)");
	$q->bind_param("is",$user_id,$ip);
	$q->execute();
} else {
	//remove from watching
	$q = $db->prepare("DELETE FROM watching WHERE user_id=? AND ip=?");
	$q->bind_param("is",$user_id,$ip);
	$q->execute();
}



?>
