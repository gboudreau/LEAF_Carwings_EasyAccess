<?php
require_once('nissan-connect-php/NissanConnect.class.php');
require_once('config.inc.php');

if (empty($_GET['id'])) {
    die("You must specify your personal ID in the URL parameters.");
}
$id = $_GET['id'];

$car = @$cars[$id];
if (empty($car)) {
    die("Invalid (unknown) personal ID.");
}

if (empty($car->tz)) {
    $car->tz = 'Canada/Eastern';
}

$nissanConnect = new NissanConnect($car->username, $car->password, $car->tz, $car->country);
$nissanConnect->debug = TRUE;
