<?php

class AdminSPConfigController extends ModuleAdminController {

    public function __construct()
    {
        parent::__construct();
		if (!(bool)Tools::getValue('ajax'))
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules').'&configure=spthemeconfigurator');
    }
	public function ajaxProcessClearCss()
	{
		
		$this->clearCacheCss();
		die(Tools::jsonEncode(array(
			'success' => true
		)));
	}
	public function clearCacheCss() {
		$cssDir = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/css/';
		$cssCacheDir = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/cache/';
	    $this->deleteCss($cssDir);
	    $this->deleteCss($cssCacheDir, true);
	}
	public function deleteCss ($directory, $delall = false) {
		$minute = 60;
	    if ($handle = opendir($directory)) {
	        while (false !== ($file = readdir($handle))) {
	            if ($file != '.' && $file != '..') {
            		if($delall && (preg_match("/css$/i", $file) || preg_match("/js$/i", $file))) {
					    $filePath = $directory.$file;
						unlink($filePath);
            		} elseif (preg_match("/css$/i", $file) && preg_match("/^theme-/i", $file)) {
					    $filePath = $directory.$file;
						unlink($filePath);
					}
	            }
	        }
	        closedir($handle);
	    }
	}
}
