<div class="header_v3">
	{block name='header'}
		{block name='header_top'}
		  	<nav class="header-top {if $SP_keepMenuTop}menu-on-top {/if}">
				<div class="container">
					<div class="main-contain clearfix">
						<div class="row">
							<div id="header_menu" class="col-lg-6 col-md-9 col-xs-4">
								{hook h="displayMenu"}
							</div>
							<div class="text-text col-lg-4 hidden-md-down">
								{hook h="displayCustomhtml12"}
							</div>
							<div class="nav-layout-3 col-lg-2 col-md-3 col-xs-8">
								{hook h="displayNav"}
							</div>
						</div>
					</div>
				</div>
		  	</nav>
		{/block}
		{block name='header_bottom'}
			<div class="header-bottom clearfix">
				<div class="container">
					<div class="header-ontop">
						<div id="header-logo" class="col-lg-2 col-md-2 col-xs-12">
				  			<a href="{$urls.base_url}">
								<img class="logo img-responsive" src="{$shop.logo}" alt="{$shop.name}">
				  			</a>
						</div>
						<div id="header_search" class="col-lg-6 col-md-6 col-xs-8">
							{hook h='displaySearchPro2'}
						</div>
						<div id="header-cart" class="col-lg-2 col-md-2 col-xs-2">
							{hook h='displayCart'}
							<div id="_mobile_cart"></div>
						</div>
						<div class="user-info-layout-3 col-lg-2 col-md-2 col-xs-2">
							{hook h="displayUserinfo"}
						</div>
					</div>
				</div>
			</div>
		{/block}

		{if {$page.page_name} == 'index'}
			<div class="slider-banner clearfix">
				<div class="container">
					<div class="row">
						<div id="vertical_menu" class="col-lg-3 col-xs-12">
							{hook h='displayVertical'}
						</div>
						<div class="slider-container col-lg-9 col-xs-12">
							<div class="slider-layout-3 col-lg-9 col-md-8">
								{hook h='displayHomeSlider3'}
							</div>

							<div class="deal-layout-3 col-lg-3 col-md-4">
								{hook h='displayDeal3'}
							</div>
						</div>
					</div>
				</div>
			</div>
		{/if}
	{/block}
</div>