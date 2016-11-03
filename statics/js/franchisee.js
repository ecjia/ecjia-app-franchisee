// JavaScript Document
;(function (app, $) {
    app.franchisee = {
        init: function () {
            //单选框切换事件
            $(document).on('click', 'input[name="validate_type"]', function (e) {
            	if ($("input[name='validate_type']:checked").val() == 1) {
            		$('.company_info').addClass('hide');
            		$('.responsible_person').html('负责人姓名：');
            	} else {
            		$('.company_info').removeClass('hide');
            		$('.responsible_person').html('法定代表人姓名：');
            	}
            });
            $('input[name="validate_type"]:checked').trigger('click');
        	
        	var InterValObj; 	//timer变量，控制时间
    		var count = 120; 	//间隔函数，1秒执行
    		var curCount;		//当前剩余秒数
    		
            $("#get_code").on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('data-url')+'&mobile=' + $("input[name='mobile']").val();
                $.get(url, function (data) {
                	if (data.state == 'success') {
	        		  　    curCount = count;
	        		     $("#mobile").attr("readonly", "true");
	        		     $("#get_code").attr("disabled", "true");
	        		     $("#get_code").html("重新发送" + curCount + "(s)");
	        		     InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
					}
                    ecjia.merchant.showmessage(data);
                }, 'json');
            });
            
            //timer处理函数
            function SetRemainTime() {
	            if (curCount == 0) {                
	                window.clearInterval(InterValObj);		//停止计时器
	                $("#mobile").removeAttr("readonly");	//启用按钮
	                $("#get_code").removeAttr("disabled");	//启用按钮
	                $("#get_code").html("重新发送验证码");
	            }
	            else {
	                curCount--;
	                $("#get_code").html("重新发送" + curCount + "(s)");
	            }
	        };
         
            var $form = $("form[name='theForm']");
			var option = {
		            rules: {
		            	mobile: "required",
		            	merchants_name: "required",
		            },
		            messages: {
		            	mobile: "请输入手机号码",
		            	merchants_name: "请输入店铺名称",
		            },
					submitHandler : function() {
						curCount = 0;
						$form.ajaxSubmit({
							dataType : "json",
							success : function(data) {
								if (data.message == '') {
									ecjia.pjax(data.url);
								} else {
									ecjia.merchant.showmessage(data);
								}
							}
						});
					}
				}
			var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
			$form.validate(options);
        },
    }
    
})(ecjia.merchant, jQuery);
 
// end