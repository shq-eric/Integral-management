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
            Third
            <small>Log</small>
        </h1>
    </section>
    <section class="content">
       
        <div class="row">

            <div class="col-md-12">

                <ul class="timeline" style="margin-top: 20px;">

                    {{foreach $list as $key=>$value}}
                    <li>
                        <div class="timeline-item" id="tmp">
                            <span class="time"><i class="fa fa-clock-o"></i>{{$value.create_time}}</span>
                            <h3 class="timeline-header">#{{$value.id}}</h3>
                            <div class="timeline-body">
                                {{foreach $value.remark as $key=>$value}}
                                    <small style="color: #ff0f0f;font-weight: 700">"{{$key}}"</small>:"{{$value}}"
                                {{/foreach}}
                            </div>
                        </div>
                    </li>
                    {{/foreach}}
                </ul>

            </div><!-- /.col -->
           
        </div><!-- /.row -->
    </section>
</div>

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
