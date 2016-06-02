<?php
session_start();
//error_reporting(0);
$rno=($_GET['requestnum']);
$patientid = ($_GET['pid']);
$druglist = ($_GET['list']);
$pharmid = ($_GET['pharmid']);
$docid = $_SESSION['sess_user_id'];
$flag=0;
include("database-connection.php");
$prescription_number= "select COUNT(*) as COUNT from PRESCRIPTION";
$s = oci_parse($conn, $prescription_number);
	OCIExecute($s, OCI_DEFAULT);
	OCIFetch($s);
	$count = ociresult($s, "COUNT");
	$count++;
	
	
	$check_row= "select COUNT(*) as COUNT from PATIENT_REQUEST where FLAG='T' and REQUEST_NO=".$rno;
	$sg = oci_parse($conn, $check_row);
	OCIExecute($sg, OCI_DEFAULT);
	OCIFetch($sg);
	$present = ociresult($sg, "COUNT");
	
	if($present==0)
	{
	//$doctor_response= "INSERT INTO PRESCRIPTION (PRESCRIPTION_NUMBER,DOC_ID,PATIENT_ID,FLAG,DRUG_LIST) VALUES (".$count.",'".strtolower($docid)."','".strtolower($patientid)."','F'".",'".strtolower($druglist)."')";
	//$stid = oci_parse($conn, $doctor_response);
	
	$docid=strtolower($docid);
	$patid=strtolower($patientid);
	$druglist=strtolower($druglist);
	
	$stid = oci_parse($conn,'CALL CreateDoctorResponse(:p1, :p2, :p3, :p4)');
	oci_bind_by_name($stid, ':p1', $count);
	oci_bind_by_name($stid, ':p2', $docid);
	oci_bind_by_name($stid, ':p3', $patid);
	oci_bind_by_name($stid, ':p4', $druglist);
	
	$f=oci_execute($stid);
	
	$doctor_response_pharmacy= "INSERT INTO DOCTOR_RESPONSE_PHARMACY (PRESCRIPTION_NUMBER,PHARMACY_ID,FLAG) VALUES (".$count.",'".strtolower($pharmid)."','F')";
	$stid2 = oci_parse($conn, $doctor_response_pharmacy);
	$g=oci_execute($stid2);

	if($f && $g)
	{
	echo "<p>SUCCESSFULLY ENROLLED!!!</p>";
	echo "<p>Please Check Requests for more!!!</p>";
	}
		
	$update_patient_request="update PATIENT_REQUEST set FLAG='T' where REQUEST_NO=".$rno;
	$stid2 = oci_parse($conn, $update_patient_request);
	oci_execute($stid2);
	}
	else
	echo "<p>ALREADY ENROLLED!!!<p>";
?>