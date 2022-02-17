jQuery(document).ready(function(){
	eventSelectMenu();
	eventSelectWidth();
	$("#select_menu").change(function(){
		eventSelectMenu();
	});
	
	$("#sub_menu").change(function(){
		eventSelectWidth();
	});
	
    $('#spmegamenu').nestable({
            listNodeName    : 'ol',
            itemNodeName    : 'li',
            rootClass       : 'spmenu',
            listClass       : 'spmenu-list',
            itemClass       : 'spmenu-item',
            dragClass       : 'spmenu-dragel',
            handleClass     : 'spmenu-handle',
            collapsedClass  : 'spmenu-collapsed',
            placeClass      : 'spmenu-placeholder',
            noDragClass     : 'spmenu-nodrag',
            emptyClass      : 'spmenu-empty',
            group           : 0,
			expandBtnHTML   : '<button data-action="expand" type="button">Expand</button>',
            collapseBtnHTML : '<button data-action="collapse" type="button">Collapse</button>',
    });
	
	$('#savePosition').click(function(){
        serialized = JSON.stringify( $('#spmegamenu').nestable('serialize'));
		var $this  = $(this);
		$.ajax({
			type: 'POST',
			url: action+"&rand="+Math.random(),
			data : 'serialized='+serialized+'&savePosition=1' 
		}).done( function () {
			$this.val( 'Update Sucess' );
			location.reload();
		});
	});
	
	
	$('#spmegamenu-menu').on('click', function(e)
	{
		var target = $(e.target),
			action = target.data('action');
		if (action === 'expand-all') {
			$('.spmenu').nestable('expandAll');
		}
		if (action === 'collapse-all') {
			$('.spmenu').nestable('collapseAll');
		}
	});
	
	$(".remove-menu").click( function(){  
		var check =  confirm('Are you sure you want to delete this?');
		if(check == true)
			return true;
		else
			return false;
	});
	
	$(".duplicate-menu").click( function(){  
		var check =  confirm('Are you sure you want to duplicate this?');
		if(check == true)
			return true;
		else
			return false;
	});
	
});	

function eventSelectMenu() {
    $(".type_group").parent().parent().hide();
	$("#type_subcategories").closest('.panel').parent().parent().hide();
	$(".showimg_subcategories").parent().parent().hide();
	$(".showimgchild_subcategories").parent().parent().hide();
	$(".type_limit_subcategories").closest('.form-group').hide();
	$(".type_product_type").closest('.form-group').hide();	
	$("#type_limit_product").closest('.form-group').hide();	
	var val = $( "#select_menu option:selected" ).val();
	if($("[id^=type_url_]").closest('.form-group').find('.translatable-field').length){
		$("[id^=type_url_]").closest('.form-group').parent().parent().hide();
		$(".html_lang").closest('.form-group').parent().parent().hide();
		if(val == 'url')
			$("[id^=type_url_]").closest('.form-group').parent().parent().show();
		else if(val == 'html')
			$(".html_lang").closest('.form-group').parent().parent().show();
		else if(val == 'subcategories'){
			$("#type_subcategories").closest('.panel').parent().parent().show();
			$(".type_limit_subcategories").closest('.form-group').show();	
			$(".showimg_subcategories").parent().parent().show();
			$(".showimgchild_subcategories").parent().parent().show();
		}			
		else if(val == 'productlist'){
			$(".type_product_type").parent().parent().show();
			$(".type_productlist_type").parent().parent().show();
			$("#type_limit_product").parent().parent().show();
		}	
		else
			$("#type_"+val).parent().parent().show();
	}
	else{
		$("[id^=type_url_]").closest('.form-group').hide();
		$(".html_lang").closest('.form-group').hide();	
		if(val == 'url')
			$("[id^=type_url_]").closest('.form-group').show();
		else if(val == 'productlist'){
			$(".type_product_type").closest('.form-group').show();	
			$(".type_productlist_type").closest('.form-group').show();
			$("#type_limit_product").closest('.form-group').show();			
		}		
		else if(val == 'subcategories'){
			$("#type_subcategories").closest('.panel').parent().parent().show();
			$(".type_limit_subcategories").closest('.form-group').show();	
			$(".showimg_subcategories").parent().parent().show();
			$(".showimgchild_subcategories").parent().parent().show();
		}			
		else if(val == 'html')
			$(".html_lang").closest('.form-group').show();	
		else
			$("#type_"+val).parent().parent().show();
	}
}

function eventSelectWidth() {
	    $(".sub_width").parent().parent().hide();
		var val = $( "#sub_menu option:selected" ).val();
		if(val == 'yes'){
			 $(".sub_width").parent().parent().show();
		}	
}
