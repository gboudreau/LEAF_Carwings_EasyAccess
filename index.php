<?php
$skip_login = TRUE;
require_once("functions.inc.php");

_header('LEAF - Carwings Quick Access URLs');
?>

<h2>LEAF - Carwings Quick Access URLs</h2>

<ul>
	<li><a href="on?id=<?php echo $id?>">Climate Control ON</a></li>
	<li><a href="off?id=<?php echo $id?>">Climate Control OFF</a></li>
	<li><a href="charge?id=<?php echo $id?>">Start Charging</a></li>
	<!--li><a href="stop_charge?id=<?php echo $id?>">Stop Charging</a></li-->
	<li><a href="status?id=<?php echo $id?>">Status Update</a></li>
</ul>
