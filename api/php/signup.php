<?php

// do not delete this line, this need to be there in order to get the data angular sends
$_POST = json_decode(file_get_contents('php://input'), true);

// working fields
$_POST['emailId'];
$_POST['title'];
$_POST['firstName'];
$_POST['lastName'];
$_POST['companyName'];
$_POST['designation'];
$_POST['country'];
$_POST['countryCode'];
$_POST['phoneNo'];


?>
