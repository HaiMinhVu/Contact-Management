<?php
require('fpdf181/fpdf.php');
include('dbconnect.php');

if(isset($_GET['eid'])){
	$pdf = new FPDF('P', 'mm', 'A4');
	$pdf->AddPage();

	$eid = $_GET['eid'];
	
	$entitysql = "SELECT * FROM Entity e INNER JOIN SMDBAccounts sma ON sma.AcctID = e.EEnterBy WHERE e.EID = $eid";
	$entityfetch = $dbconnect->query($entitysql);
	
	$pdf->SetFont('Times','B', 14);
    $pdf->SetTextColor(0,0,255);
	
	while($row = $entityfetch->fetch_array()){
    	$pdf->Cell(189	,10, 'Vender '.$row['EName'], 1, 1, 'C');
    
    	$pdf->SetFont('Times', '', 11);
    	$pdf->SetTextColor(0,0,0);
    
    	$pdf->Cell(30	,5, "Register As", 'L', 0);
		$pdf->Cell(65	,5, $row['ERegisteredName'], 0, 0);
		$pdf->Cell(30	,5, "Status", 0, 0 );
		$pdf->Cell(64	,5, $row['EStatus'], 'R', 1);
    
    	$pdf->Cell(30	,5, "Owner", 'L', 0);
		$pdf->Cell(65	,5, $row['Owner'], 0, 0);
		$pdf->Cell(30	,5, "Supplier", 0, 0);
		$pdf->Cell(64	,5, $row['Supplier'], 'R', 1);
    
    	$pdf->Cell(30	,5, "Enter By", 'L', 0);
		$pdf->Cell(65	,5, $row['username'], 0, 0);
		$pdf->Cell(30	,5, "Manufactured", 0, 0);
		$pdf->Cell(64	,5, $row['ProductManufactured'], 'R', 1);
    
    	$pdf->Cell(30	,5, "Last Modify", 'L', 0);
		$pdf->Cell(65	,5, $row['EModifyDate'], 0, 0);
		$pdf->Cell(30	,5, "OEM Customer", 0, 0);
		$pdf->Cell(64	,5, $row['OEMCustomer'], 'R', 1);
    
    	$modifybyid = $row['EModifyBy'];
    	$modifybyresult = $dbconnect->query("SELECT username FROM SMDBAccounts WHERE AcctID = $modifybyid");
    	while($modifyrow = $modifybyresult->fetch_assoc()){
    	$pdf->Cell(30	,5, "Modify By", 'L', 0);
		$pdf->Cell(65	,5, $modifyrow['username'], '', 0);
        }
		$pdf->Cell(30	,5, "# of Worker", '', 0);
		$pdf->Cell(64	,5, $row['NumberofWorker'], 'R', 1);
        
        $pdf->Cell(95	,5, "", 'LB', 0);
		$pdf->Cell(30	,5, "Annual Sale", 'B', 0);
		$pdf->Cell(64	,5, $row['AnnualSales'], 'BR', 1);
        
        $pdf->Ln();
    
    }
	
	$pdf->Ln();
	$contactsql = "SELECT * FROM Entity_Contact ec INNER JOIN Entity_RelateTo_Contact erc ON erc.ECID = ec.ECID
								INNER JOIN Entity e ON e.EID = erc.EID
                                WHERE e.EID = $eid";
    $contactfetch = $dbconnect->query($contactsql);
	$countcontact = mysqli_num_rows($contactfetch);
	$pdf->SetFont('Times','B', 14);
	$pdf->SetTextColor(0,0,255);
	$pdf->Cell(189	,10, "There are ".$countcontact." Contact Related", 1, 1, 'C');
	$pdf->SetFont('Times','', 11);	// reset font
	$pdf->SetTextColor(0,0,0);

    while($row = $contactfetch->fetch_array()){
        $pdf->Cell(30	,5, "Status", 'L', 0);
       	$pdf->SetTextColor(255,0,0);
		$pdf->Cell(65	,5, $row['ERCStatus'], '', 0);
       	$pdf->SetTextColor(0,0,0);
    	$pdf->Cell(30	,5, "Priority", '', 0);
       	$pdf->SetTextColor(255,0,0);
		$pdf->Cell(64	,5, $row['Priority'], 'R', 1);
       	$pdf->SetTextColor(0,0,0);
        
       	$pdf->Cell(30	,5, "Name", 'L', 0);
		$pdf->Cell(65	,5, $row['ECName'], '', 0);
    	$pdf->Cell(30	,5, "Address 1", '', 0);
		$pdf->Cell(64	,5, $row['ECAddress1'], 'R', 1);
    
    	$pdf->Cell(30	,5, "Title", 'L', 0);
		$pdf->Cell(65	,5, $row['ERCTitle'], '', 0);
    	$pdf->Cell(30	,5, "Address 2", '', 0);
		$pdf->Cell(64	,5, $row['ECAddress2'], 'R', 1);
    	
    	$pdf->Cell(30	,5, "Email", 'L', 0);
		$pdf->Cell(65	,5, $row['ECEmail'], '', 0);
    	$pdf->Cell(30	,5, "City", '', 0);
		$pdf->Cell(64	,5, $row['ECCity'], 'R', 1);

        $pdf->Cell(30	,5, "Phone", 'L', 0);
		$pdf->Cell(65	,5, $row['ECPhone'], '', 0);
    	$pdf->Cell(30	,5, "State", '', 0);
		$pdf->Cell(64	,5, $row['ECState'], 'R', 1);
    
    	$pdf->Cell(30	,5, "Fax", 'L', 0);
		$pdf->Cell(65	,5, $row['ECFax'], '', 0);
    	$pdf->Cell(30	,5, "Zipcode", '', 0);
		$pdf->Cell(64	,5, $row['ECZip'], 'R', 1);
    
    	$pdf->Cell(30	,5, "Website", 'L', 0);
		$pdf->Cell(65	,5, $row['ECWebsite'], '', 0);
		$pdf->Cell(30	,5, "Country", '', 0);
		$pdf->Cell(64	,5, $row['ECCountry'], 'R', 1);
        
       	$pdf->Cell(189	,5, "", 'LBR', 1, 'C');
    }
	
	$pdf->Output();
}

?>