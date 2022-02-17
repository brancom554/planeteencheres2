<?php
/**
 * package SP Footer Links
 *
 * @version 1.0.1
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class spblocklanguage extends Module implements WidgetInterface
{
    public function __construct()
    {
        $this->name = 'spblocklanguage';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'MagenTech';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Sp Language selector block');
        $this->description = $this->l('Adds a block allowing customers to select a language for your store\'s content.');
        $this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);
    }

	public function install()
	{
		if (parent::install () == false || !$this->registerHook ('displayNav') || !$this->registerHook ('displayNav_2'))
			return false;
		return true;
	}	
	
    public function renderWidget($hookName = null, array $configuration = [])
    {
        if (1 >= count(Language::getLanguages(true, $this->context->shop->id))) {
            return '';
        }
        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        return $this->fetch('module:spblocklanguage/spblocklanguage.tpl', $this->getCacheId());
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        $languages = Language::getLanguages(true, $this->context->shop->id);

        foreach ($languages as &$lang) {
            $lang['name_simple'] = $this->getNameSimple($lang['name']);
        }

        return [
            'languages' => $languages,
            'current_language' => [
                'id_lang' => $this->context->language->id,
                'name' => $this->context->language->name,
                'name_simple' => $this->getNameSimple($this->context->language->name)
            ]
        ];
    }

    private function getNameSimple($name)
    {
        return preg_replace('/\s\(.*\)$/', '', $name);
    }
}
