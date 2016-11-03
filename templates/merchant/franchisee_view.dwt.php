<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="common_header"} -->
<!-- #BeginLibraryItem "/library/franchisee_header.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->      
        
<!-- {block name="common_footer"} -->
<!-- #BeginLibraryItem "/library/franchisee_footer.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.franchisee.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>


<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
				{if $step eq 1}
				<form class="cmxform form-horizontal" name="theForm" action="{$form_action}" method="post">
					<div class="form-group">
					  	<label class="control-label col-lg-2">手机号码：</label>
					  	<div class="controls col-lg-6">
					      	<input class="form-control" name="mobile" id="mobile" placeholder="请输入手机号码" type="text"/>
					  	</div>
					 	<a class="btn btn-primary" data-url="{url path='franchisee/merchant/get_code_value'}" id="get_code">获取短信验证码</a>
					</div>
					<div class="form-group">
					  	<label class="control-label col-lg-2">{t}短信验证码：{/t}</label>
					  	<div class="col-lg-6">
					      	<input class="form-control" name="code" placeholder="请输入手机短信验证码" type="text"/>
					  	</div>
					</div>
					<div class="form-group ">
						<div class="col-lg-6 col-md-offset-2">
							<input class="btn btn-primary" type="submit" value="下一步">
					  	</div>
					</div>
				</form>
       			{/if} 
            </div>
        </section>
    </div>
</div>
<!-- {/block} -->
