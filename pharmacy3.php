<?php
 session_start();
 $prescriptionid = ($_GET['presid']);
 include("database-connection.php");
echo "<p>Drugs were packed for patient!!!</p>";
echo "<p>Please check for more requests!!!</p>";

$update_doctor_response="update DOCTOR_RESPONSE_PHARMACY set FLAG='T' where PRESCRIPTION_NUMBER=".$prescriptionid;
	$stid2 = oci_parse($conn, $update_doctor_response);
	oci_execute($stid2);

?>