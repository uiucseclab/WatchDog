<?php

/*
 * Sign out user
 */

require_once("functions.php");

unset($_SESSION['id']);

echo json_encode(array("success"=>1));

?>
