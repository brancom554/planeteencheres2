{if $list != ''}
	{foreach from=$list item=item key=k}
		{assign var="moduleclass_sfx" value=( isset( $item.params.moduleclass_sfx ) ) ?  $item.params.moduleclass_sfx : ''}
		{assign var="spverticalmenu_limit" value=( isset( $item.params.limit ) ) ?  $item.params.limit : 9}
		<div id="spverticalmenu_{$k}" class="spverticalmenu {$moduleclass_sfx|escape:'html':'UTF-8'}">
			{if isset($item.params.display_title_module) && $item.params.display_title_module && !empty($item.title)}
				<h3>
					{$item.title|escape:'html':'UTF-8'}
				</h3>
			{/if}	
			<nav class="navbar-default navbar-vertical" role="navigation">
				<div class="navbar-header">
					<button type="button" id="show-vermegamenu" data-toggle="collapse" data-target=".sp-vermegamenu" class="navbar-toggle">
					</button>
				</div>
				<div id="sp-vermegamenu" class="sp-vermegamenu clearfix">
					<span id="remove-vermegamenu" class="icon-remove"></span>
					<h2 class="cat-title">
						<span class="icon">
							<span class="line"></span>
							<span class="line"></span>
							<span class="line"></span>
						</span>
						{l s='Categories' d='Shop.Theme.Actions'}
					</h2>
					<div class="sp-verticalmenu-container">
						{$item.vermegamenu nofilter}
					</div>
				</div>
			</nav>	
		</div>
		<script type="text/javascript">{literal}

		$(document).ready(function() {
			var $element = $("#spverticalmenu_{/literal}{$k}{literal}");
			var limit = {/literal}{$spverticalmenu_limit}{literal} ;
			if($( ".sp-vermegamenu .sp-verticalmenu-container >ul >li",$element).length > limit)		
				$(".sp-vermegamenu .sp-verticalmenu-container >ul",$element).append('<div class="more-wrap"><i class="icon-plus-sign-alt"></i><span class="more-view">{/literal}{l s="More Categories" d="Shop.Theme.Actions"}{literal}</span></div>');
			$(".sp-vermegamenu .item-1",$element).each(function(i){
				if(i> (limit -1)){ 
					$(this).css('display', 'none');
				}			
			});

			$(".sp-vermegamenu .more-wrap",$element).click(function(){
				var this_more = $(this);
				if($(this).hasClass('open')){
					$(".sp-vermegamenu .item-1",$element).each(function(i){
						if(i>limit-1){
							$(this).slideUp(200);
						}
					});
					$(this).removeClass('open');
					$(this_more).html('<span class="more-view">{/literal}{l s="More Categories" d="Shop.Theme.Actions"}{literal}</span>');
				}else{
					$('.sp-vermegamenu .item-1',$element).each(function(i){
						if(i>limit-1){
							$(this).slideDown(200);
						}
					});
					$(this).addClass('open');
					$(this_more).html('<span class="more-view">{/literal}{l s="Close Menu" d="Shop.Theme.Actions"}{literal}</span>');
				}
			});

				var wd_width = $(window).width();
				if(wd_width > 767){
					offtogglevermegamenu($element);
					renderWidthSubmenu($element);
				}	
					
				$(window).resize(function() {
					var sp_width = $( window ).width();
					if(sp_width > 767){
						offtogglevermegamenu($element);
						renderWidthSubmenu($element);
					}	
				});
					
				$(".sp-vermegamenu  li.parent  .grower",$element).click(function(){
						if($(this).hasClass('close'))
							$(this).addClass('open').removeClass('close');
						else
							$(this).addClass('close').removeClass('open');
							
						$('.dropdown-menu',$(this).parent()).first().toggle(300);
						
				});
				
				
				$('#show-vermegamenu',$element).click(function() {
					if($('.sp-vermegamenu',$element).hasClass('sp-vermegamenu-active'))
						$('.sp-vermegamenu',$element).removeClass('sp-vermegamenu-active');
					else
						$('.sp-vermegamenu',$element).addClass('sp-vermegamenu-active');
					return false;
				});
				
				$('#remove-vermegamenu',$element).click(function() {
					$('.sp-vermegamenu',$element).removeClass('sp-vermegamenu-active');
					return false;
				});				

		});
		
		
	{/literal}</script>
	{/foreach}	
	
	<script type="text/javascript">{literal}	
		function offtogglevermegamenu($element)
		{
			$('.sp-vermegamenu li.parent .dropdown-menu',$element).css('display','');	
			$('.sp-vermegamenu',$element).removeClass('sp-vermegamenu-active');
			$(".sp-vermegamenu  li.parent  .grower",$element).removeClass('open').addClass('close');	
		}

		function renderWidthSubmenu($element)
		{
			$('.sp-vermegamenu  li.parent',$element).each(function(){
				value = $(this).data("subwidth");
				if(value){
					var container_width = $('.container',$element).width();
					var vertical_width = $('.sp-vermegamenu',$element).width();
					var full_width = container_width - vertical_width;
					var width_submenu = (full_width*value)/100;
					$('> .dropdown-menu',this).css('width',width_submenu+'px');
				}	
			});
		}			
	{/literal}</script>
	
{/if}