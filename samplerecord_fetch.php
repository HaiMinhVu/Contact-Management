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

/*if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY product_id DESC ';
}

if($_POST['length'] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}*/
$query .= "ORDER BY sr.SRID";
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
	$sub_array[] = $row['SName'];
	$sub_array[] = $row['EName'];
	$sub_array[] = $row['username'];
	$sub_array[] = $row['DateRequested'];
	$sub_array[] = $row['Quantity'];
	$sub_array[] = $row['PriceperUnit'];
	$sub_array[] = $row['Type'];
	$sub_array[] = $status;
	$sub_array[] = '<a href="samplerecord_detail.php?srid='.$row["SRID"].'" class="btn btn-info btn-xs">View</a>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["SRID"].'" class="btn btn-warning btn-xs update">Update</button>';
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