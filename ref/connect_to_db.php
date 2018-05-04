<?php

	$db = new mysqli("127.0.0.1","watchdog","watchdogpass","watchdog");
	if($db->connect_errno > 0) {
		die("Could not connect to database");
	}

?>
