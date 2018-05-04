<?php
$self = basename($_SERVER['PHP_SELF']);
?>
<style>
.nav {
	border: none !important;
}
.nav .active a .glyphicon {
}
.nav .active a {
	border-width: 0 0 3px 0 !important;
	color: black !important;
	border-color: #7dd3f7 !important;
	background-color: transparent !important;
	border-radius: 0 !important;
	margin-top: -1;
}
.nav a {
	color: #555;
	border: none;
	margin-top: -1;
}
</style>


<nav class="navbar">

<ul style='display: table; margin: auto; float:none !important;' class="nav nav-tabs navbar-nav">
<li <?php if ($self == "dash.php") { echo "class=\"active\""; } ?>><a href="dash.php"><span class='glyphicon glyphicon-home'></span> Network</a></li>
</ul>



</nav>

