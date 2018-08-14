<?php
include('dbconnect.php');

$query = '';

$output = array();
$query .= '
<<<<<<< HEAD
	SELECT EID, EName, Supplier, ProductManufactured, EStatus FROM PD_Entity e
    INNER JOIN PD_DB_Account sma ON sma.AcctID = e.EEnterBy 
=======
	SELECT * FROM Entity e
    INNER JOIN SMDBAccounts sma ON sma.AcctID = e.EEnterBy 
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
';

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE EName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR Owner LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR Supplier LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ProductManufactured LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR EStatus LIKE "%'.$_POST["search"]["value"].'%" ';
}

<<<<<<< HEAD
if(isset($_POST['order']))
{
	$orderby = $_POST['order']['0']['column'];
	if($orderby == 0 || $orderby == 1){
    	$orderby++;
    }
	elseif($orderby == 4 || $orderby == 5){
    	$orderby = $orderby -1;
    }
	$query .= ' ORDER BY '.$orderby.' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY EStatus, EID DESC ';
}
=======
$query .= "ORDER BY EStatus, EID ";
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
	$email;  $phone;
	$eid = $row['EID'];
<<<<<<< HEAD
	$tmpsql = 'SELECT * FROM PD_Entity_Attribute WHERE EID = '.$eid.' AND EASubCategory = "Primary"';
=======
	$tmpsql = 'SELECT * FROM Entity_Attribute WHERE EID = '.$eid.' AND EASubCategory = "Primary"';
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
	$tmpresult = $dbconnect->query($tmpsql);
	while($tmprow = $tmpresult->fetch_assoc()){
		if($tmprow['EACategory'] == "email"){
			$email = $tmprow['EAString'];
    	}
		if($tmprow['EACategory'] == "phone"){
    		$phone = $tmprow['EAString'];
    	}
	}
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
	$sub_array[] = '<a href="vendor_detail.php?eid='.$row["EID"].'">'.$row['EName'].'</a>';
	$sub_array[] = $email;
	$sub_array[] = $phone;
	$sub_array[] = $row['Supplier'];
	$sub_array[] = $row['ProductManufactured'];
	$sub_array[] = $status;
<<<<<<< HEAD
	$sub_array[] = '<a href="vendor_update.php?eid='.$row["EID"].'" class="btn btn-warning btn-xs">Edit</a> <button type="button" name="delete" id="'.$row["EID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["EStatus"].'">Delete</button>';
=======
	$sub_array[] = '<a href="vendor_update.php?eid='.$row["EID"].'" class="btn btn-warning btn-xs">Edit</a>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["EID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["EStatus"].'">Delete</button>';

>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
	$data[] = $sub_array;
}

function get_total_all_records($dbconnect)
{
	$statement = $dbconnect->query('SELECT * FROM PD_Entity');
	return mysqli_num_rows($statement);
}

$output = array(
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($dbconnect),
	"data"    			=> 	$data
);

echo json_encode($output);
?>