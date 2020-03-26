<?php
$con = mysqli_connect("localhost","root","","social");

if(mysqli_connect_errno()) {
	echo "Failed to connect:".mysqli_connect_errno();
}

//Declaring variabes to prevent errors
$fname = ""; //First name
$lname = ""; //Last name
$em = ""; //email
$em2 = ""; //email 2
$password = ""; //password
$password2 = ""; //password 2
$date = ""; //Sign up date
$error_array = "" ; //Holds any error messages that may occur for example duplication, wrong input etc

//If value component when register button is pressed
if(isset($_POST['register_button'])) {

	//Registration form values

	//This line says from this variable
	//Find the value send by this value (reg_fName)
	// The $_POST just says take whatever the value of the page is after the page has completed

	//First Name
	//Strip tags - removes any broken input e.g. html tags
	$fname = strip_tags($_POST['reg_fName']);
	//Removes uncessary spaces
	$fname = str_replace('', '', $fname);
	//Takes the string, lowers all characters, then capitialises the first letter
	$fname = ucfirst(strtolower($fname));

	//Last Name
	//Strip tags - removes any broken input e.g. html tags
	$lname = strip_tags($_POST['reg_lName']);
	//Removes uncessary spaces
	$lname = str_replace('', '', $lname);
	//Takes the string, lowers all characters, then capitialises the first letter
	$lname = ucfirst(strtolower($lname));

	//Email
	//Strip tags - removes any broken input e.g. html tags
	$email = strip_tags($_POST['reg_email']);
	//Removes uncessary spaces
	$email = str_replace('', '', $email);

	//Email 2
	//Strip tags - removes any broken input e.g. html tags
	$email2 = strip_tags($_POST['reg_email2']);
	//Removes uncessary spaces
	$email2 = str_replace('', '', $email2);

	//Password
	//Strip tags - removes any broken input e.g. html tags 
	$password = strip_tags($_POST['reg_password']);

	//Password 2
	$password2 = strip_tags($_POST['reg_password2']);

	//Date
	//Gets the current date
	$date = date("dd-mm-YYYY");

	//To check if emails match
	if($email == $email2) {

	} else {
		echo "Emails don't match"; 
	}

	
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Swirlfeed!</title>
</head>
<body>

	<!--//Each element of the page is entered here
		//Notice each element has the following features
		//Type - what type of input
		//Name - name of variable
		//Placeholder
		//Required tag - field must be entered-->
		
		<form action"register.php" method="POST">

			<input type="text" name="reg_fName" placeholder="First Name" required>
			<br>
			<input type="text" name="reg_lName" placeholder="Last Name" required>
			<br>
			<input type="email" name="reg_email" placeholder="Email" required>
			<br>
			<input type="email" name="reg_email2" placeholder="Confirm Email" required>
			<br>
			<input type="password" name="reg_password" placeholder="Password" required>
			<br>
			<input type="password" name="reg_password2" placeholder="Confirm Password" required>
			<br>
			<input type="submit" name="register_button" value="Register">
			<br>


		</form>

	</body>
	</html>