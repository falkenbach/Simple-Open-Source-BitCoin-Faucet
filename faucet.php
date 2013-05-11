<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>My Awesome Faucet from BitCoinInformation.Appspot.Com</title>
	<LINK HREF="stylesheet.css" REL="stylesheet" type="text/css" />
	<LINK REL="shortcut icon" type="image/x-icon" href="favicon.ico">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://blockchain.info//Resources/wallet/pay-now-button.js"></script>
  </head>
  <body>
    <div id="container">
      <div id="header">
		<h1>My Awesome Faucet from BitCoinInformation.Appspot.Com</h1>
      </div>
      <div id="content">
        <div class="inner" style="text-align:center;">
			<?php
			include("includes/config.php");
			include("includes/mysql.php");
			function form(){
			   ?>
				<form method="post" action="faucet.php">
					<fieldset>
						<table style="float:center!improtant; text-align:center!important; margin-left:auto!important;margin-right:auto!important;">
							<tr><legend>Request Payment</legend></tr>
							<tr><td>					
							<?php
								  require_once('recaptchalib.php');
								  $publickey = RECAPTCHAPUBLICKEY; // you got this from the signup page
								  echo recaptcha_get_html($publickey);
							?></tr></td>
							<tr><td>
								<label for="email">Bitcoin address:</label>
								<input type="text" name="address" id="address" size="32" maxlength="128">
							</tr></td>
							<tr><td>
									<input type="submit" name="submit" id="submit" value="Submit" >
							</tr></td>
						</table>
					</fieldset>	
				 </form>
				<?php
			}	
			$result = mysql_query("SELECT address FROM ".MYSQLBTCTABLE."") or die(mysql_error());
			$currentpayrequests = 0;
				while($row = mysql_fetch_array($result)) 
				{
					$currentpayrequests++;
				}
			if($currentpayrequests !== 0){
				$currentpayrequests--; //This is to correct the bug I have later on. Do not remove if you don't know what you are doing!
			}
			$result = mysql_query("SELECT pricewin FROM ".MYSQLBTCTABLE."") or die(mysql_error());
			$pricewins = 0;
				while($row = mysql_fetch_array($result)) 
				{
					if($row['pricewin'] == "1"){
					$pricewins++;}
				}
			$result = mysql_query("SELECT payments, pricewins FROM informations ORDER BY datetime DESC LIMIT 1");
				while($row = mysql_fetch_array($result)) 
				{
					$payments=$row['payments'];
					$totalpricewins=$row['pricewins'];
				}
				try{	
					$data = file_get_contents("http://blockchain.info/q/addressbalance/".FAUCETADDRESS."");
				}catch(Exception $e){
					echo "Error getting the balance.";
				}
				echo "<fieldset>";
					echo "<legend>Faucet Details</legend>";
						echo "<table class='test'>";
						echo "<tr><td class='first'>Faucet Address:</td><td>" . FAUCETADDRESS . "</td></tr>";
						echo "<tr><td class='first'>Faucet Balance:</td><td>" . ($data/100000000) . " BTC</td></tr>";
						echo "<tr><td><hr class='fancy-line'></td><td><hr class='fancy-line'></td></tr>";
						echo "<tr><td class='first'>Current Payment Requests:</td><td>" . $currentpayrequests . " People</td></tr>";
						echo "<tr><td class='first'>Current Prize Wins:</td><td>" . $pricewins . " People</td></tr>";
						echo "<tr><td class='first'>This costs the Faucet:</td><td>";
						printf("%0.7f", (($currentpayrequests*FAUCETAMOUNTINSATOSHI)/100000000) + ((($pricewins*FAUCETAMOUNTINSATOSHI) * 2)/100000000));
						echo " BTC</td></tr>";
						echo "<tr><td class='first'>The new Balance will be:</td><td>" . (($data/100000000) - (($currentpayrequests*FAUCETAMOUNTINSATOSHI)/100000000) + ((($pricewins*FAUCETAMOUNTINSATOSHI) * 2)/100000000)) . " BTC</td></tr>";
						echo "<tr><td><hr class='fancy-line'></td><td><hr class='fancy-line'></td></tr>";
						echo "<tr><td class='first'>Total Payments send:</td><td><b>" . $payments . "</b></td></tr>";
						echo "<tr><td class='first'>Total Prize Wins:</td><td><b>" . ($totalpricewins + $pricewins) . "</b></td></tr>";
						echo "</table></br>";
				echo "</fieldset>";
				
				if((($data/100000000) - ($currentpayrequests*FAUCETAMOUNTINSATOSHI)/100000000) < 0.01){
				echo "<p style='margin:0px auto;padding:15px;'>The faucet is dried up, please consider donating to help the less fornunate:<br />";
			}else{
			?>
			<fieldset>
				<legend>Faucet Information</legend>
					Add your information here.
			</fieldset>
			<?php
				if (!empty($_POST['address'])){
					//Form submitted
					require_once('recaptchalib.php');
					$privatekey = RECAPTCHAPRIVATEKEY;
					$resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);

					if (!$resp->is_valid) {
						// What happens when the CAPTCHA was entered incorrectly
						echo ("<fieldset><legend>Request Payment</legend><p style='color:red;'><b>Wrong reCAPTCHA! Try again.</b></fieldset>");
						form();
					} 
					else {
						// CAPTCHA was entered correctly
						try {
							$result = mysql_query("SELECT * FROM ".MYSQLBTCTABLE." WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "' AND date = '".date("Y-m-d")."' AND time = '".date("H")."'") or die(mysql_error());
							if(mysql_fetch_array($result) !== false){
								//Already signed up for this hour. IP isn't checked you could add that if you want.
								echo ("<fieldset><legend>Request Payment</legend><p id='form' style='color:red;'><b>You already signed up. Try again after 1 hour!</b></fieldset>");
							}else{
								//Address hasn't been sumitted in this hour.
								$random = rand(MINRANDOMNUMBER, MAXRANDOMNUMBER);
								if($random >= BELOWNUMBER){
									//NO pricewin
									$run = mysql_query("INSERT INTO ".MYSQLBTCTABLE."(id, address, ip, date, time) VALUES('','" . $_POST['address'] . "','" . $_SERVER['REMOTE_ADDR'] . "', '".date("Y-m-d")."', '".date("H")."')"); 
									if ($run !== true) {
										echo "<fieldset><legend>Request Payment</legend><p id='form' style='color:red;'><b>There was a problem. Please try again.</b></fieldset>";
									}else{
										echo "<fieldset><legend>Request Payment</legend><p id='form' style='color:green;'><b>Your address has been added!</b>";
									}
								}else{
									//PRICEWIN
									$run = mysql_query("INSERT INTO ".MYSQLBTCTABLE."(id, address, ip, date, time, pricewin) VALUES('','" . $_POST['address'] . "','" . $_SERVER['REMOTE_ADDR'] . "', '".date("Y-m-d")."', '".date("H")."', '1')"); 
									if ($run !== true) {
										echo "<fieldset><legend>Request Payment</legend><p id='form' style='color:red;'><b>There was a problem. Please try again.</b></fieldset>";
									}else{
										echo "<fieldset><legend>Request Payment</legend><p id='form' style='color:green;'><b>Your address has been added!<br /><br />You ALSO won the Prize Win! Your prize will be multiplied by ".PRICEWINTIME."!</b>";
									}
								}
							}
						}
						catch (Exception $e) {
							echo "Something went wrong with the database. The faucet will be offline until this problem is fixed. Please try again later.";
							echo $e;
						}
					}
				} 
				else {
				//Form is not submitted, show the form.
					form();
				}
			}
			mysql_close();
			?>
        </div>
      </div>
	  <div id="footer">
		<fieldset>
			  <legend>Ad</legend>
				Add you ad and stuff.
		</fieldset>
	  </div>
    </div>
    Made by: <a href="http://bitcoininformation.appspot.com/">BitCoin Information</a>
  </body>
</html>	
