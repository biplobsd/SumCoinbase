<?php

require 'vendor/autoload.php';
require_once 'ids.php';

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;

use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;

date_default_timezone_set("Asia/Dhaka");

$banner = "\n
   _____                    _____      _       _                    
  / ____|                  / ____|    (_)     | |                   
 | (___  _   _ _ __ ___   | |     ___  _ _ __ | |__   __ _ ___  ___ 
  \___ \| | | | '_ ` _ \  | |    / _ \| | '_ \| '_ \ / _` / __|/ _ \
  ____) | |_| | | | | | | | |___| (_) | | | | | |_) | (_| \__ \  __/
 |_____/ \__,_|_| |_| |_|  \_____\___/|_|_| |_|_.__/ \__,_|___/\___|
---------------------------------------------------Dev-by-Alph4D----
\n";


if(isset($sendToM) || isset($keyV)){
	echo "IDs load. Success!";
}else{
	echo $banner;
	echo "error : \n";
	exit("Remove '//' in ids.php file before start this script! and also add your ids api key,secret key and which id do you want send all coin add this. --Alph4D(githube/biplobsd)\n\n");
}

echo $banner;
echo "Your total account : ".sizeof($keyV).'\n';


$totalAmound = array();
file_put_contents('activelogs.txt','Run Started  :  '.date("Y-m-d h:i:s")."\n", FILE_APPEND);
foreach($keyV as $n => $f){
    echo "\n[".$n."]";
    $configuration = Configuration::apiKey($f["key"], $f["secret"]);
    $client = Client::create($configuration);


    // var_dump((array)$client->getAccounts());

    foreach(array_reverse((array)$client->getCurrentUser()) as $a => $b){
        echo "\nName : ".$b["name"];
        echo "\nEmail : ".$b["email"];
        $svName = $b["name"];
        break;
    }
    $i = 0;
    $tgt = array();
    foreach((array)$client->getAccounts() as $b => $c){
        if($c !== null){
           
            foreach((array)$c as $a => $p){
                foreach(array_reverse((array)$p) as $q => $r){
                    // echo "\n Wallet Name : ".$r["name"];
                    // $aNameBTC = $r["name"];
                    // echo "\n Amount : ".$r["balance"]["amount"];
                    // $totalABTC = $r["balance"]["amount"];
                    if($r["balance"]["amount"] != 0.00000000){
                        if(empty($totalAmound[$r["balance"]["currency"]])){$totalAmound[$r["balance"]["currency"]] = 0;}
                        $caught = false;
                        $tgt[$i]['name'] = $r["name"];
                        $tgt[$i]['balance'] = $r["balance"]["amount"];
                        $tgt[$i]['id'] = $r["id"];
                        echo "\n[".$i."]......................Balance Found !.........................";
                        echo "\nWallet Name : ".$r["name"];
                        echo "\nAmount : ".$r["balance"]["amount"];
                        echo "\nCurrency : ".$r["balance"]["currency"];
                        echo "\nID : ".$r["id"];
                        sleep(1);
                        echo "\nSending....";
                
                        
                        $transaction = Transaction::send([
                            'toEmail' => $sendToM,
                            'amount'           => new Money($r["balance"]["amount"], $r["balance"]["currency"]), 
                            'description'      => $i.' Nices!',
                            // 'fee'              => '0.0001' // only required for transactions under BTC0.0001
                        ]);
                        try { $client->createAccountTransaction($client->getAccount($r["id"]), $transaction); }
                        catch(Exception $e) {
                            echo $e->getMessage();
                            $caught = true;
                            $errorSv = $e->getMessage();
                        }
                        if(!$caught){
                            echo "  Success.";
                            file_put_contents('activelogs.txt','['.$n.']'.'['.$svName.':'.$r["balance"]["currency"].'] Amount : '.$r["balance"]["amount"].' :  '.date("Y-m-d h:i:s")."\n", FILE_APPEND);
                        }else{
                            file_put_contents('activelogs.txt','['.$n.']'.'['.$svName.':'.$r["balance"]["currency"].'] Error : '.$errorSv.' :  '.date("Y-m-d h:i:s")."\n", FILE_APPEND);
                        }
                        // file_put_contents('./outputs.txt',$b, FILE_APPEND);
                        $totalAmound[$r["balance"]["currency"]] = $totalAmound[$r["balance"]["currency"]] + $r["balance"]["amount"];
                        $i++;
                    }
                    
                    break;
                }
            }
        }
    }

    echo "\nTotal money IDs was : ".sizeof($tgt)."\n\n";
}
echo 'Total Earn : - \n';
file_put_contents('activelogs.txt','Total Earn : - '."\n", FILE_APPEND);
foreach($totalAmound as $name => $valu){
    echo $name.' : '.sprintf('%.8F', $valu).'\n';
    file_put_contents('activelogs.txt',$name.' : '.sprintf('%.8F', $valu).' '.'\n', FILE_APPEND);
}
echo "All Done";
file_put_contents('activelogs.txt','\nEnded  :  '.date("Y-m-d h:i:s")."\n", FILE_APPEND);



?>