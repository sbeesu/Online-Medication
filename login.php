<!DOCTYPE html>
<?php
ob_start();
session_start();
?>
<html>
<head>
	<title>Online Medication</title>
	<style>
	label {display: block;color: #999; padding-bottom:3px}
.cf:before,.cf:after {content: ""; display: table;}
.cf:after {clear: both;}
.cf {*zoom: 1;}
:focus {outline: 0;}
.loginform {	width: 410px;margin: 50px auto;padding: 25px;background-color: rgba(250,250,250,0.5);border-radius: 5px;box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.2), inset 0px 1px 0px 0px rgba(250, 250, 250, 0.5);border: 1px solid rgba(0, 0, 0, 0.3);}
.loginform ul {padding: 0;margin: 0;}
.loginform li {display: inline;float: left;}
.loginform input:not([type=submit]) {padding: 5px;margin-right: 10px;border: 1px solid rgba(0, 0, 0, 0.3);border-radius: 3px;box-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.1), 0px 1px 0px 0px rgba(250, 250, 250, 0.5) ;width: 175px;}
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

a.register{
font: 13px/18px Helvetica,Arial,Verdana,sans-serif;
-webkit-transition:background 0.3s ease-in-out;
-moz-transition:background 0.3s ease-in-out;
-o-transition:background 0.3s ease-in-out;
transition:background 0.3s ease-in-out;
color:#2F4F4F;
text-decoration:none;
padding:4px;
margin-left:50px
}
a.register:hover {background-color: #ccc;cursor:pointer;border-radius:3px}
	</style>
</head>
<body>
<?php
// define variables and set to empty values
$id = $pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = test_input($_POST["userid"]);
  $pass = test_input($_POST["password"]);
  
	include("database-connection.php");
	$check_login="select * from LOGIN where LOGIN_ID='".$id."' and PASSWORD='".$pass."'";
	$stid = oci_parse($conn, $check_login);
	oci_execute($stid);
	if(oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)==false )
	{
		echo "<script>alert('Login ID or Password Incorrect')</script>";
		echo "<script>window.location = '/db-project/login.php';</script>";
	}
	echo "<script>alert('Successfully Logged in!!')</script>";
	session_regenerate_id();
	$_SESSION['sess_user_id'] = $id;
	session_write_close();
	
	$check_type="select type from LOGIN where LOGIN_ID='".$id."'";
	$s = oci_parse($conn, $check_type);
	OCIExecute($s, OCI_DEFAULT);
	OCIFetch($s);
	$type = ociresult($s, "TYPE");
	oci_close($conn);
	if(trim($type) == "patient")
	echo "<script>window.location = '/db-project/patient1.php';</script>";
	
	if(trim($type) == "doctor")
	echo "<script>window.location = '/db-project/doctor.php';</script>";	

	if(trim($type) == "pharmacist")
	echo "<script>window.location = '/db-project/pharmacy.php';</script>";	
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
					<label for="userid">Login ID</label>
					<input type="text" name="userid" placeholder="Login ID" required>
				</li>
				<li>
					<label for="password">Password</label>
					<input type="password" name="password" placeholder="Password" required></li>		
			</ul>
			
					<input type="submit" value="Login">
					<a class='register' href="/db-project/registration.php">Not Registered yet?</a>
		
		</form>
	</section>
</body>
</html>