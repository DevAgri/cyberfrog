<?php
include "store.php";

$db = new Store();

//MAC/Linux
$portAddress = '/dev/tty.HC-06-DevB';
//Windows
//    $portAddress = 'COM3';
exec("mode com3: BAUD=9600 PARITY=N data=8 stop=1 xon=off");

$port = fopen($portAddress, 'r+w');

if (!$port) {
    
}else{
    fwrite($port, 'f');
    $strData = fgets($port);
    fclose($port);
    
    if (strpos($strData, '@') !== false && strpos($strData, '#') !== false) {
        $strData = str_replace("@", "", $strData);
        $strData = str_replace("#", "", $strData);
        $arr = explode(";", $strData);
        
        $rs = $db->insertData($arr);
    }
}