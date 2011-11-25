<?php
require_once('config.inc.php');

if (empty($_GET['id'])) {
	die("Your URL is missing your personal ID.");
}
$id = $_GET['id'];

$car = $cars[$id];
if (empty($car)) {
	die("Invalid (inexistent) personal ID.");
}

$username = $car->username;
$password = $car->password;

$portals = array(
	'CA' => 'https://carwings.mynissan.ca',
	'US' => 'https://www.nissanusa.com/owners',
)
$portal_url = $portals[strtoupper($car->country)];

define('FAN_ON', 'setHvac?fan=on');
define('FAN_OFF', 'setHvac?fan=off');
define('FAN_QUERY', 'pollHvac');
define('CAR_UPDATE', 'statusRefresh');
define('CAR_UPDATE_QUERY', 'pollStatusRefresh');
define('START_CHARGE', 'startCharge');
define('START_CHARGE_QUERY', 'pollStartCharge');

if (!@$skip_login) {
	// Keep cookies for 29 minutes
	$s = stat(getCookieFile());
	if ($s['mtime'] < time()-(29*60)) {
		unlink(getCookieFile());
		$needs_login = TRUE;
	} else {
		$needs_login = FALSE;
	}

	$referer = $portal_url . '/login';
	login();
	if (empty($car_id)) {
		die("Login failed, or failed to find car_id in resulting page.\n");
	}
}

$referer = $portal_url . '/vehicles';

function getCookieFile() {
	global $id;
	return '/tmp/leaf-' . $id . '.cookies';
}

function login() {
	global $username, $password, $car_id, $needs_login, $portal_url;
	
	if ($needs_login) {
		$url = $portal_url . '/j_spring_security_check';
		$post_data = 'j_username=' . urlencode($username) . '&j_passwordHolder=Password&j_password=' . urlencode($password) . '&owners_remember_me=on';
		curl_query($url, $post_data);
	}

	// Get car_id
	$car_id = (int) file_get_contents(".car_id-" . $id);
	if (empty($car_id)) {
		$result = curl_query($portal_url . '/vehicles');
		if (preg_match('@<div class="vehicleHeader" id="([0-9]*)">@', $result, $regs)) {
			$car_id = $regs[1];
			file_put_contents(".car_id-" . $id, $car_id);
		} else {
			die("Can't find car_id in result:\n$result\n");
		}
	}
}

function execute_command($cmd, $logged_id=FALSE) {
	global $car_id;
	if (strpos($cmd, '?') !== FALSE) {
		$cmd .= '&';
	} else {
		$cmd .= '?';
	}
	$url = $portal_url . '/vehicles/' . $cmd . 'id=' . $car_id . '&rand=' . rand(0, 2) . mt_rand();
	return curl_query($url);
}

function curl_query($url, $post_data=null) {
	global $referer;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_ENCODING , "gzip,deflate");
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_COOKIEJAR, getCookieFile());
	curl_setopt($ch, CURLOPT_COOKIEFILE, getCookieFile());

	// Fake headers
	$custom_headers = array();
	$host = substr($url, strpos($url, '/')+2);
	$host = substr($host, 0, strpos($host, '/'));
	$custom_headers[] = "Host: $host";
	$custom_headers[] = "User-Agent: Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; en-US; rv:1.8.1.4) Gecko/20070531 Firefox/2.0.0.4";
	$custom_headers[] = "Accept: image/png,*/*;q=0.5";
	$custom_headers[] = "Accept-Language: en-ca,en-us;q=0.8,en;q=0.6,fr-ca;q=0.4,fr;q=0.2";
	$custom_headers[] = "Accept-Charset: UTF-8,*";
	$custom_headers[] = "Keep-Alive: 300";
	$custom_headers[] = "Connection: keep-alive";
	if ($referer != null) {
		$custom_headers[] = "Referer: $referer";
	}
	$custom_headers[] = "Cache-Control: max-age=0";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $custom_headers);

	if (!empty($post_data)) {
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	}

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($ch);
	if ($result === FALSE) {
		die("Error during request to $url: " . curl_error($ch) . "\n");
	}
	curl_close($ch);
	
	return $result;
}

$has_header = FALSE;
function _header($title) {
	global $has_header;
	$has_header = TRUE;
	?><html>
	<head>
		<title><?php echo htmlentities($title) ?></title>
		<link rel="icon" sizes="48x48" type="image/png" href="/favicon.png"/>
		<!--[if IE]>
		<link rel="shortcut icon" href="/favicon.ico"/>
		<![endif]-->
		<link rel="apple-touch-icon-precomposed" href="/apple-touch-icon.png"/>
		<link rel="apple-touch-icon-precomposed" sizes="57x57" href="/apple-touch-icon-57x57.png"/>
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/apple-touch-icon-72x72.png"/>
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/apple-touch-icon-114x114.png"/>
		<link rel="icon" sizes="57x57" type="image/png" href="/apple-touch-icon-57x57.png"/>
		<link rel="icon" sizes="72x72" type="image/png" href="/apple-touch-icon-72x72.png"/>
		<link rel="icon" sizes="114x114" type="image/png" href="/apple-touch-icon-114x114.png"/>
		<style type="text/css">body{font-family:Georgia,Helvetica,Arial}.on{color:green}.off{color:red}.charge_220{padding-left:90px}.range_wclimate{padding-left:50px}</style>
		<style type="text/css" media="only screen and (max-device-width: 480px)">body{font-size:4em}</style>
	</head>
	<body>
	<?php
}

function footer() {
	?>
	</body>
	</html>
	<?php
}
?>
