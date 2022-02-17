<div class="contactinfo">
	<h4 class="title-footer">{l s='Contact Us' d='Shop.Theme'}</h4>
	<div class="content-footer">
		{if isset($contact_address) && $contact_address}
			<div class="address">
				<label><i class="fa fa-home"></i> {l s='Address:' d='Shop.Theme'}</label>
				<span>{$contact_address}</span>
			</div>
		{/if}
		
		{if isset($contact_email) && $contact_email}
			<div class="email">
				<label><i class="fa fa-paper-plane"></i> {l s='Mail Us:' d='Shop.Theme'}</label>
				<a href="#">{$contact_email}</a>
			</div>
		{/if}
		
		{if isset($contact_phone) && $contact_phone}
			<div class="phone">
				<label><i class="fa fa-phone"></i> {l s='Phone:' d='Shop.Theme'}</label>
				<span>{$contact_phone}</span>
			</div>
		{/if}
	</div>
</div>
