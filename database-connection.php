<?php
$host='csdb.csc.villanova.edu';
$user='sbajaj';
$passwd='FA01390440';
$service_name='csdb.villanova';

$db='(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)
(HOST='.$host.')(PORT=1521)))(CONNECT_DATA=(SERVICE_NAME = '.$service_name.')))';

$conn=oci_connect($user,$passwd,$db);


//$conn = oci_connect("sbeesu", "fL01194844", "//csdb.csc.villanova.edu:1521/csdb.villanova");
// $conn = oci_connect("shvangal", "FA01390405", "//csdb.csc.villanova.edu:1521/csdb.villanova");
 
//$conn = oci_connect("sbajaj", "FA01390440", "//csdb.csc.villanova.edu:1521/csdb.villanova");
//$conn = oci_connect("scott", "oracle", "//localhost:1521/orcl.0.0.17");
	if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
	exit();
	}
?>