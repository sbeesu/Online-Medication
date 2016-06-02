<?php

session_start();

  $docid = $_SESSION['sess_user_id'];
//$docid = "cat";
 
	include("database-connection.php");
	
	$patient_request = "select REQUEST_NO from PATIENT_REQUEST where FLAG='F' and DOC_ID='".$docid."'";
	$stid = oci_parse($conn, $patient_request);
	oci_execute($stid);?>
	<p style="text-decoration: underline;">Request List:</p>
<form name="test">
	<?php
	$check=0;
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    foreach ($row as $item) { 
	$check=1;
	$request_list=($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;");
	echo "<input type='radio' name='requests' value='".$request_list."' onclick=getPatientdetails(this.value)><span>Request Number: ".$request_list."</span>";
    }
}
if(!$row & $check==0)
echo "No Requests!!!";

oci_free_statement($stid);
oci_close($conn);
?>
</form>
