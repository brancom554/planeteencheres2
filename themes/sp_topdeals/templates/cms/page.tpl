{**
 * 2007-2016 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2016 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{extends file='page.tpl'}

{block name='page_title'}
  {$cms.meta_title}
{/block}

{block name='page_content_container'}
  <section id="content" class="page-content page-cms page-cms-{$cms.id}">
    {$cms.content nofilter}
    
    {hook h='displayCMSDisputeInformation'}
    
    {hook h='displayCMSPrintButton'}
  </section>
  
  	<script>// <![CDATA[
	jQuery(document).ready(function($) {
			$('.out-team-content').owlCarousel({
				pagination: false,
				center: false,
				nav: true,
				loop: true,
				margin: 0,
				navText: [ '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ],
				slideBy: 1,
				autoplay: true,
				autoplayTimeout: 2500,
				autoplayHoverPause: true,
				autoplaySpeed: 800,
				startPosition: 0, 
				responsive:{
					0:{
						items:1
					},
					480:{
						items:2
					},
					768:{
						items:3
					},
					1200:{
						items:4
					}
				}
			});
	    $(document).ready(function(){
	        $(".toggle-btn").click(function(){
	            $("#myCollapsible").collapse('toggle');
	        });
	    });

	    $('.nav-tabs a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show')
		})

		});
	// ]]></script>
  
{/block}
