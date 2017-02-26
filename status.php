<?php require_once("init.inc.php") ?>

<?php $title = 'LEAF Status'; include("header.inc.php") ?>

<?php
$option = isset($_GET['cached']) ? NissanConnect::STATUS_QUERY_OPTION_CACHED : NissanConnect::STATUS_QUERY_OPTION_NONE;
try {
    $result = $nissanConnect->getStatus($option);
} catch (Exception $ex) {
    die($ex->getMessage());
}
?>

Battery: <?php echo "$result->BatteryRemainingAmount/12 (" . round($result->BatteryRemainingAmount*100.0/12) . "%)" ?><br/>
<hr/>

Plugged in: <?php echo ($result->PluggedIn ? '<span class="on">YES</span>' : '<span class="off">NO</span>') ?><br/>
Charging: <?php echo ($result->Charging ? '<span class="on">YES</span>' : '<span class="off">NO</span>') ?><br/>
Charge Time:<br/>
<?php if (!empty($result->TimeRequiredToFull->Formatted)): ?>
	<span class="charge_trickle">Trickle (120v): <?php echo $result->TimeRequiredToFull->Formatted ?><br/></span>
<?php endif; ?>
<?php if (!empty($result->TimeRequiredToFull200->Formatted)): ?>
    <span class="charge_220">Normal (240v) 3.6 kW: <?php echo $result->TimeRequiredToFull200->Formatted ?><br/></span>
<?php endif; ?>
<?php if (!empty($result->TimeRequiredToFull200_6kW->Formatted)): ?>
    <span class="charge_220_66">Normal (240v) 6.6 kW: <?php echo $result->TimeRequiredToFull200_6kW->Formatted ?><br/></span>
<?php endif; ?>
<hr/>

Climate control: <?php echo ($result->RemoteACRunning ? '<span class="on">ON</span>' : '<span class="off">OFF</span>') ?><br/>
<hr/>

Range:
<?php echo round($result->CruisingRangeAcOff) . ' ' . $result->CruisingRangeUnit ?><br/>
<span class="range_wclimate">(-<?php echo round($result->CruisingRangeAcOff - $result->CruisingRangeAcOn) . ' ' . $result->CruisingRangeUnit ?> w/climate control)<br/>
<hr/>

Last Updated: <?php echo $result->LastUpdated ?><br/>
<hr/>

<?php include("footer.inc.php") ?>
