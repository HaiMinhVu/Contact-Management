<?php

//product_fetch.php

include('dbconnect.php');

$query = '';

$output = array();
$query .= "
	SELECT * FROM PD_SampleReview sre INNER JOIN PD_SampleRecord sr ON sre.SRID = sr.SRID
								INNER JOIN PD_Sample s ON s.SID = sr.SID
                                INNER JOIN PD_Entity e ON e.EID = sr.EID
                                INNER JOIN PD_DB_Account sma ON sma.AcctID = sre.ReviewBy 
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE e.EName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR s.SName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sre.ReviewBy LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sre.SReComments LIKE "%'.$_POST["search"]["value"].'%" ';
}

$query .= "ORDER BY s.SName, e.EName ";

if($_POST['length'] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $dbconnect->query($query);
$data = array();
$filtered_rows = mysqli_num_rows($statement);
while($row = $statement->fetch_assoc())
{
	$sub_array = array();
	$sub_array[] = $row['SReID'];
	$sub_array[] = '<a href="sample_detail.php?sid='.$row["SID"].'">'.$row['SName'].'</a>';
	$sub_array[] = $row['EName'];
	$sub_array[] = '<button type="button" name="reviewimage" id="'.$row["SReID"].'" class="btn btn-info btn-xs reviewimage" >'. $row['SReImages'].'</button>';
	$sub_array[] = $row['SReComments'];
	$sub_array[] = $row['username'];
	$sub_array[] = '<a href="samplereview_update.php?sreid='.$row["SReID"].'" class="btn btn-warning btn-xs">Update</a>';

	$data[] = $sub_array;
}

function get_total_all_records($dbconnect)
{
	$statement = $dbconnect->query('SELECT * FROM PD_SampleReview');
	return mysqli_num_rows($statement);
}

$output = array(
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($dbconnect),
	"data"    			=> 	$data
);

echo json_encode($output);
?>