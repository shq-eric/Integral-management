<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{block name=title}}麦乐积分{{/block}}</title>
  <link rel="shortcut icon" href="http://cdn.mailejifen.com/dist/img/ml_16X16.ico" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="http://cdn.mailejifen.com/dist/css/lib.min.css">

   {{block name=css}}{{/block}}

   <!--[if lt IE 9]>
   <script src="http://cdn.mailejifen.com/vender/html5shiv.min.js"></script>
   <script src="http://cdn.mailejifen.com/vender/respond.min.js"></script>
   <![endif]-->
</head>
<body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="http://mailejifen.com/pages/">麦乐支付中心管理后台</a>
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
        {{block name=content}}{{/block}}
      </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    {{block name=js}}{{/block}}
</body>
</html>