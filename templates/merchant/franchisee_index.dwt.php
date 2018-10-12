<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="meta"} -->
<title>
商家入驻 - {ecjia::config('shop_name')}
</title>
<!-- {/block} -->

<!-- {block name="title"} -->
商家入驻 - {ecjia::config('shop_name')}
<!-- {/block} -->

<!-- {block name="common_header"} -->
<!-- #BeginLibraryItem "/library/common_nologin_header.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="container settled-container" style="">
	<div class="sett-banner" style="background:url(https://x.dscmall.cn/storage/data/afficheimg/1489978643396742470.jpg) center center no-repeat;">
		<div class="banner-auto" style="width: 1100px;">
			<div class="s-b-tit">
				<h3>马上入驻 开向未来</h3>
				<div class="s-b-line">
				</div>
			</div>
			<div class="s-b-btn">
				<a href="{RC_Uri::url('franchisee/merchant/index')}" class="im-sett">我要入驻</a>
				<a href="{RC_Uri::url('franchisee/merchant/view')}" class="view-prog">入驻进度查询</a>
			</div>
		</div>
	</div>
	<div class="sett-section s-section-step">
		<div class="w w1200">
			<div class="sett-title">
				<div class="zw-tit">
					<h3>入驻流程</h3>
					<span class="line"></span>
				</div>
				<span class="yw-tit">ADVANCE REGISTRATION PROCESS</span>
			</div>
			<div class="sett-warp">
				<div class="item item-one">
					<div class="item-i">
						<i></i>
					</div>
					<div class="tit">
						1 提交入驻资料
					</div>
					<span>选择店铺类型/品牌</span>
					<span>填写入驻信息</span>
				</div>
				<em class="item-jt"></em>
				<div class="item item-two">
					<div class="item-i">
						<i></i>
					</div>
					<div class="tit">
						2 商家等待审核
					</div>
					<span>平台审核入驻信息</span>
					<span>通知商家</span>
				</div>
				<em class="item-jt"></em>
				<div class="item item-three">
					<div class="item-i">
						<i></i>
					</div>
					<div class="tit">
						3 完善店铺信息
					</div>
					<span>登录商家后台</span>
					<span>完善店铺信息</span>
				</div>
				<em class="item-jt"></em>
				<div class="item item-four">
					<div class="item-i">
						<i></i>
					</div>
					<div class="tit">
						4 店铺上线
					</div>
					<span>上传商品</span>
					<span>发布销售</span>
				</div>
			</div>
		</div>
	</div>
	<div class="sett-section s-section-cate">
		<div class="w w1200">
			<div class="sett-title">
				<div class="zw-tit">
					<h3>热招类目</h3>
					<span class="line"></span>
				</div>
				<span class="yw-tit">BUSINESS CATEGORY</span>
			</div>
			<div class="sett-warp">
				<div class="item">
					<i style="background:url(https://x.dscmall.cn/storage/data/afficheimg/1489978876184880114.png) center center no-repeat;width:98;height:85;display:display;float:left"></i><span>家用电器</span>
				</div>
				<div class="item">
					<i style="background:url(https://x.dscmall.cn/storage/data/afficheimg/1489978926013749778.png) center center no-repeat;width:98;height:85;display:display;float:left"></i><span>家居、家具、家装、厨具</span>
				</div>
				<div class="item">
					<i style="background:url(https://x.dscmall.cn/storage/data/afficheimg/1489978893615987749.png) center center no-repeat;width:98;height:85;display:display;float:left"></i><span>手机、数码、通信</span>
				</div>
				<div class="item">
					<i style="background:url(https://x.dscmall.cn/storage/data/afficheimg/1489978972367649095.png) center center no-repeat;width:98;height:85;display:display;float:left"></i><span>男装、女装、内衣</span>
				</div>
				<div class="item">
					<i style="background:url(https://x.dscmall.cn/storage/data/afficheimg/1489978986231187639.png) center center no-repeat;width:98;height:85;display:display;float:left"></i><span>鞋靴、箱包、钟表、奢侈品</span>
				</div>
				<div class="item">
					<i style="background:url(https://x.dscmall.cn/storage/data/afficheimg/1490910332576618152.png) center center no-repeat;width:98;height:85;display:display;float:left"></i><span>个人化妆、清洁用品</span>
				</div>
				<div class="item">
					<i style="background:url(https://x.dscmall.cn/storage/data/afficheimg/1489978943655622374.png) center center no-repeat;width:98;height:85;display:display;float:left"></i><span>休闲、运动、户外健身</span>
				</div>
				<div class="item">
					<i style="background:url(https://x.dscmall.cn/storage/data/afficheimg/1489978957373122314.png) center center no-repeat;width:98;height:85;display:display;float:left"></i><span>食品、酒类、生鲜、特产</span>
				</div>
			</div>
		</div>
	</div>
	<div class="sett-section s-section-case">
		<div class="w w1200">
			<div class="sett-title">
				<div class="zw-tit">
					<h3>成功案例</h3>
					<span class="line"></span>
				</div>
				<span class="yw-tit">SUCCESSFUL CASE</span>
			</div>
			<div class="sett-warp">
				<div class="item item1">
					<div class="item-top">
						<a href="https://www.dscmall.cn/" target="_blank"><img src="https://x.dscmall.cn/storage/data/afficheimg/1490061461513345174.png"></a>
					</div>
					<div class="item-bot">
						<div class="tit">
							模板堂官方旗舰店
						</div>
						<div class="desc">
							模板堂是国内最专业、最具开发实力的独立电子商务服务与技术提供商，业内首家股交所挂牌企业
						</div>
					</div>
				</div>
				<div class="item item2">
					<div class="item-top">
						<a href="https://www.dscmall.cn/" target="_blank"><img src="https://x.dscmall.cn/storage/data/afficheimg/1489979528200662778.png"></a>
					</div>
					<div class="item-bot">
						<div class="tit">
							ECJia电商专营店
						</div>
						<div class="desc">
							ECJia为你提供当下多种主流设备的商城开发业务，实现电商领域从移动端到PC端的终极解决方案的全方位布局
						</div>
					</div>
				</div>
				<div class="item item3">
					<div class="item-top">
						<a href="https://www.dscmall.cn/" target="_blank"><img src="https://x.dscmall.cn/storage/data/afficheimg/1489979554533969030.png"></a>
					</div>
					<div class="item-bot">
						<div class="tit">
							大商创电商系统
						</div>
						<div class="desc">
							在商创网络基于十年的电商架构重构下，打造出了一套可以满足运营商、供货商、采购商、用户分销等，在PC与移动设备上
						</div>
					</div>
				</div>
				<div class="item item4">
					<div class="item-top">
						<a href="https://www.dscmall.cn/" target="_blank"><img src="https://x.dscmall.cn/storage/data/afficheimg/1489979583329456244.png"></a>
					</div>
					<div class="item-bot">
						<div class="tit">
							ECTouch自营店
						</div>
						<div class="desc">
							ECTouch是上海商创网络科技有限公司推出的一款移动商城网店系统，可以在手机上面卖商品的电子商务软件系统
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="sett-section s-section-help">
		<div class="w w1200">
			<div class="sett-title">
				<div class="zw-tit">
					<h3>常见问题</h3>
					<span class="line"></span>
				</div>
				<span class="yw-tit">COMMON PROBLEM</span>
			</div>
			<div class="sett-warp">
				<div class="item item-right">
					<div class="number">
						01
					</div>
					<div class="info">
						<div class="name">
							<div class="tit">
								<a href="article.php?id=1" target="_blank">免责条款</a>
							</div>
							<div class="desc">
							</div>
						</div>
					</div>
				</div>
				<div class="item item-left">
					<div class="number">
						02
					</div>
					<div class="info">
						<div class="name">
							<div class="tit">
								<a href="article.php?id=2" target="_blank">隐私保护</a>
							</div>
							<div class="desc">
							</div>
						</div>
					</div>
				</div>
				<div class="item item-right">
					<div class="number">
						03
					</div>
					<div class="info">
						<div class="name">
							<div class="tit">
								<a href="article.php?id=3" target="_blank">咨询热点</a>
							</div>
							<div class="desc">
							</div>
						</div>
					</div>
				</div>
				<div class="item item-left">
					<div class="number">
						04
					</div>
					<div class="info">
						<div class="name">
							<div class="tit">
								<a href="article.php?id=4" target="_blank">联系我们</a>
							</div>
							<div class="desc">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

{if ecjia::config('stats_code')}
	{stripslashes(ecjia::config('stats_code'))}
{/if}
<!-- {/block} -->
