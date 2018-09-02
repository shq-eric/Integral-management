<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>麦乐积分</title>
  <link rel="shortcut icon" href="http://cdn.mailejifen.com/dist/img/ml_16X16.ico" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="http://cdn.mailejifen.com/dist/css/lib.min.css">
    <style>
    body{
    padding: 20px;
    }
    </style>
</head>
<body>
    {{block name=content}}{{/block}}
    <!-- type: success,info,warning,danger -->
    <div class="alert alert-{{block name=type}}info{{/block}}" role="alert">{{block name=msg}}...{{/block}}</div>
</body>
</html>