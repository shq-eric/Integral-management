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
});
</script>
{{/block}}

{{block name=breadcrumb}}
    {{if $appContext}}<li><a href="/uc/application/dashboard?id={{$appContext->id}}"><i class="fa fa-dashboard"></i> {{$appContext->app_name}}</a></li>{{/if}}
    <li class="active">平台编辑</li>
{{/block}}

{{block name=content}}
<form method="post">
    <table width="100%" border="0">
        <table width="100%" border="0">
        <tr>
            <td>
                平台标识 <input type="text" class="form-control" value="{{$model.platform}}" name="platform" {{if $model}}disabled{{/if}} />
            </td>
        </tr>
        <tr>
            <td>
                平台名称<input type="text" class="form-control" value="{{$model.name}}" name="name" />
            </td>
        </tr>
    </table>
    <br>
    <input type="submit" class="btn-primary btn" value="提交" />&nbsp;&nbsp;&nbsp;<a href="/platform/list" type="submit" class="btn-default btn">返回</a>
</form>
{{/block}}