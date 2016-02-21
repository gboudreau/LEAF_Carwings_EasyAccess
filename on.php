<?php require_once("init.inc.php") ?>

<?php $title = 'Climate ON'; include("header.inc.php") ?>

<?php
try {
    $nissanConnect->startClimateControl();
} catch (Exception $ex) {
    die($ex->getMessage());
}
?>

<b>Climate control <span class="on">ON</span></b> command<br/>
has been successfully sent to your LEAF.<br/>

<?php include("footer.inc.php") ?>
