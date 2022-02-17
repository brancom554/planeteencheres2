<?php
/**
 * package SP Banner
 *
 * @version 1.0.1
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

if (!defined ('_PS_VERSION_'))
	exit;
include_once ( dirname (__FILE__).'/SpBannerClass.php' );

class SpBanner extends Module
{
	protected $error = false;
	private $html;
	private $default_hook = array( 
		'displayBanner',
		'displayBanner2',
		'displayBanner3',
		'displayBanner4',
		'displayBanner5',
		'displayBanner6',
		'displayBanner7',
		'displayBanner8',
		'displayBanner9',
		'displayBanner10',
		'displayBanner11',
		'displayBanner12',
		'displayBanner13',
		'displayBanner14',
		'displayBanner15',
		'displayBanner16',
		'displayBanner17',
		'displayBanner18',
		'displayBanner19',
		'displayBanner20',
		'displayBanner21',
		'displayBanner22',
		'displayBanner23',
		'displayBanner24',
		'displayBanner25',
		'displayBanner26',
		'displayBanner27',
		'displayBanner28',
		'displayLeftColumn');

	public function __construct()
	{
		$this->name = 'spbanner';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'MagenTech';
		$this->secure_key = Tools::encrypt ($this->name);
		$this->bootstrap = true;
		parent::__construct ();
		$this->displayName = $this->l('SP Banner');
		$this->description = $this->l('This Module allows you to create your own HTML Module using a WYSIWYG editor.');
		$this->confirmUninstall = $this->l('Are you sure?');
		$this->ps_versions_compliancy = array('min' => '1.6.0.9', 'max' => _PS_VERSION_);
	}

	public function install()
	{
		if (parent::install () == false || !$this->registerHook ('header') || !$this->registerHook ('actionShopDataDuplication'))
			return false;
		foreach ($this->default_hook as $hook)
		{
			if (!$this->registerHook ($hook))
				return false;
		}
		$spbanner = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spbanner`')
			&& Db::getInstance ()->Execute ('CREATE TABLE `'._DB_PREFIX_.'spbanner` (`id_spbanner` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`hook` int(10) unsigned, 
			`params` text NOT NULL DEFAULT \'\' ,
			`active` tinyint(1) NOT NULL DEFAULT \'1\',
			`ordering` int(10) unsigned NOT NULL,
			`banner_effect` varchar(25) NOT NULL DEFAULT \'\',
			PRIMARY KEY (`id_spbanner`)) ENGINE=InnoDB default CHARSET=utf8');
		$spbanner_shop = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spbanner_shop`')
			&& Db::getInstance ()->Execute ('CREATE TABLE `'._DB_PREFIX_.'spbanner_shop` (`id_spbanner` int(10) unsigned NOT NULL,
			`id_shop` int(10) unsigned NOT NULL, 
			`active` tinyint(1) NOT NULL DEFAULT \'1\',
			PRIMARY KEY (`id_spbanner`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8');
		$spbanner_lang = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spbanner_lang`')
			&& Db::getInstance ()->Execute ('CREATE TABLE '._DB_PREFIX_.'spbanner_lang (`id_spbanner` int(10) unsigned NOT NULL,
			`id_lang` int(10) unsigned NOT NULL,
			`title_module` varchar(255) NOT NULL DEFAULT \'\',
			`image` varchar(255) NOT NULL DEFAULT \'\',
			`banner_link` varchar(255) NOT NULL DEFAULT \'\',
			`content` text,
			PRIMARY KEY (`id_spbanner`,`id_lang`)) ENGINE=InnoDB default CHARSET=utf8');
		if (!$spbanner || !$spbanner_shop || !$spbanner_lang)
			return false;

		$this->installFixtures();

		return true;
	}

	public function uninstall()
	{
		if (parent::uninstall () == false)
			return false;
		if (!Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spbanner`')
			|| !Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spbanner_shop`')
			|| !Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spbanner_lang`'))
			return false;
		$this->clearCacheItemForHook ();
		return true;
	}
	public function installFixtures()
	{
		$datas = array(
			array(
				'active' => 1,
				'id_spbanner' => 1,
				'hook' => Hook::getIdByName('displayLeftColumn'),
				'title_module' => 'Banner Left Column',
				'display_title_module' => 0,
				'image' => 'banner-left.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-left',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 2,
				'hook' => Hook::getIdByName('displayBanner'),
				'title_module' => 'Banner 1',
				'display_title_module' => 0,
				'image' => 'banner01.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-1',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 3,
				'hook' => Hook::getIdByName('displayBanner2'),
				'title_module' => 'Banner 2',
				'display_title_module' => 0,
				'image' => 'banner02.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-2',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 4,
				'hook' => Hook::getIdByName('displayBanner3'),
				'title_module' => 'Banner 3',
				'display_title_module' => 0,
				'image' => 'banner03.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-3',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 5,
				'hook' => Hook::getIdByName('displayBanner4'),
				'title_module' => 'Banner 4',
				'display_title_module' => 0,
				'image' => 'banner04.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-4 col-lg-3',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 6,
				'hook' => Hook::getIdByName('displayBanner5'),
				'title_module' => 'Banner 5',
				'display_title_module' => 0,
				'image' => 'banner05.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-5',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 7,
				'hook' => Hook::getIdByName('displayBanner6'),
				'title_module' => 'Banner 6',
				'display_title_module' => 0,
				'image' => 'banner06.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-6',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 8,
				'hook' => Hook::getIdByName('displayBanner7'),
				'title_module' => 'Banner 7',
				'display_title_module' => 0,
				'image' => 'banner07.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-7',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 9,
				'hook' => Hook::getIdByName('displayBanner8'),
				'title_module' => 'Banner 8',
				'display_title_module' => 0,
				'image' => 'banner08.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-8',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 10,
				'hook' => Hook::getIdByName('displayBanner9'),
				'title_module' => 'Banner 9',
				'display_title_module' => 0,
				'image' => 'banner09.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-9',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 11,
				'hook' => Hook::getIdByName('displayBanner10'),
				'title_module' => 'Banner 10',
				'display_title_module' => 0,
				'image' => 'banner10.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-10',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 12,
				'hook' => Hook::getIdByName('displayBanner11'),
				'title_module' => 'Banner 11',
				'display_title_module' => 0,
				'image' => 'banner11.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-11',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 13,
				'hook' => Hook::getIdByName('displayBanner12'),
				'title_module' => 'Banner 12',
				'display_title_module' => 0,
				'image' => 'banner12.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-12 col-xs-6',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 14,
				'hook' => Hook::getIdByName('displayBanner13'),
				'title_module' => 'Banner 13',
				'display_title_module' => 0,
				'image' => 'banner13.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-13 col-xs-6',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 15,
				'hook' => Hook::getIdByName('displayBanner14'),
				'title_module' => 'Banner 14',
				'display_title_module' => 0,
				'image' => 'banner14.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-14 col-sm-6',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 16,
				'hook' => Hook::getIdByName('displayBanner15'),
				'title_module' => 'Banner 15',
				'display_title_module' => 0,
				'image' => 'banner15.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-15 col-sm-6',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 17,
				'hook' => Hook::getIdByName('displayBanner16'),
				'title_module' => 'Banner 16',
				'display_title_module' => 0,
				'image' => 'banner16.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-16',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 18,
				'hook' => Hook::getIdByName('displayBanner17'),
				'title_module' => 'Banner 17',
				'display_title_module' => 0,
				'image' => 'banner17.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-17',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 19,
				'hook' => Hook::getIdByName('displayBanner18'),
				'title_module' => 'Banner 18',
				'display_title_module' => 0,
				'image' => 'banner18.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-18',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 20,
				'hook' => Hook::getIdByName('displayBanner19'),
				'title_module' => 'Banner 19',
				'display_title_module' => 0,
				'image' => 'banner19.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-19 col-sm-6',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 21,
				'hook' => Hook::getIdByName('displayBanner20'),
				'title_module' => 'Banner 20',
				'display_title_module' => 0,
				'image' => 'banner20.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-20 col-sm-6',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 22,
				'hook' => Hook::getIdByName('displayBanner21'),
				'title_module' => 'Banner 21',
				'display_title_module' => 0,
				'image' => 'banner21.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-21',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 23,
				'hook' => Hook::getIdByName('displayBanner22'),
				'title_module' => 'Banner 22',
				'display_title_module' => 0,
				'image' => 'banner22.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-22 col-sm-4',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 24,
				'hook' => Hook::getIdByName('displayBanner23'),
				'title_module' => 'Banner 23',
				'display_title_module' => 0,
				'image' => 'banner23.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-23 col-sm-4',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 25,
				'hook' => Hook::getIdByName('displayBanner24'),
				'title_module' => 'Banner 24',
				'display_title_module' => 0,
				'image' => 'banner24.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-24 col-sm-4',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 26,
				'hook' => Hook::getIdByName('displayBanner25'),
				'title_module' => 'Banner 25',
				'display_title_module' => 0,
				'image' => 'banner25.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-25 col-sm-6',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 27,
				'hook' => Hook::getIdByName('displayBanner26'),
				'title_module' => 'Banner 26',
				'display_title_module' => 0,
				'image' => 'banner26.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-26 col-sm-6',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 28,
				'hook' => Hook::getIdByName('displayBanner27'),
				'title_module' => 'Banner 27',
				'display_title_module' => 0,
				'image' => 'banner27.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-27',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			),
			array(
				'active' => 1,
				'id_spbanner' => 30,
				'hook' => Hook::getIdByName('displayBanner28'),
				'title_module' => 'Banner 28',
				'display_title_module' => 0,
				'image' => 'banner28.jpg',
				'content' => '',
				'moduleclass_sfx' => 'banner-28 hidden-md-down',
				'banner_link' => '#',
				'banner_effect' => 'effect-1'
			)
		);
		$return = true;
		foreach ($datas as $i => $data)
		{
			$customs = new SpBannerClass();
			$customs->hook = $data['hook'];
			$customs->active = $data['active'];
			$customs->banner_effect = $data['banner_effect'];
			$customs->ordering = $i;
			$customs->params = serialize($data);
			foreach (Language::getLanguages(false) as $lang)
			{
				$customs->content[$lang['id_lang']] = $data['content'];
				$customs->image[$lang['id_lang']] = $data['image'];
				$customs->title_module[$lang['id_lang']] = $data['title_module'];
				$customs->banner_link[$lang['id_lang']] = $data['banner_link'];
			}
			$return &= $customs->add();
		}
		return $return;
	}

	public function getContent()
	{
		if (Tools::isSubmit ('saveItem') || Tools::isSubmit ('saveAndStay'))
		{
			if ($this->postValidation())
			{
				$this->html .= $this->postProcess();
				$this->html .= $this->initForm();
			}
			else
				$this->html .= $this->initForm();
		}
		elseif (Tools::isSubmit ('addItem') || (Tools::isSubmit('editItem')
				&& $this->moduleExists((int)Tools::getValue('id_spbanner'))) || Tools::isSubmit ('saveItem'))
		{
			if (Tools::isSubmit('addItem'))
				$mode = 'add';
			else
				$mode = 'edit';
			if ($mode == 'add')
			{
				if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL)
					$this->html .= $this->initForm ();
				else
					$this->html .= $this->getShopContextError(null, $mode);
			}
			else
			{
				$associated_shop_ids = SpBannerClass::getAssociatedIdsShop((int)Tools::getValue('id_spbanner'));
				$context_shop_id = (int)Shop::getContextShopID();

				if ($associated_shop_ids === false)
					$this->html .= $this->getShopAssociationError((int)Tools::getValue('id_spbanner'));
				else if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL
					&& in_array($context_shop_id, $associated_shop_ids))
				{
					if (count($associated_shop_ids) > 1)
						$this->html = $this->getSharedSlideWarning();
					$this->html .= $this->initForm();
				}
				else
				{
					$shops_name_list = array();
					foreach ($associated_shop_ids as $shop_id)
					{
						$associated_shop = new Shop((int)$shop_id);
						$shops_name_list[] = $associated_shop->name;
					}
					$this->html .= $this->getShopContextError($shops_name_list, $mode);
				}
			}
		}
		else
		{
			if ($this->postValidation())
			{
				$this->html .= $this->postProcess();
				$this->html .= $this->displayForm ();
			}
			else
				$this->html .= $this->displayForm ();
		}
		return $this->html;
	}
	private function postValidation()
	{	$errors = array();
		if (Tools::isSubmit ('saveItem') || Tools::isSubmit ('saveAndStay'))
		{
			if (!Validate::isInt(Tools::getValue('active')) || (Tools::getValue('active') != 0
					&& Tools::getValue('active') != 1))
				$errors[] = $this->l('Invalid slide state.');
			if (!Validate::isInt(Tools::getValue('position')) || (Tools::getValue('position') < 0))
				$errors[] = $this->l('Invalid slide position.');
			if (Tools::isSubmit('id_spbanner'))
			{
				if (!Validate::isInt(Tools::getValue('id_spbanner'))
					&& !$this->moduleExists(Tools::getValue('id_spbanner')))
					$errors[] = $this->l('Invalid module ID');
			}
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				if (Tools::strlen(Tools::getValue('title_module_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The title is too long.');
				if (Tools::strlen(Tools::getValue('content_'.$language['id_lang'])) > 4000)
					$errors[] = $this->l('The content is too long.');
			}
			$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
			if (Tools::strlen(Tools::getValue('title_module_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The title module is not set.');
			if (Tools::strlen(Tools::getValue('moduleclass_sfx')) > 255)
				$errors[] = $this->l('The Module Class Suffix  is too long.');
			if (!Tools::isSubmit('has_picture') && (!isset($_FILES['image_'.$id_lang_default]) || empty($_FILES['image_'.$id_lang_default]['tmp_name'])))
				$errors[] = $this->l('The image is not set.');
			if (Tools::getValue('image_old_'.$id_lang_default) && !Validate::isFileName(Tools::getValue('image_old_'.$id_lang_default)))
				$errors[] = $this->l('The image is not set.');			
		}elseif (Tools::isSubmit('id_spbanner')
			&& (!Validate::isInt(Tools::getValue('id_spbanner'))
				|| !$this->moduleExists((int)Tools::getValue('id_spbanner'))))
			$errors[] = $this->l('Invalid module ID');
		if (count($errors))
		{
			$this->html .= $this->displayError(implode('<br />', $errors));
			return false;
		}
		return true;
	}

	private function postProcess()
	{
		$currentIndex = AdminController::$currentIndex;
		if (Tools::isSubmit ('saveItem') || Tools::isSubmit ('saveAndStay'))
		{
			if (Tools::getValue('id_spbanner'))
			{
				$spbanner = new SpBannerClass((int)Tools::getValue ('id_spbanner'));
				if (!Validate::isLoadedObject($spbanner))
				{
					$this->html .= $this->displayError($this->l('Invalid slide ID'));
					return false;
				}
			}
			else
				$spbanner = new SpBannerClass();
			$next_ps = $this->getNextPosition();
			$spbanner->ordering = (!empty($spbanner->ordering)) ? (int)$spbanner->ordering : $next_ps;
			$spbanner->active = (Tools::getValue('active')) ? (int)Tools::getValue('active') : 0;
			$spbanner->hook	= (int)Tools::getValue('hook');
			$spbanner->banner_effect	= Tools::getValue('banner_effect');
			$tmp_data = array();
			$id_spbanner = (int)Tools::getValue ('id_spbanner');
			$id_spbanner = $id_spbanner ? $id_spbanner : (int)$spbanner->getHigherModuleID();
			$tmp_data['id_spbanner'] = $id_spbanner;

			$tmp_data['active'] = (int)Tools::getValue ('active', 1);
			$tmp_data['moduleclass_sfx'] = Tools::getValue ('moduleclass_sfx');
			$tmp_data['display_title_module'] = Tools::getValue ('display_title_module');
			$tmp_data['hook '] = Tools::getValue('hook');
			
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
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
					$spbanner->image[$language['id_lang']] = $salt.'_'.$_FILES['image_'.$language['id_lang']]['name'];
				}
				elseif (Tools::getValue('image_old_'.$language['id_lang']) != '')
					$spbanner->image[$language['id_lang']] = Tools::getValue('image_old_'.$language['id_lang']);
					
				$spbanner->title_module[$language['id_lang']] = Tools::getValue('title_module_'.$language['id_lang']);
				$spbanner->banner_link[$language['id_lang']] = Tools::getValue('banner_link_'.$language['id_lang']);
				$spbanner->content[(int)$language['id_lang']] = Tools::getValue ('content_'.$language['id_lang']);
			}
			$spbanner->params = serialize($tmp_data);
			(Tools::getValue ('id_spbanner') && $this->moduleExists((int)Tools::getValue ('id_spbanner')) )? $spbanner->update() : $spbanner->add ();
			$this->clearCacheItemForHook ();
			if (Tools::isSubmit ('saveAndStay'))
			{
				$tool_id_spbanner = Tools::getValue ('id_spbanner');
				$higher_module = $spbanner->getHigherModuleID();
				$id_spbanner = $tool_id_spbanner?(int)$tool_id_spbanner:(int)$higher_module;
				Tools::redirectAdmin ($currentIndex.'&configure='
				.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spbanner='
					.$id_spbanner.'&updateItemConfirmation&conf=4');
			}
			else
				Tools::redirectAdmin ($currentIndex.'&configure='.$this->name
					.'&token='.Tools::getAdminTokenLite ('AdminModules').'&saveItemConfirmation');
		}
		elseif (Tools::isSubmit('changeStatusItem') && Tools::getValue ('id_spbanner'))
		{
			$spbanner = new SpBannerClass((int)Tools::getValue ('id_spbanner'));
			if ($spbanner->active == 0)
				$spbanner->active = 1;
			else
				$spbanner->active = 0;
			$spbanner->update();
			$this->clearCacheItemForHook ();
			Tools::redirectAdmin ($currentIndex.'&configure='.$this->name
				.'&token='.Tools::getAdminTokenLite ('AdminModules'));
		}
		elseif (Tools::isSubmit ('deleteItem') && Tools::getValue ('id_spbanner'))
		{
			$spbanner = new SpBannerClass((int)Tools::getValue ('id_spbanner'));
			$spbanner->delete ();
			$this->clearCacheItemForHook ();
			Tools::redirectAdmin ($currentIndex.'&configure='.$this->name.'&token='
				.Tools::getAdminTokenLite ('AdminModules').'&deleteItemConfirmation');
		}
		elseif (Tools::isSubmit ('duplicateItem') && Tools::getValue ('id_spbanner'))
		{
			$spbanner = new SpBannerClass(Tools::getValue ('id_spbanner'));
			foreach (Language::getLanguages (false) as $lang)
				$spbanner->title_module[(int)$lang['id_lang']] = $spbanner->title_module[(int)$lang['id_lang']]
					.$this->l(' (Copy)');
			$spbanner->duplicate();
			$this->clearCacheItemForHook ();
			Tools::redirectAdmin ($currentIndex.'&configure='.$this->name.'&token='
				.Tools::getAdminTokenLite ('AdminModules').'&duplicateItemConfirmation');
		}
		elseif (Tools::isSubmit ('saveItemConfirmation'))
			$this->html = $this->displayConfirmation ($this->l('Module successfully updated!'));
		elseif (Tools::isSubmit ('deleteItemConfirmation'))
			$this->html = $this->displayConfirmation ($this->l('Module successfully deleted!'));
		elseif (Tools::isSubmit ('duplicateItemConfirmation'))
			$this->html = $this->displayConfirmation ($this->l('Module successfully duplicated!'));
		elseif (Tools::isSubmit ('updateItemConfirmation'))
			$this->html = $this->displayConfirmation ($this->l('Module successfully updated!'));
	}

	private function clearCacheItemForHook()
	{
		$this->_clearCache ('default.tpl');
	}
	public function moduleExists($id_spbanner)
	{
		$req = 'SELECT cs.`id_spbanner` 
				FROM `'._DB_PREFIX_.'spbanner` cs
				WHERE cs.`id_spbanner` = '.(int)$id_spbanner;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}
	public function getNextPosition()
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT MAX(cs.`ordering`) AS `next_position`
			FROM `'._DB_PREFIX_.'spbanner` cs, `'._DB_PREFIX_.'spbanner_shop` css
			WHERE css.`id_spbanner` = cs.`id_spbanner` AND css.`id_shop` = '.(int)$this->context->shop->id
		);

		return (++$row['next_position']);
	}

	private function getGridItems()
	{
		$this->context = Context::getContext ();
		$id_lang = $this->context->language->id;
		$id_shop = $this->context->shop->id;
		$sql = 'SELECT b.`id_spbanner`,  b.`hook`, b.`ordering`, bs.`active`, bl.`title_module`, bl.`content`
			FROM `'._DB_PREFIX_.'spbanner` b
			LEFT JOIN `'._DB_PREFIX_.'spbanner_shop` bs ON (b.`id_spbanner` = bs.`id_spbanner` )
			LEFT JOIN `'._DB_PREFIX_.'spbanner_lang` bl ON (b.`id_spbanner` = bl.`id_spbanner`)
			WHERE bs.`id_shop` = '.(int)$id_shop.' 
			AND bl.`id_lang` = '.(int)$id_lang.'
			ORDER BY b.`ordering`';
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql );
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

	private function displayForm()
	{
		$currentIndex = AdminController::$currentIndex;
		$modules = array();
		$this->html .= $this->headerHTML ();
		if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL)
			$this->html .= $this->getWarningMultishopHtml();
		else if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL)
		{
			$modules = $this->getGridItems ();
			if (!empty($modules))
			{
				foreach ($modules as $key => $mod)
				{
					$associated_shop_ids = SpBannerClass::getAssociatedIdsShop((int)$mod['id_spbanner']);
					if ($associated_shop_ids && count($associated_shop_ids) > 1)
						$modules[$key]['is_shared'] = true;
					else
						$modules[$key]['is_shared'] = false;
				}
			}
		}
		$this->html .= '
	 	<div class="panel">
			<div class="panel-heading">
			'.$this->l('Module Manager').'
			<span class="panel-heading-action">
					<a class="list-toolbar-btn" href="'.$currentIndex.'&configure='.$this->name
			.'&token='.Tools::getAdminTokenLite ('AdminModules').'&addItem">
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
			foreach ($modules as $spbanner)
			{
				$this->html .= '
				<tr id="item_'.$spbanner['id_spbanner'].'" class=" '.( $irow ++ % 2?' ':'' ).'">
					<td class=" 	" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spbanner='
					.$spbanner['id_spbanner'].'\'">'
					.$spbanner['id_spbanner'].'</td>
					<td class=" dragHandle"><div class="dragGroup"><div class="positions">'.$spbanner['ordering']
					.'</div></div></td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&editItem&id_spbanner='.$spbanner['id_spbanner'].'\'">'.$spbanner['title_module']
					.' '.($spbanner['is_shared'] ? '<span class="label color_field"
		style="background-color:#108510;color:white;margin-top:5px;">'.$this->l('Shared').'</span>' : '').'</td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name
					.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spbanner='
					.$spbanner['id_spbanner'].'\'">'
					.( Validate::isInt ($spbanner['hook'])?$this->getHookTitle ($spbanner['hook']):'' ).'</td>
					<td class="  "> <a href="'.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&changeStatusItem&id_spbanner='.$spbanner['id_spbanner'].'&status='
					.$spbanner['active'].'&hook='.$spbanner['hook'].'">'.( $spbanner['active']?'
					<i class="icon-check"></i>':'<i class="icon-remove"></i>' ).'</a> </td>
					<td class="text-right">
						<div class="btn-group-action">
							<div class="btn-group pull-right">
								<a class="btn btn-default" href="'.$currentIndex.'&configure='.$this->name.'&token='
		.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spbanner='.$spbanner['id_spbanner'].'">
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
					.Tools::getAdminTokenLite ('AdminModules').'&duplicateItem&id_spbanner='
					.$spbanner['id_spbanner'].'">
											<i class="icon-copy"></i> '.$this->l('Duplicate').'
										</a>								
									</li>
									<li class="divider"></li>
									<li>
										<a title ="'.$this->l('Delete').'" onclick="return confirm(\''
					.$this->l('Are you sure?').'\');" href="'.$currentIndex
					.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&deleteItem&id_spbanner='
					.$spbanner['id_spbanner'].'">
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
			$this->html .= '<td colspan="5" class="list-empty">
								<div class="list-empty-msg">
									<i class="icon-warning-sign list-empty-icon"></i>
									'.$this->l('No records found').'
								</div>
							</td>';
		}
		$this->html .= '
			</tbody>
			</table>
		</div>';
	}

	public function getHookList()
	{
		$hooks = array();
		foreach ($this->default_hook as $key => $hook)
		{
			$id_hook = Hook::getIdByName ($hook);
			$name_hook = $this->getHookTitle ($id_hook);
			$hooks[$key]['key'] = $id_hook;
			$hooks[$key]['name'] = $name_hook;
		}
		return $hooks;
	}

	public function initForm()
	{
		$default_lang = (int)Configuration::get ('PS_LANG_DEFAULT');
		$hooks = $this->getHookList ();
		$opt_effect = array(
			array(
				'id_option' => 'effect-1',
				'name'      => $this->l('Effect 1')
			),
			array(
				'id_option' => 'effect-2',
				'name'      => $this->l('Effect 2')
			),
			array(
				'id_option' => 'effect-3',
				'name'      => $this->l('Effect 3')
			)
		);		
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
					'name'     => 'title_module',
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
					'name'   => 'active',
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
				),
				array(
					'type' => 'file_lang',
					'label' => $this->l('Banner Image'),
					'name' => 'image',
					'required' => true,
					'lang' => true,
					'class' => 'fixed-width-xl'
				),		
				array(
					'type'  => 'text',
					'label' => $this->l('Banner Link'),
					'name'  => 'banner_link',
					'lang' => true,
					'hint'  => $this->l('Enter the link associated to your banner. When clicking on the banner, the link opens in the same window. If no link is entered, it redirects to the homepage.'),
					'class' => 'fixed-width-xl'
				),				
				array(
					'type'         => 'textarea',
					'label'        => $this->l('Banner  Description'),
					'name'         => 'content',
					'hint'         => $this->l(' Please enter a short but meaningful description for the banner.'),
					'lang'         => true,
					'cols'         => 40,
					'rows'         => 10
				),
				array(
					'type'    => 'select',
					'label'   => $this->l('Effect'),
					'name'    => 'banner_effect',
					'options' => array(
						'query' => $opt_effect,
						'id'    => 'id_option',
						'name'  => 'name'
					),
					'class' => 'fixed-width-xl'
				)				
			),
			'submit'  => array(
				'title' => $this->l('Save')
			),
			'buttons' => array(
				array(
					'title' => $this->l('Save and stay'),
					'name'  => 'saveAndStay',
					'type'  => 'submit',
					'class' => 'btn btn-default pull-right',
					'icon'  => 'process-icon-save'
				)
			)
		);
		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = 'spbanner';
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
		$helper->submit_action = 'saveItem';
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
		$id_spbanner = (int)Tools::getValue ('id_spbanner');

		if (Tools::isSubmit ('id_spbanner') && $id_spbanner)
		{
			$spbanner = new SpBannerClass((int)$id_spbanner);
			$helper->fields_value['id_spbanner'] = Tools::getValue ('id_spbanner', $spbanner->id_spbanner);
			$params = unserialize($spbanner->params);
			$this->fields_form[0]['form']['input'][] = array(
				'type' => 'hidden',
				'name' => 'id_spbanner' );
			$this->fields_form[0]['form']['images'] = $spbanner->image;

			$has_picture = true;

			foreach (Language::getLanguages(false) as $lang)
				if (!isset($spbanner->image[$lang['id_lang']]))
					$has_picture &= false;

			if ($has_picture)
				$this->fields_form[0]['form']['input'][] = array('type' => 'hidden', 'name' => 'has_picture');		
		}
		else
		{
			$spbanner = new SpBannerClass();
			$params = array();
		}
		foreach (Language::getLanguages (false) as $lang)
		{
			$helper->fields_value['title_module'][(int)$lang['id_lang']] = Tools::getValue ('title_module_'
				.(int)$lang['id_lang'],
				$spbanner->title_module[(int)$lang['id_lang']]);
			$helper->fields_value['image'][(int)$lang['id_lang']] = Tools::getValue ('image_'
				.(int)$lang['id_lang'],$spbanner->image[(int)$lang['id_lang']]);				
			$helper->fields_value['content'][(int)$lang['id_lang']] = Tools::getValue ('content_'.(int)$lang['id_lang'],
				$spbanner->content[(int)$lang['id_lang']]);
			$helper->fields_value['banner_link'][(int)$lang['id_lang']] = Tools::getValue ('banner_link_'.(int)$lang['id_lang'],
				$spbanner->banner_link[(int)$lang['id_lang']]);				
		}
		$helper->fields_value['hook'] = Tools::getValue ('hook', $spbanner->hook);
		$helper->fields_value['has_picture'] = true;
		$helper->fields_value['active'] = (int)Tools::getValue('active', $spbanner->active);
		$display_title_module = isset( $params['display_title_module'] ) ? $params['display_title_module'] : 1;
		$helper->fields_value['display_title_module'] = Tools::getValue ('display_title_module', $display_title_module);
		$helper->fields_value['banner_effect'] = Tools::getValue ('banner_effect', $spbanner->banner_effect);		
		$helper->fields_value['moduleclass_sfx'] = Tools::getValue ('moduleclass_sfx',
			isset($params['moduleclass_sfx']) ? $params['moduleclass_sfx'] : '' );
		$helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $this->context->language->id,
				'iso_code' => $this->context->language->iso_code
			),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
			'image_baseurl' => $this->_path.'images/'
		);			
		$this->html .= $helper->generateForm ($this->fields_form);
	}

	private function getItemInHook($hook_name)
	{
		$list = array();
		$this->context = Context::getContext ();
		$id_shop = $this->context->shop->id;
		$id_lang = $this->context->language->id;
		$id_hook = Hook::getIdByName ($hook_name);
		if ($id_hook)
		{
			$sql = 'SELECT * FROM `'._DB_PREFIX_.'spbanner` b
			LEFT JOIN `'._DB_PREFIX_.'spbanner_shop` bs ON (b.`id_spbanner` = bs.`id_spbanner`)
			LEFT JOIN `'._DB_PREFIX_.'spbanner_lang` bl ON (b.`id_spbanner` = bl.`id_spbanner`)
			WHERE bs.`active` = 1 AND (bs.`id_shop` = '.$id_shop.')
			AND (bl.`id_lang` = '.$id_lang.')
			AND b.`hook` = '.( $id_hook ).' ORDER BY b.`ordering`';
			$results = Db::getInstance ()->ExecuteS ($sql);
			foreach ($results as &$row)
			{
				$row['params'] = unserialize($row['params']);
			}
		}
		return $results;
	}

	public function hookHeader()
	{
		$this->context->controller->addCSS ($this->_path.'views/css/style.css', 'all');
	}


	public function hookDisplayBanner()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner2()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner2');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner2');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner3()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner3');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner3');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner4()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner4');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner4');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner5()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner5');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner5');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner6()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner6');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner6');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayBanner7()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner7');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner7');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayBanner8()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner8');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner8');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayBanner9()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner9');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner9');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayBanner10()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner10');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner10');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayBanner11()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner11');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner11');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner12()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner12');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner12');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner13()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner13');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner13');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner14()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner14');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner14');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner15()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner15');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner15');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner16()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner16');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner16');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner17()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner17');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner17');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner18()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner18');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner18');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner19()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner19');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner19');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner20()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner20');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner20');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner21()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner21');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner21');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner22()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner22');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner22');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner23()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner23');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner23');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner24()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner24');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner24');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner25()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner25');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner25');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner26()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner26');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner26');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner27()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner27');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner27');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayBanner28()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayBanner28');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayBanner28');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayLeftColumn()
	{
		$smarty_cache_id = $this->getCacheId ('spbanner_displayLeftColumn');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayLeftColumn');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spbanner/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}


	public function headerHTML()
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
						var order = $(this).sortable("serialize") + "&action=updateSlidesPosition";
							$.ajax({
								type: "POST",
								dataType: "json",
								data:order,
								url:"'._PS_BASE_URL_.__PS_BASE_URI__.'modules/'.$this->name.'/ajax_'.$this->name
			.'.php?secure_key='.$this->secure_key.'",
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
	private function getWarningMultishopHtml()
	{
		if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL)
			return '<p class="alert alert-warning">'.
						$this->l('You cannot manage modules items from a "All Shops" or a "Group Shop" context,
						select directly the shop you want to edit').
					'</p>';
		else
			return '';
	}

	private function getShopContextError($shop_contextualized_name, $mode)
	{
		if (is_array($shop_contextualized_name))
			$shop_contextualized_name = implode('<br/>', $shop_contextualized_name);

		if ($mode == 'edit')
			return '<p class="alert alert-danger">'.
							sprintf($this->l('You can only edit this module from the shop(s) context: %s'),
								$shop_contextualized_name).
					'</p>';
		else
			return '<p class="alert alert-danger">'.
							sprintf($this->l('You cannot add modules from a "All Shops" or a "Group Shop" context')).
					'</p>';
	}

	private function getShopAssociationError($id_spbanner)
	{
		return '<p class="alert alert-danger">'.
			sprintf($this->l('Unable to get module shop association information (id_module: %d)'), (int)$id_spbanner).
				'</p>';
	}


	private function getCurrentShopInfoMsg()
	{
		$shop_info = null;

		if (Shop::isFeatureActive())
		{
			if (Shop::getContext() == Shop::CONTEXT_SHOP)
			$shop_info = sprintf($this->l('The modifications will be applied to shop: %s'), $this->context->shop->name);
			else if (Shop::getContext() == Shop::CONTEXT_GROUP)
				$shop_info = sprintf($this->l('The modifications will be applied to this group: %s'),
					Shop::getContextShopGroup()->name);
			else
				$shop_info = $this->l('The modifications will be applied to all shops and shop groups');

			return '<div class="alert alert-info">'.
						$shop_info.
					'</div>';
		}
		else
			return '';
	}
	private function getSharedSlideWarning()
	{
		return '<p class="alert alert-warning">'.
					$this->l('This module is shared with other shops!
					All shops associated to this module will apply modifications made here').
				'</p>';
	}

	public function hookActionShopDataDuplication($params)
	{
		Db::getInstance ()->execute ('
		INSERT IGNORE INTO `'._DB_PREFIX_.'spbanner_shop` (`id_spbanner`, `id_shop`)
		SELECT `id_spbanner`, '.(int)$params['new_id_shop'].'
		FROM `'._DB_PREFIX_.'spbanner_shop`
		WHERE `id_shop` = '.(int)$params['old_id_shop']);
	}
}
