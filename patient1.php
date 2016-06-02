<html>
<head>
<style>
.patient{width: 410px;margin: 50px auto;padding: 25px;background-color: rgba(250,250,250,0.5);border-radius: 5px;box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.2), inset 0px 1px 0px 0px rgba(250, 250, 250, 0.5);border: 1px solid rgba(0, 0, 0, 0.3);:focus{outline:none;}}
th{text-align:right;}
td{text-align:left;}
#logout{position: absolute;right: 0;width: 30%;top: 15px;}

</style>
<script>
function patient_request() {
document.getElementById("doctor-response").innerHTML="";
document.getElementById("set-request").innerHTML="";
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("patient-request").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","patient2.php",true);
  xmlhttp.send();
}

function selectproblem(str) {
  if (str=="") {
    document.getElementById("doctype").innerHTML="";
    return;
  } 
  document.getElementById("set-request").innerHTML="";
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("getdoc").innerHTML=xmlhttp.responseText;
    }
  }
 
  xmlhttp.open("GET","getdoc.php?problemtype="+str,true);
  xmlhttp.send();
}
function check_request(){
theone=null;
for (i=0;i<document.test.length;i++){
if (document.test[i].checked==true)
{theone=i;
doctorname=document.test[theone].value;}
}
if (theone==null) {
    document.getElementById("set-request").innerHTML="";
	alert("Please select the doctor");
    return;
  }
patient_problem=document.getElementById("patient-problem").value;
  set_request(doctorname,patient_problem);
}

function set_request(doctorname,patient_problem)
{
if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("set-request").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","patient3.php?reqid="+doctorname+"&problem="+patient_problem,true);
  xmlhttp.send();
}

function doctor_response() {
document.getElementById("patient-request").innerHTML="";
document.getElementById("set-request").innerHTML="";
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("doctor-response").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","patient4.php",true);
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
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '') || $type!="patient") {
	header("location: login.php");}
 
?>
<div id="logout">
<button onclick="window.location = '/db-project/logout.php';">Logout</button>
</div>
<div class='patient'>
<button onclick="patient_request()" style='width:49%;outline:none'>Patient Request</button>
<button onclick="doctor_response()" style='width:49%'>Doctor Response</button>
<div id="patient-request"></div>
<div id="set-request"></div>
<div id="doctor-response"></div>
</div>


</body>
</html>