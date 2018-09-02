{{block name=content}}
<div>错误：{{$msg}}</div>
{{/block}}
{{if $url}}
<script>setTimeout(function () {
        location.assign('{{$url}}');
    }, 1000);</script>
{{/if}}