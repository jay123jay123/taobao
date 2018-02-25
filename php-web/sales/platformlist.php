<html>
<head>
    <meta charset="UTF-8" />
    <title>平台分类商品列表页</title>

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
	$postfix = date("Y-m-d", time());
//	$postfix = date("Y-m-d",strtotime("-7 day"));
}
function serviceInterface($tb,$brand,$postfix)
{
    $conn = MysqlConn();
//    $SummarySql = 'select * from (select * from '.$tb.' where brand = \''.$brand.'\'  and gettime > \''.$postfix.'\'  order by gettime desc ) as tmp  group by purl order by sales desc';
    $SummarySql = 'select *from '.$tb.' where brand = \''.$brand.'\' and gettime = \''.$postfix.'\' order by id asc ';
    $res = mysql_query($SummarySql);
    $i = 0;
    while ($row = mysql_fetch_assoc($res)) {
        $SMAry[$i]['name'] = $row['name'];
        $SMAry[$i]['url'] = $row['url'];
        $SMAry[$i]['sales'] = $row['sales'];
        $SMAry[$i]['price'] = $row['price'];
        $SMAry[$i]['storename'] = $row['storename'];
        $SMAry[$i]['purl'] = $row['purl'];
        $SMAry[$i]['surl'] = $row['surl'];
        $i++;
    }
    MysqlClose($conn);

    return $SMAry;
}


$siAry = serviceInterface($tb,$brand,$postfix);

echo "<p>注：此为".$tb."的".$brand."分类销售数据默认按照高低排序(采集最晚为".$postfix.")↓ <p>";
echo "<table class=\"gridtable\">
<tr>
	<th>Num</th><th>商品名</th><th>销量</th><th>价格</th><th>店铺名</th>
</tr>
";

$i = 1;
foreach ( $siAry as $value){
    echo "<tr><td>".$i."</td><td><a href = \"".$value['purl']."\" target=\"view_window\">".$value['name']."</a></td><td>".$value['sales']."</td><td>".$value['price']."</td><td><a href = \"".$value['surl']."\" target=\"_blank\" >".$value['storename']."</a></td></tr>";
    $i++;

}

echo "</table>";

?>
</body>
</html>

