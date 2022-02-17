{if $list != ''}
	{foreach from=$list item=item key=k}
		{assign var="moduleclass_sfx" value=( isset( $item.params.moduleclass_sfx ) ) ?  $item.params.moduleclass_sfx : ''}
		{assign var="spverticalmenu_limit" value=( isset( $item.params.limit ) ) ?  $item.params.limit : 9}

		<div id="spverticalmenu_{$k}" class="spverticalmenu {$moduleclass_sfx|escape:'html':'UTF-8'}">
			{if isset($item.params.display_title_module) && $item.params.display_title_module && !empty($item.title)}
				<h3 class="cat-title">
					{$item.title|escape:'html':'UTF-8'}
				</h3>
			{/if}	
			<nav class="navbar-default navbar-vertical">
				<div class="navbar-header">
					<button type="button" id="show-vermegamenu" data-toggle="collapse" data-target=".sp-vermegamenu" class="navbar-toggle">
						<span class="icon-bar bar1"></span>
						<span class="icon-bar bar2"></span>
						<span class="icon-bar bar3"></span>
					</button>
				</div>
				<div id="sp-vermegamenu" class="sp-vermegamenu clearfix">
					<span id="remove-vermegamenu">
						{l s='Categories' d='Shop.Theme.Actions'}
					</span>
					{$item.vermegamenu nofilter}
				</div>
			</nav>	
		</div>

		<script type="text/javascript">{literal}
			$(document).ready(function() {
				$('.spverticalmenu .cat-title').on("click", function(){
					if ( $('.spverticalmenu .menu').hasClass('show-menu') ) {
				        $('.spverticalmenu .menu').removeClass('show-menu');
				    } else {
				        $('.spverticalmenu .menu.current').removeClass('show-menu');
				        $('.spverticalmenu .menu').addClass('show-menu');
				    }
				});
				var wd_width = $(window).width();
				if(wd_width > 992){
					offtogglevermegamenu();
					renderWidthSubmenu();
				}	
				if(wd_width >= 1400)
					var limit = {/literal}{$spverticalmenu_params.limit1}{literal} -1 ;			
				else if(wd_width >= 1200 && wd_width<1400)
					var limit = {/literal}{$spverticalmenu_params.limit2}{literal} -1 ;
				else if(wd_width >= 768 && wd_width<1200)
					var limit = {/literal}{$spverticalmenu_params.limit3}{literal} -1 ;

				$('#sp-vermegamenu > ul').append('<div class="more-wrap"><i class="fa fa-plus-circle"></i><span class="more-view">{/literal}{l s='More Categories' d='Shop.Theme.Actions'}{literal}</span></div>');

				$('#sp-vermegamenu .item-1').each(function(i){
					if(i>limit)
						$(this).css('display', 'none');
					else
						$(this).css('display', 'block');		
				});

				$('#sp-vermegamenu .more-wrap').click(function(){
					if($(this).hasClass('open')){
						$('#sp-vermegamenu .item-1').each(function(i){
							if(i>limit){
								$(this).slideUp(200);
							}
						});
						$(this).removeClass('open');
						$('.more-wrap').html('<i class="fa fa-plus-circle"></i><span class="more-view">{/literal}{l s='More Categories' d='Shop.Theme.Actions'}{literal}</span>');
					}else{
						$('#sp-vermegamenu .item-1').each(function(i){
							if(i>limit){
								$(this).slideDown(200);
							}
						});
						$(this).addClass('open');
						$('.more-wrap').html('<i class="fa fa-minus-circle"></i><span class="more-view">{/literal}{l s='Close Menu' d='Shop.Theme.Actions'}{literal}</span>');
					}
				});
						
				$(window).resize(function() {
				
					var sp_width = $( window ).width();
					if(sp_width >= 1400)
						var sp_limit = {/literal}{$spverticalmenu_params.limit1}{literal} -1 ;
					else if(sp_width >= 1200 && sp_width<1400)
						var sp_limit = {/literal}{$spverticalmenu_params.limit2}{literal} -1 ;
					else if(sp_width >= 768 && sp_width<1200)
						var sp_limit = {/literal}{$spverticalmenu_params.limit3}{literal} -1 ;
					
					
					$('#sp-vermegamenu .item-1').each(function(i){
						if(i>sp_limit)
							$(this).css('display', 'none');
						else
							$(this).css('display', 'block');
					});		
					
					if(sp_width > 992){
						offtogglevermegamenu();
						renderWidthSubmenu();
					}			
					
				});	
				$("#sp-vermegamenu  li.parent  .grower").click(function(){
						if($(this).hasClass('close'))
							$(this).addClass('open').removeClass('close');
						else
							$(this).addClass('close').removeClass('open');
							
						$('.dropdown-menu',$(this).parent()).first().toggle(300);
				});
			});

	$('#show-vermegamenu').click(function() {
		if($('.sp-vermegamenu').hasClass('sp-vermegamenu-active'))
			$('.sp-vermegamenu').removeClass('sp-vermegamenu-active');
		else
			$('.sp-vermegamenu').addClass('sp-vermegamenu-active');
        return false;
    });
	
	$('#remove-vermegamenu').click(function() {
        $('.sp-vermegamenu').removeClass('sp-vermegamenu-active');
        return false;
    });
	
	
	function offtogglevermegamenu()
	{
		$('#sp-vermegamenu li.parent .dropdown-menu').css('display','');	
		$('#sp-vermegamenu').removeClass('sp-vermegamenu-active');
		$("#sp-vermegamenu  li.parent  .grower").removeClass('open').addClass('close');	
	}

	function renderWidthSubmenu()
	{
		$('#sp-vermegamenu  li.parent').each(function(){
			value = $(this).data("subwidth");
			if(value){
				var container_width = $('.container').width();
				var vertical_width = $('#sp-vermegamenu').width();
				var full_width = container_width - vertical_width;
				var width_submenu = (full_width*value)/100;
				$('> .dropdown-menu',this).css('width',width_submenu+'px');
			}	
		});
	}
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