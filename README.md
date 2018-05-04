# WatchDog

Watchdog is a web platform to manage devices on a network.  It keeps track of scans of a network and can watch certain ip addresses for additional ports opening up.

## Live Version
A live version of the interface with some example scans is available at:

https://connorlake.com/watchdog

Log in with username "test@test.com" and password "test"

![](https://i.imgur.com/DlNMo4D.png)

## Setup

To set up this project, install on a web server with PHP and MySQL installed, and drop this project in the web accessible directory.

Next set up the database structure as specified in the watchdog.sql file.  You can just directly import the SQL and it will create the database and tables.

As a final step you will need to set up a user.  Edit the users table to create a new user with a chosen username, and password hash.  In order to make it easier to generate a user hash, I have included a file "test.php" that generates the hash for the password "test".  The file is easily editable and re-runable to generate other hashes.  Note that this file should be removed for a production deployment.


## Usage

### Scanning
Included in the file is a script called scanner.py.  Run this, and the script will go through each network under the `networks` table and scan everything under a /24 network (TODO add support for all CIDR notation).

For example set base to "10.0.0." for the 10.0.0.0/24 network.

It will then populate the database with a new scan, and any nodes and open ports it finds.

### Web Platform
The web platform is set up to browse a single scan at a time.  Each time a user clicks a scan, all the data is reloaded with data specific to that scan.  Note that the only data that will presist over all scan is which IP addresses that are being watched.

To watch or unwatch an ip address, click on the button with the eye in the Machines content box.  If the eye is open, the system is currently watching that ip.  So after every scan if the system notices an increase in the number of open ports, it will send an alert to the user with a predefined command in scanner.py.  If the eye is closed with a "\" over it, the system is not watching that ip, but will still updates all changes to the number of ports open.

### Tech Stack
The backend is written in PHP and MySQL, with the frontend using Bootstrap, JQuery, and HTML/CSS.

The backend for the scanner is written in python.
