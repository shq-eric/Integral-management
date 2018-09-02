{{extends file='layouts/index.php'}} {{block name=title}}麦乐积分 |
管理后台{{/block}} {{block name=js}}
<script src="/public/js/bootstrapValidator.min.js"></script>
<script src="/public/js/jquery.myvalidator.js"></script>
<script>
    $(function(){
        $('.item-data').click(function(){
            var data = $(this).data('title');
            var html = '';
            for(var k in data) {
            	html += "<div style='background: #ccc; margin-bottom: 10px;'><p style='background: #aaa; font-weight: bold;'>" + k + "</p><p style='word-break: break-all;'>" + data[k] + "</p></div>"
            }
            
            $('#data-modal .body').html(html);
            $('#data-modal').modal();
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
</style>
<div class="row">
    <div class="col-xs-12">
        <div style="margin-bottom:10px;">
            <a href="/platform/add" class="btn btn-info" role="button">添加账户</a>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">账户列表</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th style="width: 20%;">账号</th>
                        <th style="width: 10%;">类型</th>
                        <th>说明</th>
                        <th>绑定平台</th>
                        <th style="width: 10%;">配置数据</th>
                        <th style="width: 10%;">操作</th>
                    </tr>
                    {{foreach $list as $item}}
                    <tr>
                        <td><b>{{$item.account}}</b></td>
                        <td>{{$item.account_type}}</td>
                        <td>{{$item.description}}</td>
                        <td>
                            {{foreach from=$item.boundPlatforms item=$platform}}
                                <label class="label bg-gray" title="平台标识：{{$platform.platform}}">{{$platform.name}}</label>
                            {{/foreach}}
                        </td>
                        <td><span class="item-data" style="cursor: pointer;" data-title="{{$item.data|htmlspecialchars}}">点击查看</span></td>
                        <td><a href="/platform/edit-third-account?id={{$item.id}}">编辑</a></td>
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

<div class="example-modal">
    <div class="modal" id="data-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">配置数据</h4>
          </div>
          <div class="modal-body">
            <p class="body"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div><!-- /.example-modal -->

<div class="example-modal">
    <div class="modal" id="bind-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">平台绑定</h4>
          </div>
          <div class="modal-body">
            <p class="body"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div><!-- /.example-modal -->
{{/block}}
