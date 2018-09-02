{{extends file='layouts/index.php'}} 
{{block name=title}}
麦乐积分 | 管理后台
{{/block}} 

{{block name=breadcrumb}}
<li class="active">{{$title}}</li>
{{/block}}

{{block name=content}}
<link href="/public/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
<style>
label.label {
	margin-right: 10px;
}
</style>
<div class="row">
    <div class="col-xs-12">
          <form name="orderform" action="/order/refund-order" method="get" class="form-inline">
            <div class="form-group">
                    <input type="text"  class="form-control" id="maile_pay_sn" name="maile_pay_sn" placeholder="麦乐支付订单号" style="width: 200px; height: 35px " />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" class="form-control" id="maile_refund_sn" name="maile_refund_sn" placeholder="退款订单号" style="width: 200px; height: 35px;" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <select class="form-control" id="refund_reason" name="refund_reason" style="width: 150px; height: 35px;">
                    <option value ='' checked>请选择退款原因</option>
                    {{foreach $refund_reason as $reason}}
                    <option value = {{$reason.refund_reason}}>{{$reason.refund_reason}}</option>
                    {{/foreach}}
                  </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <select class="form-control" id="status" name="status" style="width: 150px; height: 35px;">
                    <option value ='' checked>请选择退款状态</option>
                    <option value =9 checked>退款成功</option>
                    <option value =10 checked>退款失败</option>
                  </select>
            </div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="input-group date"> 
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>  
                <input type="text" class="form-control pull-right" value="" id="start_time" name="start_time" placeholder="开始时间"/>
            </div>
            <p></p>
            <div class="input-group date"> 
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
                <input type="text" class="form-control pull-right" value="" id="end_time" name="end_time" placeholder="结束时间"/>
            </div>
            
            <div align="right">
                <input type="submit" class="btn btn-info" value="筛选">
            <a href="/order/refund-export-csv" id = export_csv onclick="return ModidyHerf()" class="btn btn-info" role="button">导出订单</a>
            </div>
        </form>
        <p></p>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">退款订单</h3>
                <p></p>
                {{$html}}
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
            
                <table class="table table-hover">
                    <tr>
                        <th style="width: 15%;">麦乐支付订单号</th>
                        <th style="width: 20%;">退款订单号</th>
                        <th style="width: 10%;">退款原因</th>
                        <th style="width: 10%;">退款金额</th>
                        <th style="width: 15%;">退款状态</th>
                        <th> 创建时间</th>
                    </tr>
                    {{foreach $order as $item}}
                    <tr>
                        <td><b>{{$item.maile_pay_sn}}</b></td>
                        <td><b>{{$item.maile_refund_sn}}</b></td>
                        <td>{{$item.refund_reason}}</td>
                        <td>{{number_format($item.refund_amount/100,2)}}</td>
                        <td>{{$refund_status_array[$item.status]}}</td>
                        <td>{{$item.create_time}}</td>   
                    </tr>
                    {{/foreach}}
                </table>
                <div class="box-footer clearfix">
                  {{$html}}
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
<script src="/public/js/moment.min.js"></script>
<script src="/public/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    $('#start_time,#end_time').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    
    window.onload = function() 
    {
      var res = UrlSearch();
      if(res[0] != '')
      {$('#maile_pay_sn').val(res[0])}
      if(res[1] != '')
      {$('#maile_refund_sn').val(res[1])}
      if(res[2] != '')
      {$('#refund_reason').val(res[2])}
      if(res[3] != '')
      {$('#status').val(res[3])}
      if(res[4] != '')
      {$('#start_time').val(res[4])}
      if(res[5] != '')
      {$('#end_time').val(res[5])}

    }

    function ModidyHerf(){
        var res = UrlSearch();
        var flag = res_is_void(res);
        if(flag || !res)
        {
          alert("请搜索后再导出!");
          return false;
        }
        var a = document.getElementById("export_csv");
        a.href += ("?maile_pay_sn=" + res[0] + "&maile_refund_sn=" + res[1] + "&refund_reason=" + res[2] + "&status=" +res[3]+ "&start_time=" +res[4] + "&end_time=" + res[5]);
    }
    
</script>


{{/block}}
