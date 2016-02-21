<?php require_once("init.inc.php") ?>

<?php $title = 'Start Charge'; include("header.inc.php") ?>

<?php
try {
    $nissanConnect->startCharge();
} catch (Exception $ex) {
    die($ex->getMessage());
}
?>

<b>Start Charging</b> command<br/>
has been successfully sent to your LEAF.<br/>

<?php include("footer.inc.php") ?>
