<?php
require_once("functions.inc.php");

$needs_footer = FALSE;
if (!$has_header) {
	_header('LEAF Status');
	$needs_footer = TRUE;
}

$referer = "$portal_url/leaf/checkev?vin=$car_vin&tsp=leaf";
$result = execute_command(CAR_UPDATE, array()); // Is a POST, with no data...
if ($result !== 'true') {
	die("Status Update failed: $result\n");
}

$result = execute_command(CAR_UPDATE_QUERY);

// $result is now HTML, not JSON anymore; boo!
//$json = json_decode($result);

$doc = new DOMDocument();
$doc->loadHTML($result);

$json = array();
$tags = $doc->getElementsByTagName('input');
foreach ($tags as $tag) {
    $name = (string) $tag->getAttribute('name');
    $value = (string) $tag->getAttribute('value');
    if (isset($json[$name])) continue;
    $json[$name] = $value;
    if ($name == 'hvacIn') {
        $json[$name] = ( $value === 'true' );
    }
}
$json = (object) $json;

/*
{
    "vehicleId": "76",
    "vin": "JN1AZ0CP2BT003697",
    "lang": "en",
    "VIN": "JN1AZ0CP2BT003697",
    "statusdate": "9",
    "btryLvlNb": "9",
    "teleCode": "C",
    "chargingStsCd": "NOT_CHARGING",
    "chrgrCnctdCd": "0",
    "chrgTm": "3 hrs 0 min ",
    "chrgTm220KVTx": "1 hrs 30 min ",
    "rmngChrg220KvChrgrTx": "",
    "nickname": "MyLeaf",
    "chargeTime": "2015-10-23 19:33:03.0",
    "refreshMsg1": "Status Refresh : Request Failed. Please try again later.",
    "refreshMsg2": "Status Refresh : Request Failed. Your request to status refresh timed out communicating to the vehicle. Please try your request again.<br> Also ensure your vehicle is located in an area with cellular reception and it has been driven with the last 14 days.",
    "refreshMsg3": "Status Refresh : Request Failed.<br\/>There was a problem detected executing the status refresh request. Please try your request again.",
    "chargingMsg1": "successfully began charging at",
    "chargingMsg2": "Start Charge Request Failed. Please try again later.",
    "chargingMsg3": "Start Charge : Request Failed. Your request to start charging timed out communicating to the vehicle. Please try your request again.<br> Also ensure your vehicle is located in an area with cellular reception and it has been driven with the last 14 days.",
    "chargingMsg4": "Start Charge : Request Failed.<br\/>There was a problem detected executing the start charge request. Please try your request again.",
    "rngHvacOffNb": "107712",
    "rngHvacOnNb": "87120",
    "hvacIn": false,
    "my11215": "2011",
    "acerror": "Climate Control: Request Failed<br\/>There was a problem detected executing the climate control request. Please try your request again.",
    "acewa": "Climate Control: Request Failed<br\/>There was a problem detected communicating with the vehicle. Please try your request again. Also ensure your vehicle is located in an area with cellular reception and it has been driven with the last 14 days.",
    "tmrcntrlon": "TURN ON CLIMATE CONTROL",
    "tmrcntrloff": "TURN OFF CLIMATE CONTROL",
    "dspclmtecntron": "km with climate control ON",
    "dspclmtecntroff": "km with climate control OFF",
    "nocblcnted": "Charge cable not connected",
    "qckchrgcbl": "Quick charge cable connected",
    "rpdchrgbtn": "Rapid Charging",
    "normalchrgbtn": "Charge cable connected",
    "normchrgmode": "Charging (Normal)",
    "trklchrgmode": "Charging (Trickle)",
    "rapidchrgmode": "Charging (Quick)",
    "msg1": "Set Climate Control Timer : Request Failed<br\/>There was a problem detected executing the set climate control timer request. Please try your request again. ",
    "msg2": "views.statuspage.timer.msg2",
    "msg3": "Climate Control Set to turn on:"
}
*/

if ($json === FALSE) {
	die("Query result failed to parse as JSON. Result: $result\n");
} else {
	?>
	
	Battery: 
		<?php echo "$json->btryLvlNb/12 (" . number_format($json->btryLvlNb/12*100, 0) . "%)" ?><br/>
	<hr/>

	Plugged in: 
		<?php echo ($json->chrgrCnctdCd == 1 ? '<span class="on">YES</span>' : '<span class="off">NO</span>') ?><br/>
	Charging: 
		<?php echo ($json->chargingStsCd == 'NOT_CHARGING' ? '<span class="off">NO</span>' : '<span class="on">YES</span>') ?><br/>
	Charge Time:
		<?php echo $json->chrgTm ?> (trickle)<br/>
		<?php if ($json->chrgTm220KVTx): ?>
			<span class="charge_220">(<?php echo $json->chrgTm220KVTx ?> w/fast charge)</span><br/>
		<?php endif; ?>
	<hr/>
	
	Climate control:
		<?php echo ($json->hvacIn ? '<span class="on">ON</span>' : '<span class="off">OFF</span>') ?><br/>
	<hr/>

	Range: 
		<?php
		if (strtoupper($car->country) == 'US') {
			$units = 'miles';
			$range['HvacOff'] = number_format($json->rngHvacOffNb*0.000621371192, 0);
			$range['HvacOn'] = number_format($json->rngHvacOnNb*0.000621371192, 0);
		} else {
			$units = 'km';
			$range['HvacOff'] = number_format($json->rngHvacOffNb/1000, 0);
			$range['HvacOn'] = number_format($json->rngHvacOnNb/1000, 0);
		}
		?>
		<?php echo $range['HvacOff'] . ' ' . $units ?><br/>
		<span class="range_wclimate">(-<?php echo ($range['HvacOff']-$range['HvacOn']) . ' ' . $units ?> w/climate control)<br/>
	<hr/>

    <br/>
    <?php if (!isset($_GET['book'])): ?>
        <a href="#" onclick="window.location.href='/status.php?book=y&amp;id=<?php echo $_GET['id'] ?>';return false;">Bookmark this page</a>
    <?php endif; ?>

	<?php
}

if ($needs_footer) {
	footer();
}

