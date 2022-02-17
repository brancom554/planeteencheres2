{*
 * @package SP Custom Html
 * @version 1.0.1
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author MagenTech http://www.magentech.com
 *}
{if isset($list) && !empty($list)}
    {foreach from=$list item=item}
        {assign var="moduleclass_sfx" value=( isset( $item.params.moduleclass_sfx ) ) ?  $item.params.moduleclass_sfx : ''}
        {math equation='rand()' assign='rand'}
        {assign var='randid' value="now"|strtotime|cat:$rand}
        {assign var="uniqued" value="sp_customhtml_{$item.id_spcustomhtml}_{$randid}"}
        <div class="{$uniqued|escape:'html':'UTF-8'}
		{$moduleclass_sfx|escape:'html':'UTF-8'} spcustom_html">
            {if isset($item.params.display_title_module) && $item.params.display_title_module && !empty($item.title_module)}
                <h3 class="title_block">
                     {$item.title_module|escape:'html':'UTF-8'}
                </h3>
            {/if}
            {if isset($item.content) && !empty($item.content)}
                {$item.content nofilter}
            {/if}
        </div>
    {/foreach}
{/if}


    {if $item.id_spcustomhtml == 1}
    <script>// <![CDATA[
            $(document).ready(function(){
                $(".topbar-close").click(function(){
                    $(".coupon-code").slideToggle();
                });
                $(".button").on('click',function(){
                        if($('.button').hasClass('active')){
                            $('.button').removeClass('active');
                        }else{
                            $('.button').removeClass('active');
                            $('.button').addClass('active');
                        }
                 });
            });
    </script>
    {/if}

    <script>
        jQuery(document).ready(function($) {
            if($(window).width() < 1199){
                $(function(){
                    $('.bonus-menu ul').addClass('test');
                    $('.test').owlCarousel({
                        pagination: false,
                        center: false,
                        nav: false,
                        dots: false,
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
                            481:{
                                items:2
                            },
                            992:{
                                items:3
                            }
                        }
                    });

                });
            }
        });
    </script>


    {if $item.id_spcustomhtml == 5}
        <script>// <![CDATA[
        jQuery(document).ready(function($) {
                $('.out-content').owlCarousel({
                    pagination: true,
                    center: false,
                    nav: true,
                    loop: true,
                    margin: 0,
                    navText: [ '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ],
                    slideBy: 1,
                    autoplay: false,
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
                            items:4
                        },
                        992:{
                            items:5
                        },
                        1200:{
                            items:6
                        }
                    }
                });
            });
        // ]]></script>
    {/if}


    {if $item.id_spcustomhtml == 13}
    <script>// <![CDATA[
    jQuery(document).ready(function($) {
            $('.cate-html-item').owlCarousel({
                pagination: false,
                center: false,
                nav: false,
                loop: true,
                dots: false,
                margin: 27,
                navText: [ '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ],
                slideBy: 1,
                autoplay: true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                autoplaySpeed: 800,
                startPosition: 0,
                responsive:{
                    0:{
                        items:2
                    },
                    480:{
                        items:2
                    },
                    768:{
                        items:2
                    },
                    992:{
                        items:3
                    },
                    1200:{
                        items:4
                    },
                    1500:{
                        items:5
                    }
                }
            });
        });
    // ]]></script>
    {/if}


    {if $item.id_spcustomhtml == 14}
    <script>// <![CDATA[
    jQuery(document).ready(function($) {
            $('.testimonial-items').owlCarousel({
                pagination: false,
                center: false,
                nav: false,
                loop: true,
                dots: true,
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
                        items:1
                    },
                    768:{
                        items:1
                    },
                    1200:{
                        items:1
                    }
                }
            });
        });
    // ]]></script>
    {/if}