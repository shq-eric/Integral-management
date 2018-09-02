(function($){
	$('img.img-upload').each(function(){
		//取得img 属性
		var src = $(this).data('src') || '';
		var name = $(this).data('name') || '';
		//生成 input
		var $input = $('<input type="hidden" value="'+src+'" name="'+name+'"/>');
		//在img前插入input
		$(this).before($input);

		if(!src) {
			$(this).addClass('upload-no-img');
		}
		else {
			$(this).attr('src', src);
		}
	});
	//绑定img点击事件
	$('img.img-upload').on('click', function(){
		(function(that){
			//取得图片宽高
			var width = $(that).data('width') || 0;
			var height = $(that).data('height') || 0;
			var name = $(that).data('name') || 0;

			//设置跨域
			var domain = document.domain;
			document.domain = "mailejifen.com";
			$.upload({
	            url: 'uploads',
	            fileName: 'file',
	            dataType: 'json',
	            params: {
	        		width: width,
					height: height,
					name:name,
	            },
	            onComplate: function(response) {
					if(response.code==31001){
						showModal({title:response.data,showCloseBtn:true,hideConfirmBtn:true});
						return;
					}
					document.domain = domain;
	            	if(response.code === 0) {
						//上传成功
						var Div = $(that).parent().parent();
						var Length =Div.prevAll().length;

						//判断对象个数
						if(Length > 6){
							Div.hide();
							Div.children().find('input').remove();
						}else{
							//判断是否为缩略图
							if($(that).attr('id') == 'thu'){
								$(that).attr('src',response.data.url);
								$(that).prev().val(response.data.url);
							}else{

								//克隆对象
								var newDiv = Div.clone(true);

								Div.after(newDiv);
								//添加删除按钮
								Div.children().after("<img src='/public/image/del.jpg' class='del-1'>");
								Div.children().find('img').attr('src','/public/image/load.gif');
								//加载效果
								setTimeout(function (){
									Div.children().find('img').removeAttr('src');
									Div.children().find('img').attr('src',response.data.url);
								}, 500);

								//移除图片点击事件
								Div.children().find('img').unbind("click");
								$(that).prev().val(response.data.url);
							}
						}
						//显示删除按钮
						$('.del-1').click(function(){
							$(this).parent().remove();
							Div.show();
						});
					}
	            	else {
	            		alert(response.msg);
	            	}
	            }
			});
		})(this);
	});
})(jQuery)