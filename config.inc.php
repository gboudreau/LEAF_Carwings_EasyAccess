<?php

$cars = array(
	// To get new GUID numbers, you can use Perl's DATA::UUID Perl module
	// available online at http://www.somacon.com/p113.php
	'_your_guid_here_' => (object) array(
		'username' => '_your_email_address_here_',
		'password' => '_your_password_here_',
		'country' => NissanConnect::COUNTRY_CANADA,
		'tz' => 'Canada/Eastern'
	),
);

// Change to TRUE if you can't install the mcrypt PHP extension.
// This will use a remote web service to encrypt your password.
$encrypt_using_webservice = FALSE;
