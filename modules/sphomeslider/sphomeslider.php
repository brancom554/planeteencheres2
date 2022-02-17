<?php
/*
* 2007-2015 PrestaShop
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
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @since   1.5.0
 */

if (!defined('_PS_VERSION_'))
	exit;

include_once(_PS_MODULE_DIR_.'sphomeslider/SpSlide.php');
include_once(_PS_MODULE_DIR_.'sphomeslider/SpSlideGroup.php');

class sphomeslider extends Module
{
	protected $_html = '';
	private $default_hook = array( 'displayHomeSlider', 'displayHomeSlider2', 'displayHomeSlider3', 'displayHomeSlider4', 'displayHomeSlider5');

	public function __construct()
	{
		$this->name = 'sphomeslider';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'MagenTech';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Sp slider for your homepage');
		$this->description = $this->l('Adds an image slider to your homepage.');
		$this->ps_versions_compliancy = array('min' => '1.6.0.4', 'max' => _PS_VERSION_);
	}

	/**
	 * @see Module::install()
	 */
	public function install()
	{
		/* Adds Module */
		if (parent::install() &&
			$this->registerHook('displayHeader') &&
			$this->registerHook('actionShopDataDuplication')
		)
		{
			foreach ($this->default_hook as $hook)
			{
				if (!$this->registerHook ($hook))
					return false;
			}
			/* Creates tables */
			$res = $this->createTables();

			/* Adds samples */
			if ($res)
				$this->installSamples();

			// Disable on mobiles and tablets
			$this->disableDevice(Context::DEVICE_MOBILE);

			return (bool)$res;
		}

		return false;
	}

	/**
	 * Adds samples
	 */
	protected function installSamples()
	{
		$datas = array(
			array(
				'title_module' 		=> 'HomeSlider 1',
				'position' 			=> 1,
				'active' 			=> 1,
				'display_title_module' 		=> 0,
				'id_sphomeslider_groups' 	=> 1,
				'hook'				=> 'displayHomeSlider',
				'moduleclass_sfx' 	=> '',
				'autoplay'			=> 1,
				'autoplay_timeout'	=> 2000,
				'autoplaySpeed'		=> 2000,
				'animateOut'		=> 'fadeOut',
				'animateIn'			=> 'fadeIn',
				'startPosition'		=> 0,
				'mouseDrag'			=> 1,
				'autoplayHoverPause'			=> 1,
				'touchDrag'			=> 1,
				'pullDrag'			=> 1,
				'dots'			=> 1,
				'nav'			=> 1,
				'loop'			=> 1,
				'none'			=> 'none',
				'slider'		=> array(
					array('title' 		=> '#',
						'description'	=> '',
						'legend'		=> '#',
						'url'			=> '#',
						'image'			=> 	'sample-1.jpg',
						'active'		=>  1,
						'id_sphomeslider_groups'	=> 1
					),
					array('title' 		=> '#',
						'description'	=> '',
						'legend'		=> '#',
						'url'			=> '#',
						'image'			=> 	'sample-2.jpg',
						'active'		=>  1,
						'id_sphomeslider_groups'	=> 1
					),
					array('title' 		=> '#',
						'description'	=> '',
						'legend'		=> '#',
						'url'			=> '#',
						'image'			=> 	'sample-3.jpg',
						'active'		=>  1,
						'id_sphomeslider_groups'	=> 1
					),						
				)
			),
			array(
				'title_module' 		=> 'HomeSlider 2',
				'position' 			=> 1,
				'active' 			=> 1,
				'display_title_module' 		=> 0,
				'id_sphomeslider_groups' 	=> 2,
				'hook'				=> 'displayHomeSlider2',
				'moduleclass_sfx' 	=> '',
				'autoplay'			=> 1,
				'autoplay_timeout'	=> 2000,
				'autoplaySpeed'		=> 2000,
				'animateOut'		=> 'fadeOut',
				'animateIn'			=> 'fadeIn',
				'startPosition'		=> 0,
				'mouseDrag'			=> 1,
				'autoplayHoverPause'			=> 1,
				'touchDrag'			=> 1,
				'pullDrag'			=> 1,
				'dots'			=> 1,
				'nav'			=> 1,
				'loop'			=> 1,
				'none'			=> 'none',
				'slider'		=> array(
					array('title' 		=> '#',
						'description'	=> '',
						'legend'		=> '#',
						'url'			=> '#',
						'image'			=> 	'sample-4.jpg',
						'active'		=>  1,
						'id_sphomeslider_groups'	=> 2
					),
					array('title' 		=> '#',
						'description'	=> '',
						'legend'		=> '#',
						'url'			=> '#',
						'image'			=> 	'sample-5.jpg',
						'active'		=>  1,
						'id_sphomeslider_groups'	=> 2
					),
					array('title' 		=> '#',
						'description'	=> '',
						'legend'		=> '#',
						'url'			=> '#',
						'image'			=> 	'sample-6.jpg',
						'active'		=>  1,
						'id_sphomeslider_groups'	=> 2
					),						
				)
			),
			array(
				'title_module' 		=> 'HomeSlider 3',
				'position' 			=> 1,
				'active' 			=> 1,
				'display_title_module' 		=> 0,
				'id_sphomeslider_groups' 	=> 3,
				'hook'				=> 'displayHomeSlider3',
				'moduleclass_sfx' 	=> '',
				'autoplay'			=> 1,
				'autoplay_timeout'	=> 2000,
				'autoplaySpeed'		=> 2000,
				'animateOut'		=> 'fadeOut',
				'animateIn'			=> 'fadeIn',
				'startPosition'		=> 0,
				'mouseDrag'			=> 1,
				'autoplayHoverPause'			=> 1,
				'touchDrag'			=> 1,
				'pullDrag'			=> 1,
				'dots'			=> 1,
				'nav'			=> 1,
				'loop'			=> 1,
				'none'			=> 'none',
				'slider'		=> array(
					array('title' 		=> '#',
						'description'	=> '
										',
						'legend'		=> '#',
						'url'			=> '#',
						'image'			=> 	'sample-7.jpg',
						'active'		=>  1,
						'id_sphomeslider_groups'	=> 3
					),
					array('title' 		=> '#',
						'description'	=> '
											',
						'legend'		=> '#',
						'url'			=> '#',
						'image'			=> 	'sample-8.jpg',
						'active'		=>  1,
						'id_sphomeslider_groups'	=> 3
					),
					array('title' 		=> '#',
						'description'	=> '
											',
						'legend'		=> '#',
						'url'			=> '#',
						'image'			=> 	'sample-9.jpg',
						'active'		=>  1,
						'id_sphomeslider_groups'	=> 3
					),						
				)
			)
		);

		foreach ($datas as $i => $data)
		{
			$slidegroup = new SpSlideGroup();
			$slidegroup->hook = Hook::getIdByName($data['hook']);
			$slidegroup->active = $data['active'];
			$slidegroup->position = $i;
			$slidegroup->params = serialize($data);
			foreach (Language::getLanguages(false) as $lang)
				$slidegroup->title[$lang['id_lang']] = $data['title_module'];
				
			if($slidegroup->add()){	
				foreach($data['slider'] as $key=>$slide){
					$slider = new SpSlide();
					$slider->position = $key;
					$slider->active = $slide['active'];
					$slider->id_sphomeslider_groups = $slide['id_sphomeslider_groups'];
					foreach (Language::getLanguages(false) as $language)
					{
						$slider->title[$language['id_lang']] = $slide['title'];
						$slider->description[$language['id_lang']] =  $slide['description'];
						$slider->url[$language['id_lang']] = $slide['url'];
						$slider->legend[$language['id_lang']] =  $slide['legend'];
						$slider->image[$language['id_lang']] = $slide['image'];
					}
					$slider->add();		
				}
			}
		}
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
			return (bool)$res;
		}

		return false;
	}

	/**
	 * Creates tables
	 */
	protected function createTables()
	{
		/* Group */
		$res = Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'sphomeslider_groups` (
				`id_sphomeslider_groups` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`position` int(10) unsigned NOT NULL DEFAULT \'0\',
				`active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
				`hook` int(10) unsigned, 
				`params` text NOT NULL DEFAULT \'\' ,			  
			  PRIMARY KEY (`id_sphomeslider_groups`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');		
		/* Group Shop*/
		$res &= (bool)Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'sphomeslider_groups_shop` (
				`id_sphomeslider_groups` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_shop` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_sphomeslider_groups`, `id_shop`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');			
		/* Groups lang */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'sphomeslider_groups_lang` (
			  `id_sphomeslider_groups` int(10) unsigned NOT NULL,
			  `id_lang` int(10) unsigned NOT NULL,
			  `title` varchar(255) NOT NULL,
			  PRIMARY KEY (`id_sphomeslider_groups`,`id_lang`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');		
		/* Slides */
		$res &= (bool)Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'sphomeslider` (
				`id_sphomeslider_slides` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_shop` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_sphomeslider_slides`, `id_shop`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		/* Slides configuration */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'sphomeslider_slides` (
				`id_sphomeslider_slides` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_sphomeslider_groups` int(10) unsigned NOT NULL,
				`position` int(10) unsigned NOT NULL DEFAULT \'0\',
				`active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',			  
			  PRIMARY KEY (`id_sphomeslider_slides`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		/* Slides lang configuration */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'sphomeslider_slides_lang` (
			  `id_sphomeslider_slides` int(10) unsigned NOT NULL,
			  `id_lang` int(10) unsigned NOT NULL,
			  `title` varchar(255) NOT NULL,
			  `description` text NOT NULL,
			  `legend` varchar(255) NOT NULL,
			  `url` varchar(255) NOT NULL,
			  `image` varchar(255) NOT NULL,
			  PRIMARY KEY (`id_sphomeslider_slides`,`id_lang`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		return $res;
	}

	/**
	 * deletes tables
	 */
	protected function deleteTables()
	{
		$slides = $this->getSlides();
		foreach ($slides as $slide)
		{
			$to_del = new SpSlide($slide['id_slide']);
			$to_del->delete();
		}

		return Db::getInstance()->execute('
			DROP TABLE IF EXISTS `'._DB_PREFIX_.'sphomeslider`, `'._DB_PREFIX_.'sphomeslider_slides`, `'._DB_PREFIX_.'sphomeslider_slides_lang`, `'._DB_PREFIX_.'sphomeslider_groups`, `'._DB_PREFIX_.'sphomeslider_groups_shop`, `'._DB_PREFIX_.'sphomeslider_groups_lang`;
		');
	}

	public function getContent()
	{
		$this->_html .= $this->headerHTML();
		if (Tools::isSubmit('submitBackGroup')){
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		}
		/* Validate & process */
		if (Tools::isSubmit('submitSlide') || Tools::isSubmit('delete_id_slide') ||
			Tools::isSubmit('submitGroups') || Tools::isSubmit('submitSaveAndStayGroup')  || Tools::isSubmit('changeStatus') || Tools::isSubmit('changeStatusGroup') || Tools::isSubmit('duplicateGroup') || Tools::isSubmit('delete_id_group')
		)
		{
			if ($this->_postValidation())
			{
				$this->_postProcess();
				$this->_html .= $this->renderForm();
				if(Tools::getValue('id_sphomeslider_groups'))
					$this->_html .= $this->renderList();
			}
			else{
				if (Tools::isSubmit('submitSlide')){
					$this->_html .= $this->renderAddForm ();
				}		
				else
					$this->_html .= $this->displayForm ();
			}
			$this->clearCache();
		}
		elseif(Tools::isSubmit('addGroup') || Tools::isSubmit('editGroup'))
		{
			$this->_html .= $this->renderForm();
			if(Tools::getValue('id_sphomeslider_groups'))
				$this->_html .= $this->renderList();
		}
		elseif (Tools::isSubmit('addSlide') || (Tools::isSubmit('id_slide') && $this->slideExists((int)Tools::getValue('id_slide'))))
		{
			if (Tools::isSubmit('addSlide'))
				$mode = 'add';
			else
				$mode = 'edit';

			if ($mode == 'add')
			{
				if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL)
					$this->_html .= $this->renderAddForm();
				else
					$this->_html .= $this->getShopContextError(null, $mode);
			}
			else
			{
				$associated_shop_ids = SpSlide::getAssociatedIdsShop((int)Tools::getValue('id_slide'));
				$context_shop_id = (int)Shop::getContextShopID();

				if ($associated_shop_ids === false)
					$this->_html .= $this->getShopAssociationError((int)Tools::getValue('id_slide'));
				else if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL && in_array($context_shop_id, $associated_shop_ids))
				{
					if (count($associated_shop_ids) > 1)
						$this->_html = $this->getSharedSlideWarning();
					$this->_html .= $this->renderAddForm();
				}
				else
				{
					$shops_name_list = array();
					foreach ($associated_shop_ids as $shop_id)
					{
						$associated_shop = new Shop((int)$shop_id);
						$shops_name_list[] = $associated_shop->name;
					}
					$this->_html .= $this->getShopContextError($shops_name_list, $mode);
				}
			}
		}
		else // Default viewport
		{
			//$this->_html .= $this->getWarningMultishopHtml().$this->getCurrentShopInfoMsg().$this->renderForm();

			if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL)
				$this->_html .= $this->displayForm ();
				//$this->_html .= $this->renderList();
		}

		return $this->_html;
	}

	protected function _postValidation()
	{
		$errors = array();

		/* Validation for Slider configuration */
		if (Tools::isSubmit('submitGroups') || Tools::isSubmit('submitSaveAndStayGroup'))
		{
			if (
				!Validate::isInt(Tools::getValue('width')) || !Validate::isInt(Tools::getValue('autoplay_timeout'))
				|| !Validate::isInt(Tools::getValue('autoplaySpeed'))
				|| !Validate::isInt(Tools::getValue('startPosition'))
			)
				$errors[] = $this->l('Invalid values');
				
			$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
			if (Tools::strlen(Tools::getValue('title_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The title is not set.');	
		} /* Validation for status */
		elseif (Tools::isSubmit('changeStatus'))
		{
			if (!Validate::isInt(Tools::getValue('id_slide')))
				$errors[] = $this->l('Invalid slide');
		}
		/* Validation for Slide */
		elseif (Tools::isSubmit('submitSlide'))
		{
			/* Checks state (active) */
			if (!Validate::isInt(Tools::getValue('active_slide')) || (Tools::getValue('active_slide') != 0 && Tools::getValue('active_slide') != 1))
				$errors[] = $this->l('Invalid slide state.');
			/* Checks position */
			if (!Validate::isInt(Tools::getValue('position')) || (Tools::getValue('position') < 0))
				$errors[] = $this->l('Invalid slide position.');
			/* If edit : checks id_slide */
			if (Tools::isSubmit('id_slide'))
			{

				//d(var_dump(Tools::getValue('id_slide')));
				if (!Validate::isInt(Tools::getValue('id_slide')) && !$this->slideExists(Tools::getValue('id_slide')))
					$errors[] = $this->l('Invalid slide ID');
			}
			/* Checks title/url/legend/description/image */
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				if (Tools::strlen(Tools::getValue('title_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The title is too long.');
				if (Tools::strlen(Tools::getValue('legend_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The caption is too long.');
				if (Tools::strlen(Tools::getValue('url_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The URL is too long.');
				if (Tools::strlen(Tools::getValue('description_'.$language['id_lang'])) > 4000)
					$errors[] = $this->l('The description is too long.');
				if (Tools::strlen(Tools::getValue('url_'.$language['id_lang'])) > 0 && !Validate::isUrl(Tools::getValue('url_'.$language['id_lang'])))
					$errors[] = $this->l('The URL format is not correct.');
				if (Tools::getValue('image_'.$language['id_lang']) != null && !Validate::isFileName(Tools::getValue('image_'.$language['id_lang'])))
					$errors[] = $this->l('Invalid filename.');
				if (Tools::getValue('image_old_'.$language['id_lang']) != null && !Validate::isFileName(Tools::getValue('image_old_'.$language['id_lang'])))
					$errors[] = $this->l('Invalid filename.');
			}

			/* Checks title/url/legend/description for default lang */
			$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
			if (Tools::strlen(Tools::getValue('title_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The title is not set.');
			if (Tools::strlen(Tools::getValue('legend_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The caption is not set.');
			if (Tools::strlen(Tools::getValue('url_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The URL is not set.');
			if (!Tools::isSubmit('has_picture') && (!isset($_FILES['image_'.$id_lang_default]) || empty($_FILES['image_'.$id_lang_default]['tmp_name'])))
				$errors[] = $this->l('The image is not set.');
			if (Tools::getValue('image_old_'.$id_lang_default) && !Validate::isFileName(Tools::getValue('image_old_'.$id_lang_default)))
				$errors[] = $this->l('The image is not set.');
		} /* Validation for deletion */
		elseif (Tools::isSubmit('delete_id_slide') && (!Validate::isInt(Tools::getValue('delete_id_slide')) || !$this->slideExists((int)Tools::getValue('delete_id_slide'))))
			$errors[] = $this->l('Invalid slide ID');

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

		/* Processes Slider */
		if (Tools::isSubmit('submitGroups') || Tools::isSubmit('submitSaveAndStayGroup'))
		{
			if (Tools::getValue('id_sphomeslider_groups'))
			{
				$spgoup = new SpSlideGroup((int)Tools::getValue('id_sphomeslider_groups'));
				if (!Validate::isLoadedObject($spgoup))
				{
					$this->_html .= $this->displayError($this->l('Invalid slide ID'));
					return false;
				}
			}
			else
				$spgoup = new SpSlideGroup();		
				
			$next_ps = $this->getNextPositionGroup();	
			$spgoup->position = (!empty($spgoup->position)) ? (int)$spgoup->position : $next_ps;
			$spgoup->active = (Tools::getValue('active')) ? (int)Tools::getValue('active') : 0;
			$spgoup->hook	= (int)Tools::getValue('hook');
			$tmp_data = array();
			//$tmp_data['active'] 			= (int)Tools::getValue ('active', 1);
			$tmp_data['moduleclass_sfx'] 	= Tools::getValue ('moduleclass_sfx');
			$tmp_data['autoplay'] 	= Tools::getValue ('autoplay');
			$tmp_data['autoplay_timeout'] 		= Tools::getValue ('autoplay_timeout');
			$tmp_data['display_title_module'] 	= Tools::getValue ('display_title_module');
			$tmp_data['autoplaySpeed'] 			= Tools::getValue ('autoplaySpeed');
			$tmp_data['animateOut'] 		= Tools::getValue ('animateOut');
			$tmp_data['animateIn'] 			= Tools::getValue ('animateIn');
			$tmp_data['autoplayHoverPause']	= Tools::getValue ('autoplayHoverPause');
			$tmp_data['startPosition'] 		= Tools::getValue ('startPosition');
			$tmp_data['mouseDrag'] 			= Tools::getValue ('mouseDrag');
			$tmp_data['touchDrag'] 			= Tools::getValue ('touchDrag');
			$tmp_data['pullDrag'] 			= Tools::getValue ('pullDrag');
			$tmp_data['dots'] 				= Tools::getValue ('dots');
			$tmp_data['nav'] 				= Tools::getValue ('nav');
			//$tmp_data['effect'] 				= Tools::getValue ('effect');
			$tmp_data['hook'] 					= Tools::getValue('hook');
			$tmp_data['loop'] 				= Tools::getValue('loop');
			$languages = Language::getLanguages(false);
			
			foreach ($languages as $language)
			{
				$spgoup->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
			}
			$spgoup->params = serialize($tmp_data);
			if (!Tools::getValue('id_sphomeslider_groups'))
			{
				if (!$spgoup->add())
					$errors[] = $this->displayError($this->l('The group could not be added.'));
				else
				{
					if(Tools::isSubmit('submitSaveAndStayGroup'))
						Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editGroup&id_sphomeslider_groups='.$spgoup->id);
					else	
						Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
				}
			}
			/* Update */
			elseif (!$spgoup->update())
				$errors[] = $this->displayError($this->l('The group could not be updated.'));	
			else{
				if(Tools::isSubmit('submitSaveAndStayGroup'))
					Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editGroup&id_sphomeslider_groups='.$spgoup->id);
				else	
					Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
			}
				
		} /* Process Slide status */
		elseif (Tools::isSubmit('changeStatusGroup') && Tools::isSubmit('id_sphomeslider_groups'))
		{
			$slidegroup = new SpSlideGroup((int)Tools::getValue('id_sphomeslider_groups'));
			if ($slidegroup->active == 0)
				$slidegroup->active = 1;
			else
				$slidegroup->active = 0;
			$res = $slidegroup->update();
			$this->clearCache();
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		}	
		elseif (Tools::isSubmit('duplicateGroup') && Tools::isSubmit('id_sphomeslider_groups'))
		{
			$id_sphomeslider_groups = Tools::getValue('id_sphomeslider_groups');
			$slidegroup = new SpSlideGroup((int)Tools::getValue('id_sphomeslider_groups'));
			$slidegroup->active = 0;
			$slidegroup->id = null;
			
			if($slidegroup->add()){
				$sliders = $this->getIdSliderByGroup($id_sphomeslider_groups);
				if($sliders){
					foreach($sliders as $slider){
						$new_slider = new Spslide((int)$slider['id_sphomeslider_slides']);
						$new_slider->id = null;
						$new_slider->id_sphomeslider_groups = $slidegroup->id;
						$new_slider->add();
					}
				}
			}
			$this->clearCache();
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		}			
		elseif (Tools::isSubmit('changeStatus') && Tools::isSubmit('id_slide'))
		{
			$slide = new SpSlide((int)Tools::getValue('id_slide'));
			if ($slide->active == 0)
				$slide->active = 1;
			else
				$slide->active = 0;
			$res = $slide->update();
			$this->clearCache();
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editGroup&id_sphomeslider_groups='.Tools::getValue('id_sphomeslider_groups'));
		}
		/* Processes Slide */
		elseif (Tools::isSubmit('submitSlide'))
		{
			/* Sets ID if needed */
			if (Tools::getValue('id_slide'))
			{
				$slide = new SpSlide((int)Tools::getValue('id_slide'));
				if (!Validate::isLoadedObject($slide))
				{
					$this->_html .= $this->displayError($this->l('Invalid slide ID'));
					return false;
				}
			}
			else
				$slide = new SpSlide();
			/* Sets position */
			$slide->position = (int)Tools::getValue('position');
			/* Sets active */
			$slide->active = (int)Tools::getValue('active_slide');
						/* Sets active */
			$slide->id_sphomeslider_groups = (int)Tools::getValue('id_sphomeslider_groups');
			/* Sets each langue fields */
			$languages = Language::getLanguages(false);

			foreach ($languages as $language)
			{
				$slide->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
				$slide->url[$language['id_lang']] = Tools::getValue('url_'.$language['id_lang']);
				$slide->legend[$language['id_lang']] = Tools::getValue('legend_'.$language['id_lang']);
				$slide->description[$language['id_lang']] = Tools::getValue('description_'.$language['id_lang']);

				/* Uploads image and sets slide */
				$type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_'.$language['id_lang']]['name'], '.'), 1));
				$imagesize = @getimagesize($_FILES['image_'.$language['id_lang']]['tmp_name']);
				if (isset($_FILES['image_'.$language['id_lang']]) &&
					isset($_FILES['image_'.$language['id_lang']]['tmp_name']) &&
					!empty($_FILES['image_'.$language['id_lang']]['tmp_name']) &&
					!empty($imagesize) &&
					in_array(
						Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)), array(
							'jpg',
							'gif',
							'jpeg',
							'png'
						)
					) &&
					in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
				)
				{
					$temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
					$salt = sha1(microtime());
					if ($error = ImageManager::validateUpload($_FILES['image_'.$language['id_lang']]))
						$errors[] = $error;
					elseif (!$temp_name || !move_uploaded_file($_FILES['image_'.$language['id_lang']]['tmp_name'], $temp_name))
						return false;
					elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/images/'.$salt.'_'.$_FILES['image_'.$language['id_lang']]['name'], null, null, $type))
						$errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
					if (isset($temp_name))
						@unlink($temp_name);
					$slide->image[$language['id_lang']] = $salt.'_'.$_FILES['image_'.$language['id_lang']]['name'];
				}
				elseif (Tools::getValue('image_old_'.$language['id_lang']) != '')
					$slide->image[$language['id_lang']] = Tools::getValue('image_old_'.$language['id_lang']);
			}

			/* Processes if no errors  */
			if (!$errors)
			{
				/* Adds */
				if (!Tools::getValue('id_slide'))
				{
					if (!$slide->add())
						$errors[] = $this->displayError($this->l('The slide could not be added.'));
				}
				/* Update */
				elseif (!$slide->update())
					$errors[] = $this->displayError($this->l('The slide could not be updated.'));
				$this->clearCache();
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editGroup&id_sphomeslider_groups='.Tools::getValue('id_sphomeslider_groups'));
			}
		} /* Deletes */
		elseif (Tools::isSubmit('delete_id_group'))
		{
			$slidegroup = new SpSlideGroup((int)Tools::getValue('delete_id_group'));
			if($slidegroup->delete()){
				$sliders = $this->getIdSliderByGroup((int)Tools::getValue('delete_id_group'));
				if($sliders){
					foreach($sliders as $slider){
						$new_slider = new Spslide((int)$slider['id_sphomeslider_slides']);
						$new_slider->delete();
					}
				}
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
			}else{
				$this->_html .= $this->displayError('Could not delete.');
			}
			$this->clearCache();
		}		
		elseif (Tools::isSubmit('delete_id_slide'))
		{
			$slide = new SpSlide((int)Tools::getValue('delete_id_slide'));
			$res = $slide->delete();
			$this->clearCache();
			if (!$res)
				$this->_html .= $this->displayError('Could not delete.');
			else
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&editGroup&id_sphomeslider_groups='.Tools::getValue('id_sphomeslider_groups'));
		}

		/* Display errors if needed */
		if (count($errors))
			$this->_html .= $this->displayError(implode('<br />', $errors));
		elseif (Tools::isSubmit('submitSlide') && Tools::getValue('id_slide'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		elseif (Tools::isSubmit('submitSlide'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
	}

	protected function _prepareHook($hook='displayHome')
	{
	
		$smarty_cache_id = $this->getCacheId ('sphomeslider_'.$hook);
		//if (!$this->isCached ('sphomeslider.tpl', $smarty_cache_id)){
			$id_hook = Hook::getIdByName($hook);
			$slides = $this->getSlides(true,0,$id_hook);
			if (empty($slides))
				return;
			if (is_array($slides))
				foreach ($slides as &$slide)
				{
					$slide['sizes'] = @getimagesize((dirname(__FILE__).DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$slide['image']));
					if (isset($slide['sizes'][3]) && $slide['sizes'][3])
						$slide['size'] = $slide['sizes'][3];
				}

			if (!$slides)
				return false;	
			$params = array();		
			$id_sphomeslider_groups = 0;
			if($slides[0]['params'])
				$params = unserialize($slides[0]['params']);	
			if($slides[0]['id_sphomeslider_groups'])
				$id_sphomeslider_groups = $slides[0]['id_sphomeslider_groups'];

			$this->context->smarty->assign (array(
				'sphomeslider_slides' 		=> $slides,
				'params'					=> $params,
				'id_sphomeslider_groups'	=> $id_sphomeslider_groups,
				'title_slider'	=> $slides[0]['title_group']
			));
		//}

		return true;
	}

	public function hookdisplayHeader($params)
	{
		$this->context->controller->addCSS($this->_path.'css/sphomeslider.css');
		$this->context->controller->addCSS($this->_path.'css/animate.css');
		if (!defined ('OWL_CAROUSEL')){
			//$this->context->controller->addCSS($this->_path.'css/owl.carousel.css');
			$this->context->controller->addJs($this->_path.'js/owl.carousel.js');			
			define( 'OWL_CAROUSEL', 1 );
		}		
	}

	public function hookdisplayHomeSlider($params)
	{
		if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'index')
			return;
		$smarty_cache_id = $this->getCacheId ('sphomeslider_displayHomeSlider');
		if (!$this->_prepareHook('displayHomeSlider'))
			return false;

		return $this->display (__FILE__, 'sphomeslider.tpl', $smarty_cache_id);
	}

	public function hookdisplayHomeSlider2($params)
	{
		if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'index')
			return;
		$smarty_cache_id = $this->getCacheId ('sphomeslider_displayHomeSlider2');
		if (!$this->_prepareHook('displayHomeSlider2'))
			return false;

		return $this->display (__FILE__, 'sphomeslider.tpl', $smarty_cache_id);
	}
	
	public function hookdisplayHomeSlider3($params)
	{
		if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'index')
			return;
		$smarty_cache_id = $this->getCacheId ('sphomeslider_displayHomeSlider3');
		if (!$this->_prepareHook('displayHomeSlider3'))
			return false;

		return $this->display (__FILE__, 'sphomeslider-2.tpl', $smarty_cache_id);
	}

	public function hookdisplayHomeSlider4($params)
	{
		if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'index')
			return;
		$smarty_cache_id = $this->getCacheId ('sphomeslider_displayHomeSlider4');
		if (!$this->_prepareHook('displayHomeSlider4'))
			return false;

		return $this->display (__FILE__, 'sphomeslider.tpl', $smarty_cache_id);
	}

	public function hookdisplayHomeSlider5($params)
	{
		if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'index')
			return;
		$smarty_cache_id = $this->getCacheId ('sphomeslider_displayHomeSlider5');
		if (!$this->_prepareHook('displayHomeSlider5'))
			return false;

		return $this->display (__FILE__, 'sphomeslider.tpl', $smarty_cache_id);
	}
	
	
	public function clearCache()
	{
		$this->_clearCache('sphomeslider.tpl');
	}

	public function hookActionShopDataDuplication($params)
	{
		Db::getInstance()->execute('
			INSERT IGNORE INTO '._DB_PREFIX_.'sphomeslider (id_sphomeslider_slides, id_shop)
			SELECT id_sphomeslider_slides, '.(int)$params['new_id_shop'].'
			FROM '._DB_PREFIX_.'sphomeslider
			WHERE id_shop = '.(int)$params['old_id_shop']
		);
		$this->clearCache();
	}

	public function headerHTML()
	{
		if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name)
			return;

		$this->context->controller->addJqueryUI('ui.sortable');
		/* Style & js for fieldset 'slides configuration' */
		$html = '<script type="text/javascript">
			$(function() {
				var $mySlides = $("#slides");
				$mySlides.sortable({
					opacity: 0.6,
					cursor: "move",
					update: function() {
						var order = $(this).sortable("serialize") + "&action=updateSlidesPosition";
						$.post("'.$this->context->shop->physical_uri.$this->context->shop->virtual_uri.'modules/'.$this->name.'/ajax_'.$this->name.'.php?secure_key='.$this->secure_key.'", order);
						}
					});
				$mySlides.hover(function() {
					$(this).css("cursor","move");
					},
					function() {
					$(this).css("cursor","auto");
				});
			});
		</script>';

		return $html;
	}

	public function getNextPositionGroup()
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT MAX(hssg.`position`) AS `next_position`
			FROM `'._DB_PREFIX_.'sphomeslider_groups` hssg'
		);

		return (++$row['next_position']);
	}

	public function getSlides($active = null,$id_sphomeslider_groups = 0,$id_hook=0)
	{
		$this->context = Context::getContext();
		$id_shop = $this->context->shop->id;
		$id_lang = $this->context->language->id;

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hs.`id_sphomeslider_slides` as id_slide, hss.`position`, hss.`active`, hssl.`title`,
			hssl.`url`, hssl.`legend`, hssl.`description`, hssl.`image`,hssg.`params`,hssg.`id_sphomeslider_groups`,hsgl.`title` as title_group
			FROM '._DB_PREFIX_.'sphomeslider hs
			LEFT JOIN '._DB_PREFIX_.'sphomeslider_slides hss ON (hs.id_sphomeslider_slides = hss.id_sphomeslider_slides)
			LEFT JOIN '._DB_PREFIX_.'sphomeslider_slides_lang hssl ON (hss.id_sphomeslider_slides = hssl.id_sphomeslider_slides)
			LEFT JOIN '._DB_PREFIX_.'sphomeslider_groups hssg ON (hss.id_sphomeslider_groups = hssg.id_sphomeslider_groups)
			LEFT JOIN '._DB_PREFIX_.'sphomeslider_groups_lang hsgl ON (hssg.id_sphomeslider_groups = hsgl.id_sphomeslider_groups)
			WHERE id_shop = '.(int)$id_shop.'
			'.($id_sphomeslider_groups != 0 ? ' AND hss.`id_sphomeslider_groups` = '.(int)$id_sphomeslider_groups.'' : ' ').'
			'.($id_hook != 0 ? ' AND hssg.`hook` = '.(int)$id_hook.'' : ' ').'
			AND hsgl.id_lang = '.(int)$id_lang.'
			AND hssl.id_lang = '.(int)$id_lang.
			($active ? ' AND hss.`active` = 1' : ' ').
			($active ? ' AND hssg.`active` = 1' : ' ').'
			ORDER BY hss.position'
		);
	}

	public function getAllImagesBySlidesId($id_slides, $active = null, $id_shop = null)
	{
		$this->context = Context::getContext();
		$images = array();

		if (!isset($id_shop))
			$id_shop = $this->context->shop->id;

		$results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hssl.`image`, hssl.`id_lang`
			FROM '._DB_PREFIX_.'sphomeslider hs
			LEFT JOIN '._DB_PREFIX_.'sphomeslider_slides hss ON (hs.id_sphomeslider_slides = hss.id_sphomeslider_slides)
			LEFT JOIN '._DB_PREFIX_.'sphomeslider_slides_lang hssl ON (hss.id_sphomeslider_slides = hssl.id_sphomeslider_slides)
			WHERE hs.`id_sphomeslider_slides` = '.(int)$id_slides.' AND hs.`id_shop` = '.(int)$id_shop.
			($active ? ' AND hss.`active` = 1' : ' ')
		);

		foreach ($results as $result)
			$images[$result['id_lang']] = $result['image'];

		return $images;
	}

	public function displayStatus($id_slide, $active)
	{
		$title = ((int)$active == 0 ? $this->l('Disabled') : $this->l('Enabled'));
		$icon = ((int)$active == 0 ? 'icon-remove' : 'icon-check');
		$class = ((int)$active == 0 ? 'btn-danger' : 'btn-success');
		$html = '<a class="btn '.$class.'" href="'.AdminController::$currentIndex.
			'&configure='.$this->name.'
				&token='.Tools::getAdminTokenLite('AdminModules').'
				&changeStatus&id_slide='.(int)$id_slide.'&id_sphomeslider_groups='.Tools::getValue('id_sphomeslider_groups').'" title="'.$title.'"><i class="'.$icon.'"></i> '.$title.'</a>';

		return $html;
	}

	public function slideExists($id_slide)
	{
		$req = 'SELECT hs.`id_sphomeslider_slides` as id_slide
				FROM `'._DB_PREFIX_.'sphomeslider` hs
				WHERE hs.`id_sphomeslider_slides` = '.(int)$id_slide;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}

	public function renderList()
	{
		$id_sphomeslider_groups = Tools::getValue('id_sphomeslider_groups') ? Tools::getValue('id_sphomeslider_groups') : 0 ; 
		$slides = $this->getSlides(null,$id_sphomeslider_groups);
		foreach ($slides as $key => $slide)
		{
			$slides[$key]['status'] = $this->displayStatus($slide['id_slide'], $slide['active']);
			$associated_shop_ids = SpSlide::getAssociatedIdsShop((int)$slide['id_slide']);
			if ($associated_shop_ids && count($associated_shop_ids) > 1)
				$slides[$key]['is_shared'] = true;
			else
				$slides[$key]['is_shared'] = false;
		}

		$this->context->smarty->assign(
			array(
				'link' => $this->context->link,
				'slides' => $slides,
				'id_sphomeslider_groups' => Tools::getValue("id_sphomeslider_groups") ? Tools::getValue("id_sphomeslider_groups") : 0,
				'image_baseurl' => $this->_path.'images/'
			)
		);

		return $this->display(__FILE__, 'list.tpl');
	}

	public function renderAddForm()
	{
		$modules = $this->getGridItems ();
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Slide information'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'file_lang',
						'label' => $this->l('Select a file'),
						'name' => 'image',
						'required' => true,
						'lang' => true,
						'desc' => sprintf($this->l('Maximum image size: %s.'), ini_get('upload_max_filesize'))
					),
					array(
						'type' => 'text',
						'label' => $this->l('Slide title'),
						'name' => 'title',
						'required' => true,
						'lang' => true,
					),
					array(
						'type' => 'select',
						'label' => $this->l('Group'),
						'name' => 'id_sphomeslider_groups',
						'options' => array(  'query' => $modules,
						'id' => 'id_sphomeslider_groups',
						'name' => 'title' ),
					 ),						
					array(
						'type' => 'text',
						'label' => $this->l('Target URL'),
						'name' => 'url',
						'required' => true,
						'lang' => true,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Caption'),
						'name' => 'legend',
						'required' => true,
						'lang' => true,
					),
					array(
						'type' => 'textarea',
						'label' => $this->l('Description'),
						'name' => 'description',
						'autoload_rte' => true,
						'lang' => true,
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Enabled'),
						'name' => 'active_slide',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						),
					),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		if (Tools::isSubmit('id_slide') && $this->slideExists((int)Tools::getValue('id_slide')))
		{
			$slide = new SpSlide((int)Tools::getValue('id_slide'));
			$fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_slide');
			$fields_form['form']['images'] = $slide->image;

			$has_picture = true;

			foreach (Language::getLanguages(false) as $lang)
				if (!isset($slide->image[$lang['id_lang']]))
					$has_picture &= false;

			if ($has_picture)
				$fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'has_picture');
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
		$helper->submit_action = 'submitSlide';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_sphomeslider_groups='.Tools::getValue('id_sphomeslider_groups');
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

	public function renderForm()
	{
		$default_hook = array();
		if($this->default_hook){
			foreach ($this->default_hook as $hook){
				$default_hook[] = array(
					'value' => Hook::getIdByName($hook),
					'name' => $hook
				);
			}
		}

		$effect = array(
					array('id_option'=>'none'),	
					array('id_option'=>'bounce'),
					array('id_option'=>'flash'),
					array('id_option'=>'pulse'),
					array('id_option'=>'rubberBand'),
					array('id_option'=>'shake'),
					array('id_option'=>'swing'),
					array('id_option'=>'tada'),
					array('id_option'=>'wobble'),
					array('id_option'=>'jello'),
					array('id_option'=>'bounceIn'),
					array('id_option'=>'bounceInDown'),
					array('id_option'=>'bounceInLeft'),
					array('id_option'=>'bounceInRight'),
					array('id_option'=>'bounceInUp'),
					array('id_option'=>'bounceOut'),
					array('id_option'=>'bounceOutDown'),
					array('id_option'=>'bounceOutLeft'),
					array('id_option'=>'bounceOutRight'),
					array('id_option'=>'bounceOutUp'),
					array('id_option'=>'fadeIn'),
					array('id_option'=>'fadeInDown'),
					array('id_option'=>'fadeInDownBig'),
					array('id_option'=>'fadeInLeft'),
					array('id_option'=>'fadeInLeftBig'),
					array('id_option'=>'fadeInRight'),
					array('id_option'=>'fadeInRightBig'),
					array('id_option'=>'fadeInUp'),
					array('id_option'=>'fadeInUpBig'),
					array('id_option'=>'fadeOut'),
					array('id_option'=>'fadeOutDown'),
					array('id_option'=>'fadeOutDownBig'),
					array('id_option'=>'fadeOutLeft'),
					array('id_option'=>'fadeOutLeftBig'),
					array('id_option'=>'fadeOutRight'),
					array('id_option'=>'fadeOutRightBig'),
					array('id_option'=>'fadeOutUp'),
					array('id_option'=>'fadeOutUpBig'),
					array('id_option'=>'flip'),
					array('id_option'=>'flipInX'),
					array('id_option'=>'flipInY'),
					array('id_option'=>'flipOutX'),
					array('id_option'=>'flipOutY'),
					array('id_option'=>'lightSpeedIn'),
					array('id_option'=>'lightSpeedOut'),
					array('id_option'=>'rotateIn'),
					array('id_option'=>'rotateInDownLeft'),
					array('id_option'=>'rotateInDownRight'),
					array('id_option'=>'rotateInUpLeft'),
					array('id_option'=>'rotateInUpRight'),
					array('id_option'=>'rotateOut'),
					array('id_option'=>'rotateOutDownLeft'),
					array('id_option'=>'rotateOutDownRight'),
					array('id_option'=>'rotateOutUpLeft'),
					array('id_option'=>'rotateOutUpRight'),
					array('id_option'=>'slideInUp'),
					array('id_option'=>'slideInDown'),
					array('id_option'=>'slideInLeft'),
					array('id_option'=>'slideInRight'),
					array('id_option'=>'slideOutUp'),
					array('id_option'=>'slideOutDown'),
					array('id_option'=>'slideOutLeft'),
					array('id_option'=>'slideOutRight'),
					array('id_option'=>'zoomIn'),
					array('id_option'=>'zoomInDown'),
					array('id_option'=>'zoomInLeft'),
					array('id_option'=>'zoomInRight'),
					array('id_option'=>'zoomInUp'),
					array('id_option'=>'zoomOut'),
					array('id_option'=>'zoomOutDown'),
					array('id_option'=>'zoomOutLeft'),
					array('id_option'=>'zoomOutRight'),
					array('id_option'=>'zoomOutUp'),
					array('id_option'=>'hinge'),
					array('id_option'=>'rollIn'),
					array('id_option'=>'rollOut'),);
						
		$fields_form = array(
		'form' => array(
			'legend' => array(
				'title' => $this->l('Settings'),
				'icon' => 'icon-cogs'
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Module Title'),
					'name' => 'title',
					'required' => true,
					'lang' => true,
					'class' => 'fixed-width-xl',
				),		
				array(
					'type' => 'switch',
					'label' => $this->l('Active Title Module'),
					'name' => 'display_title_module',
					'values' => array(
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
					),
				),						
				array(
					'type' => 'select',
					'label' => $this->l('Hook'),
					'name' => 'hook',
					'options' => array(  'query' => $default_hook,
					'id' => 'value',
					'name' => 'name' ),
					'default' => Hook::getIdByName('displayHome'),
				 ),	
				array(
					'type' => 'text',
					'label' => $this->l('Module Class Suffix'),
					'name' => 'moduleclass_sfx',
					'class' => 'fixed-width-xl',
				),			
				array(
					'type'   => 'switch',
					'label'  => $this->l('Auto Play'),
					'name'   => 'autoplay',
					'hint'   => $this->l('Allow to on/off auto play for slider'),
					'values' => array(
						array(
							'id'    => 'lop_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'lop_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'   => 'text',
					'label'  => $this->l('Auto Interval Timeout'),
					'name'   => 'autoplay_timeout',
					'class'  => 'fixed-width-xl',
					'hint'   => 'Autoplay interval timeout for slider.',
					'suffix' => 'ms',
				),
				array(
					'type'   => 'text',
					'label'  => $this->l('Auto Play Speed'),
					'name'   => 'autoplaySpeed',
					'class'  => 'fixed-width-xl',
					'hint'   => 'Autoplay Speed.',
					'suffix' => 'ms',
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Auto Play Hover Pause'),
					'name'   => 'autoplayHoverPause',
					'hint'   => $this->l('Allow to on/off auto play for slider'),
					'values' => array(
						array(
							'id'    => 'lop_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'lop_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),				
				array(
					'type'  => 'text',
					'label' => $this->l('Start Position Item'),
					'name'  => 'startPosition',
					'class' => 'fixed-width-xl',
					'hint'  => 'Start position or URL Hash string like #id.',
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Mouse Drag'),
					'name'   => 'mouseDrag',
					'hint'   => $this->l('Mouse drag enabled'),
					'values' => array(
						array(
							'id'    => 'mouse_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'mouse_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Touch Drag'),
					'name'   => 'touchDrag',
					'hint'   => $this->l('Touch drag enabled'),
					'values' => array(
						array(
							'id'    => 'touch_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'touch_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Pull Drag'),
					'name'   => 'pullDrag',
					'hint'   => $this->l('Stage pull to edge'),
					'values' => array(
						array(
							'id'    => 'pull_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'pull_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Show Pagination'),
					'name'   => 'dots',
					'hint'   => $this->l('Allow show/hide pagination for module'),
					'values' => array(
						array(
							'id'    => 'pag_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'pag_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Show Navigation'),
					'name'   => 'nav',
					'hint'   => $this->l('Allow show/hide navigation for module'),
					'values' => array(
						array(
							'id'    => 'nav_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'nav_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('Select Effect Animate Out'),
					'name'    => 'animateOut',
					'hint'    => $this->l('Choose the animateOut for the module here.'),
					'class'   => 'fixed-width-xl',
					'options' => array(
						'query' => $effect,
						'id'    => 'id_option',
						'name'  => 'id_option'
					)
				),
				array(
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('Select Effect Animate In'),
					'name'    => 'animateIn',
					'hint'    => $this->l('Choose the animateIn for the module here.'),
					'class'   => 'fixed-width-xl',
					'options' => array(
						'query' => $effect,
						'id'    => 'id_option',
						'name'  => 'id_option'
					)
				),								

				array(
					'type' => 'switch',
					'label' => $this->l('Loop'),
					'name' => 'loop',
					'values' => array(
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
					),
				),				
				array(
						'type' => 'switch',
						'label' => $this->l('Active'),
						'name' => 'active',
						'values' => array(
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
						),
					)					
				),
	      		 'buttons' => array(
                            array(
                                'title' => $this->l('Save And Stay'),
                                'icon' => 'process-icon-save',
                                'class' => 'pull-right',
                                'type' => 'submit',
                                'name' => 'submitSaveAndStayGroup'
                            ),
                            array(
                                'title' => $this->l('Save'),
                                'icon' => 'process-icon-save',
                                'class' => 'pull-right',
                                'type' => 'submit',
                                'name' => 'submitGroups'
                            ),
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
		$helper->submit_action = 'submitGroups';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_sphomeslider_groups='.Tools::getValue('id_sphomeslider_groups');
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

		return $helper->generateForm(array($fields_form));
	}

	public function getConfigFieldsValues()
	{
		$fields = array();

		if (Tools::isSubmit('id_sphomeslider_groups'))
		{
			$spgroup = new SpSlideGroup((int)Tools::getValue('id_sphomeslider_groups'));
			$fields['id_sphomeslider_groups'] = (int)Tools::getValue('id_sphomeslider_groups', $spgroup->id);
		}
		else
			$spgroup = new SpSlideGroup();
		$params = Tools::getValue('params', $spgroup->params);
		$params = unserialize($params);
		$fields['active'] 			= (isset($spgroup->active)) ? $spgroup->active : 1;
		$fields['moduleclass_sfx'] 	= (isset($params['moduleclass_sfx']) && $params['moduleclass_sfx']) ? $params['moduleclass_sfx'] : '';
		$fields['autoplay'] 		= (isset($params['autoplay'])) ? $params['autoplay'] : '1';
		$fields['autoplay_timeout'] = (isset($params['autoplay_timeout']) && $params['autoplay_timeout']) ? $params['autoplay_timeout'] : '2000';
		$fields['autoplaySpeed'] 			= (isset($params['autoplaySpeed']) && $params['autoplaySpeed']) ? $params['autoplaySpeed'] : '2000';
		$fields['animateOut'] 				= (isset($params['animateOut'])) ? $params['animateOut'] : '1';
		$fields['animateIn'] 				= (isset($params['animateIn'])) ? $params['animateIn'] : '1';
		$fields['startPosition'] 			= (isset($params['startPosition']) && $params['startPosition']) ? $params['startPosition'] : '0';
		$fields['mouseDrag'] 				= (isset($params['mouseDrag'])) ? $params['mouseDrag'] : '1';
		$fields['autoplayHoverPause'] 		= (isset($params['autoplayHoverPause'])) ? $params['autoplayHoverPause'] : '1';
		$fields['touchDrag'] 				= (isset($params['touchDrag']) ) ? $params['touchDrag'] : '1';
		$fields['pullDrag'] 				= (isset($params['pullDrag']) ) ? $params['pullDrag'] : '1';
		$fields['dots'] 					= (isset($params['dots'])) ? $params['dots'] : '1';
		$fields['nav'] 						= (isset($params['nav'])) ? $params['nav'] : '1';
		//$fields['effect'] 					= (isset($params['effect']) && $params['effect']) ? $params['effect'] : 'none';
		$fields['display_title_module'] 	= (isset($params['display_title_module'])) ? $params['display_title_module'] : 1;
		$fields['loop'] 					= (isset($params['loop'])) ? $params['loop'] : 1;
		$fields['hook'] 					= (isset($params['hook']) && $params['hook']) ? $params['hook'] : Hook::getIdByName('displayHome');	

		$languages = Language::getLanguages(false);

		foreach ($languages as $lang)
		{
			$fields['title'][$lang['id_lang']] = Tools::getValue('title_'.(int)$lang['id_lang'], $spgroup->title[$lang['id_lang']]);
		}

		return $fields;
	}
	
	private function displayForm()
	{
		$currentIndex = AdminController::$currentIndex;
		$modules = array();
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
					$associated_shop_ids = SpSlideGroup::getAssociatedIdsShop((int)$mod['id_sphomeslider_groups']);
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
			.'&token='.Tools::getAdminTokenLite ('AdminModules').'&addGroup">
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
			foreach ($modules as $spgroup)
			{
				$this->_html .= '
				<tr id="item_'.$spgroup['id_sphomeslider_groups'].'" class=" '.( $irow ++ % 2?' ':'' ).'">
					<td class=" 	" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&editGroup&id_sphomeslider_groups='
					.$spgroup['id_sphomeslider_groups'].'\'">'
					.$spgroup['id_sphomeslider_groups'].'</td>
					
					<td class=" dragHandle"><div class="dragGroup"><div class="positions">'.$spgroup['position']
					.'</div></div></td>
					
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&editGroup&id_sphomeslider_groups='.$spgroup['id_sphomeslider_groups'].'\'">'.$spgroup['title']
					.' '.($spgroup['is_shared'] ? '<span class="label color_field" style="background-color:#108510;color:white;margin-top:5px;">'.$this->l('Shared').'</span>' : '').'</td>
					
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name
					.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editGroup&id_sphomeslider_groups='
					.$spgroup['id_sphomeslider_groups'].'\'">'
					.( Validate::isInt ($spgroup['hook'])?$this->getHookTitle ($spgroup['hook']):'' ).'</td>
					
					<td class="  "> <a href="'.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&changeStatusGroup&id_sphomeslider_groups='.$spgroup['id_sphomeslider_groups'].'&hook='.$spgroup['hook'].'">'.( $spgroup['active']?'
					<i class="icon-check"></i>':'<i class="icon-remove"></i>' ).'</a> </td>
					
					<td class="text-right">
						<div class="btn-group-action">
							<div class="btn-group pull-right">
								<a class="btn btn-default" href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editGroup&id_sphomeslider_groups='.$spgroup['id_sphomeslider_groups'].'">
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
					.Tools::getAdminTokenLite ('AdminModules').'&duplicateGroup&id_sphomeslider_groups='
					.$spgroup['id_sphomeslider_groups'].'">
											<i class="icon-copy"></i> '.$this->l('Duplicate').'
										</a>								
									</li>
									<li class="divider"></li>
									<li>
										<a title ="'.$this->l('Delete').'" onclick="return confirm(\''
					.$this->l('Are you sure?').'\');" href="'.$currentIndex
					.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&delete_id_group&delete_id_group='
					.$spgroup['id_sphomeslider_groups'].'">
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
	
	private function getGridItems()
	{
		$this->context = Context::getContext ();
		$id_lang = $this->context->language->id;
		$id_shop = $this->context->shop->id;
		$sql = 'SELECT b.`id_sphomeslider_groups`,  b.`hook`, b.`position`, b.`active`, bl.`title`
			FROM `'._DB_PREFIX_.'sphomeslider_groups` b
			LEFT JOIN `'._DB_PREFIX_.'sphomeslider_groups_shop` bs ON (b.`id_sphomeslider_groups` = bs.`id_sphomeslider_groups` )
			LEFT JOIN `'._DB_PREFIX_.'sphomeslider_groups_lang` bl ON (b.`id_sphomeslider_groups` = bl.`id_sphomeslider_groups`)
			WHERE bs.`id_shop` = '.(int)$id_shop.' 
			AND bl.`id_lang` = '.(int)$id_lang.'
			ORDER BY b.`position`';
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql );
	}	

	public function getAddFieldsValues()
	{
		$fields = array();

		if (Tools::isSubmit('id_slide') && $this->slideExists((int)Tools::getValue('id_slide')))
		{
			$slide = new SpSlide((int)Tools::getValue('id_slide'));
			$fields['id_slide'] = (int)Tools::getValue('id_slide', $slide->id);
		}
		else
			$slide = new SpSlide();
		
		$fields['active_slide'] = Tools::getValue('active_slide', $slide->active);
		$fields['id_sphomeslider_groups'] = Tools::getValue('id_sphomeslider_groups', $slide->id_sphomeslider_groups);
		$fields['has_picture'] = true;

		$languages = Language::getLanguages(false);

		foreach ($languages as $lang)
		{
			$fields['image'][$lang['id_lang']] = Tools::getValue('image_'.(int)$lang['id_lang']);
			$fields['title'][$lang['id_lang']] = Tools::getValue('title_'.(int)$lang['id_lang'], $slide->title[$lang['id_lang']]);
			$fields['url'][$lang['id_lang']] = Tools::getValue('url_'.(int)$lang['id_lang'], $slide->url[$lang['id_lang']]);
			$fields['legend'][$lang['id_lang']] = Tools::getValue('legend_'.(int)$lang['id_lang'], $slide->legend[$lang['id_lang']]);
			$fields['description'][$lang['id_lang']] = Tools::getValue('description_'.(int)$lang['id_lang'], $slide->description[$lang['id_lang']]);
		}

		return $fields;
	}

	protected function getMultiLanguageInfoMsg()
	{
		return '<p class="alert alert-warning">'.
					$this->l('Since multiple languages are activated on your shop, please mind to upload your image for each one of them').
				'</p>';
	}

	protected function getWarningMultishopHtml()
	{
		if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL)
			return '<p class="alert alert-warning">'.
						$this->l('You cannot manage slides items from a "All Shops" or a "Group Shop" context, select directly the shop you want to edit').
					'</p>';
		else
			return '';
	}

	protected function getShopContextError($shop_contextualized_name, $mode)
	{
		if (is_array($shop_contextualized_name))
			$shop_contextualized_name = implode('<br/>', $shop_contextualized_name);

		if ($mode == 'edit')
			return '<p class="alert alert-danger">'.
							sprintf($this->l('You can only edit this slide from the shop(s) context: %s'), $shop_contextualized_name).
					'</p>';
		else
			return '<p class="alert alert-danger">'.
							sprintf($this->l('You cannot add slides from a "All Shops" or a "Group Shop" context')).
					'</p>';
	}

	protected function getShopAssociationError($id_slide)
	{
		return '<p class="alert alert-danger">'.
						sprintf($this->l('Unable to get slide shop association information (id_slide: %d)'), (int)$id_slide).
				'</p>';
	}


	protected function getCurrentShopInfoMsg()
	{
		$shop_info = null;

		if (Shop::isFeatureActive())
		{
			if (Shop::getContext() == Shop::CONTEXT_SHOP)
				$shop_info = sprintf($this->l('The modifications will be applied to shop: %s'), $this->context->shop->name);
			else if (Shop::getContext() == Shop::CONTEXT_GROUP)
				$shop_info = sprintf($this->l('The modifications will be applied to this group: %s'), Shop::getContextShopGroup()->name);
			else
				$shop_info = $this->l('The modifications will be applied to all shops and shop groups');

			return '<div class="alert alert-info">'.
						$shop_info.
					'</div>';
		}
		else
			return '';
	}
	private function getIdSliderByGroup($id_sphomeslider_groups){
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT ss.`id_sphomeslider_slides`
			FROM `'._DB_PREFIX_.'sphomeslider_slides` ss
			WHERE ss.`id_sphomeslider_groups` = '.(int)$id_sphomeslider_groups
		);
		return $result;
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
	
	public function getHigherModuleID()
	{
		$sql = 'SELECT MAX(`id_sphomeslider_groups`)
				FROM `'._DB_PREFIX_.'sphomeslider_groups`';
		$sphomeslider_groups = DB::getInstance ()->getValue($sql);
		return ( is_numeric ($sphomeslider_groups) )?$sphomeslider_groups:1;
	}
	
	public function getNextPosition()
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT MAX(cs.`position`) AS `next_position`
			FROM `'._DB_PREFIX_.'sphomeslider_groups` cs, `'._DB_PREFIX_.'sphomeslider_groups_shop` css
			WHERE css.`id_sphomeslider_groups` = cs.`id_sphomeslider_groups` AND css.`id_shop` = '.(int)$this->context->shop->id
		);

		return (++$row['next_position']);
	}

	protected function getSharedSlideWarning()
	{
		return '<p class="alert alert-warning">'.
					$this->l('This slide is shared with other shops! All shops associated to this slide will apply modifications made here').
				'</p>';
	}
}
