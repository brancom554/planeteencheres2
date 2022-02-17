<div class="contactinfo col-lg-3 col-sm-12">
	<h4 class="title-footer">{l s='Our Contact' d='Shop.Theme.Actions'}</h4>
	<p>{l s='They key is to have every key, the key to open every door. We don’t see them we will' d='Shop.Theme.Actions'}</p>
	<div class="content-footer">
		{if isset($contact_address) && $contact_address}
			<div class="address">
				<label><i class="fa fa-map-marker" aria-hidden="true"></i></label>
				<span>{$contact_address}</span>
			</div>
		{/if}
		
		{if isset($contact_phone) && $contact_phone}
			<div class="phone">
				<label><i class="fa fa-phone" aria-hidden="true"></i></label>
				<span>{$contact_phone}</span>
			</div>
		{/if}

		{if isset($contact_email) && $contact_email}
			<div class="email">
				<label><i class="fa fa-envelope"></i></label>
				<a href="#">{$contact_email}</a>
			</div>
		{/if}

	</div>
</div>
