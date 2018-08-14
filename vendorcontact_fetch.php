<?php

include('dbconnect.php');

$query = '';

$output = array();
$query .= "
	SELECT ECID, EName, ECName, ERCTitle, Priority, ECEmail, ECPhone, ERCStatus, e.EID FROM PD_Entity_Contact_Person ec 
    INNER JOIN PD_Entity_RelateTo_Contact erc ON erc.ECID = ec.ECPID
	INNER JOIN PD_Entity e ON e.EID = erc.EID
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE e.EName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR erc.ERCTitle LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR erc.Priority LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ec.ECName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ec.ECEmail LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ec.ECPhone LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	$orderby = $_POST['order']['0']['column'] + 1;
	$query .= ' ORDER BY '.$orderby.' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= "ORDER BY ERCStatus, e.EName, ec.ECName ";
}


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
	$sub_array[] = '<a href="vendor_detail.php?eid='.$row["EID"].'">'.$row['EName'].'</a>';
	$sub_array[] = $row['ECName'];
	$sub_array[] = $row['ERCTitle'];
	$sub_array[] = $row['Priority'];
	$sub_array[] = $row['ECEmail'];
	$sub_array[] = $row['ECPhone'];
	$sub_array[] = $status;
	$sub_array[] = '<a href="vendorcontact_update.php?ecid='.$row["ECID"].'&eid='.$row['EID'].'" class="btn btn-warning btn-xs">Edit</a> 
    			<button type="button" name="delete" id="'.$row["ECID"].'.'.$row["EID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["ERCStatus"].'">Delete</button>';

	$data[] = $sub_array;
}

function get_total_all_records($dbconnect)
{
	$statement = $dbconnect->query('SELECT * FROM PD_Entity_RelateTo_Contact');
	return mysqli_num_rows($statement);
}

$output = array(
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($dbconnect),
	"data"    			=> 	$data
);

echo json_encode($output);
?>