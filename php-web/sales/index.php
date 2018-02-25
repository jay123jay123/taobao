<html>
<head>
    <meta charset="UTF-8" />
    <title>Index</title>

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

$conn = MysqlConn();

$SummarySql = 'show tables';
$res = mysql_query($SummarySql,$conn);
echo "<p>注：此为品牌店铺列表 <p> <table class=\"gridtable\"><tr><th>Num</th><th>品牌</th><th>关注度</th></tr>";
$i = 1;
while ($row = mysql_fetch_assoc($res)) {
	if ( substr($row['Tables_in_deployment'],-5) ==  'Count' )
		continue;
        echo "<tr><td  align=\"center\" >".$i."</td><td><a href = \"/sales/summary/tb=".$row['Tables_in_deployment']."\"  >".$row['Tables_in_deployment']."</a></td><td></td></tr>";
	$i++;
}
echo "</table>";
MysqlClose($conn);
#mysql_close($mysql_conn);
?>

<hr>
<p>注：此为平台列表 <p> 
<table class="gridtable"><th>Num</th><th>平台</th></tr>
<tr><td  align="center" >1</td><td><a href = "/sales/platform/tb=tmallsportsCount"  >Tmall-Sports</a></td></tr>
<tr><td  align="center" >2</td><td><a href = "/sales/platform/tb=jdsportsCount"  >JD-Sports</a></td></tr>
</table>

</body>
</html>
