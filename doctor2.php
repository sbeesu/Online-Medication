<?php
session_start();
  $docid = $_SESSION['sess_user_id'];
  $requestnum = ($_GET['pid']);
  
  	include("database-connection.php");
	$getpatid= "select PATIENT_ID from PATIENT_REQUEST where REQUEST_NO=".$requestnum;
	$g = oci_parse($conn, $getpatid);
	OCIExecute($g, OCI_DEFAULT);
	OCIFetch($g);
	$patientid = ociresult($g, "PATIENT_ID");
	
	
	$check_problem="select PROBLEM from PATIENT_REQUEST where REQUEST_NO='".$requestnum."' and PATIENT_ID='".$patientid."'";
	$s = oci_parse($conn, $check_problem);
	OCIExecute($s, OCI_DEFAULT);
	OCIFetch($s);
	$problem = ociresult($s, "PROBLEM");
	
	$patient_details = "select NAME,DOB,PHONE,EMAIL from PATIENT where ID='".$patientid."'";
	$stid = oci_parse($conn, $patient_details);
	oci_execute($stid);
	
	
	?>
	
	<p style="text-decoration: underline;">Patient Problem: </p>
	<p style="text-transform: uppercase;"><?php echo $problem; ?></p>
	
	<p style="text-decoration: underline;">Patient Details:</p>

<table>
  
	<?php
while (($row = oci_fetch_array($stid, OCI_BOTH+OCI_RETURN_NULLS)) != false) {
    // Use the uppercase column names for the associative array indices
    echo "<tr><th>Name : </th><td>".$row['NAME'] ."</td></tr>";
    echo "<tr><th>Date of Birth : </th><td>".$row['DOB']."</td></tr>";
    echo "<tr><th>Phone number : </th><td>".$row['PHONE']."</td></tr>";
    echo "<tr><th>Email ID : </th><td>".$row['EMAIL']."</td></tr>";
}?>

</table>

<div class="leftdiv">
	<p style="text-decoration: underline;">Specify The drugs:</p>
	<input type="text" name="drug" id="drug" placeholder="Enter Drug Name">
	<button onclick="add_drug()">Add</button>

	<div id="response-block" style="display:none">
		<p style="text-decoration: underline;">Specified Drug List:</p>
		<p style="display:inline-block;padding-right:10px;margin-top: 0;" id="druglist"></p>
	</div>
</div>

<div class="rightdiv">
	<p style="text-decoration: underline;">Choose the Pharmacy Store:</p>
<select id="pharmacy-id">

<?php
	$pharmacy_name = "select ID,NAME from PHARMACY";
	$stid2 = oci_parse($conn, $pharmacy_name);
	oci_execute($stid2);
	
	echo "<option value=''>Select a Pharmacy Store:</option>";
	while (($row = oci_fetch_array($stid2, OCI_BOTH+OCI_RETURN_NULLS)) != false) {
		// Use the uppercase column names for the associative array indices
		echo "<option value='".$row['ID']."'>".$row['NAME']."</option>";
	}
?>
</select>
</div>

<?php 
echo "<button id='doctor2' onclick=\"response_drug('".$patientid."','".$requestnum."')\">Submit</button>";
?>

<?php
oci_free_statement($stid);
oci_close($conn);
?>