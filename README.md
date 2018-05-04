# WatchDog

## Live Version
A live version of the interface with some example scans is available at:
https://connorlake.com/watchdog
Log in with username "test@test.com" and password "test"

## Setup

To set up this project, install on a web server with PHP and MySQL installed.
Next set up the database structure as specified in the watchdog.sql file.

## Usage
### Scanning
Included in the file is a script called scanner.py
Run this, and the script will go through each network under the `networks` table and scan everything under a /24 network (TODO add support for all CIDR notation).
It will then populate the database with a new scan, and any nodes and open ports it finds.

### Web Platform
The web platform is set up to browse a single scan at a time.  Each time a user clicks a scan, all the data is reloaded with data sepecific to that scan.  Note that the only data that will presist over all scan is which IP addresses that are being watched.
To watch or unwatch an ip address, click on the button with the eye in the Machines content box.  If the eye is open, the system is currently watching that ip.  So every scan if the system notices an increase in the number of open ports, it will send an alert to the user with a predefined command in scanner.py


