
<div id="sp-cpanel_btn" class="isDown">
	<i class="fa fa-cog fa-spin"></i>
</div>		

<div id="sp-cpanel" class="sp-delay">
	<form method="get" class="no-margin">
	<h2 class="sp-cpanel-title"> {l s="Demo Options"} <span class="sp-cpanel-close"> <i class="fa fa-close"> </i></span></h2>
	<div id="sp-cpanel_settings">

		<div class="panel-group ">
			<div class="title">{l s="Select Theme Color"}</div>
			<div class="group-schemes" >
				<input id="spcpl_themesColors" name="SP_cplthemesColors" class="minicolors minicolors-input" type="text" value="{$SP_themesColors}" />
			 </div>
		</div>
		
		<div class="panel-group hidden-device">
			<div class="title">{l s="Select Menu"}</div>
			<div class="group-boxed">
				<div class="selectbox">
					<select name="SP_cplkeepMenuTop">
						<option {if "0"==$SP_keepMenuTop}  selected="selected" {/if}value="0">{l s="Menu Scroll"}</option>
						<option {if "1"==$SP_keepMenuTop}  selected="selected" {/if}value="1">{l s="Menu On Top"}</option>
					</select>
				</div>
			</div>
		</div>
		
		 <div class="panel-group">
			<div class="title">{l s="Select Product Effect"}</div>
			<div class="group-boxed">
				<div class="selectbox">
					<select name="SP_cplsecondimg">
						<option {if "0"==$SP_secondimg}  selected="selected" {/if}value="0">{l s="One Image Product"}</option>
						<option {if "1"==$SP_secondimg}  selected="selected" {/if}value="1">{l s="Two Images Product"}</option>
					</select>
				</div>
			</div>
		</div>
		
		<div class="panel-group hidden-device">
			<div class="title">{l s="Select Layout Style"}</div>
			<div class="group-boxed">
				<div class="selectbox">
					<select name="SP_cpllayoutStyle">
						<option {if "layout-full"==$SP_layoutStyle}   selected="selected" {/if}value="layout-full">{l s="Full Width"}</option>
						<option {if "layout-boxed"==$SP_layoutStyle}  selected="selected" {/if}value="layout-boxed">{l s="Boxed"}</option>
						<option {if "layout-framed"==$SP_layoutStyle} selected="selected" {/if}value="layout-framed">{l s="Framed"}</option>
						<option {if "layout-rounded"==$SP_layoutStyle}selected="selected" {/if}value="layout-rounded">{l s="Rounded"}</option>
					</select>
				</div>
			</div>
		</div>
		
        <div class="panel-group hidden-device">
			<div class="title">{l s="Select Body Image"}</div>
			<div class="group-boxed">
				<input type="hidden" name="SP_cplbody_bg_pattern" value="{$SP_body_bg_pattern}" />
				<div data-pattern="none" class="img-pattern pattern_none {if {'none'}==$SP_body_bg_pattern}  active {/if}"><span></span></div>
				{section name=patterns start=1 loop=6 step=1}
					<div data-pattern="{$smarty.section.patterns.index}" class="img-pattern pattern_{$smarty.section.patterns.index} {if {$smarty.section.patterns.index}==$SP_body_bg_pattern}  active {/if}"><span></span></div>
				{/section}
			</div>
			
			<p class="label-sm">{l s="Background only applies for Boxed, Framed, Rounded Layout"}</p>
		</div>
		
		<div class="reset-group">
		    <input type="submit" class="btn btn-default" value="Reset" name="SP_cplReset"/>
			<input type="submit" class="btn btn-success" value="Apply" name="SP_cplApply"/>
		</div>
		
	
		
	</div>
	</form>	
</div>