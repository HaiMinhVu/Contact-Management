<?php

//product_fetch.php

include('dbconnect.php');

$query = '';

$output = array();
$query .= "
	SELECT * FROM SampleRecord sr INNER JOIN Sample s ON s.SID = sr.SID
								INNER JOIN Entity e ON e.EID = sr.EID
                                INNER JOIN SMDBAccounts sma ON sma.AcctID = sr.SRRequestBy
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE e.EName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR s.SName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sr.Type LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sr.SRStatus LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sma.username LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sr.DateRequested LIKE "%'.$_POST["search"]["value"].'%" ';
}

$query .= "ORDER BY sr.SRID ";

if($_POST['length'] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $dbconnect->query($query);
$data = array();
$filtered_rows = mysqli_num_rows($statement);
while($row = $statement->fetch_assoc())
{
	$status = '';
	if($row['SRStatus'] == 'Active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else
	{
		$status = '<span class="label label-danger">InActive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['SRID'];
	$sub_array[] = '<a href="sample_detail.php?sid='.$row["SID"].'">'.$row['SName'].'</a>';
	$sub_array[] = $row['EName'];
	$sub_array[] = $row['username'];
	$sub_array[] = $row['DateRequested'];
	$sub_array[] = $row['Quantity'];
	$sub_array[] = $row['PriceperUnit'];
	$sub_array[] = $row['Type'];
	$sub_array[] = $status;
	//$sub_array[] = '<a href="sample_detail.php?sid='.$row["SID"].'" class="btn btn-info btn-xs">View</a>';
	$sub_array[] = '<a href="samplerecord_update.php?srid='.$row["SRID"].'" class="btn btn-warning btn-xs">Update</a>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["SRID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["SRStatus"].'">Delete</button>';

	$data[] = $sub_array;
}

function get_total_all_records($dbconnect)
{
	$statement = $dbconnect->query('SELECT * FROM SampleRecord');
	return mysqli_num_rows($statement);
}

$output = array(
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($dbconnect),
	"data"    			=> 	$data
);

echo json_encode($output);
?>