<?php
include('dbconnect.php');

$query = '';

$output = array();
$query .= "
	SELECT * FROM Entity_Contact ec INNER JOIN SMDBAccounts sma ON sma.AcctID = ec.ECModifyBy
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE ec.ECName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ec.ECEmail LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ec.ECPhone LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ec.ECFax LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ec.ECStatus LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ec.ECWebsite LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sma.username LIKE "%'.$_POST["search"]["value"].'%" ';
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
$query .= "ORDER BY ECID";
$statement = $dbconnect->query($query);
$data = array();
$filtered_rows = mysqli_num_rows($statement);
while($row = $statement->fetch_assoc())
{
	$status = '';
	if($row['ECStatus'] == 'Active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else
	{
		$status = '<span class="label label-danger">InActive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['ECID'];
	$sub_array[] = $row['ECName'];
	$sub_array[] = $row['ECEmail'];
	$sub_array[] = $row['ECPhone'];
	$sub_array[] = $row['ECFax'];
	$sub_array[] = $row['ECWebsite'];
	$sub_array[] = $status;
	$sub_array[] = '<a href="vender_detail.php?eid='.$row["ECID"].'" class="btn btn-info btn-xs">View</a>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["ECID"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["ECID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["ECStatus"].'">Delete</button>';

	$data[] = $sub_array;
}

function get_total_all_records($dbconnect)
{
	$statement = $dbconnect->query('SELECT * FROM Entity_Contact');
	return mysqli_num_rows($statement);
}

$output = array(
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($dbconnect),
	"data"    			=> 	$data
);

echo json_encode($output);
?>