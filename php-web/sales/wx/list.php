<?php
header("Content-type:application/json;charset=utf-8");
include ("../inc.php");
$tb = $_REQUEST['tb'];
$brand = $_REQUEST['brand'];
$postfix = $_REQUEST['date'];
if(empty($postfix)){ 
//	$postfix = date("Y-m-d", time());
	$postfix = date("Y-m-d",strtotime("-1 day"));
}
function serviceInterface($tb,$brand,$postfix)
{
    $conn = MysqlConn();
    if ($brand == 'NewGoods'){
    	$cnum = 50;
    }else{
	$cnum = 30;
    }
 //   $SummarySql = ' select name,url,msales,mprice,promotion_price , mactivity from `'.$tb.'` where brand = \''.$brand.'\' and gettime = \''.$postfix.'\'  order by msales desc ';
    $SummarySql = 'select name,url,msales,mprice,promotion_price , mactivity from (select * from (select * from  `'.$tb.'`  where brand = \''.$brand.'\' group by url,gettime) as tmp order by gettime desc) as tmp2 where gettime > \''.$postfix.'\' group by url order by msales desc limit '.$cnum;
    $res = mysql_query($SummarySql);
    $i = 0;
    while ($row = mysql_fetch_assoc($res)) {
        $SMAry[$i]['name'] = $row['name'];
        $SMAry[$i]['url'] = $row['url'];
        $SMAry[$i]['msales'] = $row['msales'];
        $SMAry[$i]['mprice'] = $row['mprice'];
        $SMAry[$i]['promotion_price'] = $row['promotion_price'];
	$SMAry[$i]['discount'] =  round($row['promotion_price'] / $row['mprice'] , 3);
        $SMAry[$i]['mactivity'] = $row['mactivity'];
        $SMAry[$i]['tb'] = $tb;
        $SMAry[$i]['brand'] = $brand;
        $i++;
    }
    MysqlClose($conn);

    return $SMAry;
}


$siAry = serviceInterface($tb,$brand,$postfix);
print_r(json_encode($siAry));
