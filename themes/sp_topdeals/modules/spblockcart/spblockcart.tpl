<div id="_desktop_cart" class="clearfix">
    <div class="spblockcart cart-preview {if $cart.products_count > 0}active{else}inactive{/if}" data-refresh-url="{$refresh_url}">
        <div class="shopping_cart clearfix">
            {if $cart.products_count > 0}
                <a rel="nofollow" href="{$cart_url}">
            {/if}
	            <div class="cart-icon">
	                <span class="icon"><i class="fa fa-shopping-cart">shopping_cart</i></span>
	            </div>
	            <div class="cart-content">
	                <span class="shopping-cart-title">{l s='My Cart' d='Shop.Theme.Actions'}</span>
                    <span class="cart-products-count">{$cart.products_count} {l s='Item(s)' d='Shop.Theme.Actions'}</span>
                    <span class="cart-products-total"> - {$cart.totals.total.value}</span>
	            </div>
            {if $cart.products_count > 0}
                </a>
            {/if}
        </div>
    </div>
</div>
