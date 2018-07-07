<?php
include('dbconnect.php');

$query = '';
$output = array();
$query .= "
	SELECT * FROM Project p
INNER JOIN SMBrands smb ON smb.BrandID = p.BrandBelongTo
INNER JOIN SMDepartments smd ON smd.SMDeptID = p.DeptBelongTo 
INNER JOIN SMEmployees sme ON sme.SMEmID = p.ProjectLead
INNER JOIN SMDBAccounts sma ON sma.AcctID = p.EnterBy
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE smb.BrandName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR smd.SMDeptName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR p.ProjectName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR p.Progress LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR p.ProjectStatus LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR p.StartDate LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR p.DateCreated LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sme.SMEmName LIKE "%'.$_POST["search"]["value"].'%" ';
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
$query .= "ORDER BY p.ProjectID DESC";
$statement = $dbconnect->query($query);
$data = array();
$filtered_rows = mysqli_num_rows($statement);
while($row = $statement->fetch_assoc()){
	$status = '';
	if($row['ProjectStatus'] == 'Active'){
		$status = '<span class="label label-success">Active</span>';
	}
	else{
		$status = '<span class="label label-danger">InActive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['ProjectID'];
	$sub_array[] = $row['ProjectName'];
	$sub_array[] = $row['username'];
	$sub_array[] = $row['SMEmName'];
	$sub_array[] = $row['DateCreated'];
	$sub_array[] = $row['Progress'];
	$sub_array[] = $status;
	$sub_array[] = '<a href="project_detail.php?project_id='.$row["ProjectID"].'" class="btn btn-info btn-xs">View</a>';
	$sub_array[] = '<a href="project_update.php?project_id='.$row["ProjectID"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["ProjectID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["ProjectStatus"].'">Delete</button>';
	$data[] = $sub_array;
}

function get_total_all_records($dbconnect){
	$statement = $dbconnect->query('SELECT * FROM Project');
	return mysqli_num_rows($statement);
}

$output = array(
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($dbconnect),
	"data"    			=> 	$data
);

echo json_encode($output);
?>