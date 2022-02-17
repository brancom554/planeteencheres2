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
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="spcurrency-block">
    <div class="currency-selector">
        <div class="sp-currency-title">
            <span class="text">{l s='Currency' d='Shop.Theme.Actions'}</span>
            <span>{$current_currency.iso_code}</span>
            <i class="fa fa-angle-down" aria-hidden="true"></i>
        </div>
        <ul class="dropdown-menu toogle_content">
            {foreach from=$currencies item=currency}
                <li {if $currency.current} class="current" {/if}>
                    <a title="{$currency.name}" rel="nofollow" href="{$currency.url}" class="currency-item">{*<i>{$currency.sign}</i>*} {$currency.iso_code}</a>
                </li>
            {/foreach}
        </ul>
        <!--<select class="sp-currency-select hidden-md-up">
            {foreach from=$currencies item=currency}
                <option value="{$currency.url}"{if $currency.current} selected="selected"{/if}>{$currency.iso_code} {$currency.sign}</option>
            {/foreach}
        </select>-->
    </div>
</div>

<script type="text/javascript">
// <![CDATA[
    $(document).ready(function($){
        $(".sp-currency-title").click(function(){
            $(this).toggleClass("active").next().slideToggle("medium");
        });
    });
// ]]>
</script>