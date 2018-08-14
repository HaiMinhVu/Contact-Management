<?php

//product_fetch.php

include('dbconnect.php');

$query = '';

$output = array();
$query .= "
	SELECT SRID, SName, EName, username, DateRequested, Quantity, Used, Available, Type, SRStatus FROM PD_SampleRecord sr 
								INNER JOIN PD_Sample s ON s.SID = sr.SID
								INNER JOIN PD_Entity e ON e.EID = sr.EID
                                INNER JOIN PD_DB_Account sma ON sma.AcctID = sr.SRRequestBy
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE e.EName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR s.SName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sr.Type LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sma.username LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sr.DateRequested LIKE "%'.$_POST["search"]["value"].'%" ';
}

<<<<<<< HEAD
if(isset($_POST['order']))
{
	$orderby = $_POST['order']['0']['column'] + 1;
	$query .= ' ORDER BY '.$orderby.' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= "ORDER BY SRStatus, SName, SRID ";
}

=======
$query .= "ORDER BY s.SName ";
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23

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
	$sub_array[] = '<a href="samplerecord_detail.php?srid='.$row["SRID"].'">'.$row['SName'].'</a>';
	$sub_array[] = $row['EName'];
	$sub_array[] = $row['username'];
	$sub_array[] = $row['DateRequested'];
	$sub_array[] = $row['Quantity'];
	$sub_array[] = $row['Used'];
	$sub_array[] = $row['Available'];
	$sub_array[] = $row['Type'];
	$sub_array[] = $status;
<<<<<<< HEAD
	$sub_array[] = '<a href="samplerecord_update.php?srid='.$row["SRID"].'" class="btn btn-warning btn-xs">Edit</a> <button type="button" name="delete" id="'.$row["SRID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["SRStatus"].'">Delete</button>';
	$sub_array[] = '';
=======
	$sub_array[] = '<a href="samplerecord_update.php?srid='.$row["SRID"].'" class="btn btn-warning btn-xs">Update</a>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["SRID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["SRStatus"].'">Delete</button>';
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23

	$data[] = $sub_array;
}

function get_total_all_records($dbconnect)
{
	$statement = $dbconnect->query('SELECT * FROM PD_SampleRecord');
	return mysqli_num_rows($statement);
}

$output = array(
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($dbconnect),
	"data"    			=> 	$data
);

echo json_encode($output);
?>