{{extends file='layouts/index.php'}}
{{block name=title}}麦乐积分 | 商户后台{{/block}}

{{block name=breadcrumb}}
<li class="active">{{$title}}</li>
{{/block}}

{{block name=content}}
<form method="post">
    <table width="100%" border="0">
        <table width="100%" border="0">
        <tr>
            <td>
                 应用名称*<input type="text" class="form-control" value="{{$model.name}}" name="name" />
            </td>
        </tr>
        <tr>
            <td>
                key<input type="text" class="form-control" value="{{$model.key}}" name="key" disabled/>
            </td>
        </tr>
        <tr>
            <td>
                secret<input type="text" class="form-control" value="{{$model.secret}}" name="secret" disabled/>
            </td>
        </tr>
        <tr>
            <td>
                <p></p>
                应用状态*
                <div>
                    <label checkbox-inline>
                        启用<input type="radio" name="status" value="0"/>
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label checkbox-inline>
                        禁用<input type="radio" name="status" value="1"/>
                    </label>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <input type="submit" class="btn-primary btn" id="btnSubmit" value="提交" />&nbsp;&nbsp;&nbsp;<a href="/application/list" type="submit" class="btn-default btn">返回</a>
</form>
{{/block}}


{{block name=js}}
<script src="/public/js/jquery.upload.js"></script>
<script src="/public/js/jquery.myupload.js"></script>
<script type="text/javascript"> 
$(function() {
    $("#btnSubmit").click(function(){
            var val_name=$("#name").val();
            if(val_name==''){
                alert("名称不能为空!");
                return false; 
            }
    });
});
</script>
<script type="text/javascript">  
    $(function() {
        var sta = {{$model['status']}}
        $(":input[name='status']").eq(sta).attr("checked",true);  
        
    });
</script>
{{/block}}