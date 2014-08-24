<?php
/**
 * Created by PhpStorm.
 * User: huobingqian
 * Date: 14-5-16
 * Time: 下午6:29
 */
class FileUtils{
    public static function saveFile($path, $content){
        $file = fopen($path, 'w');
        fwrite($file, $content);
        fclose($file);
    }

    public static function readFile($path){
        $file = fopen($path, 'r');
        $content = fread($file, filesize($path));
        fclose($file);
        return $content;
    }

    public static function getFileName($fullpath){
        return substr($fullpath,strrpos($fullpath,'/')+1);
    }
}
