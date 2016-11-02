<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<!-- start:footer -->
<!-- <footer> -->
<!--     <div class="container"> -->
        
<!--     </div> -->
<!-- </footer> -->
<div class="footer-bottom">
    <div class="container">
        <div class="footer-bottom-widget">
            <div class="row">
                <div class="col-sm-6">
                    <p>
	                    <span class="sosmed-footer">
	                    	{if ecjia::config('merchant_admin_weibo')}
	                        <a target="__blank" href="{ecjia::config('merchant_admin_weibo')}"><i class="fa fa-weibo" title="新浪微博"></i></a>
	                        {/if}
	                        
	                    	{if ecjia::config('merchant_admin_qq')}
	                        <a target="__blank" href="{ecjia::config('merchant_admin_qq')}"><i class="fa fa-qq" data-toggle="tooltip" data-placement="top" title="腾讯QQ"></i></a>
	                        {/if}
	                        
	                        {if ecjia::config('merchant_admin_weixin')}
	                        <a href="javascript:;" style="color:#333333;"><i class="fa fa-weixin" data-toggle="popover" data-placement="top" data-id="merchant_admin_weixin" title="打开手机微信扫一扫"></i></a>
	                        {/if}
	                        
	                        {if ecjia::config('merchant_admin_skype')}
	                        <a target="__blank" href="{ecjia::config('merchant_admin_skype')}"><i class="fa fa-skype" title="Skype"></i></a>
	                        {/if}
	                        
	                        {if ecjia::config('merchant_admin_html5')}
	                        <a target="__blank" href="{ecjia::config('merchant_admin_html5')}"><i class="fa fa-html5" title="HTML5 App"></i></a>
	                        {/if}
	                        
	                        {if ecjia::config('merchant_admin_iphone')}
	                        <a href="javascript:;" style="color:#333333;"><i class="fa fa-apple" data-toggle="popover" data-placement="top" data-id="merchant_admin_iphone" title="打开手机扫描二维码下载"></i></a>
	                        {/if}
	                        
	                        {if ecjia::config('merchant_admin_android')}
	                        <a href="javascript:;" style="color:#333333;"><i class="fa fa-android" data-toggle="popover" data-placement="top" data-id="merchant_admin_android" title="打开手机扫描二维码下载"></i></a>
	                    	{/if}
	                    </span>
	                    
	                    <div class="hide" id="content_merchant_admin_weixin">
                        	<div class="t_c"><img class="w100 h100" src="{RC_Upload::upload_url(ecjia::config('merchant_admin_weixin'))}"></div>
                        </div>
                        
                        <div class="hide" id="content_merchant_admin_iphone">
                        	<div class="t_c"><img class="w100 h100" src="{RC_Upload::upload_url(ecjia::config('merchant_admin_iphone'))}"></div>
                        </div>
                        
                        <div class="hide" id="content_merchant_admin_android">
                        	<div class="t_c"><img class="w100 h100" src="{RC_Upload::upload_url(ecjia::config('merchant_admin_android'))}"></div>
                        </div>
                    </p>
                </div>
                <div class="col-sm-6">
                    <p class="footer-bottom-links">
                    Copyright &copy; 2016 {ecjia::config('shop_name')} {if ecjia::config('icp_number', 2)}<a href="http://www.miibeian.gov.cn" target="_blank">{ecjia::config('icp_number')}</a>{/if}
                    </p>
                    <p class="footer-bottom-links">
                        <!-- {foreach from=$ecjia_merchant_shopinfo_list item=val} -->
                        <a class="data-pjax" href='{url path="merchant/merchant/shopinfo" args="id={$val.article_id}"}'>{$val.title}</a>
                        <!-- {/foreach} -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$("[data-toggle='popover']").popover({
	trigger: 'hover',
	html: true,
	content: function() {
        var id = $(this).attr('data-id');
        return $("#content_" + id).html();
	}
});
</script>
<!-- end:footer -->
<div class="container">
<!-- {ecjia:hook id=admin_print_main_bottom} -->
</div>
