<?php
include('dbconnect.php');

$query = '';

$output = array();
$query .= "
	SELECT * FROM Entity_Contact_Person ecp INNER JOIN SMDBAccounts sma ON sma.AcctID = ecp.ECEnterBy
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE ecp.ECName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ecp.ECEmail LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ecp.ECPhone LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ecp.ECFax LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ecp.ECStatus LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ecp.ECWebsite LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sma.username LIKE "%'.$_POST["search"]["value"].'%" ';
}

$query .= "ORDER BY ECStatus, ECPID ";

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
	if($row['ECStatus'] == 'Active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else
	{
		$status = '<span class="label label-danger">InActive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['ECPID'];
	$sub_array[] = $row['ECName'];
	$sub_array[] = $row['ECEmail'];
	$sub_array[] = $row['ECPhone'];
	$sub_array[] = $row['ECFax'];
	$sub_array[] = $row['ECWebsite'];
	$sub_array[] = $status;
	//$sub_array[] = '<a href="contact_detail.php?ecid='.$row["ECID"].'" class="btn btn-info btn-xs">View</a>';
	$sub_array[] = '<a href="contact_update.php?ecid='.$row["ECPID"].'" class="btn btn-warning btn-xs">Edit</a>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["ECPID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["ECStatus"].'">Delete</button>';

	$data[] = $sub_array;
}

function get_total_all_records($dbconnect)
{
	$statement = $dbconnect->query('SELECT * FROM Entity_Contact_Person');
	return mysqli_num_rows($statement);
}

$output = array(
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($dbconnect),
	"data"    			=> 	$data
);

echo json_encode($output);
?>