<?php
include('dbconnect.php');

$query = '';

$output = array();
$query .= "
	SELECT * FROM Entity e
    INNER JOIN SMDBAccounts sma ON sma.AcctID = e.EEnterBy
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE EName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR Owner LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR Supplier LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ProductManufactured LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR EStatus LIKE "%'.$_POST["search"]["value"].'%" ';
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
$query .= "ORDER BY EID DESC";
$statement = $dbconnect->query($query);
$data = array();
$filtered_rows = mysqli_num_rows($statement);
while($row = $statement->fetch_assoc())
{
	$status = '';
	if($row['EStatus'] == 'Active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else
	{
		$status = '<span class="label label-danger">InActive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['EID'];
	$sub_array[] = $row['EName'];
	$sub_array[] = $row['ERegisteredName'];
	$sub_array[] = $row['Owner'];
	$sub_array[] = $row['Supplier'];
	$sub_array[] = $row['ProductManufactured'];
	$sub_array[] = $status;
	$sub_array[] = '<a href="vender_detail.php?eid='.$row["EID"].'" class="btn btn-info btn-xs">View</a>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["EID"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["EID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["EStatus"].'">Delete</button>';

	$data[] = $sub_array;
}

function get_total_all_records($dbconnect)
{
	$statement = $dbconnect->query('SELECT * FROM Entity');
	return mysqli_num_rows($statement);
}

$output = array(
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($dbconnect),
	"data"    			=> 	$data
);

echo json_encode($output);
?>