<html>
<head>
    <meta charset="UTF-8" />
    <title>品牌店铺商品列表页</title>

    <style type="text/css">
        table.gridtable {
            font-family: verdana,arial,sans-serif;
            font-size:11px;
            color:#333333;
            border-width: 1px;
            border-color: #666666;
            border-collapse: collapse;
        }
        table.gridtable th {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #dedede;
        }
        table.gridtable td {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #ffffff;
        }
	a:hover, a:visited, a:link, a:active { color: #333333}

    </style>


</head>
<body>
<?php
session_start();
header('Content-type:text/html;charset=utf-8');
if(isset($_SESSION['username']) && $_SESSION['username']==='1016'){
        echo $_SESSION['username']." 欢迎你..." ;
}else{
        header('location:/sales/2/');
}
include ("inc.php");
#include ("nav.html");
// http://192.168.8.253/tu/summary.php?tb=achieve-service
#header('Content-type:text/json');
$tb = $_REQUEST['tb'];
$brand = $_REQUEST['brand'];
$postfix = $_REQUEST['date'];
if(empty($postfix)){ 
//	$postfix = date("Y-m-d", time());
	$postfix = date("Y-m-d",strtotime("-7 day"));
}
function serviceInterface($tb,$brand,$postfix)
{
    $conn = MysqlConn();
    $nowtime = date("Y-m-d", time());
    if($brand == 'NewGoods'){
	$cnum = 50;
    }else{
	$cnum = 30;
    }
 //   $SummarySql = ' select name,url,msales,mprice,promotion_price , mactivity from `'.$tb.'` where brand = \''.$brand.'\' and gettime = \''.$postfix.'\'  order by msales desc ';
    $SummarySql = 'select name,url,msales,mprice,promotion_price , mactivity , gettime from (select * from (select * from  `'.$tb.'`  where brand = \''.$brand.'\' group by url,gettime) as tmp order by gettime desc) as tmp2 where gettime > \''.$postfix.'\' group by url order by msales desc limit '.$cnum;

    $res = mysql_query($SummarySql);
    $i = 0;
    while ($row = mysql_fetch_assoc($res)) {
        $SMAry[$i]['name'] = $row['name'];
        $SMAry[$i]['url'] = $row['url'];
        $SMAry[$i]['msales'] = $row['msales'];
        $SMAry[$i]['mprice'] = $row['mprice'];
        $SMAry[$i]['promotion_price'] = $row['promotion_price'];
        $SMAry[$i]['mactivity'] = $row['mactivity'];
	# flag = 0 下架
	if ( $row['gettime'] < $nowtime  ){
        	$SMAry[$i]['flag'] = '下架或未抓到';
	}
        $i++;
    }
    MysqlClose($conn);

    return $SMAry;
}


$siAry = serviceInterface($tb,$brand,$postfix);

echo "<p>注：此为".$tb."的".$brand."分类销售数据默认按照高低排序(采集最晚为".$postfix.")↓ <p>";
echo "<table class=\"gridtable\">
<tr>
	<th>Num</th><th>商品名</th><th>销量</th><th>价格</th><th>促销价</th><th>促销折扣</th><th>活动内容</th><th>趋势图</th><th>状态</th>
</tr>

";
$i = 1;
foreach ( $siAry as $value){
    echo "<tr><td>".$i."</td><td><a href = \"".$value['url']."\" target=\"view_window\">".$value['name']."</a></td><td>".$value['msales']."</td><td>".$value['mprice']."</td><td>".$value['promotion_price']."</td><td>".round($value['promotion_price']/$value['mprice'],2)."</td><td>".$value['mactivity']."</td><td align=\"center\" ><a href = /sales/tu/?tb=".$tb."&url=".urlencode($value['url'])."&brand=".$brand."&name=".urlencode($value['name'])." ><img src = '/sales/bars_chart.png' ></a></td><td>".$value['flag']."</td></tr>";
    $i++;

}

echo "</table>";

?>
</body>
</html>

