muckrake
========

snmptt web gui

### install
1. Configure SNMPTT to insert traps into a mysql db per instructions here: http://snmptt.sourceforge.net/docs/snmptt.shtml#LoggingDatabase-MySQL
   I used type "text" instead of varchar for formatline
   For unknown trap details to display properly, you also need to add an 'id' column to the snmptt_unknown table.  If the table is already created, you can do:
     "ALTER TABLE snmptt_unknown ADD COLUMN id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY first;"
2. Place muckrake files in a web accessible directory
3. Update db.php w/ proper credentials and hostname.  Make sure host running muckrake has at least SELECT permissions
4. Load index.php
