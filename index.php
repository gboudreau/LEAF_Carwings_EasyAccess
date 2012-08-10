<?php
$skip_login = TRUE;
require_once("functions.inc.php");

_header('One-Click LEAF Controls');
?>

<ul data-role="listview" data-inset="true">
	<li><a href="on?id=<?php echo $id?>" data-rel="dialog" data-transition="flow">Climate Control <span class="on">ON</span></a></li>
	<li><a href="off?id=<?php echo $id?>" data-rel="dialog" data-transition="flow">Climate Control <span class="off">OFF</span></a></li>
	<li><a href="charge?id=<?php echo $id?>" data-rel="dialog" data-transition="flow">Start Charging</a></li>
	<!--li><a href="stop_charge?id=<?php echo $id?>">Stop Charging</a></li-->
	<li><a href="status?id=<?php echo $id?>" data-rel="dialog" data-transition="flow">Status Update</a></li>
</ul>

<?php footer() ?>
