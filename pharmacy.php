<html>
<head>
<style>
.pharmacy{width: 410px;margin: 50px auto;padding: 25px;background-color: rgba(250,250,250,0.5);border-radius: 5px;box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.2), inset 0px 1px 0px 0px rgba(250, 250, 250, 0.5);border: 1px solid rgba(0, 0, 0, 0.3);:focus{outline:none;}}
#prescription-details th{text-align: left;font-weight:normal}
#prescription-details td{text-transform: uppercase;}
#logout{position: absolute;right: 0;width: 30%;top: 15px;}
.leftdiv{float: left; border-right: 1px solid rgb(204, 204, 204); padding-right: 10px; margin-right: 10px;}
#prescription-details{overflow: hidden;}
.rightdiv{clear: right; overflow: hidden;}
#doctor2{clear: both; display: block; margin-top: 20px;}


</style>
<script>
function check_request() {
document.getElementById("status").style.display="none";
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("check-request").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","pharmacy1.php",true);
  xmlhttp.send();
}
function getPrescriptiondetails(prescriptionid)
{
document.getElementById("prescription-details").style.display="block";
if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("prescription-details").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","pharmacy2.php?pid="+prescriptionid,true);
  xmlhttp.send();
}

function response_drug(presid)
{
document.getElementById("status").style.display="block";
document.getElementById("prescription-details").style.display="none";
if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("status").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","pharmacy3.php?presid="+presid,true);
  xmlhttp.send();
  
}
</script>
</head>
<body>
<?php
//Start session
session_start();
  $id = $_SESSION['sess_user_id'];
  
  include("database-connection.php");
  $check_type="select type from LOGIN where LOGIN_ID='".$id."'";
	$s = oci_parse($conn, $check_type);
	OCIExecute($s, OCI_DEFAULT);
	OCIFetch($s);
	$type = ociresult($s, "TYPE");
	oci_close($conn);
	
  //Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '') || $type!="pharmacist") {
	header("location: login.php");}
 
?>
<div id="logout">
<button onclick="window.location = '/db-project/logout.php';">Logout</button>
</div>
<div class='pharmacy'>
<button onclick="check_request()" style='width:100%;outline:none;'>Check Request</button>
<div id="check-request"></div>
<div id="prescription-details"></div>
<div id="status"></div>
</div>


</body>
</html>