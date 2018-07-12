<?php
include('dbconnect.php');
include('functions.php');
include('header.php');

?>
<br />
	<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Project</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_project($dbconnect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Entity</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_entity($dbconnect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Sample</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_sample($dbconnect); ?></h1>
			</div>
		</div>
	</div>
	</div>
    
	<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Brand</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_brand($dbconnect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Employee</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_employee($dbconnect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Product</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_product($dbconnect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Department</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_department($dbconnect); ?></h1>
			</div>
		</div>
	</div>
	</div>
<?php
include('footer.php');    
?>