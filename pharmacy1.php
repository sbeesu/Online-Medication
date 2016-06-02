<?php

session_start();
  $pharmacyid = $_SESSION['sess_user_id'];
//$docid = "cat";
 
	include("database-connection.php");
	
	$pharmacy_request = "select PRESCRIPTION_NUMBER from DOCTOR_RESPONSE_PHARMACY where FLAG='F' and PHARMACY_ID='".$pharmacyid."'";
	$stid = oci_parse($conn, $pharmacy_request);
	oci_execute($stid);?>
	<p style="text-decoration: underline;">Request List:</p>
<form name="test">
	<?php
	$check=0;
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    foreach ($row as $item) { 
	$check=1;
	$request_list=($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;");
	$str=str_pad($request_list,8,'0',STR_PAD_LEFT);
	echo "<input type='radio' name='requests' value='".$request_list."' onclick=getPrescriptiondetails(this.value)><span>".$str."</span>";
    }
}
if(!$row & $check==0)
echo "No Requests!!!";

oci_free_statement($stid);
oci_close($conn);
?>
</form>