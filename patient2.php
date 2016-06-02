<p>Select the problem type:</p>
<form>
<select name="users" onchange="selectproblem(this.value)" id='patient-problem'>
<?php
	include("database-connection.php");
	$doctor_type = "select distinct(ptype) from doctor";
	$stid = oci_parse($conn, $doctor_type);
	oci_execute($stid);
	
echo "<option value=''>Select a Problem:</option>";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    foreach ($row as $item) {
	$doctype=($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;");
	echo "<option value='".$doctype."'>".$doctype."</option>";
	
    }
}

oci_free_statement($stid);
oci_close($conn);
?>
</select>
</form>
<div id="getdoc"></div>