
var scan_id = -1;

$(function() {
	get_scans();
	load_scan(-1);
	$(".tablesorter").tablesorter();
	$("#search").on("keyup",function() {
		scan_search($("#search").val());
	});
});


/*
 * This function loads a scan
 * A scan_id of -1 will result in the latest scan
 */
function load_scan(id) {
	scan_id = id;
	get_nodes();
	get_stats();
}



var scans = [];
function scan_search(search) {
	console.log(search);
	$("#sidebar-networks").html("");
	$.each(scans,function(i,scan) {
		if (scan['date'].includes(search)) {
			var append = "<div onclick='load_scan("+scan['id']+")' class='scan'>";
			append += scan['date'];
			append += "</div>";
			$("#sidebar-networks").append(append);
		}
	});
}


/*
 * This function marks an ip to be watched or not, reading the value of the glyphicon to determine it's current status
 */
function watch(id,ip) {
	var watch = 1;
	if ($("#watch-"+id).find("span").hasClass("glyphicon-eye-open")) {
		watch = 0;
	}
	$.post("ref/watch.php",{ip:ip,watch:watch},function(data) {
		$("#watch-"+id).find("span").toggleClass("glyphicon-eye-open");
		$("#watch-"+id).find("span").toggleClass("glyphicon-eye-close");
	});
}


/*
 * Populates the sidebar with scans
 */
function get_scans() {
	$.getJSON("ref/scans.php",function(data) {
		$.each(data,function(i,scan) {
			scans.push(scan);
			scan_search("");
		});
	});
}



/*
 * This function opens a modal and loads the data into it for the specified node id
 */
var node_ports_chart = null;
var node_dist_chart = null;
function node_details(node_ip) {
	$("#node-modal").modal();
	$("#node-ip").html(node_ip);
	$("#node-modal .table tbody").html("");
	$.post("ref/nodes_stats.php",{scan_id:scan_id,node_ip:node_ip},function(data) {
		data = JSON.parse(data);

		//Ports
		$("#node-ports-chart").html("");
		if (node_ports_chart != null) { node_ports_chart.destroy(); }
		node_ports_chart = new Chart(document.getElementById("node-ports-chart"),{
			type:'line',
			data: data['ports_chart']
		});


		//Port Distribution
		$("#node-dist-chart").html("");
		if (node_dist_chart != null) { node_dist_chart.destroy(); }
		node_dist_chart = new Chart(document.getElementById("node-dist-chart"),{
			type:'pie',
			data: data['dist_chart']
		});

		//Info
		var table_append;
		table_append += "<tr><td>ip</td><td>";
		table_append += node_ip;
		table_append += "</td></tr>";
		$.each(data['info'],function(i,info) {
			table_append += "<tr><td>"+info['title']+"</td><td>";
			table_append += info['val'];
			table_append += "</td></tr>";
		});
		$("#node-modal .table tbody").append(table_append);
	});
}



/*
This function requests the nodes list from the server
 */
var nodes = [];
function get_nodes() {
	$("#nodes tbody").html("<tr><td></td><td>Loading...</td></tr>");
	btn_loading("nodes-btn","");
	$.post("ref/nodes.php",{scan_id:scan_id},function(data) {
		data = JSON.parse(data);
		btn_reg("nodes-btn");
		$("#nodes tbody").html("");
		var selector_array = [];
		nodes = data;
		$.each(data, function(i,node) {

			//add to table
			var append = "";
			append += "<tr class='node' onclick='node_details(\""+node['ip']+"\")'>";
			append += "<td>"+i+"</td>";
			append += "<td>"+node['ip']+"</td>";
			append += "<td><button data-toggle='tooltip' title='Watch this ip for changes in ports open' id='watch-"+node['id']+"' node-id='"+node['id']+"' node-ip='"+node['ip']+"' class='watch-btn btn btn-sm btn-primary'>";
			if (node['watch'] == 1) {
				append += "<span class='glyphicon glyphicon-eye-open'></span>";
			} else {
				append += "<span class='glyphicon glyphicon-eye-close'></span>";
			}
			append += "</button></td>";
			append += "</tr>";
			$("#nodes tbody").append(append);


		});
		$(".watch-btn").on("click",function(e) {
			e.stopPropagation();
			watch($(this).attr("node-id"),$(this).attr("node-ip"));
		});
		$('[data-toggle="tooltip"]').tooltip();
		$(".tablesorter").trigger("update"); //let tablesorter know we made an update
	});
}



var nodes_chart = null;
var ports_chart = null;
var dist_chart = null;
function get_stats() {
	btn_loading("stats-btn","");
	btn_loading("dist-btn","");
	$.post("ref/nodes_stats.php",{scan_id:scan_id},function(data) {
		data = JSON.parse(data);

		btn_reg("stats-btn");
		btn_reg("dist-btn");

		//Nodes
		$("#nodes-chart").html("");
		if (nodes_chart != null) { nodes_chart.destroy(); }
		nodes_chart = new Chart(document.getElementById("nodes-chart"),{
			type:'line',
			data: data['nodes_chart']
		});


		//Ports
		$("#ports-chart").html("");
		if (ports_chart != null) { ports_chart.destroy(); }
		ports_chart = new Chart(document.getElementById("ports-chart"),{
			type:'line',
			data: data['ports_chart']
		});


		//Port Distribution
		$("#dist-chart").html("");
		if (dist_chart != null) { dist_chart.destroy(); }
		dist_chart = new Chart(document.getElementById("dist-chart"),{
			type:'pie',
			data: data['dist_chart']
		});

	});
}

