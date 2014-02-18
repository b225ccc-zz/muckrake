muckrake
========

snmptt web gui

### install
1. Configure SNMPTT per instructions here: http://snmptt.sourceforge.net/docs/snmptt.shtml#LoggingDatabase-MySQL
   I used type "text" instead of varchar for formatline
2. Place muckrake files in a web accessible directory
3. Update db.php w/ proper credentials and hostname.  Make sure host running muckrake has at least SELECT permissions
4. Load index.php
