<div class="footer-container footer-v2">
	{block name="footer"}
		<div id="footer-2-main">
			<div class="footer-top">
				<div class="container">
					<div class="row">
						{hook h="displayNewLetter2"}
						{hook h='displayFooterSocial'}
					</div>
				</div>
			</div>

			<div class="footer-center">
				<div class="container">
					<div class="row">
						<div class="footer-center-1 clearfix">
							<div class="group-link-1">
								{hook h='displayFooterLinks3'}
								{hook h='displayFooterLinks4'}
								{hook h='displayFooterLinks5'}
								{hook h='displayFooterLinks6'}
								{hook h='displayFooterLinks7'}
							</div>

							<div class="group-link-2">
								{hook h='displayFooterLinks8'}
								{hook h='displayFooterLinks9'}
								{hook h='displayFooterLinks10'}
								{hook h='displayFooterLinks11'}
								{hook h='displayFooterLinks12'}
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="footer-center-2 clearfix">
				<div class="container">
					<div class="row">
						{hook h='displayFooterContact'}
						{hook h="displayCustomhtml7"}
					</div>
				</div>
			</div>

			<div id="copyright">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-xs-12">{if isset($copyRight_txt)}<div class="copyright">{$copyRight_txt nofilter}</div>{/if}</div>
						<div class="col-md-6 col-xs-12">{hook h="displayFooterPayment"}</div>
					</div>
				</div>
			</div>
		</div>
	{/block}

	<div class="backtop">
		<a id="sp-totop" class="backtotop" href="#" title="{l s='Back to top' d='Shop.Theme.Actions'}">
			<i class="fa fa-angle-double-up"></i>
		</a>
	</div>


	<script type="text/javascript">
		jQuery(function(){
				function scroll_to(div){
					$('html, body').animate({
						scrollTop: $(div).offset().top-80
					},800);
				}
				$(".list_diemneo ul li").each(function(){
					$(this).click(function(){
						$('.list_diemneo ul li').removeClass("active");
						$(this).addClass("active");
						var neoindext=$(this).index()+1;
						scroll_to(".title_neo"+neoindext);
						var neodiv = (".title_neo"+neoindext);
						console.log(neodiv);
						var x = $(neodiv).position();
						$(".custom-scoll").css("top",x.top);
						return true;
					});
				});
			});
			jQuery(function(){
				var windowswidth = $(window).width();
				var containerwidth = $('.container').width();
				var widthcss = (windowswidth-containerwidth)/2-70;
				
				var rtl = jQuery( 'body' ).hasClass( 'rtl' );
				if( !rtl ) {
					jQuery(".custom-scoll").css("left",widthcss);
				}else{
					jQuery(".custom-scoll").css("right",widthcss);
				}
				var x = $(".title_neo3").position();
				
			});
	</script>
	
</div>
