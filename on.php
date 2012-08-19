<?php
require_once("functions.inc.php");

_header('Climate ON');

$result = execute_command(FAN_ON);
if ($result !== 'true') {
	die("Fan ON failed: $result\n");
}

#$using_query = FAN_QUERY;
#include("status.php");
?>

<b>Climate control <span class="on">ON</span></b> command<br/>
has been successfully sent to your LEAF.<br/>
<br/>
<?php if (!isset($_GET['book'])): ?>
    <a href="#" onclick="window.location.href='/on.php?book=y&amp;id=<?php echo $_GET['id'] ?>';return false;">Bookmark this page</a>
<?php endif; ?>

<?php footer() ?>
