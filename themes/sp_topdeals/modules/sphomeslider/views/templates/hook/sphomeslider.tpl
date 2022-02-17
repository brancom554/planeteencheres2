{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @version  Release: $Revision$
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- Module SpHomeSlider -->
    {if isset($sphomeslider_slides)}
		<div id="sphomepage-slider{$id_sphomeslider_groups}" class="sphomepage-slider {if isset($params.moduleclass_sfx) && $params.moduleclass_sfx}{$params.moduleclass_sfx}{/if}">
		{if isset($params.display_title_module) && $params.display_title_module}
			<h4>{$title_slider}</h4>
		{/if}
		{if isset($sphomeslider_slides.0) && isset($sphomeslider_slides.0.sizes.1)}{capture name='height'}{$sphomeslider_slides.0.sizes.1}{/capture}{/if}
			 <div class="sp-homeslider sphomeslider-inner-{$id_sphomeslider_groups}">
				{foreach from=$sphomeslider_slides item=slide}
				{math equation='rand()' assign='rand'}
				{assign var='randid' value="now"|strtotime|cat:$rand}
				{assign var="tag_id" value="sp_extra_slider_{$id_sphomeslider_groups}_{$randid}"}				
					{if $slide.active}
					<div class="item ">
						<a href="{$slide.url|escape:'html':'UTF-8'}" title="{$slide.legend|escape:'html':'UTF-8'}">
							<img class="responsive" src="{$link->getMediaLink("`$smarty.const._MODULE_DIR_`sphomeslider/images/`$slide.image|escape:'htmlall':'UTF-8'`")}"  alt="{$slide.legend|escape:'htmlall':'UTF-8'}" />
						</a>
						{if isset($slide.description) && trim($slide.description) != ''}
							<div class="sphomeslider-description">{$slide.description nofilter}</div>
						{/if}
					</div>	
					{/if}
				{/foreach}
			</div>
		</div>
		{if isset($params) && $params}
		<script type="text/javascript">
				$(".sphomeslider-inner-{$id_sphomeslider_groups}").owlCarousel({
						animateOut: '{$params.animateOut|escape:"html":"UTF-8"}',
						animateIn: '{$params.animateIn|escape:"html":"UTF-8"}',
						autoplay: {(isset($params.autoplay) && $params.autoplay ==1) ? 'true' : 'false' },
						autoplayTimeout: {$params.autoplay_timeout|escape:"html":"UTF-8"},
						autoplaySpeed: {$params.autoplaySpeed|escape:"html":"UTF-8"},
						smartSpeed: 500,
						autoplayHoverPause: {(isset($params.autoplayHoverPause) && $params.autoplayHoverPause ==1) ? 'true' : 'false' },
						startPosition: {$params.startPosition|escape:"html":"UTF-8"},
						mouseDrag: {(isset($params.mouseDrag) && $params.mouseDrag ==1) ? 'true' : 'false' },
						touchDrag: {(isset($params.touchDrag) && $params.touchDrag ==1) ? 'true' : 'false' },
						pullDrag: {(isset($params.pullDrag) && $params.pullDrag ==1) ? 'true' : 'false' },
						dots: {$params.dots|escape:"html":"UTF-8"},
						autoWidth: false,
						dotClass: "owl-dot",
						dotsClass: "owl-dots",
						nav: {(isset($params.nav) && $params.nav ==1) ? 'true' : 'false' },
						loop: {(isset($params.loop) && $params.loop ==1) ? 'true' : 'false' },
						navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
						navClass: ["owl-prev", "owl-next"],
						responsive:{
							0:{
							  items:1 // In this configuration 1 is enabled from 0px up to 479px screen size 
							},
						}
				});
		</script>
		{/if}		
	{/if}
<!-- /Module SpHomeSlider -->
