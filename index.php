<?php require_once("init.inc.php") ?>

<?php $title = 'One-Click LEAF Controls'; include("header.inc.php") ?>

<ul data-role="listview" data-inset="true">
	<li><a href="on.php?id=<?php echo $id ?>" data-rel="dialog" data-transition="flow">Climate Control <span class="on">ON</span></a></li>
	<li><a href="off.php?id=<?php echo $id ?>" data-rel="dialog" data-transition="flow">Climate Control <span class="off">OFF</span></a></li>
	<li><a href="charge.php?id=<?php echo $id ?>" data-rel="dialog" data-transition="flow">Start Charging</a></li>
	<li><a href="status.php?id=<?php echo $id ?>" data-rel="dialog" data-transition="flow">Status Update</a></li>
    <li><a href="status.php?id=<?php echo $id ?>&cached=y" data-rel="dialog" data-transition="flow">Last Known Status</a></li>
</ul>

<?php include("footer.inc.php") ?>
