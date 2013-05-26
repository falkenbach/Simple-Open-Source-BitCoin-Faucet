	<?php
/*
	Copyright (C) 2013 BitCoin Information (bitcoininformation.appspot.com)
	This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

error_reporting(0);
((is_null($mysql_error = mysqli_close($GLOBALS["mysql_connection"]))) ? false : $mysql_error);
($GLOBALS["mysql_connection"] = mysqli_connect(MYSQLHOST,  MYSQLUSERNAME,  MYSQLPASSWORD)) or die("The server is currently overloaded. Please try again later.");
((bool)mysqli_query($GLOBALS["mysql_connection"], "USE " . constant('MYSQLDATABASE'))) or die("The server is currently overloaded. Please try again later.");
?>