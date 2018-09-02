(function($) {

    $.fn.extend({

        myValidator: function(opt) {
        	opt = $.extend({
        		validators: {},
        		error: '.error',
        		onError: null,
        		onSuccess: null,
                onBeforePost: null,
            }, opt);
        	
            $(this).find('input,select,textarea').on('keydown', function(){
                $(this).parents('form').find('.auto-help-block').remove();
                $(this).parents('form').find(opt.error).hide();
            });

            $(this).bootstrapValidator({
                fields: opt.validators,
                submitHandler: function(validator, form, submitButton) {
                    var _form = form.serialize();
                    
                    if(opt.onBeforePost && !opt.onBeforePost(_form)){
                        return;
                    }

                	var method = form.attr('method').toLowerCase() || 'get';

                    $[method](form.attr('action') || '', _form, function(result) {

                        if (result.code !== 0) {
                        	if(opt.onError && !opt.onError(result)) {

                        		return;
                        	}
                        	
                            if (!result.data) {
                                if (form.find('.error').size()) {
                                    form.find('.error .help-block').html(result.msg);
                                    form.find('.error').show();
                                } else {

                                    showModal({title:result.msg,url:''});
                                }

                            }else{
                                for (var name in result.data){

                                    var error = result.data[name][0];
                                    form.find('input[name="' + name + '"],textarea[name="' + name + '"],selected[name="' + name + '"]').parents('.form-group').eq(0).removeClass('has-success').addClass('has-error');
                                    var helpBlock = form.find('input[name="' + name + '"],textarea[name="' + name + '"],selected[name="' + name + '"]').parent().find('.help-block');
                                    //var errorBlock = helpBlock.clone();
                                    helpBlock.addClass('auto-help-block');
                                	//helpBlock.after(errorBlock);
                                    helpBlock.html(error).show();
                                  }
                            }

                        } else {
                            if(opt.onSuccess && !opt.onSuccess(result)){

                                return;
                        	}

                            location.assign(form.data('go') || location.href);
                        }


                    },
                    'json');
                }
            });

            return this;
        }

    })

})(jQuery);

var showModal = function(opt){

    $('#myModal').modal(
        //当用户点击模态框外部时不会关闭模态框
        {backdrop:false}
    );
     //提示标题
    $('#myModalLabel').html(opt.title);
    //是否显示关闭btn
    if(opt.showCloseBtn){
       $('.btn-no').show();
    }else{
       $('.btn-no').hide();
    }
    if(opt.hideConfirmBtn){
        $('.btn-ok').hide();
    }else{
        //url跳转
        $('.btn-ok').click(function (){
            location.assign(opt.url);
        });
    }

}
