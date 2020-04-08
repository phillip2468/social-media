<?php
session_start();
$con = mysqli_connect("localhost","root","","social");

if(mysqli_connect_errno()) {
	echo "Failed to connect:".mysqli_connect_errno();
}

//Declaring variabes
$fname = ""; //First name
$lname = ""; //Last name
$em = ""; //email
$em2 = ""; //email 2
$password = ""; //password
$password2 = ""; //password 2
$date = ""; //Sign up date
$error_array = array() ; //Holds any error messages that may occur for example duplication, wrong input etc

//If value component when register button is pressed
if(isset($_POST['register_button'])) {

	//Registration form values

	//This line says from this variable
	//Find the value send by this value (reg_fname)
	// The $_POST just says take whatever the value of the page is after the page has completed

	//First Name
	//Strip tags - removes any broken input e.g. html tags
	$fname = strip_tags($_POST['reg_fname']);
	//Removes uncessary spaces
	$fname = str_replace('', '', $fname);
	//Takes the string, lowers all characters, then capitialises the first letter
	$fname = ucfirst(strtolower($fname));
	//Stores first name into sesssion variable
	$_SESSION['reg_fname'] = $fname;

	//Last Name
	//Strip tags - removes any broken input e.g. html tags
	$lname = strip_tags($_POST['reg_lname']);
	//Removes uncessary spaces
	$lname = str_replace('', '', $lname);
	//Takes the string, lowers all characters, then capitialises the first letter
	$lname = ucfirst(strtolower($lname));
	//Stores last name into sesssion variable
	$_SESSION['reg_lname'] = $lname;

	//Email
	//Strip tags - removes any broken input e.g. html tags
	$email = strip_tags($_POST['reg_email']);
	//Removes uncessary spaces
	$email = str_replace('', '', $email);
	//Stores email into sesssion variable
	$_SESSION['reg_email'] = $email;

	//Email 2
	//Strip tags - removes any broken input e.g. html tags
	$email2 = strip_tags($_POST['reg_email2']);
	//Removes uncessary spaces
	$email2 = str_replace('', '', $email2);
	//Stores email 2 into sesssion variable
	$_SESSION['reg_email2'] = $email2;


	//Password
	//Strip tags - removes any broken input e.g. html tags 
	$password = strip_tags($_POST['reg_password']);

	//Password 2
	$password2 = strip_tags($_POST['reg_password2']);

	//Date
	//Gets the current date
	$date = date("Y-m-d"); 

	//To check if emails match
	if($email == $email2) {

		//This check ensures that the email has a dot com
		//address at the end of it
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

			//Ensures that the validated email form is used
			$email = filter_var($email, FILTER_VALIDATE_EMAIL);

			//Check if the email already exists
			$e_check = mysqli_query($con,"SELECT email FROM users WHERE email = '$email'");

			//Count the number of rows returned
			$num_rows = mysqli_num_rows($e_check);

			//If the number of emails that exist isn't zero
			if($num_rows > 0) {
				array_push($error_array,"Email already in use<br>");
			}
		}
		else {
			array_push($error_array,"Invalid email format<br>");
		}
	}
	//Else if the emails dont match
	else{
		array_push($error_array,"Emails don't match<br>");
	}

	//If the number of characters in first name isn't in the ranges
	if(strlen($fname) > 25 || strlen($fname) < 2) {
		array_push($error_array,"Your first name must be between 2 and 25 characters<br>");
	}

	//If the number of characters in first name isn't in the ranges
	if(strlen($lname) > 25 || strlen($lname) < 2) {
		array_push($error_array,"Your last name must be between 2 and 25 characters<br>");
	}

	//Checks to see if passwords match
	if($password != $password2) {
		array_push($error_array,"Passwords do not match<br>");
	}

	//Checks for letters or numbers in password
	else{
		if(preg_match('/[^A-Za-z0-9]/', $password)){
			array_push($error_array,"Your password can only contain english characters or numbers<br>");
		}
	}

	//Checks if password is between the ranges specified
	if(strlen($password) > 30 || strlen($password) < 5) {
		array_push($error_array, " Your password must be between 5 and 30 characters<br>");
	}

	//Encrpyts password before sending it to the password
	if(empty($error_array)) {
		$password = md5($password);

		//Generate username by concatenating first name and last name
		$username = strtolower($fname . "_" . $lname);
		$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");

		//if username exists add number to username
		$i = 0; 
		while(mysqli_num_rows($check_username_query) != 0) {
			//Add 1 to i
			$i++; 
			$username = $username.$i;
			$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
		}

		//Profile picture assignment
		//Creates a random number between 1 and 2
		$rand = rand(1,2); 

		if($rand == 1) {
			$profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
		} else if ($rand == 2) {
			$profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";
		}
		
		$query = mysqli_query($con, "INSERT INTO users VALUES ('','$fname','$lname','$username','$email','$password','$date','$profile_pic','0','0','no',',')");

		array_push($error_array, "<span style='color: #14C800'> You're are all set! Login is avaliable!</span><br>");

		//Clear session variable
		$_SESSION['reg_fname'] = "";
		$_SESSION['reg_lname'] = "";
		$_SESSION['reg_email'] = "";
		$_SESSION['reg_email2'] = "";
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

	<!--Note that some inputs also a value property; this makes it so that any fields that were entered correctly, do not disappear when the page is refreshed-->

		<form action"register.php" method="POST">

			<input type="text" name="reg_fname" placeholder="First Name" value = 
			"<?php if(isset($_SESSION['reg_fname'])) {
				echo $_SESSION['reg_fname'];
			}
			?>" required>
			<br>
			<?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "Your first name must be between 2 and 25 characters<br>"; ?>

			<input type="text" name="reg_lname" placeholder="Last Name" value = 
			"<?php if(isset($_SESSION['reg_lname'])) {
				echo $_SESSION['reg_lname'];
			}
			?>"required>
			<br>
			<?php if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) echo "Your last name must be between 2 and 25 characters<br>"; ?>
			
			<input type="email" name="reg_email" placeholder="Email" value = 
			"<?php if(isset($_SESSION['reg_email'])) {
				echo $_SESSION['reg_email'];
			}
			?>"required>
			<br>

			<input type="email" name="reg_email2" placeholder="Confirm Email" value = 
			"<?php if(isset($_SESSION['reg_email2'])) {
				echo $_SESSION['reg_email2'];
			}
			?>"required>
			<br>
			<?php if(in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>"; 
			else if(in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>";
			else if(in_array("Emails don't match<br>", $error_array)) echo "Emails don't match<br>"; ?>


			<input type="password" name="reg_password" placeholder="Password" required>
			<br>
			<input type="password" name="reg_password2" placeholder="Confirm Password" required>
			<br>
			<?php if(in_array("Passwords do not match<br>", $error_array)) echo "Passwords do not match<br>"; 
			else if(in_array("Your password can only contain english characters or numbers<br>", $error_array)) echo "Your password can only contain english characters or numbers<br>";
			else if(in_array(" Your password must be between 5 and 30 characters<br>", $error_array)) echo " Your password must be between 5 and 30 characters<br>"; ?>


			<input type="submit" name="register_button" value="Register">
			<br>

			<?php if(in_array("<span style='color: #14C800'> You're are all set! Login is avaliable!</span><br>", $error_array)) echo "<span style='color: #14C800'> You're are all set! Login is avaliable!</span><br>"; ?>


		</form>

	</body>
	</html>