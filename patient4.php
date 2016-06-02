<?php
session_start();
$patientid = $_SESSION['sess_user_id'];
include("database-connection.php");

$patientid="select * from prescription where PATIENT_ID='".$patientid."'";
	$stid = oci_parse($conn, $patientid);
	oci_execute($stid);
	?>
<table>
  
	<?php
while (($row = oci_fetch_array($stid, OCI_BOTH+OCI_RETURN_NULLS)) != false) {
    // Use the uppercase column names for the associative array indices
    echo "<tr><th>Presccrition Number : </th><td>".$row['PRESCRIPTION_NUMBER'] ."</td></tr>";
	$presnum=$row['PRESCRIPTION_NUMBER'];
	
	//$pharmid="select PHARMACY_ID from DOCTOR_RESPONSE_PHARMACY where PRESCRIPTION_NUMBER='".$presnum."'";
	//$s = oci_parse($conn, $pharmid);
	//OCIExecute($s, OCI_DEFAULT);
	//OCIFetch($s);
	//$pharmids = ociresult($s, "PHARMACY_ID");
	
	$pharmloc="select * from location where PHARMACY_ID=(select PHARMACY_ID from DOCTOR_RESPONSE_PHARMACY where PRESCRIPTION_NUMBER=".$presnum.")";
	
	//$pharmloc="select * from LOCATION where PHARMACY_ID='".$pharmids."'";
	
	$s2 = oci_parse($conn, $pharmloc);
	oci_execute($s2);
	while (($row2 = oci_fetch_array($s2, OCI_BOTH+OCI_RETURN_NULLS)) != false) {

	echo "<tr><th>PHARM Street : </th><td>".$row2['STREET']."</td></tr>";
	echo "<tr><th>PHARM City : </th><td>".$row2['CITY']."</td></tr>";
	echo "<tr><th>PHARM Zipcode : </th><td>".$row2['ZIPCODE']."</td></tr>";
	}
	
    
	echo "<tr><th>Drug List : </th><td>".$row['DRUG_LIST']."</td></tr>";
}?>

</table>
	<?php
	oci_free_statement($stid);
oci_close($conn);

?>