<?php 
     $ch = curl_init(); 
     curl_setopt($ch, CURLOPT_URL, "http://v.juhe.cn/weixin/query?pno=&ps=&dtype=&key=84fbc990286797bbf598366ebbd678ae"); 
     curl_setopt($ch, CURLOPT_HEADER, false); 
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果把这行注释掉的话，就会直接输出 
     $result=curl_exec($ch); 
     curl_close($ch); 
     //$obj = @json_decode($result, TRUE);  
     //print_r( @json_encode($obj['result']['list']));
     print_r($result);
?>
