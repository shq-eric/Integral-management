{{extends file='layouts/index.php'}}
{{block name=title}}
麦乐积分 |{{$title}}
{{/block}}

{{block name=breadcrumb}}
<li class="active">{{$title}}</li>
{{/block}}
{{block name=content}}
<style>
    #tmp:hover{
     box-shadow: 1px 1px 2px 2px rgba(0,0,0,0.2);
    }
    .m-mark{
        background:#F56954;color:white;
        border-radius: 5px;
    }
    .J_field{
       font-weight: normal;
    }

</style>
<div class="content-wrapper" style="margin-left: 0;margin-top: -40px;">
    <section class="content-header">
        <h1>
            Operation
            <small>Log</small>
        </h1>
    </section>
    <section class="content">
        <form method="get">
            <input type="hidden" name="site" value="{{$site}}">
            <div class="row">
                <div class="col-xs-2 form-group">
                    <input type="text" name="search[id]" class="form-control" placeholder="ID"
                           value="{{$search['id']}}">
                </div>
                <div class="col-xs-3 form-group">
                    <input type="text" name="search[content]" class="form-control" placeholder="Email/菜单名/操作名/字段名"
                           value="{{$search['content']}}">
                </div>
                <div class="col-xs-2  form-group">
                    <div class='input-group date'>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        <input type='text' id='datetimepicker1' name="search[startTime]" class="form-control"
                               value="{{$search['startTime']}}"/>
                    </div>
                </div>
                <div class="col-xs-2  form-group">
                    <div class='input-group date'>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        <input type='text' id='datetimepicker2' name="search[endTime]" class="form-control"
                               value="{{$search['endTime']}}"/>
                    </div>
                </div>
                <div class="col-md-1">
                    <input type="submit" class="btn btn-block btn-primary btn-sm" value="筛&nbsp;选">
                </div>
            </div>
        </form>
        <div class="row">

            <div class="box-footer clearfix">
                {{$page}}
            </div>

            <div class="col-md-12">

                <ul class="timeline" style="margin-top: 20px;">

                    {{foreach $list as $value}}
                    <li>
                        <div class="timeline-item" id="tmp">
                            <span class="time"><i class="fa fa-clock-o"></i>{{$value.operation_time}}</span>
                            <h3 class="timeline-header">
                                {{if $site == 'merchant'}}
                                <a href="#">商户#{{$value.operation_merchant_id}}</a>
                                {{elseif $site == 'admin'}}
                                <a href="#">用户#{{$value.operation_admin_id}}</a>
                                {{/if}}
                                - {{$value.operation_ip}}</h3>
                            <div class="timeline-body">
                                {{$value.operation_description}}
                            </div>

                        </div>
                    </li>
                    {{/foreach}}
                </ul>

            </div><!-- /.col -->
            <div class="box-footer clearfix">
                {{$page}}
            </div>
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

{{/block}}

{{block name=js}}
<link href="/public/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
<script src="/public/js/moment.min.js"></script>
<script src="/public/js/bootstrap-datetimepicker.min.js"></script>
<script>

    $('#datetimepicker1,#datetimepicker2').datetimepicker({
        format: 'YYYY-MM-DD'
    });
</script>
{{/block}}
