<?php
header('Content-type:text/html;charset=utf-8');
include ("../inc.php");
$tb = $_REQUEST['tb'];
$brand = $_REQUEST['brand'];
if(empty($postfix)){ 
	$postfix = date("Y-m-d", time());
//	$postfix = date("Y-m-d",strtotime("-7 day"));
}
function serviceInterface($tb,$brand,$postfix)
{
    $conn = MysqlConn();
//    $SummarySql = 'select * from (select * from '.$tb.' where brand = \''.$brand.'\'  and gettime > \''.$postfix.'\'  order by gettime desc ) as tmp  group by purl order by sales desc';
    $SummarySql = 'select * from '.$tb.' where brand = \''.$brand.'\' and gettime = \''.$postfix.'\' order by id asc ';
    $res = mysql_query($SummarySql);
    $i = 0;
    while ($row = mysql_fetch_assoc($res)) {
        $SMAry[$i]['name'] = $row['name'];
//        $SMAry[$i]['url'] = $row['url'];
        $SMAry[$i]['sales'] = $row['sales'];
        $SMAry[$i]['price'] = $row['price'];
        $SMAry[$i]['storename'] = $row['storename'];
//        $SMAry[$i]['purl'] = $row['purl'];
 //       $SMAry[$i]['surl'] = $row['surl'];
        $i++;
    }
    MysqlClose($conn);

    return $SMAry;
}


$siAry = serviceInterface($tb,$brand,$postfix);

print_r(json_encode($siAry));

?>

