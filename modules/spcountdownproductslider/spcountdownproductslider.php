<?php
/**
 * package SP Deal
 *
 * @version 1.0.1
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

if (!defined ('_PS_VERSION_'))
	exit;
include_once ( dirname (__FILE__).'/SpCountdownProductSliderClass.php' );

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;

class SpCountdownProductSlider extends Module
{
	protected $categories = array();
	protected $error = false;
	private $html;
	private $default_hook = array( 'displayHome', 'displaycountdownproductslider', 'displaycountdownproductslider2' );

	public function __construct()
	{
		$this->name = 'spcountdownproductslider';
		$this->tab = 'front_office_features';
		$this->version = '1.0.2';
		$this->author = 'MagenTech';
		$this->secure_key = Tools::encrypt ($this->name);
		$this->bootstrap = true;
		parent::__construct ();
		$this->displayName = $this->l('SP Countdown Products Slider.');
		$this->description = $this->l('Display Countdown Products Slider.');
		$this->confirmUninstall = $this->l('Are you sure?');
		$this->ps_versions_compliancy = array('min' => '1.6.1.x', 'max' => _PS_VERSION_);
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
		$spcountdownproductslider = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spcountdownproductslider`')
			&& Db::getInstance ()->Execute ('
				CREATE TABLE '._DB_PREFIX_.'spcountdownproductslider (
				`id_spcountdownproductslider` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`hook` int(10) unsigned,
				`params` text NOT NULL DEFAULT \'\' ,
				`active` tinyint(1) NOT NULL DEFAULT \'1\',
				`ordering` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_spcountdownproductslider`)) ENGINE=InnoDB default CHARSET=utf8');
		$spcountdownproductslider_shop = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spcountdownproductslider_shop`')
			&& Db::getInstance ()->Execute ('
				CREATE TABLE '._DB_PREFIX_.'spcountdownproductslider_shop (
				`id_spcountdownproductslider` int(10) unsigned NOT NULL,
				`id_shop` int(10) unsigned NOT NULL,
				`active` tinyint(1) NOT NULL DEFAULT \'1\',
				 PRIMARY KEY (`id_spcountdownproductslider`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8');
		$spcountdownproductslider_lang = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spcountdownproductslider_lang`')
			&& Db::getInstance ()->Execute ('
				CREATE TABLE '._DB_PREFIX_.'spcountdownproductslider_lang (
				`id_spcountdownproductslider` int(10) unsigned NOT NULL,
				`id_lang` int(10) unsigned NOT NULL,
				`title_module` varchar(255) NOT NULL DEFAULT \'\',
				PRIMARY KEY (`id_spcountdownproductslider`,`id_lang`)) ENGINE=InnoDB default CHARSET=utf8');
		if (!$spcountdownproductslider || !$spcountdownproductslider_shop || !$spcountdownproductslider_lang)
			return false;
		$this->installFixtures();
		return true;
	}
	
	private function _getImageSize($_value_df = 'home_default'){
		$image_pro_types = ImageType::getImagesTypes ('products');
		$flag = true;
		foreach($image_pro_types  as $_image){
			if($flag && $_image['name'] == $_value_df){
				$_value_df = $_image['name'] ;
				$flag = false;
			}
		}
		if ($flag) {
			$product_type = array_shift($image_pro_types);
			$_value_df = $_value = isset($product_type['name']) ?  $product_type['name'] : 'none';	
		}
		return 	$_value_df;
	}

	public function installFixtures()
	{
		$image_pro_types = ImageType::getImagesTypes ('products');
		$product_type = array_shift($image_pro_types);
		$datas = array(
			array(
				'id_spdeal' => 1,
				'title_module' => 'Hot Deal',
				'display_title_module' => '1',
				'moduleclass_sfx' => 'countslider-1',
				'active' => 1,
				'date_from' => '2020-08-19',
				'hook' => Hook::getIdByName('displaycountdownproductslider'),
				'nb_column1' => 3,
				'nb_column2' => 3,
				'nb_column3' => 3,
				'nb_column4' => 2,
				'nb_column5' => 2,
				'target' => 'self',
				'products_ordering' => 'name',
				'ordering_direction' => 'DESC',
				'count_number' => '9',
				'image_size' => $this->_getImageSize('large_default') ,
				'display_name' => 1,
				'name_maxlength' => 50,
				'display_description' => 0,
				'description_maxlength' => 50,
				'display_price' => 1,
				'display_wishlist' => 0,
				'display_compare' => 0,
				'display_addtocart' => 1,
				'display_quickview' => 1,
				'display_availability' => 0,
				'display_variant' => 0,		
				'display_new' => 0,
				'display_sale' => 1,		
				'start_deal' => 0,
				'nav' => 0,
				'scroll' => 1,
				'delay' => 500,
				'duration' => 800,
				'interval' => 2500,
				'autoplay_timeout'	=> 2000,
				'autoplaySpeed'	=> 500,
				'startPosition' => 1,
				'dots' => 1,
				'auto' => 0,
				'pause' => 1,
				'effect' => 'none',
				'swipe' => 1
			),
			array(
				'id_spdeal' => 2,
				'title_module' => 'Hot Deal',
				'display_title_module' => '1',
				'moduleclass_sfx' => 'countslider-2',
				'active' => 1,
				'date_from' => '2020-08-19',
				'hook' => Hook::getIdByName('displaycountdownproductslider2'),
				'nb_column1' => 5,
				'nb_column2' => 4,
				'nb_column3' => 3,
				'nb_column4' => 2,
				'nb_column5' => 2,
				'target' => 'self',
				'products_ordering' => 'name',
				'ordering_direction' => 'ASC',
				'count_number' => '6',
				'image_size' => $this->_getImageSize('home_default') ,
				'display_name' => 1,
				'name_maxlength' => 50,
				'display_description' => 0,
				'description_maxlength' => 50,
				'display_price' => 1,
				'display_wishlist' => 0,
				'display_compare' => 0,
				'display_addtocart' => 1,
				'display_quickview' => 1,
				'display_availability' => 0,
				'display_variant' => 0,	
				'display_new' => 0,
				'display_sale' => 0,			
				'start_deal' => 0,
				'nav' => 0,
				'scroll' => 1,
				'delay' => 500,
				'duration' => 800,
				'interval' => 2500,
				'autoplay_timeout'	=> 2000,
				'autoplaySpeed'	=> 500,
				'startPosition' => 1,
				'dots' => 0,
				'auto' => 0,
				'pause' => 1,
				'effect' => 'none',
				'swipe' => 1
			)
		);

		$return = true;
		foreach ($datas as $i => $data)
		{
			$spcountdownproductslider = new SpCountdownProductSliderClass();
			$spcountdownproductslider->hook = $data['hook'];
			$spcountdownproductslider->active = $data['active'];
			$spcountdownproductslider->ordering = $i;
			$spcountdownproductslider->params = serialize($data);
			foreach (Language::getLanguages(false) as $lang)
				$spcountdownproductslider->title_module[$lang['id_lang']] = $data['title_module'];

			$return &= $spcountdownproductslider->add();
		}
		return $return;
	}
	
	public function uninstall()
	{
		if (parent::uninstall () == false)
			return false;
		if (!Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spcountdownproductslider`')
			|| !Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spcountdownproductslider_shop`')
			|| !Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spcountdownproductslider_lang`'))
			return false;
			$this->clearCacheItemForHook ();
		return true;
	}

	public function getContent()
	{
		if (Tools::isSubmit ('saveItem') || Tools::isSubmit ('saveAndStay') || Tools::isSubmit ('updateItemConfirmation'))
		{
			if ($this->postValidation())
			{
				if (Tools::isSubmit ('updateItemConfirmation') || Tools::isSubmit ('saveItem'))
					$this->html .= $this->displayConfirmation ($this->l('Module successfully updated!'));
				$this->html .= $this->postProcess();
				$this->html .= $this->initForm();
			}
			else
				$this->html .= $this->initForm();
		}
		elseif (Tools::isSubmit ('addItem') || (Tools::isSubmit('editItem')
				&& $this->moduleExists((int)Tools::getValue('id_spcountdownproductslider'))) || Tools::isSubmit ('saveItem'))
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
				$associated_shop_ids = SpCountdownProductSliderClass::getAssociatedIdsShop((int)Tools::getValue('id_spcountdownproductslider'));
				$context_shop_id = (int)Shop::getContextShopID();
				if ($associated_shop_ids === false)
					$this->html .= $this->getShopAssociationError((int)Tools::getValue('id_spcountdownproductslider'));
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
	{
		$errors = array();
		if (Tools::isSubmit ('saveItem') || Tools::isSubmit ('saveAndStay'))
		{
			if (!Validate::isInt(Tools::getValue('active')) || (Tools::getValue('active') != 0
					&& Tools::getValue('active') != 1))
				$errors[] = $this->l('Invalid module state.');
			if (!Validate::isInt(Tools::getValue('position')) || (Tools::getValue('position') < 0))
				$errors[] = $this->l('Invalid module position.');

			if (!Validate::isInt(Tools::getValue('count_number')) || floor (Tools::getValue('count_number')) < 0)
				$errors[] = $this->l('Invalid Count Number.');
			/* Checks date */
			if (!Validate::isDate(Tools::getValue('date_from')))
				$errors[] = Tools::displayError('Invalid \'to\' date');	
			if (Tools::isSubmit('id_spcountdownproductslider'))
			{
				if (!Validate::isInt(Tools::getValue('id_spcountdownproductslider'))
					&& !$this->moduleExists(Tools::getValue('id_spcountdownproductslider')))
					$errors[] = $this->l('Invalid module ID');
			}
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				if (Tools::strlen(Tools::getValue('title_module_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The title is too long.');
			}
			$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
			if (Tools::strlen(Tools::getValue('title_module_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The title module is not set.');
			if (Tools::strlen(Tools::getValue('moduleclass_sfx')) > 255)
				$errors[] = $this->l('The Module Class Suffix  is too long.');

			if (!is_numeric (Tools::getValue('count_number')) || floor (Tools::getValue('count_number')) < 0)
				$errors[] = $this->l('Invalid Count Number.');

			if (!is_numeric (Tools::getValue('start_countdownproduct')) || floor (Tools::getValue('start_countdownproduct')) < 0)
				$errors[] = $this->l('Invalid Start Deal');

			if (!is_numeric (Tools::getValue('autoplaySpeed')) || floor (Tools::getValue('autoplaySpeed')) < 0)
				$errors[] = $this->l('Invalid Autoplay Speed');
				
			if (!is_numeric (Tools::getValue('delay')) || floor (Tools::getValue('delay')) < 0)
				$errors[] = $this->l('Invalid Delay Speed');				

			if (!is_numeric (Tools::getValue('scroll')) || floor (Tools::getValue('scroll')) < 1)
				$errors[] = $this->l('Invalid Step');

			if (!is_numeric (Tools::getValue('autoplay_timeout')) || floor (Tools::getValue('autoplay_timeout')) < 0)
				$errors[] = $this->l('Invalid Autoplay Timeout');

			if (!is_numeric (Tools::getValue('name_maxlength')) || floor (Tools::getValue('name_maxlength')) < 0)
				$errors[] = $this->l('Invalid Name Maxlength');

			if (!is_numeric (Tools::getValue('description_maxlength')) || floor (Tools::getValue('description_maxlength')) < 0)
				$errors[] = $this->l('Invalid Description Maxlength');
		}
		elseif (Tools::isSubmit('id_spcountdownproductslider') && (!Validate::isInt(Tools::getValue('id_spcountdownproductslider'))
				|| !$this->moduleExists((int)Tools::getValue('id_spcountdownproductslider'))))
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
			if (Tools::getValue('id_spcountdownproductslider'))
			{
				$countdownproduct = new SpCountdownProductSliderClass((int)Tools::getValue ('id_spcountdownproductslider'));
				if (!Validate::isLoadedObject($countdownproduct))
				{
					$this->html .= $this->displayError($this->l('Invalid slide ID'));
					return false;
				}
			}
			else
				$countdownproduct = new SpCountdownProductSliderClass();
			$default_lang = (int)Configuration::get ('PS_LANG_DEFAULT');
			$countdownproduct = new SpCountdownProductSliderClass(Tools::getValue ('id_spcountdownproductslider'));
			$next_ps = $this->getNextPosition();
			$countdownproduct->ordering = (!empty($countdownproduct->ordering)) ? (int)$countdownproduct->ordering : $next_ps;
			$countdownproduct->active = (Tools::getValue('active')) ? (int)Tools::getValue('active') : 0;
			$countdownproduct->hook	= (int)Tools::getValue('hook');

			$tmp_data = array();
			$id_spcountdownproductslider = (int)Tools::getValue ('id_spcountdownproductslider');
			$id_spcountdownproductslider = $id_spcountdownproductslider ? $id_spcountdownproductslider : (int)$countdownproduct->getHigherModuleID();
			$tmp_data['id_spcountdownproductslider'] = (int)$id_spcountdownproductslider;
			// general options
			$tmp_data['active'] = (int)Tools::getValue ('active');
			$hook_name = Hook::getNameById((int)Tools::getValue('hook'));
			$tmp_data['hook'] = (string)$hook_name;
			$tmp_data['moduleclass_sfx'] = (string)Tools::getValue ('moduleclass_sfx');
			$tmp_data['display_title_module'] = (int)Tools::getValue ('display_title_module');
			$tmp_data['target'] = (string)Tools::getValue ('target');
			$tmp_data['display_control'] = (int)Tools::getValue ('display_control');
			for ($i = 1; $i < 6; $i ++)
				$tmp_data['nb_column'.$i] = Tools::getValue ('nb_column'.$i);
			// source options
			$tmp_data['date_from'] = (string)Tools::getValue ('date_from');			
			$tmp_data['ordering_direction'] = (string)Tools::getValue ('ordering_direction');
			$tmp_data['products_ordering'] = (string)Tools::getValue ('products_ordering');
			$tmp_data['count_number'] = (int)Tools::getValue ('count_number');
			// product options
			$tmp_data['image_size'] = (string)Tools::getValue ('image_size');
			$tmp_data['display_name'] = (int)Tools::getValue ('display_name');
			$tmp_data['name_maxlength'] = (int)Tools::getValue ('name_maxlength');
			$tmp_data['display_description'] = (int)Tools::getValue ('display_description');
			$tmp_data['description_maxlength'] = (int)Tools::getValue ('description_maxlength');
			$tmp_data['display_price'] = (int)Tools::getValue ('display_price');
			$tmp_data['display_wishlist'] = (int)Tools::getValue ('display_wishlist');
			$tmp_data['display_compare'] = (int)Tools::getValue ('display_compare');
			$tmp_data['display_addtocart'] = (int)Tools::getValue ('display_addtocart');
			$tmp_data['display_quickview'] = (int)Tools::getValue ('display_quickview');
			$tmp_data['display_new'] = (int)Tools::getValue ('display_new', 0);
			$tmp_data['display_sale'] = (int)Tools::getValue ('display_sale', 1);
			$tmp_data['display_availability'] = (int)Tools::getValue ('display_availability');
			$tmp_data['display_variant'] = (int)Tools::getValue ('display_variant');			
			//effect options
			$tmp_data['start_countdownproduct'] = (int)Tools::getValue ('start_countdownproduct');
			$tmp_data['scroll'] = (int)Tools::getValue ('scroll');
			$tmp_data['autoplay'] 	= Tools::getValue ('autoplay');
			$tmp_data['autoplay_timeout'] 		= Tools::getValue ('autoplay_timeout');
			$tmp_data['delay'] 		= Tools::getValue ('delay');
			$tmp_data['display_title_module'] 	= Tools::getValue ('display_title_module');
			$tmp_data['autoplaySpeed'] 			= Tools::getValue ('autoplaySpeed');
			$tmp_data['duration'] 		= Tools::getValue ('duration');
			$tmp_data['effect'] 			= Tools::getValue ('effect');
			$tmp_data['autoplayHoverPause']	= Tools::getValue ('autoplayHoverPause');
			$tmp_data['startPosition'] 		= Tools::getValue ('startPosition');
			$tmp_data['mouseDrag'] 			= Tools::getValue ('mouseDrag');
			$tmp_data['touchDrag'] 			= Tools::getValue ('touchDrag');
			$tmp_data['pullDrag'] 			= Tools::getValue ('pullDrag');
			$tmp_data['dots'] 				= Tools::getValue ('dots');
			$tmp_data['nav'] 				= Tools::getValue ('nav');
			$tmp_data['effect'] 				= Tools::getValue ('effect');
			$tmp_data['loop'] 				= Tools::getValue('loop');
			foreach (Language::getLanguages (false) as $lang)
			{
				$title_value = Tools::getValue ('title_module_'.(int)$lang['id_lang']) ? Tools::getValue ('title_module_'.(int)$lang['id_lang'])
					: Tools::getValue ('title_module_'.$default_lang);
				$countdownproduct->title_module[(int)$lang['id_lang']] = $title_value;
				$tmp_data['title_countdownproduct'][(int)$lang['id_lang']] = Tools::getValue ('title_countdownproduct_'.(int)$lang['id_lang']);
			}

			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				$countdownproduct->title_module[$language['id_lang']] = Tools::getValue('title_module_'.$language['id_lang']);
				$tmp_data['cat_readmore_text'][$language['id_lang']] = Tools::getValue('cat_readmore_text_'.$language['id_lang']);
			}
			$countdownproduct->params = serialize($tmp_data);
			$get_id = Tools::getValue ('id_spcountdownproductslider');
			($get_id && $this->moduleExists($get_id) )? $countdownproduct->update() : $countdownproduct->add ();
			$this->clearCacheItemForHook ();
			if (Tools::isSubmit ('saveAndStay'))
			{
				$id_spcountdownproductslider = Tools::getValue ('id_spcountdownproductslider')?
					(int)Tools::getValue ('id_spcountdownproductslider'):(int)$countdownproduct->getHigherModuleID ();

				Tools::redirectAdmin ($currentIndex.'&configure='
					.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spcountdownproductslider='
					.$id_spcountdownproductslider.'&updateItemConfirmation');
			}
			else
				Tools::redirectAdmin ($currentIndex.'&configure='
					.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules').'&saveItemConfirmation');

		}
		elseif (Tools::isSubmit ('changeStatusItem') && Tools::getValue ('id_spcountdownproductslider'))
		{
			$countdownproduct = new SpCountdownProductSliderClass((int)Tools::getValue ('id_spcountdownproductslider'));
			if ($countdownproduct->active == 0)
				$countdownproduct->active = 1;
			else
				$countdownproduct->active = 0;
			$countdownproduct->update();
			$this->clearCacheItemForHook ();
			Tools::redirectAdmin ($currentIndex.'&configure='.$this->name
				.'&token='.Tools::getAdminTokenLite ('AdminModules'));
		}
		elseif (Tools::isSubmit ('deleteItem') && Tools::getValue ('id_spcountdownproductslider'))
		{
			$countdownproduct = new SpCountdownProductSliderClass(Tools::getValue ('id_spcountdownproductslider'));
			$countdownproduct->delete ();
			$this->clearCacheItemForHook ();
			Tools::redirectAdmin ($currentIndex.'&configure='.$this->name.'&token='
				.Tools::getAdminTokenLite ('AdminModules').'&deleteItemConfirmation');
		}
		elseif (Tools::isSubmit ('duplicateItem') && Tools::getValue ('id_spcountdownproductslider'))
		{
			$countdownproduct = new SpCountdownProductSliderClass(Tools::getValue ('id_spcountdownproductslider'));
			foreach (Language::getLanguages (false) as $lang)
				$countdownproduct->title_module[(int)$lang['id_lang']] = $countdownproduct->title_module[(int)$lang['id_lang']].$this->l('(Copy)');
			$countdownproduct->duplicate ();
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

	public function moduleExists($id_module)
	{
		$req = 'SELECT cs.`id_spcountdownproductslider`
				FROM `'._DB_PREFIX_.'spcountdownproductslider` cs
				WHERE cs.`id_spcountdownproductslider` = '.(int)$id_module;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);
		return ($row);
	}
	public function getNextPosition()
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT MAX(cs.`ordering`) AS `next_position`
			FROM `'._DB_PREFIX_.'spcountdownproductslider` cs, `'._DB_PREFIX_.'spcountdownproductslider_shop` css
			WHERE css.`id_spcountdownproductslider` = cs.`id_spcountdownproductslider`
			AND css.`id_shop` = '.(int)$this->context->shop->id
		);
		return (++$row['next_position']);
	}

	private function getGridItems()
	{
		$this->context = Context::getContext ();
		$id_lang = $this->context->language->id;
		$id_shop = $this->context->shop->id;
		if (!$result = Db::getInstance ()->ExecuteS ('
			SELECT b.`id_spcountdownproductslider`, b.`hook`, b.`ordering`, bs.`active`, bl.`title_module`
			FROM `'._DB_PREFIX_.'spcountdownproductslider` b
			LEFT JOIN `'._DB_PREFIX_.'spcountdownproductslider_shop` bs ON (b.`id_spcountdownproductslider` = bs.`id_spcountdownproductslider`)
			LEFT JOIN `'._DB_PREFIX_.'spcountdownproductslider_lang` bl ON (b.`id_spcountdownproductslider` = bl.`id_spcountdownproductslider`'
			.( $id_shop?'AND bs.`id_shop` = '.$id_shop:' ' ).')
			WHERE bl.`id_lang` = '.(int)$id_lang.( $id_shop?' AND bs.`id_shop` = '.$id_shop:' ' ).'
			ORDER BY b.`ordering`'))
			return false;
		return $result;
	}

	private function getHookTitle($id_hook, $name = false)
	{
		if (!$result = Db::getInstance ()->getRow ('SELECT `name`,`title` FROM `'._DB_PREFIX_.'hook` WHERE `id_hook` = '.$id_hook))
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
					$associated_shop_ids = SpCountdownProductSliderClass::getAssociatedIdsShop((int)$mod['id_spcountdownproductslider']);
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
					<a class="list-toolbar-btn" href="'.$currentIndex
			.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules')
			.'&addItem"><span data-toggle="tooltip" class="label-tooltip" data-original-title="'
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
			foreach ($modules as $mod)
			{
				$this->html .= '
				<tr id="item_'.$mod['id_spcountdownproductslider'].'" class=" '.( $irow ++ % 2?' ':'' ).'">
					<td class=" 	" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spcountdownproductslider='
					.$mod['id_spcountdownproductslider'].'\'">'
					.$mod['id_spcountdownproductslider'].'</td>
					<td class=" dragHandle"><div class="dragGroup"><div class="positions">'.$mod['ordering']
					.'</div></div></td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&editItem&id_spcountdownproductslider='.$mod['id_spcountdownproductslider'].'\'">'
					.$mod['title_module'].' '
					.($mod['is_shared'] ? '<span class="label color_field"
				style="background-color:#108510;color:white;margin-top:5px;">'.$this->l('Shared').'</span>' : '').'</td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&editItem&id_spcountdownproductslider='.$mod['id_spcountdownproductslider'].'\'">'
					.( Validate::isInt ($mod['hook'])?$this->getHookTitle ($mod['hook']):'' ).'</td>
					<td class="  "> <a href="'.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&changeStatusItem&id_spcountdownproductslider='
					.$mod['id_spcountdownproductslider'].'&status='
					.$mod['active'].'&hook='.$mod['hook'].'">'
					.( $mod['active']?'<i class="icon-check"></i>':'<i class="icon-remove"></i>' ).'</a> </td>
					<td class="text-right">
						<div class="btn-group-action">
							<div class="btn-group pull-right">
								<a class="btn btn-default" href="'.$currentIndex.'&configure='
					.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spcountdownproductslider='
					.$mod['id_spcountdownproductslider'].'">
									<i class="icon-pencil"></i> Edit
								</a>
								<button data-toggle="dropdown" class="btn btn-default dropdown-toggle">
									<span class="caret"></span>&nbsp;
								</button>
								<ul class="dropdown-menu">
									<li>
									<a onclick="return confirm(\''.$this->l('Are you sure want duplicate this item?'
						).'\');"  title="'.$this->l('Duplicate').'" href="'
					.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&duplicateItem&id_spcountdownproductslider='
					.$mod['id_spcountdownproductslider'].'">
											<i class="icon-copy"></i> '.$this->l('Duplicate').'
										</a>
									</li>
									<li class="divider"></li>
									<li>
										<a title ="'.$this->l('Delete')
					.'" onclick="return confirm(\''.$this->l('Are you sure?'
						).'\');" href="'.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&deleteItem&id_spcountdownproductslider='
					.$mod['id_spcountdownproductslider'].'">
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

	protected function generateCategoriesOption($categories, $current = null, $id_selected = 1)
	{
		foreach ($categories as $category)
		{
			$this->categories[$category['id_category']] = str_repeat(' -|- ', $category['level_depth'] * 1)
				.Tools::stripslashes($category['name']);
			if (isset($category['children']) && !empty($category['children']))
			{
				$current = $category['id_category'];
				$this->generateCategoriesOption($category['children'], $current, $id_selected);
			}
		}
	}
	public function customGetNestedCategories($shop_id, $root_category = null, $id_lang = false, $active = true,
	$groups = null, $use_shop_restriction = true, $sql_filter = '', $sql_sort = '', $sql_limit = '')
	{
		if (isset($root_category) && !Validate::isInt($root_category))
			die(Tools::displayError());
		if (!Validate::isBool($active))
			die(Tools::displayError());
		if (isset($groups) && Group::isFeatureActive() && !is_array($groups))
			$groups = (array)$groups;
		$cache_id = 'Category::getNestedCategories_'.md5((int)$shop_id
				.(int)$root_category.(int)$id_lang.(int)$active.(int)$active
				.(isset($groups) && Group::isFeatureActive() ? implode('', $groups) : ''));
		if (!Cache::isStored($cache_id))
		{
			$result = Db::getInstance()->executeS('
				SELECT c.*, cl.*
				FROM `'._DB_PREFIX_.'category` c
				INNER JOIN `'._DB_PREFIX_.'category_shop` category_shop
				ON (category_shop.`id_category` = c.`id_category` AND category_shop.`id_shop` = "'.(int)$shop_id.'")
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
				ON (c.`id_category` = cl.`id_category` AND cl.`id_shop` = "'.(int)$shop_id.'")
				WHERE 1 '.$sql_filter.' '.($id_lang ? 'AND cl.`id_lang` = '.(int)$id_lang : '').'
				'.($active ? ' AND (c.`active` = 1 OR c.`is_root_category` = 1)' : '').'
			'.(isset($groups) && Group::isFeatureActive() ? ' AND cg.`id_group` IN ('.implode(',', $groups).')' : '').'
				'.(!$id_lang || (isset($groups) && Group::isFeatureActive()) ? ' GROUP BY c.`id_category`' : '').'
				'.($sql_sort != '' ? $sql_sort : ' ORDER BY c.`level_depth` ASC , c.`nleft` ASC').'
				'.($sql_sort == '' && $use_shop_restriction ? ', category_shop.`position` ASC' : '').'
				'.($sql_limit != '' ? $sql_limit : '')
			);

			$categories = array();
			$buff = array();
			foreach ($result as $row)
			{
				$current = &$buff[$row['id_category']];
				$current = $row;
				if ($row['id_parent'] == 0)
					$categories[$row['id_category']] = &$current;
				else
					$buff[$row['id_parent']]['children'][$row['id_category']] = &$current;
			}
			Cache::store($cache_id, $categories);
		}
		return Cache::retrieve($cache_id);
	}

	private function descFormHtml($text = null)
	{
		return array(
			'type'         => 'html',
			'name'         => 'description',
			'html_content' => '<div style="text-transform:uppercase;width:400px;color:#3586ae;
				padding:3px 5px; border-radius:2px;background-color:#edf7fb;">
					<i class="icon-question-sign"></i>  '.$text.'</div>',
		);
	}
	public function getCatSelect($default = false)
	{
		$shops_to_get = Shop::getContextListShopID();
		foreach ($shops_to_get as $shop_id)
			$this->generateCategoriesOption($this->customGetNestedCategories($shop_id, null, (int)$this->context->language->id, true));
		$catopt = array();
		if (!empty( $this->categories ))
		{
			foreach ($this->categories as $key => $cat)
			{
				if ($cat !== 'Root')
				{
					if ($default)
						$catopt[] = $key;
					else
					{
						$tmp = array();
						if ($cat != '')
						{
							$tmp['id_option'] = $key;
							$tmp['name'] = $cat;
							$catopt[] = $tmp;
						}
					}
				}
			}
		}
		return $catopt;
	}

	public function initForm()
	{
		$image_pro_types = ImageType::getImagesTypes ('products');
		array_push ($image_pro_types, array( 'name' => 'none' ));
		$default_lang = (int)Configuration::get ('PS_LANG_DEFAULT');
		$shops_to_get = Shop::getContextListShopID();
		foreach ($shops_to_get as $shop_id)
			$this->generateCategoriesOption($this->customGetNestedCategories($shop_id, null, (int)$this->context->language->id, true));

		$hooks = $this->getHookList ();
		$opt_column = array(
			array(
				'id_option' => 1,
				'name'      => 1
			),
			array(
				'id_option' => 2,
				'name'      => 2
			),
			array(
				'id_option' => 3,
				'name'      => 3
			),
			array(
				'id_option' => 4,
				'name'      => 4
			),
			array(
				'id_option' => 5,
				'name'      => 5
			),
			array(
				'id_option' => 6,
				'name'      => 6
			)
		);
		$opt_target = array(
			array(
				'id_option' => '_blank',
				'name'      => $this->l('New Window')
			),
			array(
				'id_option' => '_self',
				'name'      => $this->l('Same Window')
			),
			array(
				'id_option' => '_windowopen',
				'name'      => $this->l('Popup window')
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
					'name'     => 'title_module',
					'lang' => true,
					'class'    => 'fixed-width-xl'
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display Title'),
					'name'   => 'display_title_module',
					'hint'   => $this->l('Allow show/hide title of module.'),
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
					'type'  => 'text',
					'label' => $this->l('Module Class Suffix'),
					'name'  => 'moduleclass_sfx',
					'hint'  => $this->l('A suffix to be applied to the CSS class of the module.
					This allows for individual module styling.'),
					'class' => 'fixed-width-xl'
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Status'),
					'name'   => 'active',
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
					'options' => array(
						'query' => $hooks,
						'id'    => 'key',
						'name'  => 'name'
					)
				),
				array(
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('# Column'),
					'name'    => 'nb_column1',
					'desc'    => $this->l('For devices have screen width from 1920px to greater.'),
					'options' => array(
						'query' => $opt_column,
						'id'    => 'id_option',
						'name'  => 'name'
					)
				),
				array(
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('# Column'),
					'name'    => 'nb_column2',
					'desc'    => $this->l('For devices have screen width from 1200px up to 1400px.'),
					'options' => array(
						'query' => $opt_column,
						'id'    => 'id_option',
						'name'  => 'name'
					)
				),
				array(
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('# Column'),
					'name'    => 'nb_column3',
					'desc'    => $this->l('For devices have screen width from 992px up to 1199px.'),
					'class'   => 'fixed-width-xl',
					'options' => array(
						'query' => $opt_column,
						'id'    => 'id_option',
						'name'  => 'name'
					)
				),
				array(
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('# Column'),
					'name'    => 'nb_column4',
					'desc'    => $this->l('For devices have screen width from 768px up to 991px.'),
					'class'   => 'fixed-width-xl',
					'options' => array(
						'query' => $opt_column,
						'id'    => 'id_option',
						'name'  => 'name'
					)
				),
				array(
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('# Column'),
					'name'    => 'nb_column5',
					'desc'    => $this->l('For devices have screen width from 480px up to 767px.'),
					'class'   => 'fixed-width-xl',
					'options' => array(
						'query' => $opt_column,
						'id'    => 'id_option',
						'name'  => 'name'
					)
				),
				array(
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('Open Link'),
					'name'    => 'target',
					'hint'    => $this->l('The Type shows when you click on the link.'),
					'class'   => 'fixed-width-xl',
					'options' => array(
						'query' => $opt_target,
						'id'    => 'id_option',
						'name'  => 'name'
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display Control Button'),
					'name'   => 'display_control',
					'hint'   => 'Allow to show/hide button',
					'class'  => 'fixed-width-xl',
					'values' => array(
						array(
							'id'    => 'dis_ctr_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'dis_ctr_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
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

		$this->fields_form[1]['form'] = array(
			'legend'  => array(
				'title' => $this->l('Source Options '),
				'icon'  => 'icon-cogs'
			),
			'input'   => array(
				array(
					'type' => 'date',
					'label' => $this->l('To'),
					'name' => 'date_from',
					'maxlength' => 10,
					'required' => true,
					'hint' => $this->l('Format: 2015-10-30 (inclusive).')
				),				
				array(
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('Product Field to Order By'),
					'name'    => 'products_ordering',
					'hint'    => $this->l('Choose the position for showing button.'),
					'class'   => 'fixed-width-xl',
					'options' => array(
						'query' => array(
							array(
								'id_option' => 'name',
								'name'      => $this->l('Name')
							),
							array(
								'id_option' => 'id_product',
								'name'      => $this->l('ID')
							),
							array(
								'id_option' => 'date_add',
								'name'      => $this->l('Date Add')
							),
							array(
								'id_option' => 'price',
								'name'      => $this->l('Price')
							),
							array(
								'id_option' => 'sales',
								'name'      => $this->l('Sales')
							),
							array(
								'id_option' => 'rand',
								'name'      => $this->l('Random')
							)
						),
						'id'    => 'id_option',
						'name'  => 'name'
					)
				),
				array(
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('Ordering Direction'),
					'name'    => 'ordering_direction',
					'hint'    => $this->l('Select the direction you would like Products.'),
					'class'   => 'fixed-width-xl',
					'options' => array(
						'query' => array(
							array(
								'id_option' => 'DESC',
								'name'      => $this->l('Descending')
							),
							array(
								'id_option' => 'ASC',
								'name'      => $this->l('Ascending')
							),
						),
						'id'    => 'id_option',
						'name'  => 'name'
					)
				),
				array(
					'type'  => 'text',
					'label' => $this->l('Count'),
					'name'  => 'count_number',
					'hint'  => $this->l('Define the number of products to be displayed in this block.'),
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

		$this->fields_form[2]['form'] = array(
			'legend'  => array(
				'title' => $this->l('Product Options '),
				'icon'  => 'icon-cogs'
			),
			'input'   => array(
				array(
					'type'    => 'select',
					'label'   => $this->l('Size image (W x H)'),
					'name'    => 'image_size',
					'options' => array(
						'query' => $image_pro_types,
						'id'    => 'name',
						'name'  => 'name'
					)
				),
				array(
					'type'    => 'switch',
					'label'   => $this->l('Display Name'),
					'name'    => 'display_name',
					'hint'    => $this->l('Allow to show/hide name of product'),
					'is_bool' => true,
					'values'  => array(
						array(
							'id'    => 'avatar_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'avatar_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'  => 'text',
					'label' => $this->l('Name Maxlength'),
					'name'  => 'name_maxlength',
					'class' => 'fixed-width-xl',
					'hint'  => $this->l('The max length of title can be showed. Choose 0 for showing full title.')
				),
				array(
					'type'    => 'switch',
					'label'   => $this->l('Display Description'),
					'name'    => 'display_description',
					'hint'    => $this->l('Allow to show/hide description of product'),
					'is_bool' => true,
					'values'  => array(
						array(
							'id'    => 'avatar_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'avatar_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'  => 'text',
					'label' => $this->l('Description Maxlength'),
					'name'  => 'description_maxlength',
					'class' => 'fixed-width-xl',
					'hint'  => $this->l('The max length of description can be showed. Choose 0 for showing full description.')
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display Price'),
					'name'   => 'display_price',
					'hint'   => $this->l('Allow to show/hide Price of product'),
					'values' => array(
						array(
							'id'    => 'price_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'price_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display Add to Cart Button'),
					'name'   => 'display_addtocart',
					'hint'   => $this->l('Allow to show/hide button Addtocart of product'),
					'values' => array(
						array(
							'id'    => 'addcart_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'addcart_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display Add to Wishlist Button'),
					'name'   => 'display_wishlist',
					'hint'   => $this->l('Allow to show/hide button Wishlist of product'),
					'values' => array(
						array(
							'id'    => 'on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display Add to Compare Button'),
					'name'   => 'display_compare',
					'hint'   => $this->l('Allow to show/hide button Compare of product'),
					'values' => array(
						array(
							'id'    => 'on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display QuickView'),
					'name'   => 'display_quickview',
					'hint'   => $this->l('Allow to show/hide button QuickView'),
					'values' => array(
						array(
							'id'    => 'detail_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'detail_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display Availability'),
					'name'   => 'display_availability',
					'hint'   => $this->l('Allow to show/hide Availability'),
					'values' => array(
						array(
							'id'    => 'availability_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'availability_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display Variant'),
					'name'   => 'display_variant',
					'hint'   => $this->l('Allow to show/hide Variant'),
					'values' => array(
						array(
							'id'    => 'variant_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'variant_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),					
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display New'),
					'name'   => 'display_new',
					'hint'   => $this->l('Allow to show/hide image New'),
					'values' => array(
						array(
							'id'    => 'new_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'new_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display Sale'),
					'name'   => 'display_sale',
					'hint'   => $this->l('Allow to show/hide image Sale'),
					'values' => array(
						array(
							'id'    => 'sale_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'sale_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
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

		$this->fields_form[3]['form'] = array(
			'legend'  => array(
				'title' => $this->l('Effect Options'),
				'icon'  => 'icon-cogs'
			),
			'input'   => array(
				array(
					'type'  => 'text',
					'label' => $this->l('Start Deal'),
					'name'  => 'start_countdownproduct',
					'class' => 'fixed-width-xl'
				),
				array(
					'type'  => 'text',
					'label' => $this->l('Step'),
					'name'  => 'scroll',
					'class' => 'fixed-width-xl'
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
					'label'  => $this->l('Delay'),
					'name'   => 'delay',
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
					'type'   => 'text',
					'label'  => $this->l('Duration'),
					'name'   => 'duration',
					'class'  => 'fixed-width-xl',
					'hint'   => 'Duration.',
					'suffix' => 'ms',
				),				
				array(
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('Effect'),
					'name'    => 'effect',
					'hint'    => $this->l('Choose the effect for the module here.'),
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
		$helper->name_controller = 'spcountdownproductslider';
		$helper->identifier = $this->identifier;
		$helper->token = Tools::getAdminTokenLite ('AdminModules');
		$helper->show_cancel_button = true;
		$helper->back_url = AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules');
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
			'save'          => array(
				'desc' => $this->l('Save'),
			'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules')
			),
			'back' => array(
				'href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules'),
				'desc' => $this->l('Back to list')
			),
			'save-and-stay' => array(
				'title' => $this->l('Save then add another value'),
				'name'  => 'submitAdd'.$this->table.'AndStay',
				'type'  => 'submit',
				'class' => 'btn btn-default pull-right',
				'icon'  => 'process-icon-save'
			)
		);
		$id_spcountdownproductslider = Tools::getValue ('id_spcountdownproductslider');
		if (Tools::isSubmit ('id_spcountdownproductslider') && $id_spcountdownproductslider)
		{
			$countdownproduct = new SpCountdownProductSliderClass((int)$id_spcountdownproductslider);
			$this->fields_form[0]['form']['input'][] = array(
				'type' => 'hidden',
				'name' => 'id_spcountdownproductslider'
			);
			$params = unserialize($countdownproduct->params);
			$helper->fields_value['id_spcountdownproductslider'] = (int)Tools::getValue ('id_spcountdownproductslider',
				$countdownproduct->id_spcountdownproductslider);
		}
		else
		{
			$countdownproduct = new SpCountdownProductSliderClass();
			$params = array();
		}
		// general options
		foreach (Language::getLanguages (false) as $lang)
		{
			$helper->fields_value['title_module'][(int)$lang['id_lang']] = Tools::getValue ('title_module_'.(int)$lang['id_lang'],
				$countdownproduct->title_module[(int)$lang['id_lang']]);
		}
		$helper->fields_value['hook'] = (string)Tools::getValue ('hook', $countdownproduct->hook);
		$helper->fields_value['active'] = (int)Tools::getValue ('active', $countdownproduct->active);
		$helper->fields_value['display_title_module'] = (int)Tools::getValue ('display_title_module',
			isset( $params['display_title_module'] )?$params['display_title_module']:1);

		$helper->fields_value['nb_column1'] = (int)Tools::getValue ('nb_column1', isset( $params['nb_column1'] )?$params['nb_column1']:6);
		$helper->fields_value['nb_column2'] = (int)Tools::getValue ('nb_column2', isset( $params['nb_column2'] )?$params['nb_column2']:4);
		$helper->fields_value['nb_column3'] = (int)Tools::getValue ('nb_column3', isset( $params['nb_column3'] )?$params['nb_column3']:2);
		$helper->fields_value['nb_column4'] = (int)Tools::getValue ('nb_column4', isset( $params['nb_column4'] )?$params['nb_column4']:1);
		$helper->fields_value['nb_column5'] = (int)Tools::getValue ('nb_column5', isset( $params['nb_column5'] )?$params['nb_column5']:1);
		$helper->fields_value['moduleclass_sfx'] = (string)Tools::getValue ('moduleclass_sfx',
			isset( $params['moduleclass_sfx'] )?$params['moduleclass_sfx']:'');
		$helper->fields_value['target'] = (string)Tools::getValue ('target',
			isset( $params['target'] )?$params['target']:'_self');
		$helper->fields_value['display_control'] = (int)Tools::getValue ('display_control',
			isset( $params['display_control'] )?$params['display_control']:1);
		$helper->fields_value['display_title_countdownproduct'] = (int)Tools::getValue ('display_title_countdownproduct',
			isset( $params['display_title_countdownproduct'] )?$params['display_title_countdownproduct']:1);
		//source options
		$helper->fields_value['products_ordering'] = (string)Tools::getValue ('products_ordering',
			( isset( $params['products_ordering'] ) )?$params['products_ordering']:'name');
		$helper->fields_value['date_from'] = (string)Tools::getValue ('date_from',
			( isset( $params['date_from'] ) )?$params['date_from']:'');			
		$helper->fields_value['ordering_direction'] = (string)Tools::getValue ('ordering_direction',
			( isset( $params['ordering_direction'] ) )?$params['ordering_direction']:'DESC');
		$helper->fields_value['count_number'] = (int)Tools::getValue ('count_number', isset( $params['count_number'] )?$params['count_number']:8);
		// product options
		$helper->fields_value['image_size'] = Tools::getValue ('image_size', ( isset( $params['image_size'] ) )?$params['image_size']:'');
		$helper->fields_value['display_name'] = (int)Tools::getValue ('display_name', isset( $params['display_name'] )?$params['display_name']:1);
		$helper->fields_value['name_maxlength'] = (int)Tools::getValue ('name_maxlength',
			isset( $params['name_maxlength'] )?$params['name_maxlength']:25);
		$helper->fields_value['display_description'] = (int)Tools::getValue ('display_description',
			isset( $params['display_description'] )?$params['display_description']:0);
		$helper->fields_value['description_maxlength'] = (int)Tools::getValue ('description_maxlength',
			isset( $params['description_maxlength'] )?$params['description_maxlength']:100);
		$helper->fields_value['display_price'] = (int)Tools::getValue ('display_price', isset( $params['display_price'] )?$params['display_price']:1);
		$helper->fields_value['display_addtocart'] = (int)Tools::getValue ('display_addtocart',
			isset( $params['display_addtocart'] )?$params['display_addtocart']:1);
		$helper->fields_value['display_wishlist'] = (int)Tools::getValue ('display_wishlist',
			isset( $params['display_wishlist'] )?$params['display_wishlist']:0);
		$helper->fields_value['display_compare'] = (int)Tools::getValue ('display_compare',
			isset( $params['display_compare'] )?$params['display_compare']:0);
		$helper->fields_value['display_quickview'] = (int)Tools::getValue ('display_quickview',
			isset( $params['display_quickview'] )?$params['display_quickview']:1);
		$helper->fields_value['display_availability'] = (int)Tools::getValue ('display_availability',
			isset( $params['display_availability'] )?$params['display_availability']:1);
		$helper->fields_value['display_variant'] = (int)Tools::getValue ('display_variant',
			isset( $params['display_variant'] )?$params['display_variant']:1);			
		$helper->fields_value['display_new'] = (int)Tools::getValue ('display_new', ( isset( $params['display_new'] ) )?$params['display_new']:0);
		$helper->fields_value['display_sale'] = (int)Tools::getValue ('display_sale', ( isset( $params['display_sale'] ) )?$params['display_sale']:1);
		// effect options
		$helper->fields_value['start_countdownproduct'] = (int)Tools::getValue ('start_countdownproduct',
			isset( $params['start_countdownproduct'] )?$params['start_countdownproduct']:1);
		$helper->fields_value['scroll'] = (int)Tools::getValue ('scroll',
			isset( $params['scroll'] )?$params['scroll']:1);
			
		$helper->fields_value['active'] 			= (isset($spgroup->active)) ? $spgroup->active : 1;
		$helper->fields_value['moduleclass_sfx'] 	= (isset($params['moduleclass_sfx']) && $params['moduleclass_sfx']) ? $params['moduleclass_sfx'] : '';
		$helper->fields_value['autoplay'] 				= (isset($params['autoplay'])) ? $params['autoplay'] : '1';
		$helper->fields_value['autoplay_timeout'] 		= (isset($params['autoplay_timeout']) && $params['autoplay_timeout']) ? $params['autoplay_timeout'] : '2000';
		$helper->fields_value['delay'] 					= (isset($params['delay']) && $params['delay']) ? $params['delay'] : '500';
		$helper->fields_value['autoplaySpeed'] 			= (isset($params['autoplaySpeed']) && $params['autoplaySpeed']) ? $params['autoplaySpeed'] : '2000';
		$helper->fields_value['duration'] 				= (isset($params['duration'])) ? $params['duration'] : '1';
		$helper->fields_value['startPosition'] 			= (isset($params['startPosition']) && $params['startPosition']) ? $params['startPosition'] : '0';
		$helper->fields_value['mouseDrag'] 				= (isset($params['mouseDrag'])) ? $params['mouseDrag'] : '1';
		$helper->fields_value['autoplayHoverPause'] 		= (isset($params['autoplayHoverPause'])) ? $params['autoplayHoverPause'] : '1';
		$helper->fields_value['touchDrag'] 				= (isset($params['touchDrag']) ) ? $params['touchDrag'] : '1';
		$helper->fields_value['pullDrag'] 				= (isset($params['pullDrag']) ) ? $params['pullDrag'] : '1';
		$helper->fields_value['dots'] 					= (isset($params['dots'])) ? $params['dots'] : '1';
		$helper->fields_value['nav'] 						= (isset($params['nav'])) ? $params['nav'] : '1';
		$helper->fields_value['effect'] 					= (isset($params['effect']) && $params['effect']) ? $params['effect'] : 'none';
		$helper->fields_value['display_title_module'] 	= (isset($params['display_title_module'])) ? $params['display_title_module'] : 1;
		$helper->fields_value['loop'] 					= (isset($params['loop'])) ? $params['loop'] : 1;
		$this->html .= $helper->generateForm ($this->fields_form);
	}

	private function getData($params)
	{
		$oder_by = $params['products_ordering'];
		$order_way = $params['ordering_direction'];
		$start = 0;
		$limit = (int)$params['count_number'];

		$products = $this->getProducts ((int)$this->context->language->id, $start, $limit, $oder_by, $order_way, true);
		
		if (empty( $products ))
			return;
		
		$list = array();
		$assembler = new ProductAssembler($this->context);
		
		$presenterFactory = new ProductPresenterFactory($this->context);
		$presentationSettings = $presenterFactory->getPresentationSettings();
		$presenter = new ProductListingPresenter(
			new ImageRetriever(
				$this->context->link
			),
			$this->context->link,
			new PriceFormatter(),
			new ProductColorsRetriever(),
			$this->context->getTranslator()
		);

		foreach ($products as $product)
		{
			$obj = new Product(( $product['id_product'] ), false, $this->context->language->id);

			if (strtotime ($product['specific_prices']['from']) != false && strtotime ($product['specific_prices']['to']) != false)
			{
				$date_from = (isset($params['date_from']) && $params['date_from']) ? date ('Y-m-d H:i:s', strtotime ($params['date_from'])) : '';			
				$current = date ('Y-m-d H:i:s');
				$start_date = date ('Y-m-d H:i:s', strtotime ($product['specific_prices']['from']));
				$date_end = date ('Y-m-d H:i:s', strtotime ($product['specific_prices']['to']));
				if (strtotime ($date_end) >= strtotime ($date_from))
					$date_end = $date_from;
				if (strtotime ($date_end) >= strtotime ($current) && strtotime ($start_date) <= strtotime ($date_end))
					$list[] = $presenter->present(
						$presentationSettings,
						$assembler->assembleProduct($product),
						$this->context->language
					);
			}
		}
		
		return $list;
	}

	public function getProducts($id_lang, $start, $limit, $order_by, $order_way,
		$only_active = false, Context $context = null)
	{
		if (!$context)
			$context = Context::getContext ();

		$front = true;
		if (!in_array ($context->controller->controller_type, array( 'front', 'modulefront' )))
			$front = false;

		if (!Validate::isOrderBy ($order_by) || !Validate::isOrderWay ($order_way))
			die ( Tools::displayError () );
		if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add' || $order_by == 'date_upd')
			$order_by_prefix = 'p';
		else if ($order_by == 'name')
			$order_by_prefix = 'pl';
		else if ($order_by == 'position')
			$order_by_prefix = 'c';

		if (strpos ($order_by, '.') > 0)
		{
			$order_by = explode ('.', $order_by);
			$order_by_prefix = $order_by[0];
			$order_by = $order_by[1];
		}
		if ($order_by == 'sales' || $order_by == 'rand')
			$order_by_prefix = '';
		$specific_price = $this->getProductsSpecialPrice ();
		if (!empty( $specific_price ))
			$specific_price = implode (',', $specific_price);
		else
			return;
		$sql = 'SELECT DISTINCT  p.`id_product`, p.*, product_shop.*, pl.* , m.`name` AS manufacturer_name, s.`name` AS supplier_name,
				MAX(product_attribute_shop.id_product_attribute) id_product_attribute,  MAX(image_shop.`id_image`) id_image,
				il.`legend`, ps.`quantity` AS sales, cl.`link_rewrite` AS category, IFNULL(stock.quantity,0) as quantity,
				IFNULL(pa.minimal_quantity, p.minimal_quantity) as minimal_quantity, stock.out_of_stock,
				product_shop.`on_sale`
				FROM `'._DB_PREFIX_.'product` p
				'.Shop::addSqlAssociation ('product', 'p').'
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` '.Shop::addSqlRestrictionOnLang ('pl').')
				LEFT JOIN `'._DB_PREFIX_.'product_sale` ps ON (p.`id_product` = ps.`id_product` '.Shop::addSqlAssociation ('product_sale', 'ps').')
				LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product`)
				'.Shop::addSqlAssociation ('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
				'.Product::sqlStock ('p', 'product_attribute_shop', false, $context->shop).'
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
				ON cl.`id_category` = product_shop.`id_category_default`
				AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang ('cl').'
				LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'.
			Shop::addSqlAssociation ('image', 'i', false, 'image_shop.cover=1').'
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
				LEFT JOIN `'._DB_PREFIX_.'supplier` s ON (s.`id_supplier` = p.`id_supplier`)
				WHERE pl.`id_lang` = '.(int)$id_lang.
			( $front?' AND product_shop.`visibility` IN ("both", "catalog")':'' ).
			( $only_active?' AND product_shop.`active` = 1':'' ).'
			AND  p.`id_product` IN ('.$specific_price.')
				GROUP BY  p.`id_product`
				ORDER BY '.( isset( $order_by_prefix )?( ( $order_by_prefix != '' )?pSQL ($order_by_prefix).'.':'' ):'' )
			.( $order_by == 'rand'?' rand() ':'`'.pSQL ($order_by).'`' ).pSQL ($order_way).
			( $limit > 0?' LIMIT '.(int)$start.','.(int)$limit:'' );
		$rq = Db::getInstance (_PS_USE_SQL_SLAVE_)->executeS ($sql);
		if ($order_by == 'price')
			Tools::orderbyPrice ($rq, $order_way);
		$products_ids = array();
		foreach ($rq as $row)
			$products_ids[] = $row['id_product'];

		Product::cacheFrontFeatures ($products_ids, $id_lang);
		return Product::getProductsProperties ((int)$id_lang, $rq);
	}

	private function getProductsSpecialPrice()
	{
		$results = Db::getInstance (_PS_USE_SQL_SLAVE_)->executeS ('
			SELECT DISTINCT  id_product
			FROM `'._DB_PREFIX_.'specific_price`');
		$product_ids = array();
		if (!empty( $results ))
		{
			foreach ($results as $res)
				$product_ids[] = $res['id_product'];
		}
		return $product_ids;
	}

	private function getItemInHook($hook_name)
	{
		$list = array();
		$this->context = Context::getContext ();
		$id_shop = $this->context->shop->id;
		$id_hook = Hook::getIdByName ($hook_name);
		if ($id_hook)
		{
			$results = Db::getInstance ()->ExecuteS ('
			SELECT b.`id_spcountdownproductslider`
			FROM `'._DB_PREFIX_.'spcountdownproductslider` b
			LEFT JOIN `'._DB_PREFIX_.'spcountdownproductslider_shop` bs ON (b.`id_spcountdownproductslider` = bs.`id_spcountdownproductslider`)
			WHERE bs.`active` = 1 AND (bs.`id_shop` = '.$id_shop.') AND b.`hook` = '.( $id_hook ).'
			ORDER BY b.`ordering`');

			foreach ($results as $row)
			{
				$temp = new SpCountdownProductSliderClass($row['id_spcountdownproductslider']);
				$temp->params = unserialize($temp->params);
				$temp->products = $this->getData ($temp->params);
				$list[] = $temp;
			}
		}
		
		if (empty( $list ))
			return;
			
		return $list;
	}

	public function hookHeader()
	{
		if (isset( $this->context->controller->php_self ) && $this->context->controller->php_self == 'index')
			$this->context->controller->addCSS (_THEME_CSS_DIR_.'product_list.css');
			
			$this->context->controller->addCSS ($this->_path.'views/css/styles.css', 'all');
			$this->context->controller->addCSS ($this->_path.'views/css/animate.css', 'all');
			$this->context->controller->addCSS ($this->_path.'views/css/owl.carousel.css', 'all');
			if (!defined ('OWL_CAROUSEL')){			
				$this->context->controller->addJs($this->_path.'views/js/owl.carousel.js');
				define( 'OWL_CAROUSEL', 1 );
			}
			$this->context->controller->addJS ($this->_path.'views/js/spcountdownproductslider.js');
		return $this->display (__FILE__, 'header.tpl');
	}

	public function hookDisplayHome()
	{
		$smarty = $this->context->smarty;
		$smarty_cache_id = $this->getCacheId ('spcountdownproductslider_displayHome');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayHome');
			if (empty( $list))
				return;
			$smarty->assign (array(
				'list' => $list,
				'id_lang'	=> $this->context->language->id
			));
		//}
		return $this->fetch('module:spcountdownproductslider/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookdisplaycountdownproductslider()
	{
		$smarty = $this->context->smarty;
		$smarty_cache_id = $this->getCacheId ('spcountdownproductslider_displaycountdownproductslider');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displaycountdownproductslider');
			if (empty( $list))
				return;
			$smarty->assign (array(
				'list' => $list,
				'hook_name' => 'displaycountdownproductslider',
				'id_lang'	=> $this->context->language->id
			));
		//}
		return $this->fetch('module:spcountdownproductslider/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookdisplaycountdownproductslider2()
	{
		$smarty = $this->context->smarty;
		$smarty_cache_id = $this->getCacheId ('spcountdownproductslider_displaycountdownproductslider2');
		//if (!$this->isCached ('default2.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displaycountdownproductslider2');
			if (empty( $list))
				return;
			$smarty->assign (array(
				'list' => $list,
				'hook_name' => 'displaycountdownproductslider2',
				'id_lang'	=> $this->context->language->id
			));
		//}
		return $this->fetch('module:spcountdownproductslider/views/templates/hook/default2.tpl');
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
					opacity: 0.8,
					cursor: "move",
					handle: ".dragGroup",
					update: function() {
						var order = $(this).sortable("serialize") + "&action=updateSlidesPosition";
							$.ajax({
								type: "POST",
								dataType: "json",
								data:order,
								url:"'.$this->context->shop->physical_uri.$this->context->shop->virtual_uri.'modules/'
			.$this->name.'/ajax_'.$this->name.'.php?secure_key='.$this->secure_key.'",
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
		$html .= '<style type="text/css">#gird_items .ui-sortable-helper{display:table!important;}
		#gird_items .ui-sortable-helper td{ background-color:#00aff0!important;color:#FFF;}</style>';
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
			sprintf($this->l('You can only edit this module from the shop(s) context: %s'), $shop_contextualized_name).
			'</p>';
		else
			return '<p class="alert alert-danger">'.
			sprintf($this->l('You cannot add modules from a "All Shops" or a "Group Shop" context')).
			'</p>';
	}

	private function getShopAssociationError($id_module)
	{
		return '<p class="alert alert-danger">'.
		sprintf($this->l('Unable to get module shop association information (id_module: %d)'), (int)$id_module).
		'</p>';
	}

	private function getCurrentShopInfoMsg()
	{
		$shop_info = null;

		if (Shop::isFeatureActive())
		{
			if (Shop::getContext() == Shop::CONTEXT_SHOP)
				$shop_info = sprintf($this->l('The modifications will be applied to shop: %s'),
					$this->context->shop->name);
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
		INSERT IGNORE INTO `'._DB_PREFIX_.'spcountdownproductslider_shop` (`id_spcountdownproductslider`, `id_shop`)
		SELECT `id_spcountdownproductslider`, '.(int)$params['new_id_shop'].'
		FROM `'._DB_PREFIX_.'spcountdownproductslider_shop`
		WHERE `id_shop` = '.(int)$params['old_id_shop']);
	}

	public function cleanText($text)
	{
		$text = strip_tags ($text, '<a><b><blockquote><code><del><dd><dl><dt><em><h1><h2><h3><i><kbd>
		<p><pre><s><sup><strong>
		<strike><br><hr>');
		$text = trim ($text);
		return $text;
	}

	public function trimEncode($text)
	{
		$str = strip_tags ($text);
		$str = preg_replace ('/\s(?=\s)/', '', $str);
		$str = preg_replace ('/[\n\r\t]/', '', $str);
		$str = str_replace (' ', '', $str);
		$str = trim ($str, "\xC2\xA0\n");
		return $str;
	}

	/**
	 * Parse and build target attribute for links.
	 * @param string $value (_self, _blank, _windowopen, _modal)
	 * _blank    Opens the linked document in a new window or tab
	 * _self    Opens the linked document in the same frame as it was clicked (this is default)
	 * _parent    Opens the linked document in the parent frame
	 * _top    Opens the linked document in the full body of the window
	 * _windowopen  Opens the linked document in a Window
	 * _modal        Opens the linked document in a Modal Window
	 */
	public function parseTarget($type = '_self')
	{
		$target = '';
		switch ($type)
		{
			default:
			case '_self':
				break;
			case '_blank':
			case '_parent':
			case '_top':
				$target = 'target="'.$type.'"';
				break;
			case '_windowopen':
				$string1 = "onclick=\"window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,";
				$string2 = "resizable=yes,false');return false;\"";
				$target = $string1.$string2;
				break;
			case '_modal':
				// user process
				break;
		}
		return $target;
	}
}
