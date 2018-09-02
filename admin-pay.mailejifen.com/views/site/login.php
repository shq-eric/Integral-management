{{extends file='layouts/from.php'}}
{{block name=title}}麦乐支付中心 | 登录帐号{{/block}}

{{block name=css}}
<link rel="stylesheet" href="http://cdn.mailejifen.com/plugins/iCheck/square/blue.css">
{{/block}}
{{block name=content}}
<form method="post" class="form-horizontal">
    <div class="form-group has-feedback">
        <input type="text" class="form-control" id="username" placeholder="用户名" name="username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="密码" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="login">
        <input type="submit" value="登&nbsp;录" class="btn btn-info btn-block btn-flat">
    </div>
</form>
{{/block}}
{{block name=js}}

{{/block}}
