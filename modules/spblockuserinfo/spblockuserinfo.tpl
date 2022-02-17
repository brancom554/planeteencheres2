<div id="_desktop_spuserinfo">
    <div class="user-info">
        {if $logged}
            <a class="account" href="{$my_account_url}" title="{l s='View my customer account' d='Shop.Theme.CustomerAccount'}" rel="nofollow">
                {l s='Welcome' d='Shop.Theme.Actions'} <span>{$customerName}</span>
            </a>
            <a class="logout" href="{$logout_url}" rel="nofollow">
                {l s='Sign out' d='Shop.Theme.Actions'}
            </a>
        {else}
            <div class="welcome-text">{l s='Welcome Customer!' d='Shop.Theme.Actions'}</div>
            <a class="login" href="{$my_account_url}" title="{l s='Log in to your customer account' d='Shop.Theme.CustomerAccount'}" rel="nofollow" >
                <span>{l s='Sign in' d='Shop.Theme.Actions'}</span>
            </a>
        {/if}
    </div>
</div>