<html>
<head>
    <meta charset="UTF-8" />
    <title>平台分类列表</title>

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
// http://192.168.8.253/tu/summary.php?tb=achieve-service
header('Content-type:text/html');
#include ("nav.html");
$tb = $_REQUEST['tb'];
$conn = MysqlConn();
//$postfix = date("Y-m-d",time());
$postfix = date("Y-m-d",strtotime("-7 day"));
//$SummarySql = 'select brand , count from `'.$tb.'Count` where gettime = \''.$postfix.'\'';
$SummarySql = 'select brand,url from `'.$tb.'`  where gettime > \''.$postfix.'\' group by brand';
$res = mysql_query($SummarySql,$conn);

echo "<p>注：此为".$tb."下的部分分类↓ <p> <table class=\"gridtable\"><tr><th>Num</th><th>分类列表</th><th>原始链接</th></tr>";
$i = 1;
while ($row = mysql_fetch_assoc($res)) {
        echo "<tr><td align=\"center\" >".$i."</td><td><a href = \"/sales/platformlist/tb=".$tb."&brand=".$row['brand']."\">".$row['brand']."</a></td><td align=\"center\" ><a href = ".$row['url']." target=\"_blank\" ><img src = '/sales/Internet.png' ></a></td></tr>";
	$i++;
}
echo "</table>";
MysqlClose($conn);
#mysql_close($mysql_conn);
?>
</body>
</html>
