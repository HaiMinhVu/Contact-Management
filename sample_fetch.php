<?php

//product_fetch.php

include('dbconnect.php');

$query = '';

$output = array();
$query .= "
	SELECT * FROM Sample s INNER JOIN SMDBAccounts sma ON sma.AcctID = s.SEnterBy
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE SName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR SEnterBy LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR SDescription LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR SStatus LIKE "%'.$_POST["search"]["value"].'%" ';
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
$query .= "ORDER BY SID";
$statement = $dbconnect->query($query);
$data = array();
$filtered_rows = mysqli_num_rows($statement);
while($row = $statement->fetch_assoc())
{
	$status = '';
	if($row['SStatus'] == 'Active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else
	{
		$status = '<span class="label label-danger">InActive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['SID'];
	$sub_array[] = $row['SName'];
	$sub_array[] = $row['SDescription'];
	$sub_array[] = $row['SImages'];
	$sub_array[] = $row['username'];
	$sub_array[] = $status;
	$sub_array[] = '<a href="sample_detail.php?sid='.$row["SID"].'" class="btn btn-info btn-xs">View</a>';
	//$sub_array[] = '<button type="button" name="view" id="'.$row["SID"].'" class="btn btn-info btn-xs view">View</button>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["SID"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["SID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["SStatus"].'">Delete</button>';
	
	

	$data[] = $sub_array;
}

function get_total_all_records($dbconnect)
{
	$statement = $dbconnect->query('SELECT * FROM Sample');
	return mysqli_num_rows($statement);
}

$output = array(
	"draw"    			=> 	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($dbconnect),
	"data"    			=> 	$data
);

echo json_encode($output);
?>