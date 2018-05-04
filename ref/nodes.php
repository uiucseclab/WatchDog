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

$scan_id = intval($_POST['scan_id']);

if ($scan_id == -1) {
$q = $db->prepare("SELECT * FROM nodes WHERE scan_id = (SELECT id FROM scans ORDER BY date DESC LIMIT 1)");
} else {
$q = $db->prepare("SELECT * FROM nodes WHERE scan_id = ?");
$q->bind_param("i",$scan_id);
}

$q->execute();
$q = $q->get_result();

$nodes = array();

while ($node = $q->fetch_assoc()) {
	$nodes[] = array("id"=>$node['id'],"name"=>$node['name'],"mac"=>$node['mac'],"ip"=>$node['ip'],"watch"=>intval(is_watching($node['ip'])));
}

echo json_encode($nodes);

?>

