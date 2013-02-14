<?php
require("/var/www/mitmunc/include/functions.php");
connectDatabase();

$school = new school($_POST['schoolId']);
$school->getUsers();
$school->schoolName = $_POST['schoolName'];
$school->numStudents = sanitizeValue($_POST['numStudents']);
$school->numAdvisers = sanitizeValue($_POST['numAdvisers']);
$school->address['1'] = $_POST['address1'];
$school->address['2'] = $_POST['address2'];
$school->address['city'] = $_POST['city'];
$school->address['state'] = $_POST['state'];
$school->address['zip'] = $_POST['zip'];
$school->address['countryId'] = sanitizeValue($_POST['countryId']);
$school->saveInfo();

$user = new user($_POST['userId']);

$user->realName = $_POST['contactName'];
$user->email = $_POST['email'];
$user->phoneNumber = $_POST['phoneNumber'];
$user->saveInfo();

$school = new school($_POST['schoolId']);
$school->getUsers();
$user = new user($_POST['userId']);

require("/var/www/mitmunc/include/registration_change_form.php");

?>
