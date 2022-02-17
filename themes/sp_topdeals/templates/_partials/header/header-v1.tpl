<div class="header_v1">
	{block name='header'}
		<div class="header-bonus">
			{hook h="displayCustomhtml1"}
			<div class="topbar-close"><span class="button">button</span></div>
		</div>
		{block name='header_top'}
		  	<nav class="header-top">
				<div class="container">
					<div class="row">
						<div class="box-left col-lg-6 col-md-7 hidden-sm-down">
							{hook h="displayCustomhtml2"}
						</div>
						<div class="box-right clearfix col-lg-6 col-md-5 col-xs-12">
							<div class="header-top-right">
								{hook h="displayNav"}
								{hook h="displayUserinfo"}
							</div>
						</div>
					</div>
				</div>
		  	</nav>
		{/block}
		{block name='header_center'}
		  	<div class="header-center">
				<div class="container">
			   		<div class="row">
						<div id="header-logo" class="col-lg-3 col-md-12 col-xs-12">
				  			<a href="{$urls.base_url}">
								<img class="logo img-responsive" src="{$shop.logo}" alt="{$shop.name}">
				  			</a>
						</div>
						<div id="header_search" class="col-lg-6 col-md-7 col-xs-8">
							{hook h='displaySearchPro'}
						</div>
						<div class="html-cart col-lg-3 col-md-5 col-xs-4">
							{hook h="displayCustomhtml3"}
							<div id="header-cart">
								{hook h='displayCart'}
								<div id="_mobile_cart" class="pull-xs-right"></div>
							</div>
						</div>
			  		</div>
				</div>
		  	</div>
		{/block}
		{block name='header_bottom'}
			<div class="header-bottom {if $SP_keepMenuTop}menu-on-top {/if}">
				<div class="container">
					<div class="header-ontop">
						<div class="row">
							<div id="vertical_menu" class="col-lg-3 col-xs-12">
								{hook h='displayVertical'}
							</div>
							<div id="header_menu" class="clearfix col-lg-9 col-xs-12">
								{hook h="displayMenu"}
								<div class="custom-link-deal">
									<a class="view-deal" href="{$urls.pages.prices_drop}" title=""{l s='Today Deals' d='Shop.Theme.Global'}"">{l s='Today Deals' d='Shop.Theme.Global'}</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		{/block}
		{if {$page.page_name} == 'index'}
			<div class="slider-banner clearfix">
				<div class="container">
					<div class="row">
						<div class="slider-container col-lg-9 col-md-12 col-xs-12">
							{hook h='displayHomeSlider'}
							<div class="banner-layout-1 clearfix">
								{hook h="displayBanner"}
								{hook h="displayBanner2"}
								{hook h="displayBanner3"}
							</div>
						</div>
						<div class="deal-top col-lg-3 col-md-12 col-xs-12">
							{hook h="displayDeal"}
						</div>
					</div>
				</div>
			</div>
			<div class="spotlight-1 clearfix">
				<div class="container">
					{hook h="displayCustomhtml4"}
				</div>
			</div>
		{/if}
	{/block}
</div>