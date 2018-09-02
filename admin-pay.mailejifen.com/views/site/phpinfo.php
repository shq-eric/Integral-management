{{extends file='layouts/index.php'}}
{{block name=title}}麦乐积分 | 服务器信息{{/block}}
{{block name=content}}
<style>
    a:link {
        background: none !important;
    }
</style>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">PhpInfo</h3>
    </div>
    {{phpinfo()}}
</div>
{{/block}}