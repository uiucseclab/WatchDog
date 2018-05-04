<?php


/*
 * return a JSON response of all portfolio charts
 */

require_once("functions.php");



if (empty($_SESSION['id'])) {
	echo json_encode(array());
	die();
}


$scan_id = isset($_POST['scan_id']) ? intval($_POST['scan_id']) : PHP_INT_MAX;
if ($scan_id == -1) {
	$scan_id = PHP_INT_MAX;
}
$node_ip = isset($_POST['node_ip']) ? clean($_POST['node_ip']) : "";

$result = array();

/*
$start_date = date("Y-m-d",strtotime($_POST['start_date']));
$end_date = date("Y-m-d",strtotime($_POST['end_date']));
 */



//charts
//charts['labels'] has the global labels
//each $chart array has a datasets array
//Each dataset has the label for that graph, settings, and the data itself
//There is a total, and then a dataset for each system


//# of Nodes
$chart = array();
$chart['labels'] = array();
$chart['datasets'] = array();

$total_chart = array();
$total_chart['data'] = array(); //data array
//general chart info
$total_chart['borderColor'] = "rgba(237,143,40,1)";
$total_chart['backgroundColor'] = "rgba(237,143,40,0.8)";
$total_chart['label'] = "# Of Nodes";
$total_chart['fill'] = false;
$total_chart['pointBorderWidth'] = 3;
$total_chart['borderWidth'] = 2.5;
$total_chart['radius'] = 0;
$total_chart['hitRadius'] = 8;
$total_chart['pointBackgroundColor'] = "rgba(255,255,255,1)";
//fill in data
$chart_Q = $db->query("SELECT COUNT(nodes.id) as nodes,scans.date FROM nodes INNER JOIN scans ON nodes.scan_id=scans.id WHERE scans.id <= $scan_id GROUP BY nodes.scan_id ORDER BY nodes.scan_id ASC LIMIT 20");
while($row = $chart_Q->fetch_assoc()) {
	$chart['labels'][] = date("m-d",strtotime($row['date']));
	$total_chart['data'][] = $row['nodes'];
}
$chart['datasets'][] = $total_chart; //add total chart

$result['nodes_chart'] = $chart;




//# of ports
$chart = array();
$chart['labels'] = array();
$chart['datasets'] = array();

$total_chart = array();
$total_chart['data'] = array(); //data array
//general chart info
$total_chart['borderColor'] = "rgba(237,143,40,1)";
$total_chart['backgroundColor'] = "rgba(237,143,40,0.8)";
$total_chart['label'] = "# Open Ports";
$total_chart['fill'] = false;
$total_chart['pointBorderWidth'] = 3;
$total_chart['borderWidth'] = 2.5;
$total_chart['radius'] = 0;
$total_chart['hitRadius'] = 8;
$total_chart['pointBackgroundColor'] = "rgba(255,255,255,1)";
//fill in data
if ($node_ip != "") {
	$chart_Q = $db->query("SELECT SUM(1) as ports,scans.date as date FROM nodes INNER JOIN ports ON ports.node_id=nodes.id INNER JOIN scans ON scans.id=nodes.scan_id WHERE scans.id <= $scan_id AND nodes.ip='$node_ip' GROUP BY scans.date");
} else {
	$chart_Q = $db->query("SELECT SUM(1) as ports,scans.date as date FROM nodes INNER JOIN ports ON ports.node_id=nodes.id INNER JOIN scans ON scans.id=nodes.scan_id WHERE scans.id <= $scan_id GROUP BY scans.date");
}
while($row = $chart_Q->fetch_assoc()) {
	$chart['labels'][] = date("m-d",strtotime($row['date']));
	$total_chart['data'][] = $row['ports'];
}
$chart['datasets'][] = $total_chart; //add total chart

function port_data($port) {
	global $db;
	global $node_ip;
	global $scan_id;

	$port = intval($port);
	if ($node_ip != "") {
		$chart_Q = $db->query("SELECT SUM(IF(ports.port='$port',1,0)) as ports,scans.date as date FROM nodes INNER JOIN ports ON ports.node_id=nodes.id INNER JOIN scans ON scans.id=nodes.scan_id WHERE scans.id <= $scan_id AND nodes.ip='$node_ip' GROUP BY scans.date");
	} else {
		$chart_Q = $db->query("SELECT SUM(IF(ports.port='$port',1,0)) as ports,scans.date as date FROM nodes INNER JOIN ports ON ports.node_id=nodes.id INNER JOIN scans ON scans.id=nodes.scan_id WHERE scans.id <= $scan_id GROUP BY scans.date");
	}
	$chart = array();
	$chart['label'] = "Port $port";
	$color = name_to_color($port);
	$chart['backgroundColor'] = "rgba(".$color[0].",".$color[1].",".$color[2].",.5)";
	$chart['borderColor'] = "rgba(".$color[0].",".$color[1].",".$color[2].",1)";
	$chart['fill'] = false;
	while($row = $chart_Q->fetch_assoc()) {
		$chart['data'][] = $row['ports'];
	}
	return $chart;
}

//ports
$chart['datasets'][] = port_data("80");
$chart['datasets'][] = port_data("445");
$chart['datasets'][] = port_data("22");

$result['ports_chart'] = $chart;





//port distribution pie chart
$chart = array();
$chart['labels'] = array();
$chart['datasets'] = array();

$total_chart = array();
$total_chart['data'] = array(); //data array
$total_chart['backgroundColor'] = array();
//fill in data
if ($node_ip != "") {
	//Shows historical counts of ports
	if ($scan_id == PHP_INT_MAX) {
		$chart_Q = $db->query("SELECT ports.port,COUNT(*) as count FROM ports INNER JOIN nodes ON ports.node_id=nodes.id INNER JOIN scans ON scans.id=nodes.scan_id AND nodes.ip='$node_ip' GROUP BY ports.port");
	} else {
		$chart_Q = $db->query("SELECT ports.port,COUNT(*) as count FROM ports INNER JOIN nodes ON ports.node_id=nodes.id INNER JOIN scans ON scans.id=nodes.scan_id WHERE scans.id <= $scan_id AND nodes.ip='$node_ip' GROUP BY ports.port");
	}
} else {
	if ($scan_id == PHP_INT_MAX) {
		$chart_Q = $db->query("SELECT ports.port,COUNT(*) as count FROM ports INNER JOIN nodes ON ports.node_id=nodes.id INNER JOIN scans ON scans.id=nodes.scan_id WHERE scans.id=(SELECT scans.id as id FROM scans ORDER BY id DESC LIMIT 1) GROUP BY ports.port");
	} else {
		$chart_Q = $db->query("SELECT ports.port,COUNT(*) as count FROM ports INNER JOIN nodes ON ports.node_id=nodes.id INNER JOIN scans ON scans.id=nodes.scan_id WHERE scans.id=$scan_id GROUP BY ports.port");
	}
}
while($row = $chart_Q->fetch_assoc()) {
	$chart['labels'][] = $row['port'];
	$total_chart['data'][] = $row['count'];
	$color = name_to_color($row['port']);
	$total_chart['backgroundColor'][] = "rgba(".$color[0].",".$color[1].",".$color[2].",0.8)";
}
$chart['datasets'][] = $total_chart; //add total chart


$result['dist_chart'] = $chart;








// Node info




if ($node_ip != "") {
	//Add in node info
	$info = array();
	$q = $db->query("SELECT ports.port as port FROM ports INNER JOIN nodes ON ports.node_id=nodes.id WHERE nodes.id=(SELECT nodes.id as id FROM nodes WHERE ip='$node_ip' ORDER BY id DESC LIMIT 1)");
	$ports = array();
	$ports_str = "";
	while ($port = $q->fetch_assoc()) {
		$ports[] = $port['port'];
		$ports_str .= $port['port']."<br/>";
	}
	$info[] = array("title"=>"# of Open Ports","val"=>sizeof($ports));
	$info[] = array("title"=>"Open Ports","val"=>$ports_str);
	$first_seen = $db->query("SELECT scans.date as date FROM scans INNER JOIN nodes ON nodes.scan_id=scans.id WHERE nodes.ip='$node_ip'")->fetch_assoc()['date'];
	$info[] = array("title"=>"First Seen","val"=>$first_seen);
	$num_scans = $db->query("SELECT COUNT(scans.id) as scans FROM scans INNER JOIN nodes ON nodes.scan_id=scans.id WHERE nodes.ip='$node_ip'")->fetch_assoc()['scans'];
	$info[] = array("title"=>"# of Scans included in","val"=>$num_scans);
	$result['info'] = $info;
}




echo json_encode($result);




?>
