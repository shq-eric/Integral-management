<div>成功：{{$msg}}</div>
{{if $url}}
<script>setTimeout(function(){
	location.assign('{{$url}}');
}, 1000);</script>
{{/if}}