{{extends file='layouts/index.php'}} {{block name=title}}麦乐积分 |
管理后台{{/block}}

{{block name=breadcrumb}}
<li class="active">URL生成</li>
{{/block}}
{{block name=content}}
UID :
<input type="text" name="uid" class="form-control">
APP_KEY : <input type="text" name="app_key" class="form-control">
<br>
<div  id="url"></div>

<br>
<br>
<input type="button" value="生成" class="btn btn-success" id="btnAjax">
{{/block}}


{{block name=js}}
<script>
    $('#btnAjax').click(function () {
        var key = $('input[name=app_key]').val();
        var uid = $('input[name=uid]').val();
        if (key.replace(/(^s*)|(s*$)/g, "").length == 0 || uid.replace(/(^s*)|(s*$)/g, "").length == 0) {
            alert('必填项');
            return;
        }
        $.post('/site/create-url', 'key=' + key + '&uid=' + uid, function (msg) {
            if (msg.code == '0') {
                $('#url').html(msg.data);
                //$('#url').attr('href', msg.data);

            } else {
                alert('生成失败哦!');
            }

        });

    });

</script>


{{/block}}