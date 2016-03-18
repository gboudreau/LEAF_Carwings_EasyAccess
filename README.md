LEAF Carwings One-Click Shortcuts
=================================

![LEAF One-Click mini site](http://cl.ly/242W3k361n2U/leaf-one-click.gif "LEAF One-Click mini site")

Requirements
------------
* A webserver with PHP
* The cURL PHP extension enabled
* The mcrypt PHP extension enabled

Installation Instructions
-------------------------
Copy everything (including the hidden .htaccess file!) into a directory on your web server.
Let's say it's accessible from http://www.your_domain.com/leaf/

Edit your httpd.conf; make sure the directory on your web server has AllowOverride FileInfo or AllowOverride All, to allow the .htaccess file to do it's job.

Edit config.inc.php:

1. Generate a new GUID (using [this tool]() for example), and replace the \_your\_guid\_here\_ string with this new GUID.

2. Change the country as necessary.

3. Enter your Carwings username and password.

You're done.

You can now access the one-click shortcuts using the index page at http://www.your_domain.com/leaf/?id=_your_guid_here_
