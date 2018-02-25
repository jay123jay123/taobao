<?php
header("Content-type:application/json;charset=utf-8");
$tb = $_REQUEST['tb'];

if(empty($tb)){
	$p = array(array('name'=>'Tmall','img'=>'tmall.jpg','tb' =>'tmallsportsCount'),array('name'=>'JD','img'=>'jd.jpg','tb' =>'jdsportsCount'));
	print_r(json_encode($p));
	exit;
}

include ("../inc.php");
$conn = MysqlConn();
$postfix = date("Y-m-d",strtotime("-7 day"));
//$SummarySql = 'select brand,gettime from `'.$tb.'`  where gettime > \''.$postfix.'\' group by brand';
$SummarySql = ' select   brand,gettime from (select * from `'.$tb.'`  where gettime > \''.$postfix.'\'  order by gettime desc ) as tmp group by brand';
$res = mysql_query($SummarySql,$conn);
$jarr =array();
while ($row = mysql_fetch_assoc($res)) {
	$tmp['brand'] = $row['brand'];
	$tmp['gettime'] = $row['gettime'];
	$tmp['tb'] = $tb;
	array_push($jarr,$tmp);
}

print_r(json_encode($jarr));

?>
