<html>
<head>
    <meta charset="UTF-8" />
    <title>品牌店铺单品趋势图</title>
    <script src="/sales/jquery.min.js"></script>
    <script src="/sales/highcharts.js"></script>
    <script type="text/javascript" src="My97DatePicker/WdatePicker.js"> </script>
    <!-- <div id="container" style="width: 1800px; height: 400px; margin: 0 auto"></div> -->
    <script language="JavaScript">



        var tu = function(tablename,url,brand) {

            var title = {
                          text: '商品销量'
            };

            var titleFCount = {
                text: '调用失败次数'
            };

            var titleSCount = {
                text: '价格/促销价'
            };

            var subtitle = {
                text: ''
            };
            var xAxis = {
                categories: []
            };
            var xAxisFCount = {
                categories: []
            };

            var yAxis = {
                title: {
                    text: '月累计销量/件'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            };

            var yAxisFCount = {
                title: {
                    text: '价格/元'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            };


            var tooltip = {
                valueSuffix: '件'
            };

            var tooltipFCount = {
                valueSuffix: '元'
            };

            var legend = {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            };

            var series =  [
                {
                    name: '',
                    data:[]
                },
            ];


            var seriesFCount =  [
                {
                    name: '',
                    data:[]
                },
                {
                    name:'',
                    data:[]
                }
            ];

            var seriesSCount =  [
                {
                    name: '',
                    data:[]
                },
                {
                    name:'',
                    data:[]
                }
            ];


            var commandsUrl = "/sales/api2.php";
            series[0].name = "商品销量";
            seriesSCount[0].name = "价格";
            seriesSCount[1].name = "促销价";
            $.ajax({
                type : "post",
                url : commandsUrl,
		data : {tb : tablename , url : url , brand : brand},
                async : false,
                success : function(data) {
                    for( var key in data ){
                        xAxis.categories.push(data[key].gettime);
                        series[0].data.push(+data[key].msales);
                        seriesSCount[0].data.push(+data[key].mprice);
                        seriesSCount[1].data.push(+data[key].promotion_price);
                    }


                }
            });


            var json = {};

            json.title = title;
            json.subtitle = subtitle;
            json.xAxis = xAxis;
            json.yAxis = yAxis;
            json.tooltip = tooltip;
            json.legend = legend;
            json.series = series;

            var jsonSCount = {};
            jsonSCount.title = titleSCount;
            jsonSCount.subtitle = subtitle;
            jsonSCount.xAxis = xAxis;
            jsonSCount.yAxis = yAxisFCount;
            jsonSCount.tooltip = tooltipFCount;
            jsonSCount.legend = legend;
            jsonSCount.series = seriesSCount;

            return {json,jsonSCount};


        };

        var hcharts = function(json,id){
            $('#container' + id ).highcharts(json);
        };

        $(document).on('click','#submit', function(){
            var v = $('#dt').val();
            var url = window.location.href;
            if (url.indexOf('&dt=') > -1) {
                url = url.substr(0,url.length - 12);
            }
            window.location.href = url + '&dt=' + v;
        });

       function selected(){
           var v = $('#dt').val();
           var url = window.location.href;
           if (url.indexOf('&dt=') > -1) {
               url = url.substr(0,url.length - 12);
           }
           window.location.href = url + '&dt=' + v;
       }

    </script>

</head>
<body>
<!-- Date:<input type="text" id="dt" name="dt" onClick="WdatePicker({dateFmt:'yyyyMMdd',onpicked:function(){selected()}})" readonly="readonly"> -->
<?php
session_start();
header('Content-type:text/html;charset=utf-8');
if(isset($_SESSION['username']) && $_SESSION['username']==='1016'){
        echo $_SESSION['username']." 欢迎你..." ;
}else{
        header('location:/sales/2/');
}
include ("inc.php");

$tb = $_REQUEST['tb'];
$url = $_REQUEST['url'];
$brand = $_REQUEST['brand'];
$name = $_REQUEST['name'];

if ( isset($dt) ){
    $postfix = $dt;

}else{
    $postfix = date("Ymd",time());
}

#echo "查询日期：".$postfix."<hr>";
echo "<p>".$name ."<hr style=\"height:1px;border:none;border-top:1px dashed #0066CC;\" >";



echo "<div id=\"container1\" style=\"width: 1200px; height: 400px; margin: 0 auto\"></div>\n";
echo "<div id=\"container2\" style=\"width: 1200px; height: 400px; margin: 0 auto\"></div>\n";


echo "
        <script>
        var tutu = tu('". $tb ."','".$url."','".$brand."');

        hcharts(tutu.json,'1');
        hcharts(tutu.jsonSCount,'2');
        
        </script>";

?>






</body>
</html>
