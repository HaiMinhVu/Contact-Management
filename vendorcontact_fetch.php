<?php

include('dbconnect.php');

$query = '';

$output = array();
$query .= "
	SELECT * FROM Entity_Contact ec 
    INNER JOIN Entity_RelateTo_Contact erc ON erc.ECID = ec.ECID
	INNER JOIN Entity e ON e.EID = erc.EID
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE e.EName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR erc.ERCTitle LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ec.ECName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ec.ECEmail LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ec.ECPhone LIKE "%'.$_POST["search"]["value"].'%" ';
}

$query .= "ORDER BY e.EName, ec.ECName ";

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
	if($row['ERCStatus'] == 'Active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else
	{
		$status = '<span class="label label-danger">InActive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['ECID'];
	$sub_array[] = '<a href="vender_detail.php?eid='.$row["EID"].'">'.$row['EName'].'</a>';
	$sub_array[] = $row['ECName'];
	$sub_array[] = $row['ERCTitle'];
	$sub_array[] = $row['ECEmail'];
	$sub_array[] = $row['ECPhone'];
	$sub_array[] = $status;
	//$sub_array[] = '<a href="vender_detail.php?eid='.$row["EID"].'" class="btn btn-info btn-xs">View</a>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["ECID"].'.'.$row["EID"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["ECID"].'.'.$row["EID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["ERCStatus"].'">Delete</button>';
	$data[] = $sub_array;
}

function get_total_all_records($dbconnect)
{
	$statement = $dbconnect->query('SELECT * FROM Entity_RelateTo_Contact');
	return mysqli_num_rows($statement);
}

$output = array(
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($dbconnect),
	"data"    			=> 	$data
);

echo json_encode($output);
?>