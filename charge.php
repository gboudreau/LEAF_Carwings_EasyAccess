<?php
require_once("functions.inc.php");

_header('Start Charge');

$result = execute_command(START_CHARGE);
if ($result !== 'true') {
	die("Charge Start failed: $result\n");
}
?>

<b>Start Charging</b> command<br/>
has been successfully sent to your LEAF.<br/>
<br/>
<?php if (!isset($_GET['book'])): ?>
    <a href="#" onclick="window.location.href='/charge.php?book=y&amp;id=<?php echo $_GET['id'] ?>';return false;">Bookmark this page</a>
<?php endif; ?>

<?php footer() ?>
