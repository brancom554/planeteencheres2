/*
 * Custom code goes here.
 * A template should always ship with an empty custom.js
 */

/*
//Grid-List view
/*
 * TotalStorage
 *
 * Copyright (c) 2012 Jared Novack & Upstatement (upstatement.com)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Total Storage is the conceptual the love child of jStorage by Andris Reinman, 
 * and Cookie by Klaus Hartl -- though this is not connected to either project.
 *
 * @name $.totalStorage
 * @cat Plugins/Cookie
 * @author Jared Novack/jared@upstatement.com
 * @version 1.1.2
 * @url http://upstatement.com/blog/2012/01/jquery-local-storage-done-right-and-easy/
 */
(function($){var ls=window.localStorage;var supported;if(typeof ls=='undefined'||typeof window.JSON=='undefined'){supported=false;}else{supported=true;}
$.totalStorage=function(key,value,options){return $.totalStorage.impl.init(key,value);}
$.totalStorage.setItem=function(key,value){return $.totalStorage.impl.setItem(key,value);}
$.totalStorage.getItem=function(key){return $.totalStorage.impl.getItem(key);}
$.totalStorage.getAll=function(){return $.totalStorage.impl.getAll();}
$.totalStorage.deleteItem=function(key){return $.totalStorage.impl.deleteItem(key);}
$.totalStorage.impl={init:function(key,value){if(typeof value!='undefined'){return this.setItem(key,value);}else{return this.getItem(key);}},setItem:function(key,value){if(!supported){try{$.cookie(key,value);return value;}catch(e){console.log('Local Storage not supported by this browser. Install the cookie plugin on your site to take advantage of the same functionality. You can get it at https://github.com/carhartl/jquery-cookie');}}
var saver=JSON.stringify(value);ls.setItem(key,saver);return this.parseResult(saver);},getItem:function(key){if(!supported){try{return this.parseResult($.cookie(key));}catch(e){return null;}}
return this.parseResult(ls.getItem(key));},deleteItem:function(key){if(!supported){try{$.cookie(key,null);return true;}catch(e){return false;}}
ls.removeItem(key);return true;},getAll:function(){var items=new Array();if(!supported){try{var pairs=document.cookie.split(";");for(var i=0;i<pairs.length;i++){var pair=pairs[i].split('=');var key=pair[0];items.push({key:key,value:this.parseResult($.cookie(key))});}}catch(e){return null;}}else{for(var i in ls){if(i.length){items.push({key:i,value:this.parseResult(ls.getItem(i))});}}}
return items;},parseResult:function(res){var ret;try{ret=JSON.parse(res);if(ret=='true'){ret=true;}
if(ret=='false'){ret=false;}
if(parseFloat(ret)==ret&&typeof ret!="object"){ret=parseFloat(ret);}}catch(e){}
return ret;}}})(jQuery);
window.magentech = window.magentech || {};
magentech.init = function () {
	magentech.bindGrid();
};
magentech.bindGrid = function() {
	
	var view = $.totalStorage('n_display');
	if (!view && (typeof displayList != 'undefined') && displayList)
		view = 'list';
	if (view && view != 'grid')
		magentech.spMagentechDisplay(view);
	else
		$('#grid').addClass('selected');
	
	$.totalStorage('n_columns', 'col-lg-'+$('#js-product-list .product-miniature').attr('data-sp_gridproduct'));
	$(document).on('click', '#grid', function(e){
		e.preventDefault();
		magentech.spMagentechDisplay('grid');
	});
	$(document).on('click', '#list', function(e){
		e.preventDefault();
		magentech.spMagentechDisplay('list');
	});
}
magentech.spMagentechDisplay = function(view) {
	var sp_gridproduct = $.totalStorage('n_columns');
	if (sp_gridproduct == null) {
		 sp_gridproduct = 'col-lg-'+$('#js-product-list .product-miniature').attr('data-sp_gridproduct');
		 $.totalStorage('n_columns', sp_gridproduct);
	}
	
	if (view == 'list')
	{
		$('#js-product-list').removeClass('product-list--grid').addClass('product-list--list');
		$('#js-product-list .product-miniature').removeClass().addClass('product-miniature js-product-miniature col-xs-12');
		$('#js-product-list .product-miniature').each(function(index, element) {
			$(this).find('.product-container').addClass('row');
			$(this).find('.product-description-short').css('display', 'block'); 
			$(this).find('.left-block').addClass('col-xs-12 col-md-12 col-lg-5 col-xl-4');
			$(this).find('.right-block').addClass('col-xs-12 col-md-12 col-lg-7 col-xl-8');
                $(this).find('.product-info-box').append($(this).find('.product-list-actions'));
                $(this).find('.product-info.right-block').append($(this).find('.button-container'));
                $(this).find('.price-right').css('display', 'none');
                $(this).find('.comments_note').css('display', 'block');
		});

		
		$('.category-view-type-selector').removeClass('selected');
		$('#list').addClass('selected');
		$.totalStorage('n_display', 'list');
	}
	else
	{	
		var  old_col = 'col-lg-'+$('#js-product-list .product-miniature').attr('data-sp_gridproduct');
		$('#js-product-list').removeClass('product-list--list').addClass('product-list--grid');
		$('#js-product-list .product-miniature').each(function() {
			$(this).removeClass('col-xs-12').removeClass(old_col).addClass('product-miniature js-product-miniature '+ sp_gridproduct +' col-md-6 col-sm-6 col-xs-12');
		});
		$('#js-product-list .product-miniature').each(function(index, element) {
			$(this).find('.product-container').removeClass('row');
			$(this).find('.product-description-short').css('display', 'none'); 
			$(this).find('.left-block').removeClass('col-xs-12 col-md-12 col-lg-5 col-xl-4');
			$(this).find('.right-block').removeClass('col-xs-12 col-md-12 col-lg-7 col-xl-8');
                        $(this).find('.product-container').append($(this).find('.product-list-actions'));
                        $(this).find('.product-container').append($(this).find('.product-info-box'));
                        $(this).find('.left-block').append($(this).find('.button-container'));
                        $(this).find('.price-right').css('display', 'block');
                        $(this).find('.comments_note').css('display', 'none');
		});
		$('.category-view-type-selector').removeClass('selected');
		$('#grid').addClass('selected');
		$.totalStorage('n_display', 'grid');
	}
}

function scrollCompensate() 
{
    var inner = document.createElement('p');
    inner.style.width = "100%";
    inner.style.height = "200px";
    var outer = document.createElement('div');
    outer.style.position = "absolute";
    outer.style.top = "0px";
    outer.style.left = "0px";
    outer.style.visibility = "hidden";
    outer.style.width = "200px";
    outer.style.height = "150px";
    outer.style.overflow = "hidden";
    outer.appendChild(inner);
    document.body.appendChild(outer);
    var w1 = inner.offsetWidth;
    outer.style.overflow = 'scroll';
    var w2 = inner.offsetWidth;
    if (w1 == w2) w2 = outer.clientWidth;
    document.body.removeChild(outer);
    return (w1 - w2);
}

function processScroll(element, eclass, offset_top) {
	var scrollTop = $(window).scrollTop();
	if($(element).height()< $(window).height()){
		if (scrollTop > offset_top) {
			$(element).addClass(eclass);
			$('.header-container').addClass('has-top-margin');	
			setTimeout(function() {
	            $(element).addClass('animate-children');
	        }, 150);
		} else if (scrollTop <= offset_top) {
			$(element).removeClass(eclass);
			$('.header-container').removeClass('has-top-margin');	
			setTimeout(function() {
	            $(element).removeClass('animate-children');
	        }, 150);
		}
	}
}

$(window).on("load", function() {
	if (($(window).width()+scrollCompensate()) > 992){
		if($(".menu-on-top").length > 0){
			var offset_top = $(".menu-on-top").offset().top;
			processScroll(".menu-on-top", "menu-fixed", offset_top);
			$(window).scroll(function(){
				processScroll(".menu-on-top", "menu-fixed", offset_top);
			});
		}
	}
});

$(document).ready( function(){
	 prestashop.on('updateProductList', function (event) {
		if (magentech.spMagentechDisplay instanceof Function) {
			var view = $.totalStorage('n_display');
				magentech.spMagentechDisplay(view);
		}
    });
	
	$(".img-pattern").each(function(){
			var that = $(this) 	;
			that.on('click', function(){
				var _pattern =  $(this).data('pattern');
				$('input[name="SP_cplbody_bg_pattern"]').val(_pattern);
				if($(this).hasClass('selected'))
					return;
				else{
					$(".img-pattern").removeClass('selected');
					$(".img-pattern").removeClass('active');
					$(this).addClass('selected');
				}
			});
		});
	$(window).on('orientationchange', function(event) {
        console.log(orientation);
    });
	$(".backtotop").addClass("hidden-top");
		$(window).scroll(function () {
		if ($(this).scrollTop() === 0) {
			$(".backtotop").addClass("hidden-top")
		} else {
			$(".backtotop").removeClass("hidden-top")
		}
	});
	$('.backtotop').click(function () {
		$('body,html').animate({
				scrollTop:0
			}, 1200);
		return false;
	});
	if ($('#js-product-list').length > 0) {
		magentech.init();
	}
	function CountDown(date, elem) {
		var dateNow = new Date(),
			amount = date.getTime() - dateNow.getTime(),
			lb_day = elem.attr('data-day'),
			lb_days = elem.attr('data-days'),
			lb_hour = elem.attr('data-hour'),
			lb_hours = elem.attr('data-hours'),
			lb_min = elem.attr('data-min'),
			lb_mins = elem.attr('data-mins'),
			lb_sec = elem.attr('data-sec'),
			lb_secs = elem.attr('data-secs');
		if (amount < 0 && $("#" + id).length) {
			elem.html("Now!");
		} else {
			days = 0;
			hours = 0;
			mins = 0;
			secs = 0;
			out = "";
			amount = Math.floor(amount / 1000);
			days = Math.floor(amount / 86400);
			amount = amount % 86400;
			hours = Math.floor(amount / 3600);
			amount = amount % 3600;
			mins = Math.floor(amount / 60);
			amount = amount % 60;
			secs = Math.floor(amount);
			if (days != 0) {
				out += "<div class='time-item time-day'>" + "<div class='num-time'>" + days + "</div>" + "<div class='name-time'>" + ((days == 1) ? lb_day : lb_days )+ "</div>" + "</div> ";
			}
			if (hours != 0) {
				out += "<div class='time-item time-hour'>" + "<div class='num-time'>" + hours + "</div>" + "<div class='name-time'>" + ((hours == 1) ? lb_hour : lb_hours) + "</div>" + "</div>";
			}
			out += "<div class='time-item time-min'>" + "<div class='num-time'>" + mins + "</div>" + "<div class='name-time'>" + ((mins == 1) ? lb_min : lb_mins )+ "</div>" + "</div>";
			out += "<div class='time-item time-sec'>" + "<div class='num-time'>" + secs + "</div>" + "<div class='name-time'>" + ((secs == 1) ? lb_sec : lb_secs) + "</div>" + "</div>";
			out = out.substr(0, out.length - 2);
			elem.html(out);

			setTimeout(function () {
				CountDown(date, elem);
			}, 1000);
		}
	}

	function _forProductDetail () {
		if ($('.product-images').length){
			$('.product-images').slick({		  
				slidesToShow: parseInt($('.product-images').attr('data-thumb')),
				slidesToScroll: 1,
				vertical: $('.product-images').attr('data-thumbtype') == "false" ? false : true,
				infinite: false,
				arrows: true,
				responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 4,
				  }
				},
				{
				  breakpoint: 992,
				  settings: {
					slidesToShow: 3,																																							 
				  }
				},
				{
				  breakpoint: 768,
				  settings: {
					slidesToShow: 3,
				  }
				},
				{
				  breakpoint: 480,
				  settings: {
					slidesToShow: 3,
				  }
				},
				{
				  breakpoint: 479,
				  settings: {
					slidesToShow: 1,
				  }
				},
				]
			});
		}
		var product_cover = $('.product-cover') , _productzoom = product_cover.attr('data-productzoom') ,_productzoomtype = product_cover.attr('data-productzoomtype');
		if (_productzoom == 1 && $('.js-qv-product-cover').length) {
			$('.js-qv-product-cover').elevateZoom({
				zoomType: _productzoomtype,
				scrollZoom: true,
				lensShape: "square",
			}); 
		}	
	}
	_forProductDetail();
	prestashop.on('updatedProduct', function (event) {
		_forProductDetail();
    });
	if ($('.main-product .item-timer').length ) {
		$('.main-product .item-timer').each(function(){
			var _data_timer = $(this).attr('data-timer');
			var data = new Date(_data_timer);
				CountDown(data, $(this));
		});
	}	
	
	$(".close").click(function(){
			$('#newsletter_block_popup').fadeOut('medium');
		});
	  
		$('.ckmsg').off('click').on('click', function(e){
			var  c = 'checked', isChecked = $("input.ckmsg").is(":" + c);
			var _checked = $("input.ckmsg:checked").length;
			var options = {};
			options.expires = 1; 
			if (_checked) {
				$.cookie('sp_news_letter',1, options);
			}else{
				$.cookie('sp_news_letter',null);
			}
		});
	  
		$('.check_lable').off('click').on('click', function(e){
			e.preventDefault();
			var  c = 'checked', isChecked = $("input.ckmsg").is(":" + c);
			isChecked ?  $("input.ckmsg").attr('checked', false) : $("input.ckmsg").attr('checked', true);
			var _checked = $("input.ckmsg:checked").length;
			_checked ?  $('.msg  span').addClass('checked') :  $('.msg  span').removeClass('checked', 'checked');
			var options = {};
				options.expires = 1; 
			if (_checked) {
				$.cookie('sp_news_letter',1, options);
			}else{
				$.cookie('sp_news_letter',null);
			}
		});

});

/*
PluginDetect v0.9.1
www.pinlady.net/PluginDetect/license/
[ ]
[ isMinVersion getVersion ]
[ AllowActiveX ]
*/
(function(){var j={version:"0.9.1",name:"PluginDetect",addPlugin:function(p,q){if(p&&j.isString(p)&&q&&j.isFunc(q.getVersion)){p=p.replace(/\s/g,"").toLowerCase();j.Plugins[p]=q;if(!j.isDefined(q.getVersionDone)){q.installed=null;q.version=null;q.version0=null;q.getVersionDone=null;q.pluginName=p;}}},uniqueName:function(){return j.name+"998"},openTag:"<",hasOwnPROP:({}).constructor.prototype.hasOwnProperty,hasOwn:function(s,t){var p;try{p=j.hasOwnPROP.call(s,t)}catch(q){}return !!p},rgx:{str:/string/i,num:/number/i,fun:/function/i,arr:/array/i},toString:({}).constructor.prototype.toString,isDefined:function(p){return typeof p!="undefined"},isArray:function(p){return j.rgx.arr.test(j.toString.call(p))},isString:function(p){return j.rgx.str.test(j.toString.call(p))},isNum:function(p){return j.rgx.num.test(j.toString.call(p))},isStrNum:function(p){return j.isString(p)&&(/\d/).test(p)},isFunc:function(p){return j.rgx.fun.test(j.toString.call(p))},getNumRegx:/[\d][\d\.\_,\-]*/,splitNumRegx:/[\.\_,\-]/g,getNum:function(q,r){var p=j.isStrNum(q)?(r&&j.isString(r)?new RegExp(r):j.getNumRegx).exec(q):null;return p?p[0]:null},compareNums:function(w,u,t){var s,r,q,v=parseInt;if(j.isStrNum(w)&&j.isStrNum(u)){if(j.isDefined(t)&&t.compareNums){return t.compareNums(w,u)}s=w.split(j.splitNumRegx);r=u.split(j.splitNumRegx);for(q=0;q<Math.min(s.length,r.length);q++){if(v(s[q],10)>v(r[q],10)){return 1}if(v(s[q],10)<v(r[q],10)){return -1}}}return 0},formatNum:function(q,r){var p,s;if(!j.isStrNum(q)){return null}if(!j.isNum(r)){r=4}r--;s=q.replace(/\s/g,"").split(j.splitNumRegx).concat(["0","0","0","0"]);for(p=0;p<4;p++){if(/^(0+)(.+)$/.test(s[p])){s[p]=RegExp.$2}if(p>r||!(/\d/).test(s[p])){s[p]="0"}}return s.slice(0,4).join(",")},pd:{getPROP:function(s,q,p){try{if(s){p=s[q]}}catch(r){this.errObj=r;}return p},findNavPlugin:function(u){if(u.dbug){return u.dbug}var A=null;if(window.navigator){var z={Find:j.isString(u.find)?new RegExp(u.find,"i"):u.find,Find2:j.isString(u.find2)?new RegExp(u.find2,"i"):u.find2,Avoid:u.avoid?(j.isString(u.avoid)?new RegExp(u.avoid,"i"):u.avoid):0,Num:u.num?/\d/:0},s,r,t,y,x,q,p=navigator.mimeTypes,w=navigator.plugins;if(u.mimes&&p){y=j.isArray(u.mimes)?[].concat(u.mimes):(j.isString(u.mimes)?[u.mimes]:[]);for(s=0;s<y.length;s++){r=0;try{if(j.isString(y[s])&&/[^\s]/.test(y[s])){r=p[y[s]].enabledPlugin}}catch(v){}if(r){t=this.findNavPlugin_(r,z);if(t.obj){A=t.obj}if(A&&!j.dbug){return A}}}}if(u.plugins&&w){x=j.isArray(u.plugins)?[].concat(u.plugins):(j.isString(u.plugins)?[u.plugins]:[]);for(s=0;s<x.length;s++){r=0;try{if(x[s]&&j.isString(x[s])){r=w[x[s]]}}catch(v){}if(r){t=this.findNavPlugin_(r,z);if(t.obj){A=t.obj}if(A&&!j.dbug){return A}}}q=w.length;if(j.isNum(q)){for(s=0;s<q;s++){r=0;try{r=w[s]}catch(v){}if(r){t=this.findNavPlugin_(r,z);if(t.obj){A=t.obj}if(A&&!j.dbug){return A}}}}}}return A},findNavPlugin_:function(t,s){var r=t.description||"",q=t.name||"",p={};if((s.Find.test(r)&&(!s.Find2||s.Find2.test(q))&&(!s.Num||s.Num.test(RegExp.leftContext+RegExp.rightContext)))||(s.Find.test(q)&&(!s.Find2||s.Find2.test(r))&&(!s.Num||s.Num.test(RegExp.leftContext+RegExp.rightContext)))){if(!s.Avoid||!(s.Avoid.test(r)||s.Avoid.test(q))){p.obj=t}}return p},getVersionDelimiter:",",findPlugin:function(r){var q,p={status:-3,plugin:0};if(!j.isString(r)){return p}if(r.length==1){this.getVersionDelimiter=r;return p}r=r.toLowerCase().replace(/\s/g,"");q=j.Plugins[r];if(!q||!q.getVersion){return p}p.plugin=q;p.status=1;return p}},AXO:(function(){var q;try{q=new window.ActiveXObject()}catch(p){}return q?null:window.ActiveXObject})(),getAXO:function(p){var r=null;try{r=new j.AXO(p)}catch(q){j.errObj=q;}if(r){j.browser.ActiveXEnabled=!0}return r},browser:{detectPlatform:function(){var r=this,q,p=window.navigator?navigator.platform||"":"";j.OS=100;if(p){var s=["Win",1,"Mac",2,"Linux",3,"FreeBSD",4,"iPhone",21.1,"iPod",21.2,"iPad",21.3,"Win.*CE",22.1,"Win.*Mobile",22.2,"Pocket\\s*PC",22.3,"",100];for(q=s.length-2;q>=0;q=q-2){if(s[q]&&new RegExp(s[q],"i").test(p)){j.OS=s[q+1];break}}}},detectIE:function(){var r=this,u=document,t,q,v=window.navigator?navigator.userAgent||"":"",w,p,y;r.ActiveXFilteringEnabled=!1;r.ActiveXEnabled=!1;try{r.ActiveXFilteringEnabled=!!window.external.msActiveXFilteringEnabled()}catch(s){}p=["Msxml2.XMLHTTP","Msxml2.DOMDocument","Microsoft.XMLDOM","TDCCtl.TDCCtl","Shell.UIHelper","HtmlDlgSafeHelper.HtmlDlgSafeHelper","Scripting.Dictionary"];y=["WMPlayer.OCX","ShockwaveFlash.ShockwaveFlash","AgControl.AgControl"];w=p.concat(y);for(t=0;t<w.length;t++){if(j.getAXO(w[t])&&!j.dbug){break}}if(r.ActiveXEnabled&&r.ActiveXFilteringEnabled){for(t=0;t<y.length;t++){if(j.getAXO(y[t])){r.ActiveXFilteringEnabled=!1;break}}}q=u.documentMode;try{u.documentMode=""}catch(s){}r.isIE=r.ActiveXEnabled;r.isIE=r.isIE||j.isNum(u.documentMode)||new Function("return/*@cc_on!@*/!1")();try{u.documentMode=q}catch(s){}r.verIE=null;if(r.isIE){r.verIE=(j.isNum(u.documentMode)&&u.documentMode>=7?u.documentMode:0)||((/^(?:.*?[^a-zA-Z])??(?:MSIE|rv\s*\:)\s*(\d+\.?\d*)/i).test(v)?parseFloat(RegExp.$1,10):7)}},detectNonIE:function(){var q=this,p=0,t=window.navigator?navigator:{},s=q.isIE?"":t.userAgent||"",u=t.vendor||"",r=t.product||"";q.isGecko=!p&&(/Gecko/i).test(r)&&(/Gecko\s*\/\s*\d/i).test(s);p=p||q.isGecko;q.verGecko=q.isGecko?j.formatNum((/rv\s*\:\s*([\.\,\d]+)/i).test(s)?RegExp.$1:"0.9"):null;q.isOpera=!p&&(/(OPR\s*\/|Opera\s*\/\s*\d.*\s*Version\s*\/|Opera\s*[\/]?)\s*(\d+[\.,\d]*)/i).test(s);p=p||q.isOpera;q.verOpera=q.isOpera?j.formatNum(RegExp.$2):null;q.isEdge=!p&&(/(Edge)\s*\/\s*(\d[\d\.]*)/i).test(s);p=p||q.isEdge;q.verEdgeHTML=q.isEdge?j.formatNum(RegExp.$2):null;q.isChrome=!p&&(/(Chrome|CriOS)\s*\/\s*(\d[\d\.]*)/i).test(s);p=p||q.isChrome;q.verChrome=q.isChrome?j.formatNum(RegExp.$2):null;q.isSafari=!p&&((/Apple/i).test(u)||!u)&&(/Safari\s*\/\s*(\d[\d\.]*)/i).test(s);p=p||q.isSafari;q.verSafari=q.isSafari&&(/Version\s*\/\s*(\d[\d\.]*)/i).test(s)?j.formatNum(RegExp.$1):null;},init:function(){var p=this;p.detectPlatform();p.detectIE();p.detectNonIE()}},init:{hasRun:0,library:function(){window[j.name]=j;var q=this,p=document;j.head=p.getElementsByTagName("head")[0]||p.getElementsByTagName("body")[0]||p.body||null;j.browser.init();q.hasRun=1;}},isMinVersion:function(v,u,r,q){var s=j.pd.findPlugin(v),t,p=-1;if(s.status<0){return s.status}t=s.plugin;u=j.formatNum(j.isNum(u)?u.toString():(j.isStrNum(u)?j.getNum(u):"0"));if(t.getVersionDone!=1){t.getVersion(u,r,q);if(t.getVersionDone===null){t.getVersionDone=1}}if(t.installed!==null){p=t.installed<=0.5?t.installed:(t.installed==0.7?1:(t.version===null?0:(j.compareNums(t.version,u,t)>=0?1:-0.1)))}return p},getVersion:function(u,r,q){var s=j.pd.findPlugin(u),t,p;if(s.status<0){return null}t=s.plugin;if(t.getVersionDone!=1){t.getVersion(null,r,q);if(t.getVersionDone===null){t.getVersionDone=1}}p=(t.version||t.version0);p=p?p.replace(j.splitNumRegx,j.pd.getVersionDelimiter):p;return p},Plugins:{}};j.init.library();})();




/*! fancyBox v2.1.5 fancyapps.com | fancyapps.com/fancybox/#license */
(function(r,G,f,v){var J=f("html"),n=f(r),p=f(G),b=f.fancybox=function(){b.open.apply(this,arguments)},I=navigator.userAgent.match(/msie/i),B=null,s=G.createTouch!==v,t=function(a){return a&&a.hasOwnProperty&&a instanceof f},q=function(a){return a&&"string"===f.type(a)},E=function(a){return q(a)&&0<a.indexOf("%")},l=function(a,d){var e=parseInt(a,10)||0;d&&E(a)&&(e*=b.getViewport()[d]/100);return Math.ceil(e)},w=function(a,b){return l(a,b)+"px"};f.extend(b,{version:"2.1.5",defaults:{padding:15,margin:20,
width:800,height:600,minWidth:100,minHeight:100,maxWidth:9999,maxHeight:9999,pixelRatio:1,autoSize:!0,autoHeight:!1,autoWidth:!1,autoResize:!0,autoCenter:!s,fitToView:!0,aspectRatio:!1,topRatio:0.5,leftRatio:0.5,scrolling:"auto",wrapCSS:"",arrows:!0,closeBtn:!0,closeClick:!1,nextClick:!1,mouseWheel:!0,autoPlay:!1,playSpeed:3E3,preload:3,modal:!1,loop:!0,ajax:{dataType:"html",headers:{"X-fancyBox":!0}},iframe:{scrolling:"auto",preload:!0},swf:{wmode:"transparent",allowfullscreen:"true",allowscriptaccess:"always"},
keys:{next:{13:"left",34:"up",39:"left",40:"up"},prev:{8:"right",33:"down",37:"right",38:"down"},close:[27],play:[32],toggle:[70]},direction:{next:"left",prev:"right"},scrollOutside:!0,index:0,type:null,href:null,content:null,title:null,tpl:{wrap:'<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',image:'<img class="fancybox-image" src="{href}" alt="" />',iframe:'<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen'+
(I?' allowtransparency="true"':"")+"></iframe>",error:'<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',closeBtn:'<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',next:'<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',prev:'<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'},openEffect:"fade",openSpeed:250,openEasing:"swing",openOpacity:!0,
openMethod:"zoomIn",closeEffect:"fade",closeSpeed:250,closeEasing:"swing",closeOpacity:!0,closeMethod:"zoomOut",nextEffect:"elastic",nextSpeed:250,nextEasing:"swing",nextMethod:"changeIn",prevEffect:"elastic",prevSpeed:250,prevEasing:"swing",prevMethod:"changeOut",helpers:{overlay:!0,title:!0},onCancel:f.noop,beforeLoad:f.noop,afterLoad:f.noop,beforeShow:f.noop,afterShow:f.noop,beforeChange:f.noop,beforeClose:f.noop,afterClose:f.noop},group:{},opts:{},previous:null,coming:null,current:null,isActive:!1,
isOpen:!1,isOpened:!1,wrap:null,skin:null,outer:null,inner:null,player:{timer:null,isActive:!1},ajaxLoad:null,imgPreload:null,transitions:{},helpers:{},open:function(a,d){if(a&&(f.isPlainObject(d)||(d={}),!1!==b.close(!0)))return f.isArray(a)||(a=t(a)?f(a).get():[a]),f.each(a,function(e,c){var k={},g,h,j,m,l;"object"===f.type(c)&&(c.nodeType&&(c=f(c)),t(c)?(k={href:c.data("fancybox-href")||c.attr("href"),title:c.data("fancybox-title")||c.attr("title"),isDom:!0,element:c},f.metadata&&f.extend(!0,k,
c.metadata())):k=c);g=d.href||k.href||(q(c)?c:null);h=d.title!==v?d.title:k.title||"";m=(j=d.content||k.content)?"html":d.type||k.type;!m&&k.isDom&&(m=c.data("fancybox-type"),m||(m=(m=c.prop("class").match(/fancybox\.(\w+)/))?m[1]:null));q(g)&&(m||(b.isImage(g)?m="image":b.isSWF(g)?m="swf":"#"===g.charAt(0)?m="inline":q(c)&&(m="html",j=c)),"ajax"===m&&(l=g.split(/\s+/,2),g=l.shift(),l=l.shift()));j||("inline"===m?g?j=f(q(g)?g.replace(/.*(?=#[^\s]+$)/,""):g):k.isDom&&(j=c):"html"===m?j=g:!m&&(!g&&
k.isDom)&&(m="inline",j=c));f.extend(k,{href:g,type:m,content:j,title:h,selector:l});a[e]=k}),b.opts=f.extend(!0,{},b.defaults,d),d.keys!==v&&(b.opts.keys=d.keys?f.extend({},b.defaults.keys,d.keys):!1),b.group=a,b._start(b.opts.index)},cancel:function(){var a=b.coming;a&&!1!==b.trigger("onCancel")&&(b.hideLoading(),b.ajaxLoad&&b.ajaxLoad.abort(),b.ajaxLoad=null,b.imgPreload&&(b.imgPreload.onload=b.imgPreload.onerror=null),a.wrap&&a.wrap.stop(!0,!0).trigger("onReset").remove(),b.coming=null,b.current||
b._afterZoomOut(a))},close:function(a){b.cancel();!1!==b.trigger("beforeClose")&&(b.unbindEvents(),b.isActive&&(!b.isOpen||!0===a?(f(".fancybox-wrap").stop(!0).trigger("onReset").remove(),b._afterZoomOut()):(b.isOpen=b.isOpened=!1,b.isClosing=!0,f(".fancybox-item, .fancybox-nav").remove(),b.wrap.stop(!0,!0).removeClass("fancybox-opened"),b.transitions[b.current.closeMethod]())))},play:function(a){var d=function(){clearTimeout(b.player.timer)},e=function(){d();b.current&&b.player.isActive&&(b.player.timer=
setTimeout(b.next,b.current.playSpeed))},c=function(){d();p.unbind(".player");b.player.isActive=!1;b.trigger("onPlayEnd")};if(!0===a||!b.player.isActive&&!1!==a){if(b.current&&(b.current.loop||b.current.index<b.group.length-1))b.player.isActive=!0,p.bind({"onCancel.player beforeClose.player":c,"onUpdate.player":e,"beforeLoad.player":d}),e(),b.trigger("onPlayStart")}else c()},next:function(a){var d=b.current;d&&(q(a)||(a=d.direction.next),b.jumpto(d.index+1,a,"next"))},prev:function(a){var d=b.current;
d&&(q(a)||(a=d.direction.prev),b.jumpto(d.index-1,a,"prev"))},jumpto:function(a,d,e){var c=b.current;c&&(a=l(a),b.direction=d||c.direction[a>=c.index?"next":"prev"],b.router=e||"jumpto",c.loop&&(0>a&&(a=c.group.length+a%c.group.length),a%=c.group.length),c.group[a]!==v&&(b.cancel(),b._start(a)))},reposition:function(a,d){var e=b.current,c=e?e.wrap:null,k;c&&(k=b._getPosition(d),a&&"scroll"===a.type?(delete k.position,c.stop(!0,!0).animate(k,200)):(c.css(k),e.pos=f.extend({},e.dim,k)))},update:function(a){var d=
a&&a.type,e=!d||"orientationchange"===d;e&&(clearTimeout(B),B=null);b.isOpen&&!B&&(B=setTimeout(function(){var c=b.current;c&&!b.isClosing&&(b.wrap.removeClass("fancybox-tmp"),(e||"load"===d||"resize"===d&&c.autoResize)&&b._setDimension(),"scroll"===d&&c.canShrink||b.reposition(a),b.trigger("onUpdate"),B=null)},e&&!s?0:300))},toggle:function(a){b.isOpen&&(b.current.fitToView="boolean"===f.type(a)?a:!b.current.fitToView,s&&(b.wrap.removeAttr("style").addClass("fancybox-tmp"),b.trigger("onUpdate")),
b.update())},hideLoading:function(){p.unbind(".loading");f("#fancybox-loading").remove()},showLoading:function(){var a,d;b.hideLoading();a=f('<div id="fancybox-loading"><div></div></div>').click(b.cancel).appendTo("body");p.bind("keydown.loading",function(a){if(27===(a.which||a.keyCode))a.preventDefault(),b.cancel()});b.defaults.fixed||(d=b.getViewport(),a.css({position:"absolute",top:0.5*d.h+d.y,left:0.5*d.w+d.x}))},getViewport:function(){var a=b.current&&b.current.locked||!1,d={x:n.scrollLeft(),
y:n.scrollTop()};a?(d.w=a[0].clientWidth,d.h=a[0].clientHeight):(d.w=s&&r.innerWidth?r.innerWidth:n.width(),d.h=s&&r.innerHeight?r.innerHeight:n.height());return d},unbindEvents:function(){b.wrap&&t(b.wrap)&&b.wrap.unbind(".fb");p.unbind(".fb");n.unbind(".fb")},bindEvents:function(){var a=b.current,d;a&&(n.bind("orientationchange.fb"+(s?"":" resize.fb")+(a.autoCenter&&!a.locked?" scroll.fb":""),b.update),(d=a.keys)&&p.bind("keydown.fb",function(e){var c=e.which||e.keyCode,k=e.target||e.srcElement;
if(27===c&&b.coming)return!1;!e.ctrlKey&&(!e.altKey&&!e.shiftKey&&!e.metaKey&&(!k||!k.type&&!f(k).is("[contenteditable]")))&&f.each(d,function(d,k){if(1<a.group.length&&k[c]!==v)return b[d](k[c]),e.preventDefault(),!1;if(-1<f.inArray(c,k))return b[d](),e.preventDefault(),!1})}),f.fn.mousewheel&&a.mouseWheel&&b.wrap.bind("mousewheel.fb",function(d,c,k,g){for(var h=f(d.target||null),j=!1;h.length&&!j&&!h.is(".fancybox-skin")&&!h.is(".fancybox-wrap");)j=h[0]&&!(h[0].style.overflow&&"hidden"===h[0].style.overflow)&&
(h[0].clientWidth&&h[0].scrollWidth>h[0].clientWidth||h[0].clientHeight&&h[0].scrollHeight>h[0].clientHeight),h=f(h).parent();if(0!==c&&!j&&1<b.group.length&&!a.canShrink){if(0<g||0<k)b.prev(0<g?"down":"left");else if(0>g||0>k)b.next(0>g?"up":"right");d.preventDefault()}}))},trigger:function(a,d){var e,c=d||b.coming||b.current;if(c){f.isFunction(c[a])&&(e=c[a].apply(c,Array.prototype.slice.call(arguments,1)));if(!1===e)return!1;c.helpers&&f.each(c.helpers,function(d,e){if(e&&b.helpers[d]&&f.isFunction(b.helpers[d][a]))b.helpers[d][a](f.extend(!0,
{},b.helpers[d].defaults,e),c)});p.trigger(a)}},isImage:function(a){return q(a)&&a.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg)((\?|#).*)?$)/i)},isSWF:function(a){return q(a)&&a.match(/\.(swf)((\?|#).*)?$/i)},_start:function(a){var d={},e,c;a=l(a);e=b.group[a]||null;if(!e)return!1;d=f.extend(!0,{},b.opts,e);e=d.margin;c=d.padding;"number"===f.type(e)&&(d.margin=[e,e,e,e]);"number"===f.type(c)&&(d.padding=[c,c,c,c]);d.modal&&f.extend(!0,d,{closeBtn:!1,closeClick:!1,nextClick:!1,arrows:!1,
mouseWheel:!1,keys:null,helpers:{overlay:{closeClick:!1}}});d.autoSize&&(d.autoWidth=d.autoHeight=!0);"auto"===d.width&&(d.autoWidth=!0);"auto"===d.height&&(d.autoHeight=!0);d.group=b.group;d.index=a;b.coming=d;if(!1===b.trigger("beforeLoad"))b.coming=null;else{c=d.type;e=d.href;if(!c)return b.coming=null,b.current&&b.router&&"jumpto"!==b.router?(b.current.index=a,b[b.router](b.direction)):!1;b.isActive=!0;if("image"===c||"swf"===c)d.autoHeight=d.autoWidth=!1,d.scrolling="visible";"image"===c&&(d.aspectRatio=
!0);"iframe"===c&&s&&(d.scrolling="scroll");d.wrap=f(d.tpl.wrap).addClass("fancybox-"+(s?"mobile":"desktop")+" fancybox-type-"+c+" fancybox-tmp "+d.wrapCSS).appendTo(d.parent||"body");f.extend(d,{skin:f(".fancybox-skin",d.wrap),outer:f(".fancybox-outer",d.wrap),inner:f(".fancybox-inner",d.wrap)});f.each(["Top","Right","Bottom","Left"],function(a,b){d.skin.css("padding"+b,w(d.padding[a]))});b.trigger("onReady");if("inline"===c||"html"===c){if(!d.content||!d.content.length)return b._error("content")}else if(!e)return b._error("href");
"image"===c?b._loadImage():"ajax"===c?b._loadAjax():"iframe"===c?b._loadIframe():b._afterLoad()}},_error:function(a){f.extend(b.coming,{type:"html",autoWidth:!0,autoHeight:!0,minWidth:0,minHeight:0,scrolling:"no",hasError:a,content:b.coming.tpl.error});b._afterLoad()},_loadImage:function(){var a=b.imgPreload=new Image;a.onload=function(){this.onload=this.onerror=null;b.coming.width=this.width/b.opts.pixelRatio;b.coming.height=this.height/b.opts.pixelRatio;b._afterLoad()};a.onerror=function(){this.onload=
this.onerror=null;b._error("image")};a.src=b.coming.href;!0!==a.complete&&b.showLoading()},_loadAjax:function(){var a=b.coming;b.showLoading();b.ajaxLoad=f.ajax(f.extend({},a.ajax,{url:a.href,error:function(a,e){b.coming&&"abort"!==e?b._error("ajax",a):b.hideLoading()},success:function(d,e){"success"===e&&(a.content=d,b._afterLoad())}}))},_loadIframe:function(){var a=b.coming,d=f(a.tpl.iframe.replace(/\{rnd\}/g,(new Date).getTime())).attr("scrolling",s?"auto":a.iframe.scrolling).attr("src",a.href);
f(a.wrap).bind("onReset",function(){try{f(this).find("iframe").hide().attr("src","//about:blank").end().empty()}catch(a){}});a.iframe.preload&&(b.showLoading(),d.one("load",function(){f(this).data("ready",1);s||f(this).bind("load.fb",b.update);f(this).parents(".fancybox-wrap").width("100%").removeClass("fancybox-tmp").show();b._afterLoad()}));a.content=d.appendTo(a.inner);a.iframe.preload||b._afterLoad()},_preloadImages:function(){var a=b.group,d=b.current,e=a.length,c=d.preload?Math.min(d.preload,
e-1):0,f,g;for(g=1;g<=c;g+=1)f=a[(d.index+g)%e],"image"===f.type&&f.href&&((new Image).src=f.href)},_afterLoad:function(){var a=b.coming,d=b.current,e,c,k,g,h;b.hideLoading();if(a&&!1!==b.isActive)if(!1===b.trigger("afterLoad",a,d))a.wrap.stop(!0).trigger("onReset").remove(),b.coming=null;else{d&&(b.trigger("beforeChange",d),d.wrap.stop(!0).removeClass("fancybox-opened").find(".fancybox-item, .fancybox-nav").remove());b.unbindEvents();e=a.content;c=a.type;k=a.scrolling;f.extend(b,{wrap:a.wrap,skin:a.skin,
outer:a.outer,inner:a.inner,current:a,previous:d});g=a.href;switch(c){case "inline":case "ajax":case "html":a.selector?e=f("<div>").html(e).find(a.selector):t(e)&&(e.data("fancybox-placeholder")||e.data("fancybox-placeholder",f('<div class="fancybox-placeholder"></div>').insertAfter(e).hide()),e=e.show().detach(),a.wrap.bind("onReset",function(){f(this).find(e).length&&e.hide().replaceAll(e.data("fancybox-placeholder")).data("fancybox-placeholder",!1)}));break;case "image":e=a.tpl.image.replace("{href}",
g);break;case "swf":e='<object id="fancybox-swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%"><param name="movie" value="'+g+'"></param>',h="",f.each(a.swf,function(a,b){e+='<param name="'+a+'" value="'+b+'"></param>';h+=" "+a+'="'+b+'"'}),e+='<embed src="'+g+'" type="application/x-shockwave-flash" width="100%" height="100%"'+h+"></embed></object>"}(!t(e)||!e.parent().is(a.inner))&&a.inner.append(e);b.trigger("beforeShow");a.inner.css("overflow","yes"===k?"scroll":
"no"===k?"hidden":k);b._setDimension();b.reposition();b.isOpen=!1;b.coming=null;b.bindEvents();if(b.isOpened){if(d.prevMethod)b.transitions[d.prevMethod]()}else f(".fancybox-wrap").not(a.wrap).stop(!0).trigger("onReset").remove();b.transitions[b.isOpened?a.nextMethod:a.openMethod]();b._preloadImages()}},_setDimension:function(){var a=b.getViewport(),d=0,e=!1,c=!1,e=b.wrap,k=b.skin,g=b.inner,h=b.current,c=h.width,j=h.height,m=h.minWidth,u=h.minHeight,n=h.maxWidth,p=h.maxHeight,s=h.scrolling,q=h.scrollOutside?
h.scrollbarWidth:0,x=h.margin,y=l(x[1]+x[3]),r=l(x[0]+x[2]),v,z,t,C,A,F,B,D,H;e.add(k).add(g).width("auto").height("auto").removeClass("fancybox-tmp");x=l(k.outerWidth(!0)-k.width());v=l(k.outerHeight(!0)-k.height());z=y+x;t=r+v;C=E(c)?(a.w-z)*l(c)/100:c;A=E(j)?(a.h-t)*l(j)/100:j;if("iframe"===h.type){if(H=h.content,h.autoHeight&&1===H.data("ready"))try{H[0].contentWindow.document.location&&(g.width(C).height(9999),F=H.contents().find("body"),q&&F.css("overflow-x","hidden"),A=F.outerHeight(!0))}catch(G){}}else if(h.autoWidth||
h.autoHeight)g.addClass("fancybox-tmp"),h.autoWidth||g.width(C),h.autoHeight||g.height(A),h.autoWidth&&(C=g.width()),h.autoHeight&&(A=g.height()),g.removeClass("fancybox-tmp");c=l(C);j=l(A);D=C/A;m=l(E(m)?l(m,"w")-z:m);n=l(E(n)?l(n,"w")-z:n);u=l(E(u)?l(u,"h")-t:u);p=l(E(p)?l(p,"h")-t:p);F=n;B=p;h.fitToView&&(n=Math.min(a.w-z,n),p=Math.min(a.h-t,p));z=a.w-y;r=a.h-r;h.aspectRatio?(c>n&&(c=n,j=l(c/D)),j>p&&(j=p,c=l(j*D)),c<m&&(c=m,j=l(c/D)),j<u&&(j=u,c=l(j*D))):(c=Math.max(m,Math.min(c,n)),h.autoHeight&&
"iframe"!==h.type&&(g.width(c),j=g.height()),j=Math.max(u,Math.min(j,p)));if(h.fitToView)if(g.width(c).height(j),e.width(c+x),a=e.width(),y=e.height(),h.aspectRatio)for(;(a>z||y>r)&&(c>m&&j>u)&&!(19<d++);)j=Math.max(u,Math.min(p,j-10)),c=l(j*D),c<m&&(c=m,j=l(c/D)),c>n&&(c=n,j=l(c/D)),g.width(c).height(j),e.width(c+x),a=e.width(),y=e.height();else c=Math.max(m,Math.min(c,c-(a-z))),j=Math.max(u,Math.min(j,j-(y-r)));q&&("auto"===s&&j<A&&c+x+q<z)&&(c+=q);g.width(c).height(j);e.width(c+x);a=e.width();
y=e.height();e=(a>z||y>r)&&c>m&&j>u;c=h.aspectRatio?c<F&&j<B&&c<C&&j<A:(c<F||j<B)&&(c<C||j<A);f.extend(h,{dim:{width:w(a),height:w(y)},origWidth:C,origHeight:A,canShrink:e,canExpand:c,wPadding:x,hPadding:v,wrapSpace:y-k.outerHeight(!0),skinSpace:k.height()-j});!H&&(h.autoHeight&&j>u&&j<p&&!c)&&g.height("auto")},_getPosition:function(a){var d=b.current,e=b.getViewport(),c=d.margin,f=b.wrap.width()+c[1]+c[3],g=b.wrap.height()+c[0]+c[2],c={position:"absolute",top:c[0],left:c[3]};d.autoCenter&&d.fixed&&
!a&&g<=e.h&&f<=e.w?c.position="fixed":d.locked||(c.top+=e.y,c.left+=e.x);c.top=w(Math.max(c.top,c.top+(e.h-g)*d.topRatio));c.left=w(Math.max(c.left,c.left+(e.w-f)*d.leftRatio));return c},_afterZoomIn:function(){var a=b.current;a&&(b.isOpen=b.isOpened=!0,b.wrap.css("overflow","visible").addClass("fancybox-opened"),b.update(),(a.closeClick||a.nextClick&&1<b.group.length)&&b.inner.css("cursor","pointer").bind("click.fb",function(d){!f(d.target).is("a")&&!f(d.target).parent().is("a")&&(d.preventDefault(),
b[a.closeClick?"close":"next"]())}),a.closeBtn&&f(a.tpl.closeBtn).appendTo(b.skin).bind("click.fb",function(a){a.preventDefault();b.close()}),a.arrows&&1<b.group.length&&((a.loop||0<a.index)&&f(a.tpl.prev).appendTo(b.outer).bind("click.fb",b.prev),(a.loop||a.index<b.group.length-1)&&f(a.tpl.next).appendTo(b.outer).bind("click.fb",b.next)),b.trigger("afterShow"),!a.loop&&a.index===a.group.length-1?b.play(!1):b.opts.autoPlay&&!b.player.isActive&&(b.opts.autoPlay=!1,b.play()))},_afterZoomOut:function(a){a=
a||b.current;f(".fancybox-wrap").trigger("onReset").remove();f.extend(b,{group:{},opts:{},router:!1,current:null,isActive:!1,isOpened:!1,isOpen:!1,isClosing:!1,wrap:null,skin:null,outer:null,inner:null});b.trigger("afterClose",a)}});b.transitions={getOrigPosition:function(){var a=b.current,d=a.element,e=a.orig,c={},f=50,g=50,h=a.hPadding,j=a.wPadding,m=b.getViewport();!e&&(a.isDom&&d.is(":visible"))&&(e=d.find("img:first"),e.length||(e=d));t(e)?(c=e.offset(),e.is("img")&&(f=e.outerWidth(),g=e.outerHeight())):
(c.top=m.y+(m.h-g)*a.topRatio,c.left=m.x+(m.w-f)*a.leftRatio);if("fixed"===b.wrap.css("position")||a.locked)c.top-=m.y,c.left-=m.x;return c={top:w(c.top-h*a.topRatio),left:w(c.left-j*a.leftRatio),width:w(f+j),height:w(g+h)}},step:function(a,d){var e,c,f=d.prop;c=b.current;var g=c.wrapSpace,h=c.skinSpace;if("width"===f||"height"===f)e=d.end===d.start?1:(a-d.start)/(d.end-d.start),b.isClosing&&(e=1-e),c="width"===f?c.wPadding:c.hPadding,c=a-c,b.skin[f](l("width"===f?c:c-g*e)),b.inner[f](l("width"===
f?c:c-g*e-h*e))},zoomIn:function(){var a=b.current,d=a.pos,e=a.openEffect,c="elastic"===e,k=f.extend({opacity:1},d);delete k.position;c?(d=this.getOrigPosition(),a.openOpacity&&(d.opacity=0.1)):"fade"===e&&(d.opacity=0.1);b.wrap.css(d).animate(k,{duration:"none"===e?0:a.openSpeed,easing:a.openEasing,step:c?this.step:null,complete:b._afterZoomIn})},zoomOut:function(){var a=b.current,d=a.closeEffect,e="elastic"===d,c={opacity:0.1};e&&(c=this.getOrigPosition(),a.closeOpacity&&(c.opacity=0.1));b.wrap.animate(c,
{duration:"none"===d?0:a.closeSpeed,easing:a.closeEasing,step:e?this.step:null,complete:b._afterZoomOut})},changeIn:function(){var a=b.current,d=a.nextEffect,e=a.pos,c={opacity:1},f=b.direction,g;e.opacity=0.1;"elastic"===d&&(g="down"===f||"up"===f?"top":"left","down"===f||"right"===f?(e[g]=w(l(e[g])-200),c[g]="+=200px"):(e[g]=w(l(e[g])+200),c[g]="-=200px"));"none"===d?b._afterZoomIn():b.wrap.css(e).animate(c,{duration:a.nextSpeed,easing:a.nextEasing,complete:b._afterZoomIn})},changeOut:function(){var a=
b.previous,d=a.prevEffect,e={opacity:0.1},c=b.direction;"elastic"===d&&(e["down"===c||"up"===c?"top":"left"]=("up"===c||"left"===c?"-":"+")+"=200px");a.wrap.animate(e,{duration:"none"===d?0:a.prevSpeed,easing:a.prevEasing,complete:function(){f(this).trigger("onReset").remove()}})}};b.helpers.overlay={defaults:{closeClick:!0,speedOut:200,showEarly:!0,css:{},locked:!s,fixed:!0},overlay:null,fixed:!1,el:f("html"),create:function(a){a=f.extend({},this.defaults,a);this.overlay&&this.close();this.overlay=
f('<div class="fancybox-overlay"></div>').appendTo(b.coming?b.coming.parent:a.parent);this.fixed=!1;a.fixed&&b.defaults.fixed&&(this.overlay.addClass("fancybox-overlay-fixed"),this.fixed=!0)},open:function(a){var d=this;a=f.extend({},this.defaults,a);this.overlay?this.overlay.unbind(".overlay").width("auto").height("auto"):this.create(a);this.fixed||(n.bind("resize.overlay",f.proxy(this.update,this)),this.update());a.closeClick&&this.overlay.bind("click.overlay",function(a){if(f(a.target).hasClass("fancybox-overlay"))return b.isActive?
b.close():d.close(),!1});this.overlay.css(a.css).show()},close:function(){var a,b;n.unbind("resize.overlay");this.el.hasClass("fancybox-lock")&&(f(".fancybox-margin").removeClass("fancybox-margin"),a=n.scrollTop(),b=n.scrollLeft(),this.el.removeClass("fancybox-lock"),n.scrollTop(a).scrollLeft(b));f(".fancybox-overlay").remove().hide();f.extend(this,{overlay:null,fixed:!1})},update:function(){var a="100%",b;this.overlay.width(a).height("100%");I?(b=Math.max(G.documentElement.offsetWidth,G.body.offsetWidth),
p.width()>b&&(a=p.width())):p.width()>n.width()&&(a=p.width());this.overlay.width(a).height(p.height())},onReady:function(a,b){var e=this.overlay;f(".fancybox-overlay").stop(!0,!0);e||this.create(a);a.locked&&(this.fixed&&b.fixed)&&(e||(this.margin=p.height()>n.height()?f("html").css("margin-right").replace("px",""):!1),b.locked=this.overlay.append(b.wrap),b.fixed=!1);!0===a.showEarly&&this.beforeShow.apply(this,arguments)},beforeShow:function(a,b){var e,c;b.locked&&(!1!==this.margin&&(f("*").filter(function(){return"fixed"===
f(this).css("position")&&!f(this).hasClass("fancybox-overlay")&&!f(this).hasClass("fancybox-wrap")}).addClass("fancybox-margin"),this.el.addClass("fancybox-margin")),e=n.scrollTop(),c=n.scrollLeft(),this.el.addClass("fancybox-lock"),n.scrollTop(e).scrollLeft(c));this.open(a)},onUpdate:function(){this.fixed||this.update()},afterClose:function(a){this.overlay&&!b.coming&&this.overlay.fadeOut(a.speedOut,f.proxy(this.close,this))}};b.helpers.title={defaults:{type:"float",position:"bottom"},beforeShow:function(a){var d=
b.current,e=d.title,c=a.type;f.isFunction(e)&&(e=e.call(d.element,d));if(q(e)&&""!==f.trim(e)){d=f('<div class="fancybox-title fancybox-title-'+c+'-wrap">'+e+"</div>");switch(c){case "inside":c=b.skin;break;case "outside":c=b.wrap;break;case "over":c=b.inner;break;default:c=b.skin,d.appendTo("body"),I&&d.width(d.width()),d.wrapInner('<span class="child"></span>'),b.current.margin[2]+=Math.abs(l(d.css("margin-bottom")))}d["top"===a.position?"prependTo":"appendTo"](c)}}};f.fn.fancybox=function(a){var d,
e=f(this),c=this.selector||"",k=function(g){var h=f(this).blur(),j=d,k,l;!g.ctrlKey&&(!g.altKey&&!g.shiftKey&&!g.metaKey)&&!h.is(".fancybox-wrap")&&(k=a.groupAttr||"data-fancybox-group",l=h.attr(k),l||(k="rel",l=h.get(0)[k]),l&&(""!==l&&"nofollow"!==l)&&(h=c.length?f(c):e,h=h.filter("["+k+'="'+l+'"]'),j=h.index(this)),a.index=j,!1!==b.open(h,a)&&g.preventDefault())};a=a||{};d=a.index||0;!c||!1===a.live?e.unbind("click.fb-start").bind("click.fb-start",k):p.undelegate(c,"click.fb-start").delegate(c+
":not('.fancybox-item, .fancybox-nav')","click.fb-start",k);this.filter("[data-fancybox-start=1]").trigger("click");return this};p.ready(function(){var a,d;f.scrollbarWidth===v&&(f.scrollbarWidth=function(){var a=f('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo("body"),b=a.children(),b=b.innerWidth()-b.height(99).innerWidth();a.remove();return b});if(f.support.fixedPosition===v){a=f.support;d=f('<div style="position:fixed;top:20px;"></div>').appendTo("body");var e=20===
d[0].offsetTop||15===d[0].offsetTop;d.remove();a.fixedPosition=e}f.extend(b.defaults,{scrollbarWidth:f.scrollbarWidth(),fixed:f.support.fixedPosition,parent:f("body")});a=f(r).width();J.addClass("fancybox-lock-test");d=f(r).width();J.removeClass("fancybox-lock-test");f("<style type='text/css'>.fancybox-margin{margin-right:"+(d-a)+"px;}</style>").appendTo("head")})})(window,document,jQuery);

