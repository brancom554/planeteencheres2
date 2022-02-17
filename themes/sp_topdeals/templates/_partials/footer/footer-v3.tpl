<div class="footer-container footer-v3">
	{block name="footer"}
		<div id="footer-3-main">

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
						{hook h="displayCustomhtml16"}
				</div>
			</div>

			<div class="footer-bottom clearfix">
				<div class="container">
					<div class="row">
						{hook h='displayFooterLinks13'}
						{hook h='displayFooterLinks14'}
						{hook h='displayFooterLinks15'}
						{hook h='displayFooterLinks16'}
						{hook h='displayFooterLinks17'}
						<div class="col-lg-2 col-md-4 gallery">
							{hook h="displayCustomhtml17"}
							<script type="text/javascript">
								$(document).ready(function() {
									$('.fancybox').fancybox();
						
									$('.fancybox-thumbs').fancybox({
										prevEffect : 'none',
										nextEffect : 'none',
						
										closeBtn  : false,
										arrows    : true,
										nextClick : true,
						
										helpers : {
											thumbs : {
												width  : 50,
												height : 50
											}
										}
									});
								});
							</script>
						</div>
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
</div>
