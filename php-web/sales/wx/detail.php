<?php  
header("Content-type:application/json;charset=utf-8");//字符编码设置  
include ("../inc.php");

$tb = $_REQUEST['tb'];


// 创建连接  
$con = MysqlConn();
// 检测连接  
$sql = 'select * from ( select * from `'.$tb.'Count` where count !=0    order by gettime desc ) as tmp  group by brand';  
$result = mysql_query($sql , $con);  
mysql_close($con);
if (!$result) {
    printf("Error: %s\n", mysql_error($con));
    exit();
}

$jarr = array();

while ($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$tmp = array();
	$tmp['tb'] = $tb;
	$tmp['brand'] = $row['brand'];
	$tmp['count'] = $row['count'];
	$tmp['gettime'] = $row['gettime'];
	array_push($jarr,$tmp);
}
print_r(json_encode($jarr));

?> 
