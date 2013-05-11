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
			if(false == false){
				try {
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
					$json = file_get_contents("https://blockchain.info/nl/merchant/".GUID."/address_balance?password=".FIRSTPASSWORD."&address=".FAUCETADDRESS."&confirmations=".MINIMUMTRANSACTION."");
					$data = json_decode($json);
					echo "<fieldset>";
						echo "<legend>Faucet Details</legend>";
							echo "<table class='test'>";
							echo "<tr><td class='first'>Faucet Address:</td><td>" . $data->{'address'} . "</td></tr>";
							echo "<tr><td class='first'>Faucet Balance:</td><td>" . ($data->{'balance'}/100000000) . " BTC</td></tr>";
							echo "<tr><td class='first'>Current Payment Requests:</td><td>" . $currentpayrequests . " People</td></tr>";
							echo "<tr><td class='first'>Current Price Wins:</td><td>" . $pricewins . " People</td></tr>";
							echo "<tr><td class='first'>This costs the Faucet:</td><td>";
							printf("%0.7f", (($currentpayrequests*FAUCETAMOUNTINSATOSHI)/100000000) + ((($pricewins*FAUCETAMOUNTINSATOSHI) * 2)/100000000));
							echo " BTC</td></tr>";
							echo "<tr><td class='first'>The new Balance will be:</td><td>" . (($data->{'balance'}/100000000) - (($currentpayrequests*FAUCETAMOUNTINSATOSHI)/100000000) + ((($pricewins*FAUCETAMOUNTINSATOSHI) * 2)/100000000)) . " BTC</td></tr>";
							echo "<tr><td class='first'>Total Payments send:</td><td><b>" . $payments . "</b></td></tr>";
							echo "<tr><td class='first'>Total Price Wins:</td><td><b>" . ($totalpricewins + $pricewins) . "</b></td></tr>";
							echo "</table></br>";
					echo "</fieldset>";
					
					
					if((($data->{'balance'}/100000000) - ($currentpayrequests*FAUCETAMOUNTINSATOSHI)/100000000) < 0.01){
						echo "<p style='margin:0px auto;padding:15px;'>The faucet is dried up, please consider donating to help the less fornunate:<br />
						<b>".FAUCETADDRESS."</b><br />
						<script>
						var CoinWidget_Config = {
							address : '".FAUCETADDRESS."',
							text : 'Donate for the Faucet',
							text_label : 'Faucet Address',
							counter : 'hide'
						};
						</script>
						<script src='http://c.coinwidget.com/widget.js'></script></p>";
					}else{
					?>
					<fieldset>
						<legend>Faucet Information</legend>
							<font style="font-family:Georgia,serif;color:#4E443C;font-variant: small-caps; text-transform: none; font-weight: 100; margin-bottom: 0;">Payout</font>
							<p /><b>Current payout is</b>: <u><?php echo FAUCETAMOUNTINBTC;?> BTC</u>.<br/>Higher payout is possible if I get more donations for the faucet.<br />
							<hr class="fancy-line">
							<font style="font-family:Georgia,serif;color:#4E443C;font-variant: small-caps; text-transform: none; font-weight: 100; margin-bottom: 0;">Sending Information</font>
							<p />We send BTC when <?php echo MINIMUMPAYOUTREQUEST; ?> people requested a payment to keep the transaction fee low.<br />So it could take a while until you get your BTC, BUT you can request a payment <u>every</u> <font style="font-weight:bold;font-size:14px;">hour!</font></b><br />
							<hr class="fancy-line">
							<font style="font-family:Georgia,serif;color:#4E443C;font-variant: small-caps; text-transform: none; font-weight: 100; margin-bottom: 0;">Price Win</font>
							<p />There is a 1 out of 10 chance that you get the Price Win.<br />If you get it, we will multiply your payout by <b><?php echo PRICEWINTIME; ?></b>! This means that you get: <u><?php printf("%0.7f", (FAUCETAMOUNTINBTC * PRICEWINTIME)); ?> BTC</u>!
							<hr class="fancy-line">
							<font style="font-family:Georgia,serif;color:#4E443C;font-variant: small-caps; text-transform: none; font-weight: 100; margin-bottom: 0;">News</font>
							<p /><b>We now have a referral system! Request a payment and check it out.</b><br/>
							<hr class="fancy-line">
							<font style="font-family:Georgia,serif;color:#4E443C;font-variant: small-caps; text-transform: none; font-weight: 100; margin-bottom: 0;">Keep Us Alive</font>
							<p style='padding:5px;'><i>Please consider donating to help the less fornunate:</i><br />
							<script>
							var CoinWidget_Config = {
								address : '<?php echo FAUCETADDRESS;?>',
								text : 'Donate for the Faucet',
								text_label : 'Faucet Address',
								counter : 'hide'
							};
							</script>
							<script src='http://c.coinwidget.com/widget.js'></script></p>
					</fieldset>
					<?php
						if (!empty($_POST['address'])){
							require_once('recaptchalib.php');
							$privatekey = RECAPTCHAPRIVATEKEY;
							$resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);

							if (!$resp->is_valid) {
								// What happens when the CAPTCHA was entered incorrectly
								echo ("<fieldset><legend>Request Payment</legend><p style='color:red;'><b>Wrong reCAPTCHA! Try again.</b></fieldset>");
								form();
							} 
							else {
								try {
									$result = mysql_query("SELECT * FROM ".MYSQLBTCTABLE." WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "' AND date = '".date("Y-m-d")."' AND time = '".date("H")."'") or die(mysql_error());
									if(mysql_fetch_array($result) !== false){
										echo ("<fieldset><legend>Request Payment</legend><p id='form' style='color:red;'><b>You already signed up. Try again after 1 hour!</b></fieldset>");
									}else{
										$random = rand(MINRANDOMNUMBER, MAXRANDOMNUMBER);
										if($random >= BELOWNUMBER){
											$run = mysql_query("INSERT INTO ".MYSQLBTCTABLE."(id, address, ip, date, time) VALUES('','" . $_POST['address'] . "','" . $_SERVER['REMOTE_ADDR'] . "', '".date("Y-m-d")."', '".date("H")."')"); 
											if ($run !== true) {
												echo "<fieldset><legend>Request Payment</legend><p id='form' style='color:red;'><b>There was a problem. Please try again.</b></fieldset>";
											}else{
												echo "<fieldset><legend>Request Payment</legend><p id='form' style='color:green;'><b>Your address has been added!</b>";
											}
										}else{
											$run = mysql_query("INSERT INTO ".MYSQLBTCTABLE."(id, address, ip, date, time, pricewin) VALUES('','" . $_POST['address'] . "','" . $_SERVER['REMOTE_ADDR'] . "', '".date("Y-m-d")."', '".date("H")."', '1')"); 
											if ($run !== true) {
												echo "<fieldset><legend>Request Payment</legend><p id='form' style='color:red;'><b>There was a problem. Please try again.</b></fieldset>";
											}else{
												echo "<fieldset><legend>Request Payment</legend><p id='form' style='color:green;'><b>Your address has been added!<br /><br />You ALSO won the Price Win! Your price will be multiplied by ".PRICEWINTIME."!</b>";
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
							form();
						}
					}
				}
				catch (Exception $e) {
				echo "<fieldset><legend>Sorry</legend>Blockchain is offline, Faucet information is not possible right now.</fieldset>";
				}
			}else{
				echo "<fieldset><legend>Sorry</legend>The faucet is currently offline, because we are adding new features. We have to make changes to the database, which makes the the faucet non-useable.</fieldset>";
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
  </body>
</html>	