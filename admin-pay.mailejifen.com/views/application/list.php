{{extends file='layouts/index.php'}} 
{{block name=title}}麦乐积分 |管理后台  {{/block}} 

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
            <a href="/application/add" class="btn btn-info" role="button">添加应用</a>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">应用列表</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th style="width: 10%;">应用名称</th>
                        <th >key</th>
                        <th >secret</th>
                        <th style="width: 10%;">应用状态</th>
                        <th style="width: 10%;">操作</th>
                    </tr>
                    {{foreach $list as $item}}
                    <tr>
                        <td>{{$item.name}}</td>
                        <td>{{$item.key}}</td>
                        <td>{{$item.secret}}</td>
                        <td>{{$item.status}}</td>
                        <td><a href="/application/edit?id={{$item.id}}">编辑</a></td>
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

{{block name=js}}
<script src="/public/js/bootstrapValidator.min.js"></script>
<script src="/public/js/jquery.myvalidator.js"></script>
{{/block}}