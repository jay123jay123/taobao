<?php  
header("Content-type:application/json;charset=utf-8");//字符编码设置  
include ("../inc.php");
// 创建连接  
$con = MysqlConn();
// 检测连接  

  
$sql = "show tables";  
$result = mysql_query($sql , $con);  
mysql_close($con);
if (!$result) {
    printf("Error: %s\n", mysql_error($con));
    exit();
}

$jarr = array();

while ($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$tmp = array();
        if ( substr($row['Tables_in_deployment'],-5) ==  'Count' ){
                continue;
	}
	$tmp['name'] = $row['Tables_in_deployment'];
	$tmp['img'] = $row['Tables_in_deployment'].'.jpg';
	array_push($jarr,$tmp);
}
print_r(json_encode($jarr));

?> 
