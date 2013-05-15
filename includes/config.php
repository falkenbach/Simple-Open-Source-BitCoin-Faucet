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

define("GUID", "");
define("FIRSTPASSWORD", "");
define("SECONDPASSWORD", "");
define("FAUCETADDRESS", "");
define("MINIMUMTRANSACTION", "1");

define("FAUCETAMOUNTINBTC", "0.00001");
define("FAUCETAMOUNTINSATOSHI", 1000);

define("MINIMUMPAYOUTREQUEST", 50);
define("PRICEWINTIME", 3); 
define("NOTEMESSAGE", "BitCoin Information Faucet");
/* 
   Note's won't be send with the payment at the moment. You can add it if you like. 
   Just add &note=".NOTEMSSAGE." to the blockchain url in the "Job.php" file/   
*/

define("MINRANDOMNUMBER", 1);
define("MAXRANDOMNUMBER", 100);
define("BELOWNUMBER", 10);

define("MYSQLHOST", "");
define("MYSQLUSERNAME", "");
define("MYSQLPASSWORD", "");
define("MYSQLDATABASE", "");
define("MYSQLBTCTABLE", "freebtc");
define("MYSQLINFORMATIONTABLE", "informations");

define("RECAPTCHAPUBLICKEY", "");
define("RECAPTCHAPRIVATEKEY", "");

define("DONATEADDRESS", "1CBYvv61QrdLJcr14oXZwiN3hKGgSAARCN");
?>