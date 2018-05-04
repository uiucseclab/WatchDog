<?php

require_once("functions.php");

//redirect to login if signed out
if (empty($_SESSION['id']) && basename($_SERVER['PHP_SELF'], '.php') != "index") {
	header("Location: index.php");
}

?>

<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=.9">

	<link href="https://fonts.googleapis.com/css?family=Roboto:500" rel="stylesheet">
	
<script src="js/Chart.min.js"></script>



<!-- aos -->
<link rel="stylesheet" href="css/aos.css">
<script src="js/aos.js"></script>



<!-- Auto loads fonts -->
<div class='fake'>
<i class='fa fa-square-o'></i>
<i class='glyphicon glyphicon-ok'></i>
</div>

<script src="js/jquery-ui/external/jquery/jquery.js"></script>
<script src="js/jquery-ui/jquery-ui.min.js"></script>
<script src="js/jquery.tablesorter.min.js"></script>
<link rel="stylesheet" href="js/jquery-ui/jquery-ui.min.css">
<script type="text/javascript" src="js/jquery.form.min.js"></script>

<script src="js/bootstrap.min.js"></script>
<link href="css/bootstrap.css" rel="stylesheet">

<link rel='stylesheet' href='css/font-awesome.min.css'>

<script>
$(function() {
	$("[data-toggle='tooltip']").tooltip();
	$(".tablesorter").tablesorter();
	AOS.init();
});
</script>

<!-- custom resources -->
<link rel="stylesheet" href="css/wd.css">
<link rel="stylesheet" href="css/custom.css">
<script src="js/custom.js"></script>
<script src="js/wd.js"></script>


<title>Watch Dog</title>
</head>

