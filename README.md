# BitCoin Open Source Faucet

##Describtion
This is a open source bitcoin faucet, created by [BitCoin Information](http://bitcoininformation.appspot.com/faucet/).

###Installation:
1. Download the .ZIP.
2. Unzip it in a folder.
3. Change the config which you can find at: "includes/config.php".
4. Import the freebtc.sql and the informations.sql in your MySQL database.
5. Upload everything on your webserver.
6. Setup a cronjob and let it run the script "runthiscronjob.php". If you do not have access to cronjob functinallity, you can use [SetCronJob](https://www.setcronjob.com/). As a free user you can let it run every hour (which is often enough).
7. ????
8. Profit.

###Known Bugs:
1. There has to be a first row in the database, else it won't work. I do not know why this happens, but there has to be a row. Nothing will be send to this address, because it will be skipped by the "OFFSET 1". This means that you can put in whatever you want.