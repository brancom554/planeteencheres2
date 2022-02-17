<!-- SP Block user information module NAV  -->

<div class="topleft-content">
		{if $is_logged}
			<span>Hi {$cookie->customer_firstname} {$cookie->customer_lastname}</span>
		{/if}
		{if $is_logged}
			<span> | </span>
			<span class="logout"> 
				<a href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Logout' d='Shop.Theme.Actions'}">
					{l s='Logout' d='Shop.Theme.Actions'} 
				</a>
			</span>
		{else}
		    Default welcome msg!
			<span class="register">
			<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log in to your customer account' d='Shop.Theme.Actions'}">
				{l s='Join Free' d='Shop.Theme.Actions'}
			</a>
			</span>
			<span class="or">or</span>
			<span class="login">
				<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log in to your customer account' d='Shop.Theme.Actions'}">
					{l s='Sign In' d='Shop.Theme.Actions'}
				</a>
			</span>
		{/if}
</div>