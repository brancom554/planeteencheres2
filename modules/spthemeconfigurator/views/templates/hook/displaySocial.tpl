
{if $social_in_footer}
<div class="footer-social">
	{if isset($social_facebook) && $social_facebook}<a href="{$social_facebook}" class="facebook" target="_blank" ><i class="fa fa-facebook"></i></a>{/if}
	{if isset($social_twitter) && $social_twitter}<a href="{$social_twitter}" class="twitter" target="_blank" ><i class="fa fa-twitter"></i></a>{/if}
	{if isset($social_pinterest) && $social_pinterest}<a href="{$social_pinterest}" class="twitter" target="_blank" ><i class="fa fa-pinterest"></i></a>{/if}
	{if isset($social_google) && $social_google}<a href="{$social_google}" class="google" target="_blank"><i class="fa fa-google-plus"></i></a>{/if}
	{if isset($social_instagram) && $social_instagram}<a href="{$social_instagram}" class="instagram" target="_blank" ><i class="fa fa-instagram"></i></a>{/if}
	{if isset($social_linkedIn) && $social_linkedIn}<a href="{$social_linkedIn}" class="linkedIn" target="_blank" ><i class="fa fa-linkedin"></i></a>{/if}
	{if isset($social_skype) && $social_skype}<a href="{$social_skype}" class="skype" target="_blank"><i class="fa fa-skype"></i></a>{/if}
	{if isset($social_flickr) && $social_flickr}<a href="{$social_flickr}" class="flickr" target="_blank" ><i class="fa fa-flickr"></i></a>{/if}
</div>
{/if}