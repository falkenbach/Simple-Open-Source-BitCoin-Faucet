# Simple Open Source BitCoin Faucet

##Describtion
This is a simple open source bitcoin faucet, created by [BitCoin Information](http://bitcoininformation.appspot.com/faucet/).

###Installation:
1. Download the .ZIP.
2. Unzip it in a folder.
3. Change the config which you can find at: " *includes/config.php* ".
4. Import the " *freebtc.sql* " and the " *informations.sql* " in your MySQL database.
5. Upload everything on your webserver.
6. Setup a cronjob and let it run the script " *job.php* ". If you do not have access to cronjob functinallity, you can use [SetCronJob](https://www.setcronjob.com/). As a free user you can let it run every hour (which is often enough).
7. ????
8. Profit.

###Known Bugs:
- There has to be a first row in the database, else the cronjob won't work. I do not know why this happens, but there has to be a row. Nothing will be send to this address, because it will be skipped by the " *OFFSET 1* ". So you could enter whatever you want.

###License:
Copyright (C) 2013 BitCoin Information (bitcoininformation.appspot.com)
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see <http://www.gnu.org/licenses/>.
