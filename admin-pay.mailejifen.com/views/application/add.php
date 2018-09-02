{{extends file='layouts/index.php'}}
{{block name=title}}麦乐积分 | 商户后台{{/block}}

{{block name=js}}
<script src="/public/js/jquery.upload.js"></script>
<script src="/public/js/jquery.myupload.js"></script>
<script src="/public/js/moment.min.js"></script>
<link rel="stylesheet" href="/public/css/upload.css">

{{/block}}

{{block name=breadcrumb}}
<li class="active">{{$title}}</li>    
{{/block}}

{{block name=content}}
<form method="post">
    <table width="100%" border="0">
        <table width="100%" border="0">
        <tr>
            <td>
                 平台标识* <input type="text" class="form-control" value="{{$model.platform}}" name="platform" {{if $model}}disabled{{/if}} />
            </td>
        </tr>
            <td>
                 应用名称*<input type="text" class="form-control" value="{{$model.name}}" name="name" />
            </td>
        </tr>
        <tr>
            <td>
                <p></p>
                应用状态*
                <div>
                    <label checkbox-inline>
                        启用<input type="radio" class="minimal" checked name="status" value="0"  />
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label checkbox-inline>
                        禁用<input type="radio" class="minimal" name="status" value="1"/>
                    </label>
                </div> 
            </td>
        </tr>
    </table>
    <br>
    <input type="submit" class="btn-primary btn" id="btnSubmit" value="提交"  />&nbsp;&nbsp;&nbsp;<a href="/application/list" type="submit" class="btn-default btn">返回</a>
</form>
{{/block}}