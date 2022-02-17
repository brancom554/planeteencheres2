{if isset($SP_moreinfo) && $SP_moreinfo == 'tab'}
	<div class="tabs">
		<ul class="nav nav-tabs">
			{if $product.description}
				<li class="nav-item">
					<a class="nav-link{if $product.description} active{/if}" data-toggle="tab" href="#description">{l s='Description' d='Shop.Theme.Catalog'}</a>
				</li>
			{/if}
			{*<li class="nav-item">
				<a class="nav-link{if !$product.description} active{/if}" data-toggle="tab" href="#product-details">{l s='Product Details' d='Shop.Theme.Catalog'}</a>
			</li>*}
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#review">{l s='Review' d='Shop.Theme.Catalog'}</a>
			</li>
			{if $product.attachments}
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#attachments">{l s='Attachments' d='Shop.Theme.Catalog'}</a>
				</li>
			{/if}
			{foreach from=$product.extraContent item=extra key=extraKey}
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#extra-{$extraKey}">{$extra.title}</a>
				</li>
			{/foreach}
			{if ($SP_product_customtab)}
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#product-customtab">{l s='Custom Tab' d='Shop.Theme.Catalog'}</a>
				</li>
			{/if}
		</ul>
		<div class="tab-content" id="tab-content">
		   	<div class="tab-pane fade in{if $product.description} active{/if}" id="description">
				{block name='product_description'}
					<div class="product-description">{$product.description nofilter}</div>
				{/block}
		   	</div>
		   	{block name='product_details'}
				{include file='catalog/_partials/product-details.tpl'}
		   	{/block}
			
			<div class="tab-pane fade in" id="review">
				{hook h="displayReview"}
		   	</div>
			
		   	{block name='product_attachments'}
				{if $product.attachments}
					<div class="tab-pane fade in" id="attachments">
					 	<section class="product-attachments">
						   	<h3 class="h5 text-uppercase">{l s='Download' d='Shop.Theme.Actions'}</h3>
						   	{foreach from=$product.attachments item=attachment}
							 	<div class="attachment">
							   		<h4><a href="{url entity='attachment' params=['id_attachment' => $attachment.id_attachment]}">{$attachment.name}</a></h4>
							   		<p>{$attachment.description}</p>
							   		<a href="{url entity='attachment' params=['id_attachment' => $attachment.id_attachment]}">
								 		{l s='Download' d='Shop.Theme.Actions'} ({$attachment.file_size_formatted})
							   		</a>
							 	</div>
						   	{/foreach}
					 	</section>
				   	</div>
				{/if}
		   	{/block}
			{foreach from=$product.extraContent item=extra key=extraKey}
				<div class="tab-pane fade in {$extra.attr.class}" id="extra-{$extraKey}" {foreach $extra.attr as $key => $val} {$key}="{$val}"{/foreach}>
					{$extra.content nofilter}
				</div>
			{/foreach}
			{if ($SP_product_customtab)}
			   	<div class="tab-pane fade in" id="product-customtab">
					{block name='product_customtab'}
						{$SP_product_customtab nofilter}
					{/block}
			   	</div>
		   	{/if}
		</div>
	</div>
	{elseif $SP_moreinfo == 'accordion'}
		<div id="accordion" class="panel-group">
			{if $product.description}
				<div class="panel panel-default">
					<div id="headingOne" class="panel-heading">
						<h4 class="panel-title"><a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">{l s='Description' d='Shop.Theme.Catalog'}</a></h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse in">
						<div class="panel-body">
							{block name='product_description'}
								<div class="product-description">{$product.description nofilter}</div>
							{/block}
						</div>
					</div>
				</div>
			{/if}
			<div class="panel panel-default">
				<div id="headingTwo" class="panel-heading">
					<h4 class="panel-title"><a class="collapsed" href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">{l s='Data sheet' d='Shop.Theme.Catalog'}</a></h4>
				</div>
				<div id="collapseTwo" class="panel-collapse collapse">
					<div class="panel-body">
						{block name='product_details'}
							{include file='catalog/_partials/product-details.tpl'}
						{/block}
					</div>
				</div>
			</div>
			{if $product.attachments}
				<div class="panel panel-default">
					<div id="headingThree" class="panel-heading">
						<h4 class="panel-title"><a class="collapsed" href="#collapseThree" data-toggle="collapse" data-parent="#accordion">{l s='Attachments' d='Shop.Theme.Catalog'}</a></h4>
					</div>
					<div id="collapseThree" class="panel-collapse collapse">
						<div class="panel-body">
							{block name='product_attachments'}
								{if $product.attachments}
								  	<div class="tab-pane fade in" id="attachments">
									 	<section class="product-attachments">
										   	<h3 class="h5 text-uppercase">{l s='Download' d='Shop.Theme.Actions'}</h3>
										   	{foreach from=$product.attachments item=attachment}
											 	<div class="attachment">
											   		<h4><a href="{url entity='attachment' params=['id_attachment' => $attachment.id_attachment]}">{$attachment.name}</a></h4>
											   		<p>{$attachment.description}</p>
											   		<a href="{url entity='attachment' params=['id_attachment' => $attachment.id_attachment]}">
												 		{l s='Download' d='Shop.Theme.Actions'} ({$attachment.file_size_formatted})
											   		</a>
											 	</div>
										   {/foreach}
									 	</section>
								   	</div>
								{/if}
						   {/block}
						</div>
					</div>
				</div>
			{/if}
			{if isset($product.extra)}
				<div class="panel panel-default">
					{foreach from=$product.extraContent item=extra key=extraKey}
						<div id="extra-{$extraKey}" class="panel-heading">
							<h4 class="panel-title"><a class="collapsed" href="#extra-{$extraKey}" data-toggle="collapse" data-parent="#accordion">{$extra.title}</a></h4>
						</div>
					{/foreach}
					{foreach from=$product.extraContent item=extra key=extraKey}
					   <div id="extra-{$extraKey}" class="panel-collapse collapse">
							<div class="panel-body">
								{$extra.content nofilter}
							</div>
					   </div>
				   {/foreach}
				</div>
			{/if}
			{if ($SP_product_customtab)}
				<div class="panel panel-default">
					<div id="headingFour" class="panel-heading">
						<h4 class="panel-title"><a class="collapsed" href="#collapseFour" data-toggle="collapse" data-parent="#accordion">{l s='Custom Tab' d='Shop.Theme.Catalog'}</a></h4>
					</div>
					<div id="collapseFour" class="panel-collapse collapse">
						<div class="panel-body">
							{block name='product_customtab'}
								{$SP_product_customtab nofilter}
							{/block}
						</div>
					</div>
				</div>
			{/if}
		</div>
	{elseif $SP_moreinfo == 'list'}
		<div class="moreinfo-list">
		{if $product.description}
			<div class="infobox">
				<div class="titlebox">
					<h4>{l s='Description' d='Shop.Theme.Catalog'}</h4>
				</div>
				<div class="contentbox">
					{block name='product_description'}
						<div class="product-description">{$product.description nofilter}</div>
					{/block}
				</div>
			</div>
		{/if}
		<div class="infobox">
			<div class="titlebox">
				<h4>{l s='Data sheet' d='Shop.Theme.Catalog'}</h4>
			</div>
			<div class="contentbox">
				{block name='product_details'}
					{include file='catalog/_partials/product-details.tpl'}
				{/block}
			</div>
		</div>
		{if $product.attachments}
			<div class="infobox">
				<div class="titlebox">
					<h4>{l s='Attachments' d='Shop.Theme.Catalog'}</h4>
				</div>
				<div class="contentbox">
					{block name='product_attachments'}
						{if $product.attachments}
						  	<div class="tab-pane fade in" id="attachments">
							 	<section class="product-attachments">
								   	<h3 class="h5 text-uppercase">{l s='Download' d='Shop.Theme.Actions'}</h3>
								   	{foreach from=$product.attachments item=attachment}
									 	<div class="attachment">
									   		<h4><a href="{url entity='attachment' params=['id_attachment' => $attachment.id_attachment]}">{$attachment.name}</a></h4>
									   		<p>{$attachment.description}</p>
										   	<a href="{url entity='attachment' params=['id_attachment' => $attachment.id_attachment]}">
										 		{l s='Download' d='Shop.Theme.Actions'} ({$attachment.file_size_formatted})
										   	</a>
									 	</div>
								   	{/foreach}
							 	</section>
						   	</div>
						{/if}
				   {/block}
				</div>
			</div>
		{/if}
		{if isset($product.extra)}
			<div class="infobox">
				{foreach from=$product.extraContent item=extra key=extraKey}
					<div class="titlebox">
						<h4>{$extra.title}</h4>
					</div>
					<div class="contentbox">
						{$extra.content nofilter}
					</div>
				{/foreach}
			</div>
		{/if}
		{if ($SP_product_customtab)}
			<div class="infobox">
				<div class="titlebox">
					<h4>{l s='Custom Tab' d='Shop.Theme.Catalog'}</h4>
				</div>
				<div class="contentbox">
					{block name='product_customtab'}
						{$SP_product_customtab nofilter}
					{/block}
				</div>
			</div>
		{/if}
	</div>
{/if}


<script>// <![CDATA[
    $(document).ready(function(){
        $(".open-comment-form").on('click',function(){
                $('#review').addClass('active');
         });
        $("#productcomment-modal .close").on('click',function(){
                $('#review').removeClass('active');
         });
    });
</script>
