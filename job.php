<!--
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
-->

<?php
include("includes/config.php");
    try{
		$json = file_get_contents("https://blockchain.info/nl/merchant/".GUID."/address_balance?password=".FIRSTPASSWORD."&address=".FAUCETADDRESS."&confirmations=".MINIMUMTRANSACTION."");
		$data = json_decode($json);
		if($data->{'balance'}/100000000 > 0.01){
			include("includes/mysql.php");		
			$result = mysql_query("SELECT address FROM ".MYSQLBTCTABLE."") or die(mysql_error());
			$currentpayrequests = 0;
				while($row = mysql_fetch_array($result)) 
				{
					$currentpayrequests++;
				} 
			if($currentpayrequests >= MINIMUMPAYOUTREQUEST){
				$arr = null;
				$result = mysql_query("SELECT address, pricewin FROM ".MYSQLBTCTABLE." ORDER BY id LIMIT ".MINIMUMPAYOUTREQUEST." OFFSET 1") or die(mysql_error());;
				if(mysql_fetch_array($result) != null){
					$totalpricewins = 0;
					while($row = mysql_fetch_array($result)) 
					{
						if($row['pricewin'] == "0"){
							$arr[$row['address']] = FAUCETAMOUNTINSATOSHI;
						}else{
							$arr[$row['address']] = (FAUCETAMOUNTINSATOSHI * PRICEWINTIME);
							$totalpricewins++;
						}
					} 
					$recipients = urlencode(json_encode($arr));
					if($recipients == null || $recipients == ""){
						echo "Problem with recipients";
					}else{
						if(SECONDPASSWORD == ""){
						echo "No second password<br />";
							$json_url = "https://blockchain.info/nl/merchant/".GUID."/sendmany?password=".FIRSTPASSWORD."&note=".NOTEMESSAGE."&recipients=$recipients";
						}else{
							$json_url = "https://blockchain.info/nl/merchant/".GUID."/sendmany?password=".FIRSTPASSWORD."&second_password=".SECONDPASSWORD."&note=".NOTEMESSAGE."&recipients=$recipients";
						}
						$json_data = file_get_contents($json_url);
						$json_feed = json_decode($json_data);
						echo $json_feed->{'message'};
						echo $json_feed->{'error'};
						if($json_feed->{'error'} == null){
							$result = mysql_query("SELECT payments, pricewins FROM ".MYSQLINFORMATIONTABLE." ORDER BY datetime DESC LIMIT 1");
							while($row = mysql_fetch_array($result)){
								//Update the faucet information
								mysql_query("INSERT INTO ".MYSQLINFORMATIONTABLE." (id,datetime,payments,pricewins)VALUES (NULL,'".date("Y-m-d H:i:s")."',  '". ($row['payments'] + 1)."',  '". ($row['pricewins'] + $totalpricewins )."')");
							}											
							mysql_query("TRUNCATE TABLE ".MYSQLBTCTABLE.";");
							// This is a know bug. The payout script doesn't work with the first row. That is why there is a OFFSET 1. This line is needed howewer. //
							mysql_query("INSERT INTO ".MYSQLBTCTABLE." (id,address,ip) VALUES ( '', 'randomaddress', '127.0.0.1' )")or die(mysql_error());
							// ------------------------- //
							echo "<br />Cleared table";
						}
					}
				}else{
					echo "Nobody to give BTC too.";
				}
			}else{
				echo "Too less requests to cashout.";
			}
			mysql_close();
		}else{
			echo "Not enough BTC to payout.";
		}
	}catch (Exception $e) {
		echo "Something went wrong.";
	}
?>