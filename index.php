<?php
include('dbconnect.php');
include('functions.php');
include('header.php');

?>
	<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading"><a href="project.php"><strong>Projects</strong></a></div>
			<div class="panel-body" align="center">
				<h1>Active: <?php echo count_total_project_active($dbconnect); ?></h1>
                <h1>InActive: <?php echo count_total_project_inactive($dbconnect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading"><a href="vendor.php"><strong>Vendors</strong></a></div>
			<div class="panel-body" align="center">
				<h1>Active: <?php echo count_total_entity_active($dbconnect); ?></h1>
                <h1>InActive: <?php echo count_total_entity_inactive($dbconnect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading"><a href="sample.php"><strong>Samples</strong></a></div>
			<div class="panel-body" align="center">
				<h1>Active: <?php echo count_total_sample_active($dbconnect); ?></h1>
                <h1>InActive: <?php echo count_total_sample_inactive($dbconnect); ?></h1>
			</div>
		</div>
	</div>
	</div>
<?php
include('footer.php');    
?>