<?php
/*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

include_once(_PS_MODULE_DIR_.'spmegamenu/Megamenu.php');
include_once(_PS_MODULE_DIR_.'spmegamenu/MegamenuGroup.php');

class SpMegaMenu extends Module
{
	
	protected $_html = '';
	protected $spmegamenu_style = 'mega';
	private $default_hook = array( 'displayMenu', 'displayMenu2' );	
		
    public function __construct()
    {
        $this->name = 'spmegamenu';
        $this->tab = 'front_office_features';
        $this->version = '1.7.0';
		$this->author = 'MagenTech';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
		parent::__construct();

		$this->displayName = $this->l('Sp Mega Menu');
        $this->description = $this->l('Adds a new horizontal mega menu to the top of your e-commerce website.');
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

	/**
	 * @see Module::install()
	 */
	public function install()
	{
		/* Adds Module */
        if (parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('actionObjectCategoryUpdateAfter') &&
            $this->registerHook('actionObjectCategoryDeleteAfter') &&
            $this->registerHook('actionObjectCategoryAddAfter') &&
            $this->registerHook('actionObjectCmsUpdateAfter') &&
            $this->registerHook('actionObjectCmsDeleteAfter') &&
            $this->registerHook('actionObjectCmsAddAfter') &&
            $this->registerHook('actionObjectSupplierUpdateAfter') &&
            $this->registerHook('actionObjectSupplierDeleteAfter') &&
            $this->registerHook('actionObjectSupplierAddAfter') &&
            $this->registerHook('actionObjectManufacturerUpdateAfter') &&
            $this->registerHook('actionObjectManufacturerDeleteAfter') &&
            $this->registerHook('actionObjectManufacturerAddAfter') &&
            $this->registerHook('actionObjectProductUpdateAfter') &&
            $this->registerHook('actionObjectProductDeleteAfter') &&
            $this->registerHook('actionObjectProductAddAfter') &&
            $this->registerHook('categoryUpdate') &&
            $this->registerHook('actionShopDataDuplication'))
		{
			foreach ($this->default_hook as $hook)
			{
				if (!$this->registerHook ($hook))
					return false;
			}
			$shops = Shop::getContextListShopID();
			$shop_groups_list = array();

			/* Setup each shop */
			foreach ($shops as $shop_id)
			{
				$shop_group_id = (int)Shop::getGroupFromShop($shop_id, true);

				if (!in_array($shop_group_id, $shop_groups_list))
					$shop_groups_list[] = $shop_group_id;

				/* Sets up configuration */
				$res = Configuration::updateValue('spmegamenu_style', $this->spmegamenu_style, false, $shop_group_id, $shop_id);
			}

			/* Sets up Shop Group configuration */
			if (count($shop_groups_list))
			{
				foreach ($shop_groups_list as $shop_group_id)
				{
					$res = Configuration::updateValue('spmegamenu_style', $this->spmegamenu_style, false, $shop_group_id);
				}
			}

			/* Sets up Global configuration */
			$res = Configuration::updateValue('spmegamenu_style', $this->spmegamenu_style);	
			/* Creates tables */
			$res &= $this->createTables();
			/* Adds samples */
			if ($res)
				include_once( dirname(__FILE__).'/sample.php');
				
			return (bool)$res;
		}

		return false;
	}

	/**
	 * @see Module::uninstall()
	 */
	public function uninstall()
	{
		/* Deletes Module */
		if (parent::uninstall())
		{
			/* Deletes tables */
			$res = $this->deleteTables();
			$res &= Configuration::deleteByName('spmegamenu_style');
			return (bool)$res;
		}

		return false;
	}

	/**
	 * Creates tables
	 */
	protected function createTables()
	{
		/* spmegamenu */
		$res = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spmegamenu_group`')
			&& Db::getInstance ()->Execute ('CREATE TABLE `'._DB_PREFIX_.'spmegamenu_group` (
			`id_spmegamenu_group` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`hook` varchar(20) NOT NULL, 
			`params` text NOT NULL DEFAULT \'\' ,
			`status` tinyint(1) NOT NULL DEFAULT \'1\',
			`position` int(10) unsigned NOT NULL,
			PRIMARY KEY (`id_spmegamenu_group`)) ENGINE=InnoDB default CHARSET=utf8');
		$res &= Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spmegamenu_group_shop`')
			&& Db::getInstance ()->Execute ('CREATE TABLE `'._DB_PREFIX_.'spmegamenu_group_shop` (
			`id_spmegamenu_group` int(10) unsigned NOT NULL,
			`id_shop` int(10) unsigned NOT NULL, 
			PRIMARY KEY (`id_spmegamenu_group`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8');
		$res &= Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spmegamenu_group_lang`')
			&& Db::getInstance ()->Execute ('CREATE TABLE '._DB_PREFIX_.'spmegamenu_group_lang (
			`id_spmegamenu_group` int(10) unsigned NOT NULL,
			`id_lang` int(10) unsigned NOT NULL,
			`title` varchar(255) NOT NULL DEFAULT \'\',
			`content` text,
			PRIMARY KEY (`id_spmegamenu_group`,`id_lang`)) ENGINE=InnoDB default CHARSET=utf8');
			
		$res &= (bool)Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'spmegamenu` (
				`id_spmegamenu` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_spmegamenu_group` int(10) unsigned NOT NULL,
				`id_parent` int(11) NOT NULL,
				`value` varchar(255) NOT NULL,
				`type` varchar(20) NOT NULL,
				`width` varchar(25) NOT NULL,
				`menu_class` varchar(25) NOT NULL,
				`show_title` tinyint(1) NOT NULL,
				`show_sub_title` tinyint(1) NOT NULL,			  
				`sub_menu` varchar(25) NOT NULL,
				`sub_width` varchar(25) NOT NULL,
				`group` tinyint(1) NOT NULL,
				`type_submenu` tinyint(1) NOT NULL DEFAULT 1,
				`lesp` int(11) NOT NULL,
				`cat_subcategories` int(11) NOT NULL,
				`sp_lesp` int(11) NOT NULL,
				`position` int(11) NOT NULL,
				`active` tinyint(1) NOT NULL,
			  PRIMARY KEY (`id_spmegamenu`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		/* spmegamenu lang */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'spmegamenu_lang` (
			  `id_spmegamenu` int(11) NOT NULL,
			  `id_lang` int(11) NOT NULL,
			  `title` varchar(255) DEFAULT NULL,
			  `label` varchar(255) DEFAULT NULL,
			  `short_description` varchar(255) DEFAULT NULL,
			  `sub_title` varchar(255) DEFAULT NULL,
			  `html` text NOT NULL,
			  `url` varchar(255) NOT NULL,
			  PRIMARY KEY (`id_spmegamenu`,`id_lang`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;
		');

		/* menus shop */
		$res &= Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'spmegamenu_shop` (
			  `id_spmegamenu` int(11) NOT NULL,
			  `id_shop` int(11) NOT NULL,
			  PRIMARY KEY (`id_spmegamenu`,`id_shop`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;
		');

		return $res;
	}
	
	protected function getWarningMultishopHtml()
	{
		if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL)
			return '<p class="alert alert-warning">'.
						$this->l('You cannot manage megamenu items from a "All Shops" or a "Group Shop" context, select directly the shop you want to edit').
					'</p>';
		else
			return '';
	}	

	/**
	 * deletes tables
	 */
	protected function deleteTables()
	{
		$menus = $this->getMenus();
		foreach ($menus as $menu)
		{
			$to_del = new Megamenu($menu['id_spmegamenu']);
			$to_del->delete();
		}

		return Db::getInstance()->execute('
			DROP TABLE IF EXISTS 
				`'._DB_PREFIX_.'spmegamenu`, 
				`'._DB_PREFIX_.'spmegamenu_lang`, 
				`'._DB_PREFIX_.'spmegamenu_shop`,
				`'._DB_PREFIX_.'spmegamenu_group`,
				`'._DB_PREFIX_.'spmegamenu_group_shop`,
				`'._DB_PREFIX_.'spmegamenu_group_lang`;
		');
	}

	public function getContent()
	{
		$this->_html .= $this->headerHTML();

		/* Validate & process */
		if (Tools::isSubmit('submitMenu') || Tools::isSubmit('delete_id_spmegamenu') || Tools::isSubmit('duplicate_id_spmegamenu') ||
			Tools::isSubmit('changeStatus') || Tools::getValue('savePosition') || Tools::isSubmit('submitConfigMenu') || Tools::isSubmit('saveAndStayGroup')
			|| Tools::isSubmit('saveGroupMenu') || Tools::isSubmit('changeStatusMenuGroup') ||  Tools::isSubmit('duplicateMenuGroup') || Tools::isSubmit('deleteMenuGroup')
		)
		{
			if ($this->_postValidation())
			{
				$this->_postProcess();
				$this->_html .= $this->initForm();
				if(Tools::isSubmit('id_spmegamenu_group')){
					$this->_html .= $this->renderAddForm();
					$this->_html .= $this->renderList();
				}
			}
			else
				$this->_html .= $this->renderAddForm();

			$this->clearCache();
		}
		elseif(Tools::isSubmit('addMenuGroup') || Tools::isSubmit('editMenugroup'))
		{
			$this->_html .= $this->initForm();
			if(Tools::isSubmit('editMenugroup')){
				$this->_html .= $this->renderAddForm();
				$this->_html .= $this->renderList();
			}
		}
		else // Default viewport
		{
			$this->_html .= $this->displayForm();
		}

		return $this->_html;
	}

	protected function _postValidation()
	{
		$errors = array();

		if (Tools::isSubmit('changeStatus'))
		{
			if (!Validate::isInt(Tools::getValue('id_spmegamenu')))
				$errors[] = $this->l('Invalid menu');
		}
		/* Validation for menu */
		elseif (Tools::isSubmit('submitMenu'))
		{
			/* Checks state (active) */
			if (!Validate::isInt(Tools::getValue('active_menu')) || (Tools::getValue('active_menu') != 0 && Tools::getValue('active_menu') != 1))
				$errors[] = $this->l('Invalid menu state.');
			/* Checks position */
			if (!Validate::isInt(Tools::getValue('position')) || (Tools::getValue('position') < 0))
				$errors[] = $this->l('Invalid menu position.');
			/* If edit : checks id_spmegamenu */
			if (Tools::isSubmit('id_spmegamenu'))
			{

				//d(var_dump(Tools::getValue('id_spmegamenu')));
				if (!Validate::isInt(Tools::getValue('id_spmegamenu')) && !$this->menuExists(Tools::getValue('id_spmegamenu')))
					$errors[] = $this->l('Invalid menu ID');
			}
			if (Tools::getValue('type') == 'product')
				if (!Validate::isInt(Tools::getValue('type_product[product]')))
					$errors[] = $this->l('Invalid Product ID');
			/* Checks title/url/legend/description/image */
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				if (Tools::strlen(Tools::getValue('title_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The title is too long.');
				if (Tools::strlen(Tools::getValue('url_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The URL is too long.');
				if (Tools::strlen(Tools::getValue('short_description_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The short description is too long.');	
				if (Tools::strlen(Tools::getValue('label_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The  label is too long.');						
				if (Tools::strlen(Tools::getValue('url_'.$language['id_lang'])) > 0 && !Validate::isUrl(Tools::getValue('url_'.$language['id_lang'])))
					$errors[] = $this->l('The URL format is not correct.');
			}

			/* Checks title/url/legend/description for default lang */
			$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
			if (Tools::strlen(Tools::getValue('title_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The title is not set.');
			if (Tools::getValue('type') == 'url')
				if (Tools::strlen(Tools::getValue('url_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The url is not set.');
		} /* Validation for deletion */
		elseif (Tools::isSubmit('delete_id_spmegamenu') && (!Validate::isInt(Tools::getValue('delete_id_spmegamenu')) || !$this->menuExists((int)Tools::getValue('delete_id_spmegamenu'))))
			$errors[] = $this->l('Invalid menu ID');

		/* Display errors if needed */
		if (count($errors))
		{
			$this->_html .= $this->displayError(implode('<br />', $errors));

			return false;
		}

		/* Returns if validation is ok */

		return true;
	}

	protected function _postProcess()
	{
		$errors = array();
		$shop_context = Shop::getContext();
		if (Tools::isSubmit('submitConfigMenu'))
		{
			$shop_groups_list = array();
			$shops = Shop::getContextListShopID();

			foreach ($shops as $shop_id)
			{
				$shop_group_id = (int)Shop::getGroupFromShop($shop_id, true);

				if (!in_array($shop_group_id, $shop_groups_list))
					$shop_groups_list[] = $shop_group_id;

				$res = Configuration::updateValue('spmegamenu_style', Tools::getValue('spmegamenu_style'), false, $shop_group_id, $shop_id);
			}

			/* Update global shop context if needed*/
			switch ($shop_context)
			{
				case Shop::CONTEXT_ALL:
					$res = Configuration::updateValue('spmegamenu_style', Tools::getValue('spmegamenu_style'));
					if (count($shop_groups_list))
					{
						foreach ($shop_groups_list as $shop_group_id)
						{
							$res = Configuration::updateValue('spmegamenu_style', Tools::getValue('spmegamenu_style'), false, $shop_group_id);
						}
					}
					break;
				case Shop::CONTEXT_GROUP:
					if (count($shop_groups_list))
					{
						foreach ($shop_groups_list as $shop_group_id)
						{
							$res = Configuration::updateValue('spmegamenu_style', Tools::getValue('spmegamenu_style'), false, $shop_group_id);
						}
					}
					break;
			}

			$this->clearCache();

			if (!$res)
				$errors[] = $this->displayError($this->l('The configuration could not be updated.'));
			else
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		} 	
		elseif (Tools::isSubmit('changeStatusMenuGroup') && Tools::getValue('id_spmegamenu_group'))
		{
			$menugroup = new MegamenuGroup((int)Tools::getValue('id_spmegamenu_group'));
			if ($menugroup->status == 0)
				$menugroup->status = 1;
			else
				$menugroup->status = 0;
				
			$res = $menugroup->update();
			$this->clearCache();
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		}
		elseif (Tools::isSubmit('duplicateMenuGroup') && Tools::isSubmit('id_spmegamenu_group'))
		{
			$menugroup = new MegamenuGroup((int)Tools::getValue('id_spmegamenu_group'));
			$id_spmegamenu_group = Tools::getValue('id_spmegamenu_group');
			$menugroup->status = 0;
			$menugroup->id = null;
			
			if($menugroup->add()){
				$menus = $this->getIdMenuByGroup($id_spmegamenu_group,true);
				if($menus){
					foreach($menus as $menu){
						$new_menu = new Megamenu((int)$menu['id_spmegamenu']);
						$new_menu->id = null;
						$new_menu->id_parent = 1;
						$new_menu->id_spmegamenu_group = $menugroup->id;
						$new_menu->position = $new_menu->getmaxPositonMenu();
						$id_parent = (int)$menu['id_spmegamenu'];
						if($new_menu->add())
							$this->duplicateParentMenu($id_parent,$new_menu->id,$menugroup->id);
					}
				}
			}
			$this->clearCache();
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		}	
		elseif (Tools::isSubmit('deleteMenuGroup'))
		{
			$menugroup = new MegamenuGroup((int)Tools::getValue('id_spmegamenu_group'));
			if($menugroup->delete()){
				$menus = $this->getIdMenuByGroup((int)Tools::getValue('id_spmegamenu_group'));
				if($menus){
					foreach($menus as $menu){
						$new_menu = new Megamenu((int)$menu['id_spmegamenu']);
						$new_menu->delete();
					}
				}
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
			}else{
				$this->_html .= $this->displayError('Could not delete.');
			}
			$this->clearCache();
		}		
		elseif (Tools::isSubmit('saveAndStayGroup') || Tools::isSubmit('saveGroupMenu'))
		{
			$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
			if (Tools::strlen(Tools::getValue('title_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The title is not set.');
			else{
			if (Tools::getValue('id_spmegamenu_group'))
			{
				$menugroup = new MegamenuGroup((int)Tools::getValue ('id_spmegamenu_group'));
				if (!Validate::isLoadedObject($menugroup))
				{
					$this->html .= $this->displayError($this->l('Invalid slide ID'));
					return false;
				}
			}
			else
				$menugroup = new MegamenuGroup();
			$next_ps = $this->getNextPosition();
			$menugroup->position = (!empty($menugroup->position)) ? (int)$menugroup->position : $next_ps;
			$menugroup->status = (Tools::getValue('status')) ? (int)Tools::getValue('status') : 0;
			$menugroup->hook	= Tools::getValue('hook');
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				$menugroup->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
				$menugroup->content[(int)$language['id_lang']] = Tools::getValue ('content_'.$language['id_lang']);
			}
			
			Tools::getValue ('id_spmegamenu_group') && $this->moduleExists((int)Tools::getValue ('id_spmegamenu_group'))  ? $menugroup->update() : $menugroup->add ();
			$this->clearCache();
			if (Tools::isSubmit ('saveAndStayGroup'))
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editMenugroup&id_spmegamenu_group='.$menugroup->id);
			else
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);				
			}
		}		
		elseif (Tools::isSubmit('changeStatus') && Tools::isSubmit('id_spmegamenu'))
		{
			$menu = new Megamenu((int)Tools::getValue('id_spmegamenu'));
			if ($menu->active == 0)
				$menu->active = 1;
			else
				$menu->active = 0;
			$res = $menu->update();
			$this->clearCache();
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editMenugroup&id_spmegamenu_group='.(int)Tools::getValue('id_spmegamenu_group'));
		}
		elseif(Tools::getValue('savePosition') && Tools::getValue('serialized')){
			$mgmenu   = new Megamenu();
			$serialized = Tools::getValue('serialized');
			$lists =  Tools::jsonDecode($serialized, true); 
			$lesp = 1;
			$id_parent = 1;
			$mgmenu->updatePositions($lists,$lesp,$id_parent);
			$this->clearCache();
			die('Updated');
        }
		/* Processes menu */
		elseif (Tools::isSubmit('submitMenu'))
		{
			/* Sets ID if needed */
			if (Tools::getValue('id_spmegamenu'))
			{
				$mgmenu = new Megamenu((int)Tools::getValue('id_spmegamenu'));
				if (!Validate::isLoadedObject($mgmenu))
				{
					$this->_html .= $this->displayError($this->l('Invalid menu ID'));
					return false;
				}
			}
			else
				$mgmenu = new Megamenu();
				
			/* Sets id_parent */
			$mgmenu->id_parent = (int)Tools::getValue('id_parent');	
			/* Sets type */
			$mgmenu->type = Tools::getValue('type');				
			/* Sets position */
			if (!Tools::getValue('id_spmegamenu'))
			{
				$mgmenu->position = (int)$mgmenu->getmaxPositonMenu();	
			}
			/* Sets active */
			$mgmenu->active = (int)Tools::getValue('active');
			/* Sets show_title */
			$mgmenu->show_title = (int)Tools::getValue('show_title');	
			/* Sets show_sub_title */
			$mgmenu->show_sub_title = (int)Tools::getValue('show_sub_title');
			/* Sets menu_class */
			$mgmenu->menu_class = Tools::getValue('menu_class');	
			/* Sets width */
			$mgmenu->width = Tools::getValue('width');
			/* Sets sub_menu */
			$mgmenu->sub_menu = Tools::getValue('sub_menu');	
			/* Sets sub_width */
			$mgmenu->sub_width = Tools::getValue('sub_width');							
			/* Sets group */
			$mgmenu->group  = (int)Tools::getValue('group');	
			/* Sets cat_subcategories */
			$mgmenu->cat_subcategories  = (int)Tools::getValue('cat_subcategories');	
			/* Sets limit_subcategories */
			$mgmenu->id_spmegamenu_group  = (int)Tools::getValue('id_spmegamenu_group');			
			/* Sets type */
            if( $mgmenu->type && $mgmenu->type !="html" && Tools::getValue("type_".$mgmenu->type) ){
                $mgmenu->value = serialize(Tools::getValue("type_".$mgmenu->type));
            }

			/* Sets each langue fields */
			$languages = Language::getLanguages(false);

			foreach ($languages as $language)
			{
				$mgmenu->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
				$mgmenu->label[$language['id_lang']] = Tools::getValue('label_'.$language['id_lang']);
				$mgmenu->short_description[$language['id_lang']] = Tools::getValue('short_description_'.$language['id_lang']);
				$mgmenu->sub_title[$language['id_lang']] = Tools::getValue('sub_title_'.$language['id_lang']);
				$mgmenu->url[$language['id_lang']] = Tools::getValue('url_'.$language['id_lang']);
				$mgmenu->html[$language['id_lang']] = Tools::getValue('html_'.$language['id_lang']);
			}
			/* Processes if no errors  */
			if (!$errors)
			{
				/* Adds */
				if (!Tools::getValue('id_spmegamenu'))
				{
					if (!$mgmenu->add())
						$errors[] = $this->displayError($this->l('The menu could not be added.'));
				}
				/* Update */
				elseif ($mgmenu->update())
					//$errors[] = $this->displayError($this->l('The menu could not be updated.'));
				$this->clearCache();
			}
		} /* Deletes */
		elseif (Tools::isSubmit('delete_id_spmegamenu'))
		{
			Megamenu::deleteMenu((int)Tools::getValue('delete_id_spmegamenu'));
			$this->clearCache();
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editMenugroup&id_spmegamenu_group='.(int)Tools::getValue('id_spmegamenu_group'));
		}
		elseif (Tools::isSubmit('duplicate_id_spmegamenu'))
		{
			$id_parent = (int)Tools::getValue('duplicate_id_spmegamenu');
			$id_spmegamenu_group = (int)Tools::getValue('id_spmegamenu_group');
			$parent_menu = new Megamenu((int)Tools::getValue('duplicate_id_spmegamenu'));
			$parent_menu->id = null;
			$parent_menu->id_spmegamenu = null;
			$parent_menu->active = 0;
			$parent_menu->position = $parent_menu->getmaxPositonMenu();
			if ($parent_menu->add())
				$this->duplicateParentMenu($id_parent,$parent_menu->id,$id_spmegamenu_group);
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=19&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editMenugroup&id_spmegamenu_group='.(int)Tools::getValue('id_spmegamenu_group'));
		}		

		/* Display errors if needed */
		if (count($errors))
			$this->_html .= $this->displayError(implode('<br />', $errors));
		elseif (Tools::isSubmit('submitMenu') && Tools::getValue('id_spmegamenu'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_spmegamenu='.Tools::getValue('id_spmegamenu').'&editMenugroup&id_spmegamenu_group='.(int)Tools::getValue('id_spmegamenu_group'));
		elseif (Tools::isSubmit('submitMenu'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editMenugroup&id_spmegamenu_group='.(int)Tools::getValue('id_spmegamenu_group'));
	}

	protected function _prepareHook($hook)
	{
		$this->clearCache();			  
		//if (!$this->isCached('spmegamenu.tpl', $this->getCacheId())){
			global $link;
			if(!$hook)
				return;
			$id_shop_group = Shop::getContextShopGroupID();
			$id_shop = Shop::getContextShopID();	
			$spmegamenu_style = Tools::getValue('spmegamenu_style', Configuration::get('spmegamenu_style', null, $id_shop_group, $id_shop));
			$current_link = $link->getPageLink('', false, $this->context->language->id);
			$object = new Megamenu();
			$groups 	= $this->getIdGroupByHook($hook);
			
			if(isset($groups['id_spmegamenu_group']) && $groups['id_spmegamenu_group'])
				$megamenu = $object->getMegamenu(1, 1,$groups['id_spmegamenu_group']);
			else
				$megamenu = '';
			$this->smarty->assign( 'spmegamenu', $megamenu );
			$this->smarty->assign( 'id_spmegamenu_group', $groups['id_spmegamenu_group']);
			$this->smarty->assign( 'current_link', $current_link );
			$this->smarty->assign( 'spmegamenu_style', $spmegamenu_style );
			return $this->display(__FILE__,'spmegamenu.tpl');
		//}

		return true;
	}


	public function hookActionShopDataDuplication($params)
	{
		Db::getInstance ()->execute ('
		INSERT IGNORE INTO `'._DB_PREFIX_.'spmegamenu_shop` (`id_spmegamenu`, `id_shop`)
		SELECT `id_spmegamenu`, '.(int)$params['new_id_shop'].'
		FROM `'._DB_PREFIX_.'spmegamenu_shop`
		WHERE `id_shop` = '.(int)$params['old_id_shop']);
	}
	
    public function hookHeader()
    {
		$this->context->controller->addCss( __PS_BASE_URI__.'modules/spmegamenu/css/spmegamenu.css' ); 
    }
	

	public function hookdisplayMenu($params)
	{
		if (!$this->_prepareHook('displayMenu'))
			return false;

		return $this->display(__FILE__, 'spmegamenu.tpl');
	}
	
	public function hookdisplayMenu2($params)
	{
		if (!$this->_prepareHook('displayMenu2'))
			return false;

		return $this->display(__FILE__, 'spmegamenu.tpl');
	}

	
	
	public function clearCache()
	{
		$this->_clearCache('spmegamenu.tpl');
	}
	
	private function getIdGroupByHook($hook){
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
				SELECT mg.`id_spmegamenu_group`
				FROM `'._DB_PREFIX_.'spmegamenu_group` mg
				WHERE `hook` = \''.pSQL($hook).'\' AND `status`=1');
		return $result;
	}	

	public function headerHTML()
	{
		if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name)
			return;
		$action = AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules');
		$html = '<script type="text/javascript">var action="'.$action.'";</script>';
		return $html;
	}
	
	public function SortGroupHTML()
	{
		if (Tools::getValue ('controller') != 'AdminModules' && Tools::getValue ('configure') != $this->name)
			return;
		$this->context->controller->addJqueryUI ('ui.sortable');
		$html = '<script type="text/javascript">
			$(function() {
				var $gird_items = $("#gird_items");
				$gird_items.sortable({
					opacity: 0.6,
					cursor: "move",
					handle: ".dragGroup",
					update: function() {
						var order = $(this).sortable("serialize") + "&action=updateGroupPosition";
							$.ajax({
								type: "POST",
								dataType: "json",
								data:order,
								url:"'._PS_BASE_URL_.__PS_BASE_URI__.'modules/'.$this->name.'/ajax_spsortgroup.php?secure_key='.$this->secure_key.'",
								success: function (msg){
									if (msg.error)
									{
										showErrorMessage(msg.error);
										return;
									}
									$(".positions", $gird_items).each(function(i){
										$(this).text(i);
									});
									showSuccessMessage(msg.success);
								}
							});
						
						}
					});
					$(".dragGroup",$gird_items).hover(function() {
						$(this).css("cursor","move");
					},
					function() {
						$(this).css("cursor","auto");
				    });
			});
		</script>
		';
		$html .= '<style type="text/css">#gird_items .ui-sortable-helper{display:table!important;}</style>';
		return $html;
	}	

	public function getMenus($active = null)
	{
		$this->context = Context::getContext();
		$id_shop = $this->context->shop->id;
		$id_lang = $this->context->language->id;

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hs.`id_spmegamenu` as id_spmegamenu, hs.`position`, hs.`active`,hs.`type`, hssl.`title`
			FROM '._DB_PREFIX_.'spmegamenu hs
			LEFT JOIN '._DB_PREFIX_.'spmegamenu_shop hss ON (hs.id_spmegamenu = hss.id_spmegamenu)
			LEFT JOIN '._DB_PREFIX_.'spmegamenu_lang hssl ON (hss.id_spmegamenu = hssl.id_spmegamenu)
			WHERE id_shop = '.(int)$id_shop.'
			AND hssl.id_lang = '.(int)$id_lang.
			($active ? ' AND hs.`active` = 1' : ' ').'
			ORDER BY hs.position'
		);
	}


	public function menuExists($id_spmegamenu)
	{
		$req = 'SELECT hs.`id_spmegamenu` as id_spmegamenu
				FROM `'._DB_PREFIX_.'spmegamenu` hs
				WHERE hs.`id_spmegamenu` = '.(int)$id_spmegamenu;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}
	
	public function initForm()
	{
		$default_lang = (int)Configuration::get ('PS_LANG_DEFAULT');
		$hooks = $this->getHookList ();
		$this->fields_form[0]['form'] = array(
			'tinymce' => true,
			'legend'  => array(
				'title' => $this->l('General Options'),
				'icon'  => 'icon-cogs'
			),
			'input'   => array(
				array(
					'type'     => 'text',
					'label'    => $this->l('Title'),
					'lang'     => true,
					'name'     => 'title',
					'required'	=> true,
					'class'    => 'fixed-width-xl',
					'hint'     => $this->l('Title Of Module')
				),
				array(
					'type'  => 'text',
					'label' => $this->l('Module Class Suffix'),
					'name'  => 'moduleclass_sfx',
					'hint'  => $this->l('A suffix to be applied to the CSS class of the module.
					This allows for individual module styling.'),
					'class' => 'fixed-width-xl'
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display Title'),
					'name'   => 'display_title_module',
					'hint'   => $this->l('Display Title Of Module'),
					'values' => array(
						array(
							'id'    => 'active_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'active_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Status'),
					'name'   => 'status',
					'hint'   => $this->l('Status Of Module'),
					'values' => array(
						array(
							'id'    => 'active_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'active_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'    => 'select',
					'label'   => $this->l('Hook into'),
					'name'    => 'hook',
					'hint'    => $this->l('Select Hook for Module'),
					'options' => array(
						'query' => $hooks,
						'id'    => 'key',
						'name'  => 'name'
					)
				)
			),
			'submit'  => array(
				'title' => $this->l('Save')
			),
			'buttons' => array(
				array(
					'title' => $this->l('Save and stay'),
					'name'  => 'saveAndStayGroup',
					'type'  => 'submit',
					'class' => 'btn btn-default pull-right',
					'icon'  => 'process-icon-save'
				)
			)
		);
		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = 'spmegamenu_group';
		$helper->identifier = $this->identifier;
		$helper->token = Tools::getAdminTokenLite ('AdminModules');
		$helper->show_cancel_button = true;
		$helper->back_url = AdminController::$currentIndex.'&configure='.$this->name.'&token='
			.Tools::getAdminTokenLite ('AdminModules');
		foreach (Language::getLanguages (false) as $lang)
			$helper->languages[] = array(
				'id_lang'    => $lang['id_lang'],
				'iso_code'   => $lang['iso_code'],
				'name'       => $lang['name'],
				'is_default' => ( $default_lang == $lang['id_lang']?1:0 )
			);
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;
		$helper->toolbar_scroll = true;
		$helper->title = $this->displayName;
		$helper->submit_action = 'saveGroupMenu';
		$helper->toolbar_btn = array(
			'save' => array(
				'desc' => $this->l('Save'),
				'href' => AdminController::$currentIndex.'&configure='.$this->name
					.'&save'.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules')
			),
			'back' => array(
				'href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules'),
				'desc' => $this->l('Back to list') )
		);
		$id_spmegamenu_group = (int)Tools::getValue ('id_spmegamenu_group');

		if (Tools::isSubmit ('id_spmegamenu_group') && $id_spmegamenu_group)
		{
			$spmenugroup = new MegamenuGroup((int)$id_spmegamenu_group);
			$params = unserialize($spmenugroup->params);
			$this->fields_form[0]['form']['input'][] = array(
				'type' => 'hidden',
				'name' => 'id_spmegamenu_group' );
		$helper->fields_value['id_spmegamenu_group'] = Tools::getValue ('id_spmegamenu_group', $spmenugroup->id);
		}
		else
		{
			$spmenugroup = new MegamenuGroup();
			$params = array();
		}
		foreach (Language::getLanguages (false) as $lang)
		{
			$helper->fields_value['title'][(int)$lang['id_lang']] = Tools::getValue ('title_'
				.(int)$lang['id_lang'],
				$spmenugroup->title[(int)$lang['id_lang']]);
		}
		$helper->fields_value['hook'] = Tools::getValue ('hook', $spmenugroup->hook);
		$helper->fields_value['status'] = (int)Tools::getValue('status', $spmenugroup->status);
		$display_title_module = isset( $params['display_title_module'] ) ? $params['display_title_module'] : 1;
		$helper->fields_value['display_title_module'] = Tools::getValue ('display_title_module', $display_title_module);
		$helper->fields_value['moduleclass_sfx'] = Tools::getValue ('moduleclass_sfx',
			isset($params['moduleclass_sfx']) ? $params['moduleclass_sfx'] : '' );
		$this->_html .= $helper->generateForm ($this->fields_form);
	}	
	
	private function displayForm()
	{
		$currentIndex = AdminController::$currentIndex;
		$modules = array();
		$this->_html .= $this->headerHTML ();
		$this->_html .= $this->SortGroupHTML();
		if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL)
			$this->_html .= $this->getWarningMultishopHtml();
		else if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL)
		{
			$modules = $this->getGridItems ();
			if (!empty($modules))
			{
				foreach ($modules as $key => $mod)
				{
					$associated_shop_ids = MegamenuGroup::getAssociatedIdsShop((int)$mod['id_spmegamenu_group']);
					if ($associated_shop_ids && count($associated_shop_ids) > 1)
						$modules[$key]['is_shared'] = true;
					else
						$modules[$key]['is_shared'] = false;
				}
			}
		}
		$this->_html .= '
	 	<div class="panel">
			<div class="panel-heading">
			'.$this->l('Module Manager').'
			<span class="panel-heading-action">
					<a class="list-toolbar-btn" href="'.$currentIndex.'&configure='.$this->name
			.'&token='.Tools::getAdminTokenLite ('AdminModules').'&addMenuGroup">
			<span data-toggle="tooltip" class="label-tooltip" data-original-title="'
			.$this->l('Add new module').'" data-html="true"><i class="process-icon-new "></i></span></a>
			</span>
			</div>
			<table width="100%" class="table" cellspacing="0" cellpadding="0">
			<thead>
			<tr class="nodrag nodrop">
				<th>'.$this->l('ID').'</th>
				<th>'.$this->l('Ordering').'</th>
				<th class=" left">'.$this->l('Title').'</th>
				<th class=" left">'.$this->l('Hook into').'</th>
				<th class=" left">'.$this->l('Status').'</th>
				<th class=" right"><span class="title_box text-right">'.$this->l('Actions').'</span></th>
			</tr>
			</thead>
			<tbody id="gird_items">';
		if (!empty($modules))
		{
			static $irow;
			foreach ($modules as $spmenugroup)
			{
				$this->_html .= '
				<tr id="item_'.$spmenugroup['id_spmegamenu_group'].'" class=" '.( $irow ++ % 2?' ':'' ).'">
					<td class=" 	" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&editMenugroup&id_spmegamenu_group='
					.$spmenugroup['id_spmegamenu_group'].'\'">'
					.$spmenugroup['id_spmegamenu_group'].'</td>
					<td class=" dragHandle"><div class="dragGroup"><div class="positions">'.$spmenugroup['position']
					.'</div></div></td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&editMenugroup&id_spmegamenu_group='.$spmenugroup['id_spmegamenu_group'].'\'">'.$spmenugroup['title']
					.' '.($spmenugroup['is_shared'] ? '<span class="label color_field"
		style="background-color:#108510;color:white;margin-top:5px;">'.$this->l('Shared').'</span>' : '').'</td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name
					.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editMenugroup&id_spmegamenu_group='
					.$spmenugroup['id_spmegamenu_group'].'\'">'
					.$spmenugroup['hook'].'</td>
					<td class="  "> <a href="'.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&changeStatusMenuGroup&id_spmegamenu_group='.$spmenugroup['id_spmegamenu_group'].'&status='
					.$spmenugroup['status'].'&hook='.$spmenugroup['hook'].'">'.( ($spmenugroup['status'] && $spmenugroup['status'] == 1)?'
					<i class="icon-check"></i>':'<i class="icon-remove"></i>' ).'</a> </td>
					<td class="text-right">
						<div class="btn-group-action">
							<div class="btn-group pull-right">
								<a class="btn btn-default" href="'.$currentIndex.'&configure='.$this->name.'&token='
		.Tools::getAdminTokenLite ('AdminModules').'&editMenugroup&id_spmegamenu_group='.$spmenugroup['id_spmegamenu_group'].'">
									<i class="icon-pencil"></i> Edit
								</a> 
								<button data-toggle="dropdown" class="btn btn-default dropdown-toggle">
									<span class="caret"></span>&nbsp;
								</button>
								<ul class="dropdown-menu">
									<li>
							<a onclick="return confirm(\''
					.$this->l('Are you sure want duplicate this item?')
					.'\');"  title="'.$this->l('Duplicate').'" href="'.$currentIndex.'&configure='
					.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&duplicateMenuGroup&id_spmegamenu_group='
					.$spmenugroup['id_spmegamenu_group'].'">
											<i class="icon-copy"></i> '.$this->l('Duplicate').'
										</a>								
									</li>
									<li class="divider"></li>
									<li>
										<a title ="'.$this->l('Delete').'" onclick="return confirm(\''
					.$this->l('Are you sure?').'\');" href="'.$currentIndex
					.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&deleteMenuGroup&id_spmegamenu_group='
					.$spmenugroup['id_spmegamenu_group'].'">
											<i class="icon-trash"></i> '.$this->l('Delete').'
										</a>
									</li>
								</ul>
							</div>
						</div>
					</td>
				</tr>';
			}
		}
		else
		{
			$this->_html .= '<td colspan="5" class="list-empty">
								<div class="list-empty-msg">
									<i class="icon-warning-sign list-empty-icon"></i>
									'.$this->l('No records found').'
								</div>
							</td>';
		}
		$this->_html .= '
			</tbody>
			</table>
		</div>';
	}	
	
	public function renderList()
	{
		$this->context->controller->addJS( __PS_BASE_URI__.'modules/spmegamenu/js/jquery.nestable.js' ); 
		$this->context->controller->addCss( __PS_BASE_URI__.'modules/spmegamenu/css/form.css' ); 
		$object   		= new Megamenu();
		$output = '
			<div class="clearfix">
			<div class="col-md-12 col-lg-12 form_content">
				<h3>
					<i class="icon-list-ul"></i>
						menus list
					<span class="form-heading-action">
					   <menu id="spmegamenu-menu">
							<button type="button" class="btn btn-info" data-action="expand-all">Expand All</button>
							<button type="button" class="btn btn-info" data-action="collapse-all">Collapse All</button>
						</menu>
						<p><input type="button" value="'.$this->l('Update Position').'" id="savePosition" data-loading-text="'.$this->l('Processing ...').'" class="btn btn-info" name="savePosition"></p>
						<a id="desc-product-new" class="list-toolbar-btn" href="'.Context::getContext()->link->getAdminLink('AdminModules').'&configure=spmegamenu&addMenu=1&editMenugroup&id_spmegamenu_group='.(int)Tools::getValue('id_spmegamenu_group').'">
							<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new" data-html="true">
								<i class="process-icon-new "></i>
							</span>
						</a>
					</span>
				</h3>';
		$output .= $object->getTree(1,1);
		$output .= '</div>';
		$output .= '</div>';
		return $output;
	}
	
	public function renderForm()
	{
		$style = array(
            array(
                'value' => 'css',
                'label' => $this->l('Css Menu')
            ),
            array(
                'value' => 'mega',
                'label' => $this->l('Mega Menu')
            )
        );
		
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'select',
						'label' => $this->l('Style'),
						'name' => 'spmegamenu_style',
						'options' => array(  'query' => $style,
						'id' => 'value',
						'name' => 'label' ),
						'default' => 'mega',
					),				
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();

		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitConfigMenu';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

		return $helper->generateForm(array($fields_form));
	}	

	public function renderAddForm()
	{
		$this->context->controller->addJS( __PS_BASE_URI__.'modules/spmegamenu/js/form.js' ); 
		$id_lang    	= $this->context->language->id;
		$id_shop    	= $this->context->shop->id;
		$id_spmegamenu 	= Tools::getValue('id_spmegamenu') ? (int)Tools::getValue('id_spmegamenu') : 0;
		$object   		= new Megamenu($id_spmegamenu);
		$selected_categories = array();
		if($object->value){
			$object->value = unserialize($object->value);
			if($object->cat_subcategories && $object->type == 'subcategories')
				$selected_categories[0] = $object->cat_subcategories;			
		}	
		$categories 	= Category::getCategories( $id_lang, true, false  ) ;
        $manufacturers 	= Manufacturer::getManufacturers(false, $id_lang, true);
        $suppliers     	= Supplier::getSuppliers(false, $id_lang, true);
        $cms          	= CMS::listCms($this->context->language->id, false, true);
		$menu         	= $object->getChildren(null, $id_lang,$id_shop);
		$check = 0;
		
		foreach($menu  as $m){
			if($m['id_spmegamenu'] == 1)
				$check = 1;
		}
		
		if($check == 0){
			$root['id_spmegamenu'] = 1;
			$root['title']  = $this->l('Root');
			array_push($menu, $root);
		}
		$active = array(
            array(
                'id' => 'active_on',
                'value' => 1,
                'label' => $this->l('Enabled')
            ),
            array(
                'id' => 'active_off',
                'value' => 0,
                'label' => $this->l('Disabled')
            )
        );
		
		$sub_menu = array(
            array(
                'value' => 'yes',
                'label' => $this->l('Yes')
            ),
            array(
                'value' => 'no',
                'label' => $this->l('No')
            )
        );
		
		$list_product = array(
			array(
				'id' => 'new',
				'label' => $this->l('New')
			),
			array(
				'id' => 'bestseller',
				'label' => $this->l('Bestseller')
			),
			array(
				'id' => 'special',
				'label' => $this->l('Special')
			),
			array(
				'id' => 'featured',
				'label' => $this->l('Featured')
			)
		);	
		
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Menu information'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
                array(
                    'type'  => 'text',
                    'label' => $this->l('Title:'),
                    'name'  => 'title',
                    'value' => true,
                    'lang'  => true,
					'required'=> true,
                    'default'=> '',
					'col' => '6',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Title'),
                    'name' => 'show_title',
                    'values' => $active,
                    'default' => 1,
    
                 ),		
				array(
                    'type' => 'textarea',
                    'label' => $this->l('Label:'),
                    'name'  => 'label',
                    'value' => true,
                    'lang'  => true,
                    'default'=> '',
					'autoload_rte' => true,
					'col' => '6',
                ), 
				array(
                    'type' => 'textarea',
                    'label' => $this->l('Short Description:'),
                    'name'  => 'short_description',
                    'value' => true,
                    'lang'  => true,
                    'default'=> '',
					'autoload_rte' => true,
					'col' => '6',
                ), 				
                array(
                    'type' => 'select',
                    'label' => $this->l('Parent ID'),
                    'name' => 'id_parent',
                    'options' => array(  'query' =>   $menu,
                    'id' => 'id_spmegamenu',
                    'name' => 'title' ),
                    'default' => 1,
         
                 ), 
				array(
                    'type'  => 'text',
                    'label' => $this->l('Submenu Title:'),
                    'name'  => 'sub_title',
                    'value' => true,
                    'lang'  => true,
                    'default'=> '',
					'col' => '6',
                ),				 
				array(
                    'type' => 'switch',
                    'label' => $this->l('Show Sub Title'),
                    'name' => 'show_sub_title',
                    'values' => $active,
                    'default' => 1,
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Menu Type'),
                    'name' => 'type',
                    'id'    => 'select_menu',
                    'options' => array(  'query' => array(
                        array('id' => 'url', 'name' => $this->l('Url')),
						array('id' => 'product', 'name' => $this->l('Product')),
						array('id' => 'productlist', 'name' => $this->l('Product List')),
                        array('id' => 'manufacture', 'name' => $this->l('Manufacture')),
						array('id' => 'all_manufacture', 'name' => $this->l('All Manufacture')),
                        array('id' => 'supplier', 'name' => $this->l('Supplier')),
						array('id' => 'all_supplier', 'name' => $this->l('All Supplier')),
                        array('id' => 'cms', 'name' => $this->l('Cms')),
                        array('id' => 'html', 'name' => $this->l('Html')),
                        array('id' => 'category', 'name' => $this->l('Category')),
						array('id' => 'subcategories', 'name' => $this->l('Sub Categories'))
                    ),
                     'id' => 'id',
                    'name' => 'name' ),
                    'default' => "url",
         
                 ),
            
                array(
                    'type' => 'text',
                    'label' => $this->l('Product ID'),
                    'name' => 'type_product[product]',
                    'id' => 'type_product',
                    'class'=> 'type_group',
                    'default' => "",
					'desc'    => $this->l('Ex: 3')
                ),

				array(
					'type' 	  => 'select',
					'label'   => $this->l('Products List'),
					'name' 	  => 'type_productlist[type]',
					'options' => array(  'query' => $list_product ,
					'id' 	  => 'id',
					'name' 	  => 'label' ),
					'default' => "new",
					'class'=> 'type_group type_product_type',
					'desc'    => $this->l('Select Product Type')
	            ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Limit Product'),
                    'name' => 'type_productlist[limit]',
                    'id' => 'type_limit_product',
                    'class'=> 'type_group',
                    'default' => 4,
                ),				
                array(
                    'type' => 'select',
                    'label' => $this->l('CMS Type'),
                    'name' => 'type_cms[cms]',
                    'id'   => 'type_cms',
                    'options' => array(  'query' => $cms,
                    'id' => 'id_cms',
                    'name' => 'meta_title' ),
                    'default' => "",
                    'class'=> 'type_group', 
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('URL'),
                    'name' => 'url',
                    'id' => 'type_url',
					'required'=> true,
					'lang'  => true,
                    'class'=> 'type_group_lang',
                    'default' => "#",
					'col' => '6',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Category'),
                    'name' => 'type_category[category]',
                    'id'   => 'type_category',
                    'options' => array(  'query' => $categories,
                    'id' => 'id_category',
                    'name' => 'name' ),
                    'default' => "",
                    'class'=> 'type_group', 
                ),
				array(
					'type'  => 'categories',
					'label' => $this->l('Sub categories'),
					'name'  => "cat_subcategories",
					'tree'  => array(
						'id'                  => 'type_subcategories',
						'selected_categories' => $selected_categories,
                        'root_category'       => $this->context->shop->getCategory()
					)
				),
				array(
                    'type' => 'text',
                    'label' => $this->l('Limit Subcategories Lever 2'),
                    'name' => "type_subcategories[limit1]",
                    'class'=> 'type_group type_limit_subcategories',
                    'default' => 4,
                ),	
				array(
                    'type' => 'text',
                    'label' => $this->l('Limit Subcategories Lever 3'),
                    'name' => "type_subcategories[limit2]",
                    'class'=> 'type_group type_limit_subcategories',
                    'default' => 4,
                ),									
				array(
                    'type' => 'select',
                    'label' => $this->l('Show Image Sub Categories'),
                    'name' => "type_subcategories[showimg]",
					'class'	=> 'showimg_subcategories',
					'options' => array(  'query' => $sub_menu,
                    'id' => 'value',
                    'name' => 'label' ),
                    'default' => 'no',
                 ),	
				array(
                    'type' => 'select',
                    'label' => $this->l('Show Image Children Categories'),
                    'name' => "type_subcategories[showimgchild]",
					'class'	=> 'showimgchild_subcategories',
					'options' => array(  'query' => $sub_menu,
                    'id' => 'value',
                    'name' => 'label' ),
                    'default' => 'no',
                 ),					 
                array(
                    'type' => 'select',
                    'label' => $this->l('Manufacture Type'),
                    'name' => 'type_manufacture[manufacture]',
                    'id' => 'type_manufacture',
                    'options' => array(  'query' => $manufacturers,
                     'id' => 'id_manufacturer',
                    'name' => 'name' ),
                    'default' => "",
                    'class'=> 'type_group', 
                ),
                 array(
                    'type' => 'select',
                    'label' => $this->l('Supplier Type'),
                    'name' => 'type_supplier[supplier]',
                    'id' => 'type_supplier',
                    'options' => array(  'query' => $suppliers,
                    'id' => 'id_supplier',
                    'name' => 'name' ),
                    'default' => "",
                    'class'=> 'type_group', 
                ),

                array(
                    'type' => 'textarea',
                    'label' => $this->l('Html'),
                    'name' => 'html',
                    'lang' => true,
                    'default' => '',
                    'autoload_rte' => true,
                    'class'=> 'html_lang', 
					'col' => '6',
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Class'),
                    'name' => 'menu_class',
                    'display_image' => true,
                    'default' => '',
					'col' => '6',
                ),
				array(
                    'type' => 'text',
                    'label' => $this->l('Width'),
                    'name' => 'width',
                    'id' => 'width',
                    'class'=> 'width',
                    'default' => "",
					'desc' => "Ex : 960px , 100%",
					'col' => '6',
                ),
				array(
                    'type' => 'select',
                    'label' => $this->l('Have Sub Menu'),
                    'name' => 'sub_menu',
					'options' => array(  'query' => $sub_menu,
                    'id' => 'value',
                    'name' => 'label' ),
                    'default' => 'no',
                 ),
				array(
                    'type' => 'text',
                    'label' => $this->l('Submenu Width'),
                    'name' => 'sub_width',
                    'id' => 'sub_width',
                    'class'=> 'sub_width',
                    'default' => "",
					'desc' => "Ex : 960px , 100%",
					'col' => '6',
                ),
				array(
                    'type' => 'switch',
                    'label' => $this->l('Group'),
                    'name' => 'group',
                    'values' => $active,
                    'default' => 0,
                 ),
				array(
                    'type' => 'switch',
                    'label' => $this->l('Active'),
                    'name' => 'active',
                    'values' => $active,
                    'default' => 1,
                 ),
				
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		if (Tools::isSubmit('id_spmegamenu') && $this->menuExists((int)Tools::getValue('id_spmegamenu')))
		{
			$menu = new Megamenu((int)Tools::getValue('id_spmegamenu'));
			$fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_spmegamenu');
		}

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $this;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitMenu';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_spmegamenu_group='.Tools::getValue('id_spmegamenu_group');
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $this->getAddFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
			'image_baseurl' => $this->_path.'images/'
		);

		$helper->override_folder = '/';

		$languages = Language::getLanguages(false);

		if (count($languages) > 1)
			return $this->getMultiLanguageInfoMsg().$helper->generateForm(array($fields_form));
		else
			return $helper->generateForm(array($fields_form));
	}

	public function getAddFieldsValues()
	{
		$fields = array();

		if (Tools::isSubmit('id_spmegamenu') && $this->menuExists((int)Tools::getValue('id_spmegamenu')))
		{
			$mgmenu = new Megamenu((int)Tools::getValue('id_spmegamenu'));
			$fields['id_spmegamenu'] = (int)Tools::getValue('id_spmegamenu', $mgmenu->id);
		}
		else
			$mgmenu = new Megamenu();

		$fields['active'] = Tools::getValue('active', $mgmenu->active);
		$fields['id_parent'] = Tools::getValue('id_parent', $mgmenu->id_parent);
		$fields['type'] = Tools::getValue('type', $mgmenu->type);
		$fields['position'] = Tools::getValue('position', $mgmenu->position);
		$fields['show_title'] = Tools::getValue('show_title', $mgmenu->show_title);
		$fields['show_sub_title'] = Tools::getValue('show_sub_title', $mgmenu->show_sub_title);
		$fields['menu_class'] = Tools::getValue('menu_class', $mgmenu->menu_class);
		$fields['width'] = Tools::getValue('width', $mgmenu->width);
		$fields['sub_menu'] = Tools::getValue('sub_menu', $mgmenu->sub_menu);
		$fields['sub_width'] = Tools::getValue('sub_width', $mgmenu->sub_width);
		$fields['group'] = Tools::getValue('group', $mgmenu->group);
		$fields['sub_width'] = Tools::getValue('sub_width', $mgmenu->sub_width);
		$fields['cat_subcategories'] = Tools::getValue('cat_subcategories', $mgmenu->cat_subcategories);
		
		$array_type = array('product' =>array('product'),
							'productlist' =>array('type','limit'),
							'cms' =>array('cms'),
							'category' =>array('category'),
							'manufacture' =>array('manufacture'),
							'supplier' =>array('supplier'),
							'subcategories' => array('limit1','limit2','limit3','showimg','showimgchild'),
							);
		
		foreach($array_type as $type=>$configs){
			if(isset($mgmenu->type) && $mgmenu->type && $mgmenu->type == $type){
				$values	= unserialize(Tools::getValue('value',$mgmenu->value));
				if($values){
					foreach($values as $key=>$value)
						$fields['type_'.$mgmenu->type.'['.$key.']'] = $value;
				}
			}	
			else{
				$fields["type_".$type] = '';
				if($configs){
					foreach($configs as $config)
						$fields['type_'.$type.'['.$config.']'] = '';
				}
			}	
		}
		$languages = Language::getLanguages(false);

		foreach ($languages as $lang)
		{
			$fields['title'][$lang['id_lang']] = Tools::getValue('title_'.(int)$lang['id_lang'], $mgmenu->title[$lang['id_lang']]);
			$fields['label'][$lang['id_lang']] = Tools::getValue('label_'.(int)$lang['id_lang'], $mgmenu->label[$lang['id_lang']]);
			$fields['short_description'][$lang['id_lang']] = Tools::getValue('short_description_'.(int)$lang['id_lang'], $mgmenu->short_description[$lang['id_lang']]);
			$fields['url'][$lang['id_lang']] = Tools::getValue('url_'.(int)$lang['id_lang'], $mgmenu->url[$lang['id_lang']]);
			$fields['sub_title'][$lang['id_lang']] = Tools::getValue('sub_title_'.(int)$lang['id_lang'], $mgmenu->sub_title[$lang['id_lang']]);
			$fields['html'][$lang['id_lang']] = Tools::getValue('html_'.(int)$lang['id_lang'], $mgmenu->html[$lang['id_lang']]);
		}
		return $fields;
	}
	
	private function getGridItems()
	{
		$this->context = Context::getContext ();
		$id_lang = $this->context->language->id;
		$id_shop = $this->context->shop->id;
		$sql = 'SELECT b.`id_spmegamenu_group`,  b.`hook`, b.`position`, b.`status`, bl.`title`, bl.`content`
			FROM `'._DB_PREFIX_.'spmegamenu_group` b
			LEFT JOIN `'._DB_PREFIX_.'spmegamenu_group_shop` bs ON (b.`id_spmegamenu_group` = bs.`id_spmegamenu_group` )
			LEFT JOIN `'._DB_PREFIX_.'spmegamenu_group_lang` bl ON (b.`id_spmegamenu_group` = bl.`id_spmegamenu_group`)
			WHERE bs.`id_shop` = '.(int)$id_shop.' 
			AND bl.`id_lang` = '.(int)$id_lang.'
			ORDER BY b.`position`';
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
	}
	

	protected function getMultiLanguageInfoMsg()
	{
		return '<p class="alert alert-warning">'.
					$this->l('Since multiple languages are activated on your shop, please mind to upload your image for each one of them').
				'</p>';
	}
	
	public function getConfigFieldsValues()
	{
		$id_shop_group = Shop::getContextShopGroupID();
		$id_shop = Shop::getContextShopID();

		return array(
			'spmegamenu_style' => Tools::getValue('spmegamenu_style', Configuration::get('spmegamenu_style', null, $id_shop_group, $id_shop)),
		);
	}
	
	public function renderProductList($products){
		$tpl = 'views/templates/hook/product.tpl';
		$this->smarty->assign( 'products', $products);
		return $this->display(__FILE__, $tpl);
	}
	
	public function getHookList()
	{
		$hooks = array();
		foreach ($this->default_hook as $key=>$hook)
		{
			$hooks[$key]['key'] = $hook;
			$hooks[$key]['name'] = $hook;
		}
		return $hooks;
	}	
	
	private function getHookTitle($id_hook, $name = false)
	{
		if (!$result = Db::getInstance ()->getRow ('
			SELECT `name`,`title`
			FROM `'._DB_PREFIX_.'hook`
			WHERE `id_hook` = '.( $id_hook )))
			return false;
		return ( ( $result['title'] != '' && $name )?$result['title']:$result['name'] );
	}
		
	public function getNextPosition()
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT MAX(cs.`position`) AS `next_position`
			FROM `'._DB_PREFIX_.'spmegamenu_group` cs, `'._DB_PREFIX_.'spmegamenu_group_shop` css
			WHERE css.`id_spmegamenu_group` = cs.`id_spmegamenu_group` AND css.`id_shop` = '.(int)$this->context->shop->id
		);

		return (++$row['next_position']);
	}	
	
	public function moduleExists($id_spmegamenu_group)
	{
		$req = 'SELECT cs.`id_spmegamenu_group` 
				FROM `'._DB_PREFIX_.'spmegamenu_group` cs
				WHERE cs.`id_spmegamenu_group` = '.(int)$id_spmegamenu_group;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}
	
	private function getIdMenuByGroup($id_spmegamenu_group,$id_parent=false){
		$sql = '	SELECT ss.`id_spmegamenu`
					FROM `'._DB_PREFIX_.'spmegamenu` ss
					WHERE ss.`id_spmegamenu_group` = '.(int)$id_spmegamenu_group ;
		if($id_parent)	
		$sql .= ' AND id_parent = 1';
				
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		return $result;
	}
	
	public function duplicateParentMenu($id_parent,$id_spmegamenu,$id_spmegamenu_group){
		$id_lang       = Context::getContext()->language->id;
		$id_shop       = Context::getContext()->shop->id;
		$spmegamenu = new Megamenu();
		$menus         	= $spmegamenu->getChildren($id_parent, $id_lang,$id_shop);
		if($menus){
			foreach($menus as $menu){
				$id_children  = $menu['id_spmegamenu'];
				$parent_menu = new Megamenu((int)$id_children);
				$parent_menu->id = null;
				$parent_menu->id_spmegamenu = null;
				$parent_menu->id_spmegamenu_group = $id_spmegamenu_group;
				$parent_menu->active = 1;
				$parent_menu->id_parent = $id_spmegamenu;
				$parent_menu->position = $parent_menu->getmaxPositonMenu();
				$parent_menu->add();
					$this->duplicateParentMenu($id_children,$parent_menu->id,$id_spmegamenu_group);
			}
		}
	}
}
