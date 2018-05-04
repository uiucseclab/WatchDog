function notify_custom(element, type, content) {
	$("#"+element).slideUp();
	$("#"+element).html("<div class='alert "+type+"'>"+content+"</div>");
	$("#"+element).slideDown();
}

var btn_html = [];

/*
 * Sets button back to what it originally had before it was told to be in a loaing state
 */
function btn_reg(element) {
	$("#"+element).html(btn_html[element]);
	$("#"+element).prop('disabled',false);
}

/*
 * Sets a button in a loading state
 */
function btn_loading(element,message) {
	btn_html[element] = $("#"+element).html();
	$("#"+element).html("<span class='glyphicon glyphicon-refresh spinner'></span>"+message);
	$("#"+element).prop('disabled',true);
}

/*
 * Sets an element to have a loading symbol
 */
function element_loading(element,message) {
	$("#"+element).html("<span class='glyphicon glyphicon-refresh spinner'></span>"+message);
}
function element_reg(element) {
	$("#"+element).html("");
}


function checkmark(id) {
	$("#"+id).html("");
	$("#"+id).show();
	$("#"+id).html("<span class='checkmark glyphicon glyphicon-ok'></span>");
	setTimeout(function() {
	$("#"+id).fadeOut();
	},4000);
}


function back(id) {
	btn_loading(id," Back");
	window.location = 'dash.php';
}



function toggle_view(id) {
	if ($("#"+id).is(":visible")) {
		$("#"+id).slideUp();
		$("#"+id+"-toggle-btn .glyphicon").css({ "transform": "rotate(-90deg)", "-webkit-transform": "rotate(0deg)", "-moz-transform": "rotate(-90deg)" });
	} else {
		$("#"+id).slideDown();
		$("#"+id+"-toggle-btn .glyphicon").css({ "transform": "rotate(0deg)", "-webkit-transform": "rotate(90deg)", "-moz-transform": "rotate(0deg)" });
	}
}
