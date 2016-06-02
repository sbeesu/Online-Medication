<html>
<head>
<style>
.doctor{width: 410px;margin: 50px auto;padding: 25px;background-color: rgba(250,250,250,0.5);border-radius: 5px;box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.2), inset 0px 1px 0px 0px rgba(250, 250, 250, 0.5);border: 1px solid rgba(0, 0, 0, 0.3);:focus{outline:none;}}
#patient-details th{text-align: left;font-weight:normal}
#patient-details td{text-transform: uppercase;}
#logout{position: absolute;right: 0;width: 30%;top: 15px;}
.leftdiv{float: left; border-right: 1px solid rgb(204, 204, 204); padding-right: 10px; margin-right: 10px;}
#patient-details{overflow: hidden;}
.rightdiv{clear: right; overflow: hidden;}
#doctor2{clear: both; display: block; margin-top: 20px;}

</style>
<script>
function check_request() {
document.getElementById("set-response").innerHTML = "";
document.getElementById("patient-details").innerHTML="";
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
  xmlhttp.open("GET","doctor1.php",true);
  xmlhttp.send();
}

function getPatientdetails(reqnum)
{
document.getElementById("patient-details").innerHTML="";
if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("patient-details").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","doctor2.php?pid="+reqnum,true);
  xmlhttp.send();
}
var list1="";
function add_drug()
{
	var drug = document.getElementById("drug").value;
	document.getElementById("drug").value="";
	if(drug!="")
	{
	document.getElementById("response-block").style.display="block";
	list = document.getElementById("druglist").innerHTML;
	if(list=="")
	{
		list=drug;
		list1=drug;
		}
	else{
		list = (list + ", " + drug);
		list1 = (list1 + "," + drug);
		}
		document.getElementById("druglist").innerHTML = list;
	}
	else
	{alert("Please specify the drug!!");}
}

function response_drug(patientid,request_number)
{
var pharmacyid=document.getElementById("pharmacy-id").value;
	if(list1=="")
	{
	alert("Prescirbe Drugs");
	return;}
	if(pharmacyid=="")
	{
	alert("Select Pharmacy");
	return;}
	if (window.XMLHttpRequest) {
    xmlhttp=new XMLHttpRequest();
  } else { 
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("set-response").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","doctor3.php?pid="+patientid+"&list="+list1+"&pharmid="+pharmacyid+"&requestnum="+request_number,true);
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
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '') || $type!="doctor") {
	header("location: login.php");}
 
?>
<div id="logout">
<button onclick="window.location = '/db-project/logout.php';">Logout</button>
</div>
<div class='doctor'>
<button onclick="check_request()" style='width:99%;outline:none'>Check Request</button>

<div id="check-request"></div>
<div id="patient-details"></div>
<div id="set-response"></div>
</div>


</body>
</html>