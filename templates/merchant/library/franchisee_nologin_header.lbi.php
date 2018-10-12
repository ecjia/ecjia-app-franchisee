<div class="height-50"></div>

<div id="header">
	<div class="header-content">
		<a href="{RC_Uri::home_url()}"><img class="wt-10" src="{if $shop_logo_url}{$shop_logo_url}{else}{$static_url}shop_logo.png{/if}"></a>
		<div class="head-item">
			<ul class="item-nav">
				<li {if !$smarty.get.id}class="active"{/if}><a href="{RC_Uri::url('franchisee/merchant/init')}">首页</a></li>
				<!-- {foreach from=$data item=val} -->
					{if $val.title eq '入驻流程'}
						<a href="{RC_Uri::url('franchisee/merchant/article')}&id={$val.article_id}"><li {if $smarty.get.id eq $val.article_id}class="active"{/if}>入驻流程</li></a>
					{else if $val.title eq '入驻协议'}
						<a href="{RC_Uri::url('franchisee/merchant/article')}&id={$val.article_id}"><li {if $smarty.get.id eq $val.article_id}class="active"{/if}>入驻协议</li></a>
					{else if $val.title eq '入驻帮助'}
						<a href="{RC_Uri::url('franchisee/merchant/article')}&id={$val.article_id}"><li {if $smarty.get.id eq $val.article_id}class="active"{/if}>入驻帮助</li></a>
					{else if $val.title eq '了解更多'}
						<a href="{RC_Uri::url('franchisee/merchant/article')}&id={$val.article_id}"><li {if $smarty.get.id eq $val.article_id}class="active"{/if}>了解更多</li></a>
					{/if}
				<!-- {/foreach} -->
			</ul>
			<div class="contact-phone">{$service_phone}</div>
		</div>
	</div>
</div>