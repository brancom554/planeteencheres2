<div class="footer-v1 footer-container">
	{block name="footer"}
	<div id="footer-1-main">
		<div class="footer-top">
			<div class="container">
				<div class="row">
					{hook h="displayNewLetter"}
				</div>
			</div>
		</div>
		<div class="footer-center-1 clearfix">
			<div class="container">
				<div class="border">
					<div class="row">
							<div class="group-link-1">
								{hook h='displayFooterContact'}
								{hook h='displayFooterLinks'}
							</div>

							<div class="group-link-2">
								{hook h='displayFooterLinks2'}
							</div>
							
							<div class="col-lg-3 col-xs-12 group-link-3">
								{hook h='displayHomeNews'}
							</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-center-2 clearfix">
			<div class="container">
				<div class="border">
					<div class="row">
						<div class="col-lg-6 col-xs-12">
							{hook h="displayCustomhtml7"}
						</div>
						<div class="col-lg-6 col-xs-12">
							{hook h='displayFooterSocial'}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="container">
				<div class="border">
					{hook h="displayCustomhtml8"}
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
