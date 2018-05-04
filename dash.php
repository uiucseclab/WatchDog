<?php include("ref/pre.php"); ?>


<style>

body {

/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#efefef+0,ffffff+80,adadad+100 */
background: #efefef; /* Old browsers */
background: -moz-linear-gradient(-45deg,  #efefef 0%, #ffffff 80%, #adadad 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(-45deg,  #efefef 0%,#ffffff 80%,#adadad 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(135deg,  #efefef 0%,#ffffff 80%,#adadad 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#efefef', endColorstr='#adadad',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */

}

</style>

<script src='js/dash.js'></script>


<div class='wrapper'>

	<div id='sidebar'>
		<div id='sidebar-header'>
			<div class='search'>
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
					<input id="search" type="text" class="form-control" placeholder="Search for a scan">
				</div>
			</div>
		</div>
		<div id='sidebar-networks'></div>

	</div> <!-- end of sidebar -->


	<div id='content'>


		<div class='row'>

			<div class='col-md-6'>
				<div class='content-box'>
					<div class='content-box-header'>
						Historical Stats<span class='pull-right'><button id='stats-btn' onclick='get_stats()' class='btn btn-primary'><span class='glyphicon glyphicon-refresh'></span></button></span>
					</div>
					<div class='content-box-content'>
						<div class='row'>
							<div class='col-6'>
								<p class='text-center'># Of Nodes per Scan</p>
								<canvas id="nodes-chart" width="1200" height="450"></canvas>
							</div>

							<div class='col-6'>
								<p class='text-center'># Of Open Ports per Scan</p>
								<canvas id="ports-chart" width="1200" height="450"></canvas>
							</div>
						</div>
					</div>
				</div>


			</div>

			<div class='col-md-6'>
				<div class='row'>
					<div class='content-box'>
						<div class='content-box-header'>
							Machines<span class='pull-right'><button id='nodes-btn' onclick='get_nodes()' class='btn btn-primary'><span class='glyphicon glyphicon-refresh'></span></button></span>
						</div>
						<div class='content-box-content'>

							<table id='nodes' class='table tablesorter table-condensed port-table'>

								<thead>
									<tr>
										<th width=2>#</th>
										<th>Last IP</th>
										<th>Watch</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class='row'>
					<div class='content-box'>
						<div class='content-box-header'>
							Ports<span class='pull-right'><button id='dist-btn' onclick='get_stats()' class='btn btn-primary'><span class='glyphicon glyphicon-refresh'></span></button></span>
						</div>
						<div class='content-box-content'>
							<canvas id="dist-chart" width="800" height="400"></canvas>
						</div>
					</div>
				</div>


			</div> 
		</div>



</div> <!-- end of container -->




<!-- modal for displaying a node -->

<div id='node-modal' class="modal fade">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title">Node Stats For <strong><span id='node-ip'></span></strong></h3>
      </div>
      <div class="modal-body">
		<h3 class='text-center'>Scan History</h3>
		<div>
			<canvas id="node-ports-chart" width="1200" height="450"></canvas>
		</div>
		<h3 class='text-center'>Historical Ports Open</h3>
		<div>
			<canvas id="node-dist-chart" width="800" height="400"></canvas>
		</div>
		<h3 class='text-center'>General Info</h3>
		<table class='table'>
		<tbody>
		</tbody>
		</table>
      </div>
    </div>
  </div>
</div>



