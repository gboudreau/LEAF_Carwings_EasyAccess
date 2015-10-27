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
	'CA' => 'https://carwings.mynissan.ca/owners',
	'US' => 'https://www.nissanusa.com/owners',
);

$portal_url = $portals[strtoupper($car->country)];

define('FAN_ON', 'setHvac?fan=on');
define('FAN_OFF', 'setHvac?fan=off');
define('CAR_UPDATE', 'statusRefresh');
define('CAR_UPDATE_QUERY', 'checkev?tsp=leaf');
define('START_CHARGE', 'startCharge');

if (!@$skip_login) {
	// Keep cookies for 29 minutes
	$s = @stat(getCookieFile());
	if ($s['mtime'] < time()-(29*60)) {
		@unlink(getCookieFile());
		$needs_login = TRUE;
	} else {
		$needs_login = FALSE;
	}

	$referer = $portal_url . '/login';
	login();
	if (empty($car_vin)) {
		die("Login failed, or failed to find car_id in resulting page.\n");
	}
}

$referer = $portal_url . '/vehicles';

function getCookieFile() {
	global $id;
	return '/tmp/leaf-' . $id . '.cookies';
}

function login() {
	global $username, $password, $car_vin, $needs_login, $portal_url, $id;
	
	if ($needs_login) {
		$url = $portal_url . '/j_spring_security_check';
		$post_data = 'j_username=' . urlencode($username) . '&j_password=' . urlencode($password) . '&ReturnUrl=';
		curl_query($url, $post_data);
	}

	// Get car_id
	$car_vin = @file_get_contents("/tmp/.car_vin-" . $id);
	if (empty($car_vin)) {
		$result = curl_query($portal_url . '/vehicles');
		if (preg_match('@<span class="vin">VIN:\s*([A-Z0-9]+)</span>@', $result, $regs)) {
			$car_vin = $regs[1];
			file_put_contents("/tmp/.car_vin-" . $id, $car_vin);
		} else {
			die("Can't find car_id in result:\n$result\n");
		}
	}
}

function execute_command($cmd, $post_data=null) {
	global $car_vin, $portal_url;
	if (strpos($cmd, '?') !== FALSE) {
		$cmd .= '&';
	} else {
		$cmd .= '?';
	}
	$url = $portal_url . '/leaf/' . $cmd . 'vin=' . $car_vin;
	return curl_query($url, $post_data);
}

function curl_query($url, $post_data=null) {
	global $referer;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_ENCODING , "gzip,deflate");
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_COOKIEJAR, getCookieFile());
	curl_setopt($ch, CURLOPT_COOKIEFILE, getCookieFile());

	// Fake headers
	$custom_headers = array();
	$host = substr($url, strpos($url, '/')+2);
	$host = substr($host, 0, strpos($host, '/'));
	$custom_headers[] = "Host: $host";
	$custom_headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.16 Safari/537.36";
	$custom_headers[] = "Accept: */*";
	$custom_headers[] = "Accept-Language: en-US,en;q=0.8,fr;q=0.6";
	if ($referer != null) {
		$custom_headers[] = "Referer: $referer";
	}
	$custom_headers[] = "Cache-Control: max-age=0";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $custom_headers);

	if ($post_data !== null) {
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
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
        <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>
		<style>
		    .on{color:green}
		    .off{color:red}
            .ui-header .ui-title {
                margin: 15px;
            }
        </style>
	</head>
	<div data-role="page">
	    <div data-role="header"><h1><?php echo htmlentities($title) ?></h1></div>
	    <div data-role="content">
	<?php
}

function footer() {
	?>
	</div>
	</body>
	</html>
	<?php
}

