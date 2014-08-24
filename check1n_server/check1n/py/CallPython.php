<?php
/**
 * Created by PhpStorm.
 * User: Enbandari
 * Date: 14-5-28
 * Time: 上午12:18
 */

class CallPython {
    public static function callThrough($scriptName, $args){
        $cmd = 'python '.$scriptName.' '.join(' ',$args);
        passthru($cmd);
    }

    public static function callReturn($scriptName, $args){

    }
}