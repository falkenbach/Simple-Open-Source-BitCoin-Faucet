<?php
mysql_connect(MYSQLHOST, MYSQLUSERNAME, MYSQLPASSWORD) or die(mysql_error());
mysql_select_db(MYSQLDATABASE) or die(mysql_error());
?>