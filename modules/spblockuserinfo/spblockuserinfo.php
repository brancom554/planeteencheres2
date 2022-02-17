<?php
/**
 * package SP Footer Links
 *
 * @version 1.0.1
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */


use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

class spblockuserinfo extends Module implements WidgetInterface
{
    public function __construct()
    {
        $this->name = 'spblockuserinfo';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'MegenTech';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->getTranslator()->trans('Sp Customer "Sign in" link', array(), 'Modules.CustomerSignIn');
        $this->description = $this->getTranslator()->trans('Adds a block that displays information about the customer.', array(), 'Modules.CustomerSignIn');
        $this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);
    }

	public function install()
	{
        return
            parent::install()
                && $this->registerHook('displayUserinfo')
        ;
	}		
	
    public function getWidgetVariables($hookName, array $configuration)
    {
        if (!$this->active) {
            return;
        }

        $logged = $this->context->customer->isLogged();
        $customerName = '';
        if ($logged) {
            $customerName = $this->getTranslator()->trans(
                '%firstname% %lastname%',
                array(
                    '%firstname%' => $this->context->customer->firstname,
                    '%lastname%' => $this->context->customer->lastname,
                ),
                'Modules.CustomerSignIn'
            );
        }
        $link = $this->context->link;
        return [
            'logged' => $logged,
            'customerName' => $customerName,
            'logout_url' => $link->getPageLink('index', true, null, 'mylogout'),
            'my_account_url' => $link->getPageLink('my-account', true),

        ];
    }

    public function renderWidget($hookName, array $configuration)
    {
        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        return $this->fetch('module:'.$this->name.'/'.$this->name.'.tpl');
    }
}
