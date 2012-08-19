<?php
$skip_login = TRUE;
require_once("functions.inc.php");

_header('One-Click LEAF Controls');
?>

<ul data-role="listview" data-inset="true">
	<li><a href="on.php?id=<?php echo $id?>" data-rel="dialog" data-transition="flow">Climate Control <span class="on">ON</span></a></li>
	<li><a href="off.php?id=<?php echo $id?>" data-rel="dialog" data-transition="flow">Climate Control <span class="off">OFF</span></a></li>
	<li><a href="charge.php?id=<?php echo $id?>" data-rel="dialog" data-transition="flow">Start Charging</a></li>
	<li><a href="status.php?id=<?php echo $id?>" data-rel="dialog" data-transition="flow">Status Update</a></li>
</ul>

<?php footer() ?>
