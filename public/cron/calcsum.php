<?php
try {
    $db = new PDO("mysql:host=127.0.0.1;dbname=homestead", "homestead", "secret");
    $yesterday  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
    $yesterday =  date('Y-m-d', $yesterday);
    $transactions = $db->query("SELECT * FROM transactions WHERE `date`='".$yesterday."'");
    $sum = 0;


    foreach ($transactions->fetchAll() as $transaction){
        $sum = $sum + $transaction['amount'];
    }
    return $sum;
}
catch(PDOException $e) {
    echo $e->getMessage();
}

$db = null;