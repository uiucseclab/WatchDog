<?php include("ref/pre.php"); ?>

<?php
//check if already logged in
if (!empty($_SESSION['id'])) { header("Location: dash.php"); }
?>


<style>
.login {
	margin-top: 6%;
	width: 400px;
}

.c1 {
	background-size: 100%;
	background-repeat: no-repeat;
	height: 100%;

/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#efefef+0,ffffff+80,adadad+100 */
background: #efefef; /* Old browsers */
background: -moz-linear-gradient(-45deg,  #efefef 0%, #ffffff 80%, #adadad 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(-45deg,  #efefef 0%,#ffffff 80%,#adadad 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(135deg,  #efefef 0%,#ffffff 80%,#adadad 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#efefef', endColorstr='#adadad',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */

}

.form-control .btn {
	background-color: rgba(0,0,0,0);
}


</style>


<script>
function login() {
	btn_loading("loginbtn"," Loading...");
	$.post("ref/login.php",{email:$("#email").val(),password:$("#password").val()},function(data) {
		data = JSON.parse(data);
		if (data['success'] == 1) {
			$("#info").slideUp();
			$("#login-form").slideUp(function() {
			});
			setTimeout(function() {window.location = 'dash.php';},1000);
		} else {
			btn_reg("loginbtn");
			notify_custom("info","alert-info",data['message']);
		}
	});
}
</script>


<div data-aos='fade' data-aos-duration='1000' class='c1 container-fluid text-center'>
<div class="container text-center login">
<img class='img-responsive text-center' data-aos='fade-up' data-aos-duration='800' src='img/logo.png'></img>
<br/>
<br/>

<form id='login-form' data-aos='fade-up' data-aos-duration='800' data-aos-delay='200' action="javascript: login()">

<input id="email" class="form-control" placeholder="Email" required autofocus>
<br/>
<input type="password" id="password" class="form-control" placeholder="Password" required autofocus>

<br/>
<button id="loginbtn" class="btn btn-primary form-control" type="submit">Log In</button>


</form>

<br/>
<div id='info'></div>

</div>

</div>


