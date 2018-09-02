{{extends file='layouts/index.php'}}
{{block name=title}}麦乐积分 | 商户后台{{/block}}
{{block name=js}}
<script src="/public/js/jquery.upload.js"></script>
<script src="/public/js/jquery.myupload.js"></script>
<link rel="stylesheet" href="/public/css/upload.css">
<script>
$(function() {
	var data = $('textarea[name=data]').data('title');
	if(!data) {
		data = {};
	}
	$('textarea[name=data]').val(JSON.stringify(data, null, 8));

	$('form').on('submit', function() {
	   var json = $('.json').val();
	   if(json == '') {
		   $('.json').val('{}');
		   return true;
	   }

	   try {
		   JSON.parse(json);
	   }
	   catch(e) {
		   alert('json数据格式不正确，请检查后再提交');
		   return false;
	   }
	});
});
</script>
{{/block}}

{{block name=breadcrumb}}
    {{if $appContext}}<li><a href="/uc/application/dashboard?id={{$appContext->id}}"><i class="fa fa-dashboard"></i> {{$appContext->app_name}}</a></li>{{/if}}
    <li class="active">账号编辑</li>
{{/block}}

{{block name=content}}
<form method="post">
    <table width="100%" border="0">
        <table width="100%" border="0">
        <tr>
            <td>
                 账号（在第三方平台上的账号，如支付宝账号） <input type="text" class="form-control" value="{{$model.account}}" name="account" />
            </td>
        </tr>
        <tr>
            <td>
                类型（alipay:支付宝; weixin:微信; iapppay:爱贝） <input type="text" class="form-control" value="{{$model.account_type}}" name="account_type" {{if $model}}disabled{{/if}}/>
            </td>
        </tr>
        <tr>
            <td>
                说明<br/><textarea class="form-control" name="description">{{$model.description}}</textarea>
            </td>
        </tr>
        <tr>
            <td>
                配置数据（json）<br/><textarea class="form-control json" style="word-break: break-all; font-weight: bold;" name="data" rows="20" data-title="{{$model.data|htmlspecialchars}}"></textarea>
            </td>
        </tr>
    </table>
    <br>
    <input type="submit" class="btn-primary btn" value="提交" />&nbsp;&nbsp;&nbsp;<a href="/platform/third-account" type="submit" class="btn-default btn">返回</a>
</form>
{{/block}}