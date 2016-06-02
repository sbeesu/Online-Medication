<?php
session_start();
error_reporting(0);

$docname = ($_GET['reqid']);
$patient_problem = ($_GET['problem']);
$patientid = $_SESSION['sess_user_id'];
	
	include("database-connection.php");
	$doctorid="select id from doctor where name='".$docname."'";
	$stid = oci_parse($conn, $doctorid);
	oci_execute($stid);
	
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    foreach ($row as $item) {
	$doc_id=($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;");
	}}
	
	$request_number= "select COUNT(*) as COUNT from PATIENT_REQUEST";
	$s = oci_parse($conn, $request_number);
	OCIExecute($s, OCI_DEFAULT);
	OCIFetch($s);
	$count = ociresult($s, "COUNT");
	$count++;
	
	
	$check_row= "select COUNT(*) as COUNT from PATIENT_REQUEST where DOC_ID='".strtolower($doc_id)."' and PATIENT_ID='".strtolower($patientid)."' and FLAG='F'";
	$sg = oci_parse($conn, $check_row);
	OCIExecute($sg, OCI_DEFAULT);
	OCIFetch($sg);
	$present = ociresult($sg, "COUNT");
	if($present==0)
	{
	
	//$patient_request= "INSERT INTO PATIENT_REQUEST (REQUEST_NO,DOC_ID,PATIENT_ID,FLAG,PROBLEM) VALUES (".$count.",'".strtolower($doc_id)."','".strtolower($patientid)."','F'".",'".strtolower($patient_problem)."')";
	
	$docid=strtolower($doc_id);
	$patid=strtolower($patientid);
	$patproblem=strtolower($patient_problem);
	
	$stid2 = oci_parse($conn,'CALL CreatePatientRequest(:p1, :p2, :p3, :p4)');
	oci_bind_by_name($stid2, ':p1', $count);
	oci_bind_by_name($stid2, ':p2', $docid);
	oci_bind_by_name($stid2, ':p3', $patid);
	oci_bind_by_name($stid2, ':p4', $patproblem);
	
	$f=oci_execute($stid2);
	
	if($f)
	echo "<p>SUCCESSFULLY ENROLLED!!!</p>";
	}
	else
	echo "<p>ALREADY ENROLLED!!!<p>";
	
oci_free_statement($stid);
oci_close($conn);
?>