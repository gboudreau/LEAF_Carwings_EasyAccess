<?php
require_once("functions.inc.php");

_header('Climate OFF');

$result = execute_command(FAN_OFF);
if ($result !== 'true') {
	die("Fan OFF failed: $result\n");
}
?>

<b>Climate control <span class="off">OFF</span></b> command<br/>
has been successfully sent to your LEAF.<br/>
<br/>
<?php if (!isset($_GET['book'])): ?>
    <a href="#" onclick="window.location.href='/off.php?book=y&amp;id=<?php echo $_GET['id'] ?>';return false;">Bookmark this page</a>
<?php endif; ?>

<?php footer() ?>
