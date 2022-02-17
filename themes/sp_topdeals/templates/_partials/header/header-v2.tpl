<div class="header_v2 clearfix">
	{block name='header'}
		{block name='header_top'}
		  	<nav class="header-top">
				<div class="container">
					<div class="row">
						<div id="header-logo" class="col-lg-3 col-xs-6">
				  			<a href="{$urls.base_url}">
								<img class="logo img-responsive" src="{$shop.logo}" alt="{$shop.name}">
				  			</a>
						</div>

						<div class="width-bonus-menu-2 col-lg-7 hidden-md-down">
							{hook h="displayCustomhtml9"}
						</div>

						<div id="header-cart" class="col-lg-3 col-xs-6">
							{hook h='displayCart'}
							<div id="_mobile_cart" class="pull-xs-right"></div>
						</div>

					</div>
				</div>
		  	</nav>
		{/block}
		{block name='header_bottom'}
			<div class="header-bottom {if $SP_keepMenuTop}menu-on-top{/if}">
				<div class="container">
					<div class="header-ontop">
						<div class="row">
							<div class="main-menu col-lg-8 col-md-6 col-xs-3">
								<div id="header_menu">
									{hook h="displayMenu"}
								</div>
							</div>
							<div id="header_search" class="col-lg-4 col-md-6 col-xs-9">
								{hook h='displaySearchPro'}
							</div>

						</div>
					</div>
				</div>
			</div>
		{/block}

		{include file="./button-nav.tpl"}
		{hook h="displayUserinfo"}

		{if {$page.page_name} == 'index'}
			<div class="slider-banner clearfix">
				<div class="container">
					<div class="row">
						<div id="vertical_menu" class="col-lg-3 col-xs-12">
							{hook h='displayVertical'}
						</div>
						<div class="slider-container col-lg-9 col-xs-12">
							{hook h='displayHomeSlider2'}
							<div class="banner-layout-3 clearfix">
								{hook h="displayBanner12"}
								{hook h="displayBanner13"}
							</div>
						</div>
					</div>
				</div>
			</div>
		{/if}
	{/block}
</div>