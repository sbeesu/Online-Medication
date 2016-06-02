<!DOCTYPE html>
<html>
<head>
	<title>Online Medication</title>
	<style>
	#specification,#patient-dob,#pharmacy-loc{display:none}
	.loginform {	width: 410px;margin: 50px auto;padding: 25px;background-color: rgba(250,250,250,0.5);border-radius: 5px;box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.2), inset 0px 1px 0px 0px rgba(250, 250, 250, 0.5);border: 1px solid rgba(0, 0, 0, 0.3);}
	label {display: block;color: #999;padding-bottom:3px}
	.loginform ul {padding: 0;margin: 0;}
	.loginform input:not([type=submit]){padding: 5px;margin-right: 10px;border: 1px solid rgba(0, 0, 0, 0.3);border-radius: 3px;box-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.1), 0px 1px 0px 0px rgba(250, 250, 250, 0.5) ;width:250px;}
	.loginform input[type="radio"]{width:auto;color:#999}
	.loginform select{color:#999}
	.cf:before,.cf:after {content: ""; display: table;}
.cf:after {clear: both;}
.cf {*zoom: 1;}
:focus {outline: 0;}
.loginform input[type=submit] {
	border: 1px solid rgba(0, 0, 0, 0.3);
	background: #64c8ef; /* Old browsers */
	background: -moz-linear-gradient(top,  #64c8ef 0%, #00a2e2 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#64c8ef), color-stop(100%,#00a2e2)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #64c8ef 0%,#00a2e2 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #64c8ef 0%,#00a2e2 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #64c8ef 0%,#00a2e2 100%); /* IE10+ */
	background: linear-gradient(to bottom,  #64c8ef 0%,#00a2e2 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#64c8ef', endColorstr='#00a2e2',GradientType=0 ); /* IE6-9 */
	color: #fff;
	padding: 5px 15px;
	margin-right: 0;
	margin-top: 15px;
	border-radius: 3px;
	text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.3);
}
.loginform li{list-style: none;padding-bottom:15px}
.loginform li span{color:#999}
#specification span{color:#999;display:block;}
#specification input[type="radio"]{float:left}

	</style>
	</head>
<body>

<?php

$name = $userid = $pass = $cpass = $type = $mobile = $email = $problem = $pharmacy_street = $pharmacy_city = $pharmacy_zip = $patient_dob = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $userid = test_input($_POST["userid"]);
  $pass = test_input($_POST["password"]);
  $cpass = test_input($_POST["cpassword"]);
  $type = test_input($_POST["type"]);
  $mobile = test_input($_POST["mobile"]);
  $email = test_input($_POST["email"]);
  $problem = test_input($_POST["problem"]);
  $pharmacy_street = test_input($_POST["street"]);
  $pharmacy_city = test_input($_POST["city"]);
  $pharmacy_zip = test_input($_POST["zipcode"]);
  $patient_dob = test_input($_POST["patientdob"]);
  $patient_dob = (string)$patient_dob;
  
  include("database-connection.php");
	$check_login="select * from login where LOGIN_ID='".$userid."'";
	$stid = oci_parse($conn, $check_login);
	oci_execute($stid);

	if(oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)==true )
	{
		echo "<script>alert('Login ID already registered')</script>";
		echo "<script>window.location = '/db-project/registration.php';</script>";
	}
	if($pass!=$cpass)
		{
			echo "<script>alert('Password and Confirm Password were not correct')</script>";
			echo "<script>window.location = '/db-project/registration.php';</script>";
		}
	if($type=="doctor")
	{	
		$doctor_login="INSERT INTO DOCTOR (ID,NAME,PTYPE,PHONE,EMAIL) VALUES ('".strtolower($userid)."','".strtolower($name)."','".strtolower($problem)."','".strtolower($mobile)."','".strtolower($email)."')";
		$stid3 = oci_parse($conn, $doctor_login);
		oci_execute($stid3);
	}
	if($type=="patient")
	{	
		$patient_login="INSERT INTO PATIENT (ID,NAME,DOB,PHONE,EMAIL) VALUES ('".strtolower($userid)."','".strtolower($name)."',TO_DATE('".$patient_dob."','YYYY-MM-DD'),'".strtolower($mobile)."','".strtolower($email)."')";
		$stid3 = oci_parse($conn, $patient_login);
		oci_execute($stid3);
	}
	if($type=="pharmacist")
	{	
		$pharmacy_login="INSERT INTO PHARMACY (ID,NAME,PHONE,EMAIL) VALUES ('".strtolower($userid)."','".strtolower($name)."','".strtolower($mobile)."','".strtolower($email)."')";
		$pharmacy_location="INSERT INTO LOCATION(PHARMACY_ID,STREET,CITY,ZIPCODE) VALUES ('".strtolower($userid)."','".strtolower($pharmacy_street)."','".strtolower($pharmacy_city)."',".$pharmacy_zip.")";
		$stid3 = oci_parse($conn, $pharmacy_login);
		$stid4 = oci_parse($conn, $pharmacy_location);
		oci_execute($stid3);
		oci_execute($stid4);
	}
	$insert_login="INSERT INTO login (LOGIN_ID,PASSWORD,TYPE) VALUES ('".strtolower($userid)."','".strtolower($pass)."','".strtolower($type)."')";
	$stid2 = oci_parse($conn, $insert_login);
	oci_execute($stid2);
	echo "<script>alert('Registered Successfull!!');</script>";
	echo "<script>window.location = '/db-project/login.php';</script>";
	oci_close($conn);
  }
  

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

	<section class="loginform cf">
		<form name="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" accept-charset="utf-8">
			<ul>
				<li>
					<label for="name">Name*</label>
					<input type="text" name="name" placeholder="Name" required>
				</li>
				<li>
					<label for="loginid">Login ID*</label>
					<input type="text" name="userid" placeholder="Login ID" required>
				</li>
				<li>
					<label for="password">Password*</label>
					<input type="password" name="password" placeholder="Password" required>
				</li>
				<li>
					<label for="password">Confirm Password*</label>
					<input type="password" name="cpassword" placeholder="Confirm Password" required>
				</li>
				<li>
					<label for="mobile">Mobile</label>
					<input type="text" name="mobile" placeholder="Mobile">
				</li>
				<li>
					<label for="email">E-Mail</label>
					<input type="email" name="email" placeholder="E-Mail">
				</li>
				<li>
					<label for="category">Patient/Doctor/Pharmacist</label>
					<input type="radio" name="type" value="doctor" onclick="if(this.checked){document.getElementById('specification').style.display='block'; }if(this.checked){document.getElementById('patient-dob').style.display='none'} if(this.checked){document.getElementById('pharmacy-loc').style.display='none'}"><span>Doctor</span>
					
					<input type="radio" name="type" value="patient" onclick="if(this.checked){document.getElementById('specification').style.display='none';} if(this.checked){document.getElementById('patient-dob').style.display='block'} if(this.checked){document.getElementById('pharmacy-loc').style.display='none'}"><span>Patient</span>
					
					<input type="radio" name="type" value="pharmacist" onclick="if(this.checked){document.getElementById('specification').style.display='none';} if(this.checked){document.getElementById('patient-dob').style.display='none'} if(this.checked){document.getElementById('pharmacy-loc').style.display='block'}"><span>Pharmacist</span>
				</li>
				<li id="specification">
					<label for="specification">Please specify the problem you can cure:</label>
					<input type="text" name="problem" placeholder="Problem Type">
				</li>
				<li id="patient-dob">
					<label for="patient-dob">Please specify Date of Birth:</label>
					<input type="date" name="patientdob" placeholder="DOB">
				</li>
				<li id="pharmacy-loc">
					<label for="pharmacy-loc">Please specify the Pharmacy Location:</label>
					<input type="text" name="street" placeholder="Street">
					<input type="text" name="city" placeholder="City">
					<input type="text" name="zipcode" placeholder="Zipcode">
				</li>
			</ul>
			
					<input type="submit" value="Register">
		
		</form>
	</section>
</body>
</html>