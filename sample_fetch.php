<?php

//product_fetch.php

include('dbconnect.php');

$query = '';

$output = array();
$query .= "
	SELECT * FROM PD_Sample s INNER JOIN PD_DB_Account sma ON sma.AcctID = s.SEnterBy
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE SName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR username LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR SDescription LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR SStatus LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	$orderby = $_POST['order']['0']['column'] + 1;
	$query .= ' ORDER BY '.$orderby.' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= "ORDER BY SStatus, SID ";
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
	$sub_array[] = '<a href="sample_detail.php?sid='.$row["SID"].'">'.$row['SName'].'</a>';
	$sub_array[] = $row['SDescription'];
	$sub_array[] = '<a href="sample_image.php?id='.$row['SID'].'" target="_blank"><img src="images/sample/'. $row['SImages'].'" height="30" width="30"></a>';
	$sub_array[] = $row['username'];
	$sub_array[] = $status;
	$sub_array[] = '<a href="sample_update.php?sid='.$row["SID"].'" class="btn btn-warning btn-xs">Edit</a> 
    				<button type="button" name="delete" id="'.$row["SID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["SStatus"].'">Delete</button>';
	$data[] = $sub_array;
}

function get_total_all_records($dbconnect)
{
	$statement = $dbconnect->query('SELECT * FROM PD_Sample');
	return mysqli_num_rows($statement);
}

$output = array(
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($dbconnect),
	"data"    			=> 	$data
);

echo json_encode($output);
?>