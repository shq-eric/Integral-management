{{extends file='layouts/index.php'}} 
{{block name=title}}
麦乐积分 | 管理后台
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
        <form name="orderform"action="/order/maile-pay-order" method="get" class="form-inline">
          <div class="form-group">
                  <input type="text" class="form-control" id="maile_pay_sn" name="maile_pay_sn" placeholder="麦乐支付订单号" style="width: 200px; height: 35px;" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="text" class="form-control" id="order_sn" name="order_sn" placeholder="商品订单号" style="width: 200px; height: 35px;" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <select class="form-control" id="platform" name="platform" style="width: 150px; height: 35px;">
                    <option value ='' checked>请选择购买平台</option>
                    {{foreach $platform as $plt}}
                    <option value = {{$plt.platform}}>{{$platform_array[$plt.platform]}}</option>
                    {{/foreach}}
                  </select>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <select class="form-control" id="pay_type" name="pay_type" style="width: 150px; height: 35px;">
                    <option value ='' checked>请选择充值方式</option>
                    {{foreach $pay_type as $type}}
                    {{if $type.pay_type!= ''}}
                    <option value = {{$type.pay_type}}>{{$type.pay_type}}</option>
                    {{/if}}
                    {{/foreach}}
                  </select>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <select class="form-control" id="pay_client_type" name="pay_client_type" style="width: 200px; height: 35px;">
                    <option value ='' checked>请选择支付客户端类型</option>
                    <option value ='h5' checked>h5</option>
                    <option value ='web' checked>web</option>
                    <option value ='app' checked>app</option>
                  </select>
              
              <p></p>
                  <select class="form-control" id="status" name="status" style="width: 150px; height: 35px;">
                    <option value ='' checked>请选择充值状态</option>
                    {{foreach $status as $key => $value}}
                    <option value = {{$value}}>{{$key}}</option>
                    {{/foreach}}
                  </select>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="input-group date"> 
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>  
                <input type="text" class="form-control pull-right" value="" id="start_time" name="start_time" placeholder="开始时间"/>
            </div> 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="input-group date"> 
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
                <input type="text" class="form-control pull-right" value="" id="end_time" name="end_time" placeholder="结束时间"/>
            </div>
          </div> 
            <p></p>    
            <div align="right">
                <input type="submit" class="btn btn-info" value="筛选">
            <a href="/order/maile-export-csv" id=export_csv onclick="  return ModidyHerf()" class="btn btn-info" role="button">导出订单</a>
            </div>
        </form>
        <p></p>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">麦乐订单</h3>
                <p></p>
                {{$html}}
            </div>
            
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th style="width: 15%;">麦乐支付订单号</th>
                        <th style="width: 15%;">商品订单号</th>
                        <th >购买平台</th>
                        <th >充值方式</th>
                        <th >充值金额</th>
                        <th >支付客户端类型</th>
                        <th >充值状态</th>
                        <th style="width: 5%;">币种</th>
                        <th> 创建时间</th>
                    </tr>
                    {{foreach $order as $item}}
                    <tr>
                        <td><b>{{$item.maile_pay_sn}}</b></td>
                        <td><b>{{$item.order_sn}}</b></td>
                        <td>{{$platform_array[$item.platform]}}</td>
                        <td>{{$item.pay_type}}</td>
                        <td>{{number_format($item.pay_amount/100,2)}}</td>
                        <td>{{$item.pay_client_type}}</td>
                        <td>{{$status_array[$item.status]}}</td>
                        <td>{{$item.fee_type}}</td>
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
<link href="/public/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
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
      {$('#order_sn').val(res[1])}
      if(res[2] != '')
      {$('#platform').val(res[2])}
      if(res[3] != '')
      {$('#pay_type').val(res[3])}
      if(res[4] != '')
      {$('#pay_client_type').val(res[4])}
      if(res[5] != '')
      {$('#status').val(res[5])}
      if(res[6] != '')
      {$('#start_time').val(res[6])}
      if(res[7] != '')
      {$('#end_time').val(res[7])}

    }

    function ModidyHerf(){
        var res = UrlSearch();
        var flag = res_is_void(res);
        if(flag || !res)
        {
          alert("请筛选条件后再导出!");
          return false;
        }
        var a = document.getElementById("export_csv");
        a.href += ("?maile_pay_sn=" + res[0] + "&order_sn=" + res[1] + "&platform=" + res[2] + "&pay_type=" +res[3]+ "&pay_client_type=" +res[4] + "&status=" + res[5] + "&start_time=" +res[6] + "&end_time=" +res[7] );
        return true;
    }
</script>
{{/block}}
