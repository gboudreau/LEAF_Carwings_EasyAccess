LEAF Carwings One-Click Shortcuts
=================================

![LEAF One-Click mini site](http://cl.ly/242W3k361n2U/leaf-one-click.gif "LEAF One-Click mini site")

Requirements
------------
* A webserver with PHP
* The cURL PHP extension enabled

Installation Instructions
-------------------------
Copy everything into a directory on your web server.
Let's say it's accessible from http://www.your_domain.com/leaf/

Edit config.inc.php:

1. Generate a new GUID (using [this tool](http://www.somacon.com/p113.php) for example), and replace the \_your\_guid\_here\_ string with this new GUID.

2. Change the country as necessary.

3. Enter your Nissan Connect username (email address) and password.

4. If you can't use the openssl_encrypt() function (very unlikely), you will need to change `$encrypt_using_webservice` to `TRUE`. **WARNING!** This will use a remote web service to encrypt your password.

You're done.

You can now access the one-click shortcuts using the index page at http://www.your_domain.com/leaf/?id=_your_guid_here_
