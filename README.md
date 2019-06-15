# SumCoinbase 
![alt text](/img/preview.png "Preview script")

### Installing

#### Termux
1. `pkg update && pkg upgrade`
2. `pkg install php`
3. `pkg install nano`
4. `pkg install git`
5. `cd /sdcard/` Make sure termux access your file storage permission granted.
6. `git clone https://github.com/biplobsd/SumCoinbase.git`
7. `cd SumCoinbase`
8. `nano ids.php` Write your all Coinbase ids API key and secret in ids.php
9. `php makeSimple.php` start script

#### Windows
1. Install php in cmd
2. Download project `https://github.com/biplobsd/SumCoinbase.git`
3. Write your all Coinbase ids API key and secret in ids.php 
4. Open cmd in SumCoinbase folder
5. `php makeSimple.php` start script


### Usages
Input your email, which email you went to send all coin also input your Coinbase API key and secret in the ids.php file. Then open your console and type `php makeSimple.php` and hit Enter. Now, wait for script doing.

This script save logs in a text file. Check out activelogs.txt.