<?php
include('dbconnect.php');

$query = '';
$output = array();
$query .= "
	SELECT * FROM PD_Project p
INNER JOIN PD_Employee sme ON sme.SMEmID = p.ProjectLead
INNER JOIN PD_DB_Account sma ON sma.AcctID = p.EnterBy
WHERE ";

if($_POST["is_date_search"] == "yes")
{
 $query .= 'p.StartDate BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
	$query .= '(p.ProjectName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR p.Progress LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR p.ProjectStatus LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sme.SMEmName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sma.username LIKE "%'.$_POST["search"]["value"].'%" ) ';
}

if(isset($_POST['order']))
{
	$orderby = $_POST['order']['0']['column'] + 1;
	$query .= ' ORDER BY '.$orderby.' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY p.ProjectStatus, p.Progress DESC, p.StartDate DESC ';
}

if($_POST['length'] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

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
	$sub_array[] = '<a href="project_detail.php?project_id='.$row["ProjectID"].'">'.$row['ProjectName'].'</a>';
	$sub_array[] = $row['username'];
	$sub_array[] = $row['SMEmName'];
	$sub_array[] = $row['StartDate'];
	$sub_array[] = $row['Progress'];
	$sub_array[] = $status;
	$sub_array[] = '<a href="project_update.php?project_id='.$row["ProjectID"].'" class="btn btn-warning btn-xs update">Edit</a> <button type="button" name="delete" id="'.$row["ProjectID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["ProjectStatus"].'">Delete</button>';
	
	$data[] = $sub_array;
}

function get_total_all_records($dbconnect){
	$statement = $dbconnect->query('SELECT * FROM PD_Project');
	return mysqli_num_rows($statement);
}

$output = array(
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($dbconnect),
	"data"    			=> 	$data
);

echo json_encode($output);
?>