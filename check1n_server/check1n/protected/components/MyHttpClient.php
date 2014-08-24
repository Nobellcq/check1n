<?php
/**
 * Created by JetBrains PhpStorm.
 * User: huobingqian
 * Date: 14-4-8
 * Time: 下午5:56
 * To change this template use File | Settings | File Templates.
 */
//echo post('http://10.129.196.60/WebDevPublic/WebDevPublic/index.php?r=NewsClue/ajax/eventlist','limit=1');
//echo post2('http://10.129.196.60/WebDevPublic/WebDevPublic/index.php?r=NewsClue/ajax/eventlist',array('limit'=>1));
//echo post3('10.129.196.60','WebDevPublic/WebDevPublic/index.php?r=NewsClue/ajax/eventlist','limit=1','');

//$url='http://10.129.196.60/WebDevPublic/WebDevPublic/index.php?r=NewsClue/ajax/eventlist&limit=5';
//$html = file_get_contents($url);
//echo $html;
class MyHttpClient{
    public static function get($url){
        return file_get_contents($url);
    }

    public static function getByCurl($url){
        $ch = curl_init($url) ;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        return curl_exec($ch) ;
    }

    public static function post($url, $post_data = '', $timeout = 5){//curl
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_POST, 1);
        if($post_data != ''){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }

        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        return $file_contents;
    }

//    function post2($url, $data){//file_get_content
//
//
//
//        $postdata = http_build_query(
//
//            $data
//
//        );
//
//
//
//        $opts = array('http' =>
//
//        array(
//
//            'method'  => 'POST',
//
//            'header'  => 'Content-type: application/x-www-form-urlencoded',
//
//            'content' => $postdata
//
//        )
//
//        );
//
//
//
//        $context = stream_context_create($opts);
//
//
//        $result = file_get_contents($url, false, $context);
//
//        return $result;
//
//
//    }
//
//    function post3($host,$path,$query,$others=''){//fsocket
//
//
//        $post="POST $path HTTP/1.1\r\nHost: $host\r\n";
//
//        $post.="Content-type: application/x-www-form-";
//
//        $post.="urlencoded\r\n${others}";
//
//        $post.="User-Agent: Mozilla 4.0 yige.org\r\nContent-length: ";
//
//        $post.=strlen($query)."\r\nConnection: close\r\n\r\n$query";
//
//        $h=fsockopen($host,80);
//
//        fwrite($h,$post);
//
//        for($a=0,$r='';!$a;){
//
//            $b=fread($h,8192);
//
//            $r.=$b;
//
//            $a=(($b=='')?1:0);
//
//        }
//
//        fclose($h);
//
//        return $r;
//
//    }
}

