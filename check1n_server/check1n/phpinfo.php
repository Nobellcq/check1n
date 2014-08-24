<?php
//echo 'helssslo';
//    $k = trim($k);
//    $a = array();
//    exec('python ./some.py '.$k, $a);
//    echo $a[0];
//    passthru('python check1n/py/kaoqin.py check1n/py/abc.txt check1n/py/out.html 05 05 05 05 05 07 08 09 12 13');
//echo join(';',array('a','b','c'));
//
//$weekDay = date('w');
//// 3456012
//// 10 11 12 13 7 8 9
//// 7  8  9  10 4 5 6
//// 0  1  2  3  4 5 6
//$wd = ($weekDay + 4) % 7;
//$starttime = date('Y-m-d H:i:s',strtotime(date('Y-m-d')) - $wd * 24 * 3600);
//$endtime = date('Y-m-d H:i:s',strtotime(date('Y-m-d')) + (7-$wd)* 24* 3600);
//
//echo $starttime."\n".$endtime;
include 'py/CallPython.php';
//$tempPath = 'temp.txt';
//$output = 'out.html';
//$dir = 'py/';
//CallPython::callThrough($dir.'kaoqin.py',array( $dir.$tempPath,$dir.$output,'05','05','05','05','05','07','08','09','12','13'));

//$cmd = 'C:\xampp\htdocs\check1n\protected/../py/kaoqin.py C:\xampp\htdocs\check1n\protected/../py/temp.txt C:\xampp\htdocs\check1n\protected/../py/out.html 05 05 05 05 05 21 22 23 26 27';
$cmd = 'python C:\xampp\htdocs\check1n\protected/../py/kaoqin.py C:\xampp\htdocs\check1n\protected/../py/temp.txt C:\xampp\htdocs\check1n\protected/../py/out.html 05 05 05 05 05 14 15 16 19 20';
passthru($cmd);