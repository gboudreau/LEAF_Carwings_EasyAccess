<?php require_once("init.inc.php") ?>

<?php $title = 'Climate OFF'; include("header.inc.php") ?>

<?php
try {
    $nissanConnect->stopClimateControl();
} catch (Exception $ex) {
    die($ex->getMessage());
}
?>

<b>Climate control <span class="off">OFF</span></b> command<br/>
has been successfully sent to your LEAF.<br/>

<?php include("footer.inc.php") ?>
