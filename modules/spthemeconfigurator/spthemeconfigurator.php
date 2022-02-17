<?php

/**
 * @package SP Theme Configurator
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.magentech.com
 */


if (!defined('_PS_VERSION_')) exit;

include_once(dirname(__FILE__) . '/spthemeconfiguratorcore.php');

class spthemeconfigurator extends SPThemeConfiguratorCore
{	
   
	
    function __construct(){
        $this->name = 'spthemeconfigurator';
        $this->tab = 'front_office_features';
        $this->version = '2.0.0';
		$this->versions = 'SP Theme Settings v.'.$this->version.' | PS v.'._PS_VERSION_;		
        $this->author = 'MagenTech';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
        $this->displayName = $this->l('SP Theme Configuration');
        $this->description = $this->l('Configure the main elements of your theme.');
		
		parent::__construct();
       
		$this->SPConfigCore = new spthemeconfiguratorcore;
		$this->defaults = $this->SPConfigCore->getThemeFields();
		
    }

    /* ------------------------------------------------------------- */
    /*  INSTALL THE MODULE
    /* ------------------------------------------------------------- */
    public function install()
    {
		if (  parent::install() && 
            $this->registerHook('header') && 
            $this->registerHook('displayAnywhere') &&
            $this->registerHook('actionShopDataDuplication') &&
            $this->registerHook('displayRightColumnProduct') &&
            $this->registerHook('displaySecondImage') &&
			$this->registerHook('displayAllImage') &&
            $this->registerHook('displayFooterSocial') &&
			$this->registerHook('displayFooterContact') &&
            $this->registerHook('displayFooterPayment') &&
            $this->registerHook('displaySidebarProduct') &&
            $this->_defaultValues() &&
			$this->_createTab()
        ){
            if ($id_hook = Hook::getIdByName('displayHeader'))
                $this->updatePosition($id_hook, 0, 1);
            return true;
        }
        return false;
    }

    /* ------------------------------------------------------------- */
    /*  UNINSTALL THE MODULE
    /* ------------------------------------------------------------- */
    public function uninstall()
    {
		 if(!parent::uninstall() ||
			$this->_deleteTab() ||
            !$this->_deleteConfigs()
        )
			return true;

    }

   
	
    /* ------------------------------------------------------------- */
    /*  HOOK (displayHeader)
    /* ------------------------------------------------------------- */
    public function hookHeader($params)
    {
        $this->_prepHook($params);
		global $cookie, $smarty;
		$sp_var = array();
		
        $id_shop = $this->context->shop->id;
		$is_responsive = Configuration::get('SP_layoutRes');
		$showCpanel = Configuration::get('SP_showCpanel');
		
		foreach($this->defaults as $key => $value) {
			$sp_var[$key] = Configuration::get($key);
		}
		$home_url = Tools::getHttpHost(true).__PS_BASE_URI__;
		// Load SP JS 
		$this->context->controller->registerJavascript('jquery-1.11.0.min.js', '/assets/sp-js/jquery-1.11.0.min.js', ['position' => 'head', 'priority' => 0]);
		$this->context->controller->registerJavascript('owl.carousel.js', '/assets/sp-js/owl.carousel.js', ['position' => 'head', 'priority' => 1]);
		$this->context->controller->registerJavascript('splib.js', '/assets/sp-js/splib.js', ['position' => 'bottom', 'priority' => 2]);
		$this->context->controller->registerJavascript('jquery.imagesloaded.js', '/assets/sp-js/jquery.imagesloaded.js', ['position' => 'head', 'priority' => 3]);
		$this->context->controller->registerJavascript('jquery.sj_accordion.js', '/assets/sp-js/jquery.sj_accordion.js', ['position' => 'head', 'priority' => 4]);
		$this->context->controller->registerJavascript('jquery.fancybox.pack.js', '/assets/sp-js/jquery.fancybox.pack.js', ['position' => 'head', 'priority' => 5]);
		$this->context->controller->registerJavascript('jquery.fancybox-media.js', '/assets/sp-js/jquery.fancybox-media.js', ['position' => 'head', 'priority' => 6]);
		// Load Cpanel Config
		 if($showCpanel){ 
			$this->context->controller->addCSS(_MODULE_DIR_ . $this->name . '/views/css/front/sp-cpanel.css');
			//$this->context->controller->addCSS(__PS_BASE_URI__.'modules/'.$this->name.'/views/css/front/jquery.miniColors.css', 'all');
			$this->context->controller->addJS(__PS_BASE_URI__.'modules/'.$this->name.'/views/js/front/jquery.miniColors.min.js', 'all');
			$this->context->controller->addJS(__PS_BASE_URI__.'modules/'.$this->name.'/views/js/front/sp-cpanel.js', 'all');
			
			
			if( Tools::getIsset('SP_cplApply') && strtolower( Tools::getValue('SP_cplApply') ) == "apply" ){
		  		foreach($this->defaults as $key => $value) {
                    if(Tools::getIsset(str_replace('SP_', 'SP_cpl', $key))){
                        $cookie->__set(str_replace('SP_', 'SP_cpl', $key), Tools::getValue(str_replace('SP_', 'SP_cpl', $key)) );
                    }
				}
				header("location:". $home_url);
				//Tools::redirect( "index.php" );
			}
            if( Tools::getIsset('SP_cplReset') && strtolower( Tools::getValue('SP_cplReset') ) == "reset" ){
	  			foreach($this->defaults as $key => $value) {
					$cookie->__unset(str_replace('SP_', 'SP_cpl', $key));
				}
				header("location:". $home_url);
				//Tools::redirect( "index.php" );	
			}
			
			// Set value for params
			
	  		foreach($this->defaults as $key => $value) {
				if($cookie->__get(str_replace('SP_', 'SP_cpl', $key)) !== false){
					$sp_var[$key] = $cookie->__get( str_replace('SP_', 'SP_cpl', $key));
	  			}
			}
		}
		
		
		// compile scss
		$scssDir = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/_dev/css/';
		$cssDir = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/assets/css/';
		 
        /* We are loading css files in this hook, because
         * this is the only way to make sure these css files
         * will override any other css files.. Otherwise
         * module positioning will cause a lot of issues.
         */

        /* LOAD CSS */
		$language = new Language($cookie->id_lang);

		if ($language->is_rtl){
			$this->context->controller->registerStylesheet('bootstrap-rtl', 'assets/css/bootstrap/bootstrap-rtl.css', ['media' => 'all']);
		}
		//else $this->context->controller->addCSS(_THEME_CSS_DIR_ . 'bootstrap/bootstrap.min.css');
		 
       
	    // DO NOT MOVE THIS -> see the file for more information
        //$this->context->controller->addCSS(_THEME_CSS_DIR_ . 'jquery_plugins/jquery.plugins.css');
        
		// DO NOT MOVE THIS
		if($sp_var['SP_themecolorrand']) {
			$themeColors = ($this->randColor($sp_var['SP_themecolorrandin'])) ? $this->randColor($sp_var['SP_themecolorrandin']) : $sp_var['SP_themesColors'];
		} else {
			$themeColors = $sp_var['SP_themesColors'];
		}
		$themeColors2 = $sp_var['SP_themesColors2'];
		$smarty->assign( $sp_var );
		$themeColors = strtolower($themeColors);
		$themeCssName = 'theme-' . str_replace("#", "", $themeColors) . '.css';
		$rtlCssName = 'rtl.css';
		$resCssName = 'responsive.css';
		$ie9CssName = 'ie9.css';
		
        // Load auto-created css files
        $cssFile = 'configCss-' . $id_shop . '.css';
        if (file_exists(_PS_MODULE_DIR_ . $this->name . '/views/css/front/' . $cssFile)) {
            $this->context->controller->addCSS(_MODULE_DIR_ . $this->name . '/views/css/front/' . $cssFile);
        }
        else {
            $this->context->controller->addCSS(_MODULE_DIR_ . $this->name . '/views/css/front/configCSS-default.css');
        }
		
		// Load auto-created SCSS Compile
		if((!file_exists($cssDir . $themeCssName)) || $sp_var['SP_Scsscompile'] == 1) {
			require "scssphp/scss.inc.php";
			require "scssphp/compass/compass.inc.php";
			
			$scss = new scssc();
			new scss_compass($scss);
			
			if($sp_var['SP_Scssformat']) $cssFormat = $sp_var['SP_Scssformat'];
			else $cssFormat = 'scss_formatter_compressed';
			
			$scss->setFormatter($cssFormat);
			$scss->addImportPath($scssDir);
			
			
			
			$variables = '$color1: '.$themeColors.';';
			$variables2= '$color2: '.$themeColors2.';';
			
			$string_sass = $variables. $variables2 . file_get_contents($scssDir . "themestyles.scss");
			
			$rtl_css 	= $scss->compile('@import "rtl.scss"');
			$res_css 	= $scss->compile('@import "responsive.scss"');
			$ie9_css 	= $scss->compile('@import "ie9.scss"');
			$string_css = $scss->compile($string_sass);
			$string_css = preg_replace('/\/\*[\s\S]*?\*\//', '', $string_css); // remove mutiple comments
			
			file_put_contents($cssDir . $themeCssName, $string_css);
			file_put_contents($cssDir . $rtlCssName, $rtl_css);
			file_put_contents($cssDir . $resCssName, $res_css);
			file_put_contents($cssDir . $ie9CssName, $ie9_css);
			
		}
		
		
		$this->context->controller->registerStylesheet('theme-color','assets/css/'.$themeCssName);
		$this->context->controller->registerStylesheet('responsive.css','assets/css/responsive.css');
		
		if($is_responsive) $this->context->controller->addCss(_THEME_CSS_DIR_ . 'responsive.css');
		else  $this->context->controller->addCss(_THEME_CSS_DIR_ . 'bootstrap/none-responsive.css');
		
		
		
        /* GLOBAL SMARTY VARS */
        /* LOAD JS */
        // Load custom JS files
		$controller_name = Dispatcher::getInstance()->getController();
		$this->context->controller->addJqueryPlugin('backtotop', _THEME_JS_DIR_ . 'sp_lib/');
		if(Configuration::get('SP_keepMenuTop') == 1)
			$this->context->controller->registerJavascript('keepmenu', 'modules/'.$this->name.'/views/js/front/jquery.keepmenu.js', ['position' => 'bottom', 'priority' => 150]);
			//$this->context->controller->addJS(__PS_BASE_URI__.'modules/'.$this->name.'/views/js/front/sp-cpanel.js', 'all');
			//$this->context->controller->addJqueryPlugin('keepmenu', _THEME_JS_DIR_ . 'sp_lib/');
		if(Configuration::get('SP_animationScroll') == 1) $this->context->controller->addJqueryPlugin('scrollReveal', _THEME_JS_DIR_ . 'sp_lib/');
		
        $this->context->controller->addJqueryPlugin('global', _THEME_JS_DIR_ . 'sp_lib/');
		$this->context->controller->addJqueryPlugin('ui.touch-punch.min', _THEME_JS_DIR_ . 'sp_lib/');

		// Load JS Zoom Image
		//if(Configuration::get('SP_productZoom') == 1) $this->context->controller->addJqueryPlugin('elevatezoom', _THEME_JS_DIR_ . 'sp_lib/');

      
		
    }
	
	/* ------------------------------------------------------------- */
    /*  GET DISPLAY SECOND IMAGE
    /* ------------------------------------------------------------- */
	public function hookDisplaySecondImage($params) {
		
		//if (!$this->isCached('displaySecondImage.tpl', $this->getCacheId($params['id_product']))) {
			$id_lang = $this->context->language->id;
				$obj     = new Product((int) ($params['id_product']), false, $id_lang);
				$images  = $obj->getImages($this->context->language->id);
				$_images = array();
				if (!empty($images))
					foreach ($images as $k => $image)
						if(!$image['cover']) $_images[] = $obj->id . '-' . $image['id_image'];
			  
			$this->smarty->assign(array(
				'link' => $this->context->link,
				'link_rewrite' => $params['link_rewrite'],
				'images' => $_images
			));
		//}
		return $this->fetch('module:spthemeconfigurator/views/templates/hook/displaySecondImage.tpl');
		//return $this->display(__FILE__, 'displaySecondImage.tpl', $this->getCacheId($params['id_product']));
	}
	public function hookDisplayAllImage($params) {
		if (!Configuration::get('SP_allimg')) return;
		
		if (!$this->isCached('displayAllImage.tpl', $this->getCacheId($params['id_product']))) {
			$id_lang = $this->context->language->id;
				$obj     = new Product((int) ($params['id_product']), false, $id_lang);
				$images  = $obj->getImages($this->context->language->id);
				$_images = array();
				if (!empty($images))
					foreach ($images as $k => $image)
						if(!$image['cover']) $_images[] = $obj->id . '-' . $image['id_image'];
			  
			$this->smarty->assign(array(
				'link_rewrite' => $params['link_rewrite'],
				'images' => $_images
			));
		}
		return $this->display(__FILE__, 'displayAllImage.tpl', $this->getCacheId($params['id_product']));
	}
	/* ------------------------------------------------------------- */
    /*  GET DISPLAY FOOTER SOCIAL
    /* ------------------------------------------------------------- */
	public function hookDisplayFooterContact($params) {
		return $this->display(__FILE__, 'displayContact.tpl');
	}
	
	/* ------------------------------------------------------------- */
    /*  GET DISPLAY FOOTER CONTACT
    /* ------------------------------------------------------------- */
	public function hookDisplayFooterSocial($params) {
		if (!Configuration::get('social_in_footer')) return;
		return $this->display(__FILE__, 'displaySocial.tpl');
	}
	
	/* ------------------------------------------------------------- */
    /*  GET DISPLAY SIDEBAR PRODUCT
    /* ------------------------------------------------------------- */
	public function hookDisplaySidebarProduct($params) {
		if (!Configuration::get('SP_SidebarProduct')) return;
		return $this->display(__FILE__, 'displaySidebarProduct.tpl');
	}
	
	/* ------------------------------------------------------------- */
    /*  GET DISPLAY FOOTER SOCIAL
    /* ------------------------------------------------------------- */
	public function hookDisplayFooterPayment($params) {
		if (!Configuration::get('SP_payment_image')) return;
		return $this->display(__FILE__, 'displaypayment.tpl');
	}
}
