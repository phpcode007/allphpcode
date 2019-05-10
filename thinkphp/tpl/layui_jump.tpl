{__NOLAYOUT__}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>跳转提示</title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <link rel="stylesheet" href="__ADMIN__/layui/css/layui.css">
    <script src="__ADMIN__/layui/layui.all.js"></script>
    <style type="text/css">
        *{ padding: 0; margin: 0; }
        body{ background: #fff; font-family: "Microsoft Yahei","Helvetica Neue",Helvetica,Arial,sans-serif; color: #333; font-size: 16px; }
        .system-message{ padding: 24px 48px; }
        .system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
        .system-message .jump{ padding-top: 10px; }
        .system-message .jump a{ color: #333; }
        .system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px; }
        .system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display: none; }
    </style>
</head>
<body>
<div class="system-message">

    <input type="hidden" id="msg" value="<?php echo(strip_tags($msg));?>" />
    <input type="hidden" id="url" value="<?php echo(strip_tags($url));?>" />
    <input type="hidden" id="wait" value="<?php echo(strip_tags($wait));?>" />
</div>
<script type="text/javascript">
    layui.use('layer', function(){
        var layer = layui.layer;
        var msg=$('#msg').val();
        var url1=$('#url').val();
        var wait=$('#wait').val();

        layer.open({
            content:msg,//提示信息
            anim:Math.floor(Math.random()*8),//0-7的随机动画效果
            success:function(layero,index){
                var interval = setInterval(function(){
                    var time = --wait;
                    if(time <= 0) {
                        location.href = url1;
                        clearInterval(interval);
                    };
                }, 1000);
            }
        })

    });
</script>
</body>
</html>
