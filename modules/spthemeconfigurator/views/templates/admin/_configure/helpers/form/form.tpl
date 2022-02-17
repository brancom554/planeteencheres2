{extends file="helpers/form/form.tpl"}

{block name='defaultForm'}
    <ul id="sp-config-tabs">
        {foreach $sptabs as $tabTitle => $tabClass}
            <li class="tab" data-tab="{$tabClass}">
                {$tabTitle}
            </li>
        {/foreach}
		
    </ul>
	
    {$smarty.block.parent}
	
	<div class="footer-section">
			<span>{$versions}| Powered by <a href="http://magentech.com/" target="_blank">MagenTech.</a></span>
	</div>
	
{/block}




{block name="input"}
	
    {if $input.name == 'SP_payment_image'}
        {if isset($fields_value[$input.name]) && $fields_value[$input.name] != ''}
            <img src="{$imagePath}{$fields_value[$input.name]}"/><br />
            <a href="{$current}&{$identifier}={$form_id}&token={$token}&deleteConfig={$input.name}">
                <img src="../img/admin/delete.gif" alt="{l s='Delete'}" /> {l s='Delete'}
            </a>
            <small>{l s='Do not forget to save the options after deleted the image!'}</small>
            <br /><br />
        {/if}
		{$smarty.block.parent}
	{elseif $input.name == 'body_bg_image'}
		 {if isset($fields_value[$input.name]) && $fields_value[$input.name] != ''}
            <img src="{$imagePath}{$fields_value[$input.name]}"/><br />
            <a href="{$current}&{$identifier}={$form_id}&token={$token}&deleteConfig={$input.name}">
                <img src="../img/admin/delete.gif" alt="{l s='Delete'}" /> {l s='Delete'}
            </a>
            <small>{l s='Do not forget to save the options after deleted the image!'}</small>
            <br /><br />
        {/if}
		{$smarty.block.parent}
	{elseif $input.name == 'SP_clearcss'}
		<div class="alert alert-warning">
			<button id="sns_clearcss" class="btn btn-success" type="button">
				<i class="icon-eraser"></i> {l s="Clear CSS"}
			</button>
		  	<span style="margin:0 10px;">{l s='Delete all of the theme css file and regenerate from sass.'}</span>
		  	
			
		</div>
		<script>
			function objToString(obj) {
				var str = '';
				for (var p in obj) {
					if (obj.hasOwnProperty(p)) {
						str += '&' + p + '=' + obj[p];
					}
				}
				return str;
			}
			$('#sns_clearcss').on('click', function(){
				var that = $(this);
				that.attr('class', 'btn btn-warning disabled');
				that.find('i').attr('class', 'icon-spinner icon-spin');
				var params = {
					action : 'clearCss',
					ajax : 1
				};
				var query = $.ajax({
					type: 'POST',
					url: '{$controller_url}',
					data: objToString(params),
					dataType: 'json',
					success: function(data) {
						if(data.success){
							that.attr('class', 'btn btn-success disabled');
							that.find('i').attr('class', 'icon-eraser');
						} else {
							that.attr('class', 'btn btn-danger');
							that.find('i').attr('class', 'icon-frown');
						}
					}
				});
			});
		</script>
    {else}
        {$smarty.block.parent}

    {/if}

{/block}