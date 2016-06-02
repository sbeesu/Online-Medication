
<?php
$problemtype = ($_GET['problemtype']);

	include("database-connection.php");
	echo "<p >Please select a doctor from list:</p>";
	$doctor = "select name from DOCTOR where ptype='".$problemtype."'";
	$stid = oci_parse($conn, $doctor);
	oci_execute($stid);?>
<form name="test">
	<?php
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    foreach ($row as $item) {
	$docname=($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;");
	echo "<input type='radio' name='docname' value='".$docname."' required><span>".$docname."</span>";
    }
}
oci_free_statement($stid);
oci_close($conn);
?>
</form>
<button onclick="check_request()">Send Request</button>

