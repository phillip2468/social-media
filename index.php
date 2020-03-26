<?php
$con = mysqli_connect("localhost","root","","social");

if(mysqli_connect_errno()) {
	echo "Failed to connect:".mysqli_connect_errno();
}

$query = mysqli_query($con,"INSERT INTO test VALUES(NULL,'Phillip')");
?>
<!DOCTYPE html>
<html>
<head>
	<title>SwirlFeed</title>
</head>
<body>
Hello Phillip !!!
</body>
</html>