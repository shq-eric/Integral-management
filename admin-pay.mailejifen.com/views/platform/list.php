{{extends file='layouts/index.php'}} {{block name=title}}麦乐积分 |
管理后台{{/block}} {{block name=js}}
<script src="/public/js/bootstrapValidator.min.js"></script>
<script src="/public/js/jquery.myvalidator.js"></script>
{{/block}}

{{block name=breadcrumb}}
<li class="active">{{$title}}</li>
{{/block}}

{{block name=content}}
<style>
label.label {
	margin-right: 10px;
}
</style>
<div class="row">
    <div class="col-xs-12">
        <div style="margin-bottom:10px;">
            <a href="/platform/add" class="btn btn-info" role="button">添加平台</a>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">用户列表</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th style="width: 10%;">平台标识</th>
                        <th style="width: 10%;">平台名称</th>
                        <th>绑定账号</th>
                        <th style="width: 10%;">操作</th>
                    </tr>
                    {{foreach $list as $item}}
                    <tr>
                        <td><b>{{$item.platform}}</b></td>
                        <td>{{$item.name}}</td>
                        <td>
                            {{foreach $item.boundAccounts as $account}}
                            <div style="margin-bottom: 10px;"><label class="label bg-gray">{{$accountTypeMap[$account.account_type]}}</label>{{$account.account}} <span style="font-size: 12px; color: #666;">{{$account.description}}</span></div>
                            {{/foreach}}
                            <label class="label bg-gray"><a href="/platform/platform-account-bind?id={{$item.id}}"><i class="fa fa-edit" style="cursor: pointer;">编辑</i></a></label>
                        </td>
                        <td><a href="/platform/edit?id={{$item.id}}">编辑</a></td>
                    </tr>
                    {{/foreach}}
                </table>
                <div class="box-footer clearfix">
                </div>
            </div><!-- /.box -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
{{/block}}
