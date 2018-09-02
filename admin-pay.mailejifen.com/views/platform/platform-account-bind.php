{{extends file='layouts/index.php'}} {{block name=title}}麦乐积分 |
管理后台{{/block}} {{block name=js}}
<script src="/public/js/bootstrapValidator.min.js"></script>
<script src="/public/js/jquery.myvalidator.js"></script>
<script>
var boundAccounts = {{$boundAccounts|json_encode}};
var platformId = {{$model.id}};

$(function(){
    $('.bind').on('click', function() {
        var $tr = $(this).closest('tr');
        var account_type = $tr.find('.type').html();
        var accountId = $tr.data('id');
        
        for(var i in boundAccounts) {
            if(boundAccounts[i]['account_type'] == account_type) {
                if(confirm('该支付类型已存在绑定账号，确认替换掉该账号？')) {
                    return true;
                }
                else {
                    return false;
                }
            }
        }
    });
});
</script>
{{/block}}

{{block name=breadcrumb}}
<li class="active">{{$title}}</li>
{{/block}}

{{block name=content}}
<style>
label.label {
	margin-right: 10px;
}
.bind, .unbind {
	cursor: pointer;
}
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">账户列表 - 绑定到 [<b>{{$model->name}}</b>]</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th style="width: 30%;">账号</th>
                        <th style="width: 10%;">类型</th>
                        <th>是否绑定</th>
                        <th style="width: 10%;">操作</th>
                    </tr>
                    {{foreach $list as $item}}
                    <tr data-id="{{$item.id}}">
                        <td><b>{{$item.account}}</b> <span style="font-size: 12px; color: #666;">{{$item.description}}</span></td>
                        <td class="type">{{$item.account_type}}</td>
                        <td>{{if $item.bound}}<label class="label bg-green">是</label>{{else}}<label class="label bg-red">否</label>{{/if}}</td>
                        <td>{{if $item.bound}}
                            <a href="/platform/do-unbind?platformId={{$model.id}}&accountId={{$item.id}}"><label class="label bg-red unbind"><i class="fa fa-unlink"> 解除绑定</i></label></a>
                            {{else}}
                            <a href="/platform/do-bind?platformId={{$model.id}}&accountId={{$item.id}}"><label class="label bg-green bind"><i class="fa fa-link"> 绑定</i></label></a>
                            {{/if}}
                        </td>
                    </tr>
                    {{/foreach}}
                </table>
                <div class="box-footer clearfix">
                </div>
            </div><!-- /.box -->
        </div>
        <!-- /.box-body -->
        <div style="margin-bottom:10px;">
            <a href="/platform/list" class="btn btn-info" role="button">返回</a>
        </div>
        
    </div>
    <!-- /.box -->
</div>
{{/block}}
