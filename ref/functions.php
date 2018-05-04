<?php


session_start();
require_once("connect_to_db.php");

//security headers

//prevent frames:
header("X-Frame-Options: DENY");
header("Content-Security-Policy: frame-ancestors 'none'", false);


//log user in
/*
if (!empty($_SESSION['id'])) {
	$uid = $_SESSION['id'];
} else {
	if (!empty($_COOKIE['user_hash'])) {
		//check if this user_hash cookie is valid
		$userQ = $db->query("SELECT * FROM Users WHERE hash='".clean($_COOKIE['user_hash'])."'");
		if ($userQ->num_rows == 1) {
			//store this data and log them in
			$uid = $userQ->fetch_assoc()['id'];
			$_SESSION['id'] = $uid;
			
			//update cookie to last longer
			setcookie('user_hash',$_COOKIE['user_hash'],time() + (24*60*60 * 1),'/');
		}
	}
}*/



function remove_newlines($input) {
	return str_replace(array("\r","\n"),'',$input);
}

function chash($str) {
	$salt = ")G*H4gh(S*HFeOSDf";
	return hash('sha256', $str.$salt);
}


function is_clean($input) {
	return clean($input) == $input;
}


function clean($dirty_string) {
	global $db;
	return $db->real_escape_string($dirty_string);
}


/*
 * Check if user can access this reactor and return an object to it
 */
function get_reactor($id) {
	global $db;

	$q = $db->prepare("SELECT * FROM reactors WHERE user_id=? AND id=?");
	$q->bind_param("ii",$_SESSION['id'],$id);
	$q->execute();
	$q = $q->get_result();

	//check if reactor exists
	if($q->num_rows != 1) {
		return false;
	}

	return $q->fetch_assoc();

}


/*
 * This function takes a name and comes up with a color for it
 * It is used in the chart generation
 */
function name_to_color($name) {

	$hash = hash('md2',$name);
	$red = substr($hash,0,1).substr($hash,1,1);
	$green = substr($hash,2,1).substr($hash,3,1);
	$blue = substr($hash,4,1).substr($hash,5,1);

	$color = array();
	$color[] = hexdec($red)%180;
	$color[] = hexdec($green)%180;
	$color[] = hexdec($blue)%180;

	return $color;
}

function is_watching($ip) {
	global $db;
	$q = $db->prepare("SELECT id FROM watching WHERE user_id=? AND ip=?");
	$q->bind_param("is",$_SESSION['id'],$ip);
	$q->execute();
	$q = $q->get_result();
	if ($q->num_rows == 0) {
		return false;
	} else {
		return true;
	}
}


/*
 * This function deletes all data with a reactor
 * This function DOES NOT check any permissions
 */
function delete_reactor($r_id) {
	global $db;

	//delete reactor_data
	$q = $db->prepare("DELETE FROM reactor_data WHERE r_id=?");
	$q->bind_param("i",$r_id);
	$q->execute();
	if (!$q) { return false; }

	//delete
	$q = $db->prepare("DELETE FROM reactors WHERE id=?");
	$q->bind_param("i",$r_id);
	$q->execute();
	if (!$q) { return false; }

	return true;
}


/*
 * This function deletes all data with a user, including all their reactors
 * This function DOES NOT check any permissions
 */
function delete_user($user_id) {
	global $db;

	//delete all reactors for each user
	$q = $db->prepare("DELETE FROM FROM reactors WHERE user_id=?");
	$q->bind_param("i",$user_id);
	$q->execute();

	if (!$q) { return false; }

	//remove user
	$q = $db->prepare("DELETE FROM users WHERE id=?");
	$q->bind_param("i",$user_id);
	$q->execute();

	if (!$q) { return false; }

	return true;
}


/*
 * This function imports a single data point to a reactor
 *
 * This funtion DOES NOT check permission
 */

function import_reactor_data($r_id,$data) {
	global $db;

	$q = $db->prepare("INSERT INTO reactor_data (r_id,temp,heat_index,humidity,date) VALUES (?,?,?,?,?)");
	$q->bind_param("iiiis",$r_id,$data['temp'],$data['heat_index'],$data['humidity'],date("Y-m-d h:i:s",$data['timestamp']));
	$q->execute();

	if ($q) { return true; } else { return false; }
}



?>
