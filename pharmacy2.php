<?php
session_start();
 include("database-connection.php");


  $pharmid = $_SESSION['sess_user_id'];
  $prescriptionid = ($_GET['pid']);

	include("database-connection.php");
	
	$check_problem="select * from PRESCRIPTION where PRESCRIPTION_NUMBER=".$prescriptionid;
	$stid = oci_parse($conn, $check_problem);
	oci_execute($stid);
	?>
	
	<p style="text-decoration: underline;">Details:</p>

<table>
	<?php
while (($row = oci_fetch_array($stid, OCI_BOTH+OCI_RETURN_NULLS)) != false) {
    echo "<tr><th>Prescription Number : </th><td>".str_pad($row['PRESCRIPTION_NUMBER'],8,'0',STR_PAD_LEFT)."</td></tr>";
    echo "<tr><th>Doctor ID : </th><td>".$row['DOC_ID']."</td></tr>";
    echo "<tr><th>Patient ID : </th><td>".$row['PATIENT_ID']."</td></tr>";
    echo "<tr><th>Drug List : </th><td>".$row['DRUG_LIST']."</td></tr>";
}?>
</table>

<?php 
echo "<button id='doctor2' onclick=\"response_drug(".$prescriptionid.")\">Submit</button>";
?>

<?php
oci_free_statement($stid);
oci_close($conn);
?>