<section class="contact-form">
    <form action="{$urls.pages.contact}" method="post" {if $contact.allow_file_upload}enctype="multipart/form-data"{/if}>
        {if $notifications}
            <div class="col-xs-12 alert {if $notifications.nw_error}alert-danger{else}alert-success{/if}">
                <ul>
                    {foreach $notifications.messages as $notif}
                        <li>{$notif}</li>
                    {/foreach}
                </ul>
          </div>
        {/if}
        <section class="form-fields">
            <div class="form-group row">
                <div class="col-xs-12">
                    <h3 class="contact-title">{l s='Contact us' d='Shop.Theme.Actions'}</h3>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label">{l s='Subject' d='Shop.Forms.Labels'}</label>
                <select name="id_contact" class="form-control form-control-select">
                    {foreach from=$contact.contacts item=contact_elt}
                        <option value="{$contact_elt.id_contact}">{$contact_elt.name}</option>
                    {/foreach}
                </select>
            </div>
            <div class="form-group">
                <label class="form-control-label">{l s='Email address' d='Shop.Forms.Labels'}</label>
                <input
                    class="form-control"
                    name="from"
                    type="email"
                    value="{$contact.email}"
                    placeholder="{l s='your@email.com' d='Shop.Forms.Help'}"
                >
            </div>
            {if $contact.orders}
                <div class="form-group">
                    <label class="form-control-label">{l s='Order reference' d='Shop.Forms.Labels'}</label>
                    <select name="id_order" class="form-control form-control-select">
                        <option value="">{l s='Select reference' d='Shop.Forms.Help'}</option>
                        {foreach from=$contact.orders item=order}
                            <option value="{$order.id_order}">{$order.reference}</option>
                        {/foreach}
                    </select>
                    <span class="form-control-comment">
                        {l s='optional' d='Shop.Forms.Help'}
                    </span>
                </div>
            {/if}
            {if $contact.allow_file_upload}
                <div class="form-group">
                    <label class="form-control-label">{l s='Attachment' d='Shop.Forms.Labels'}</label>
                    <input type="file" name="fileUpload" class="filestyle">
                    <span class="form-control-comment">
                        {l s='optional' d='Shop.Forms.Help'}
                    </span>
                </div>
            {/if}
            <div class="form-group ">
                <label class="form-control-label">{l s='Message' d='Shop.Forms.Labels'}</label>
                <textarea
                    class="form-control"
                    name="message"
                    placeholder="{l s='How can we help?' d='Shop.Forms.Help'}"
                    rows="3"
                >{if $contact.message}{$contact.message}{/if}</textarea>
            </div>
        </section>
        <footer class="form-footer text-xs-right">
            <input class="btn btn-primary" type="submit" name="submitMessage" value="{l s='Send Message' d='Shop.Theme.Actions'}">
        </footer>
    </form>
</section>
