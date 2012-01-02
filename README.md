LEAF Carwings One-Click Shortcuts
=================================

Requirements
------------
* A webserver with PHP
* The cURL PHP extension enabled

Installation Instructions
-------------------------
Copy everything (including the hidden .htaccess file!) into a directory on your web server.
Let's say it's accessible from http://www.your_domain.com/leaf/

Edit config.inc.php:

1. Generate a new GUID (using [this tool]() for example), and replace the \_your\_guid\_here\_ string with this new GUID.

2. Change the country as necessary (only tested with CA for now; US should work too, but untested).

3. Enter your Carwings username and password.

You're done.

You can now access the one-click shortcuts using the index page at http://www.your_domain.com/leaf/?id=_your_guid_here_
