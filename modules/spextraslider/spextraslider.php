<?php
/**
 * package SP Extra Slider
 *
 * @version 1.0.1
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

if (!defined ('_PS_VERSION_'))
	exit;

include_once ( dirname (__FILE__).'/SpExtraSliderClass.php' );

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;

class SpExtraSlider extends Module
{
	protected $categories = array();
	protected $error = false;
	private $html;
	private $default_hook = array('displayExtraSlider', 'displayExtraSlider2', 'displayExtraSlider3', 'displayExtraSlider4' , 'displayExtraSlider5', 'displayExtraSlider6' , 'displayExtraSlider7', 'displayExtraSlider8', 'displayLeftColumn' );

	public function __construct()
	{
		$this->name = 'spextraslider';
		$this->tab = 'front_office_features';
		$this->version = '1.0.1';
		$this->author = 'MagenTech';
		$this->secure_key = Tools::encrypt ($this->name);
		$this->bootstrap = true;
		parent::__construct ();
		$this->displayName = $this->l('SP Extra Slider');
		$this->description = $this->l('Display products on extra slider.');
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
		$spextraslider = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spextraslider`')
			&& Db::getInstance ()->Execute ('
			CREATE TABLE '._DB_PREFIX_.'spextraslider (
				`id_spextraslider` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`hook` int(10) unsigned,
				`params` text NOT NULL DEFAULT \'\' ,
				`active` tinyint(1) NOT NULL DEFAULT \'1\',
				`ordering` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_spextraslider`)) ENGINE=InnoDB default CHARSET=utf8');
		$spextraslider_shop = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spextraslider_shop`')
			&& Db::getInstance ()->Execute ('
				CREATE TABLE '._DB_PREFIX_.'spextraslider_shop (
				`id_spextraslider` int(10) unsigned NOT NULL,
				`id_shop` int(10) unsigned NOT NULL,
				`active` tinyint(1) NOT NULL DEFAULT \'1\',
				 PRIMARY KEY (`id_spextraslider`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8');
		$spextraslider_lang = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spextraslider_lang`')
			&& Db::getInstance ()->Execute ('CREATE TABLE '._DB_PREFIX_.'spextraslider_lang (
				`id_spextraslider` int(10) unsigned NOT NULL,
				`id_lang` int(10) unsigned NOT NULL,
				`title_module` varchar(255) NOT NULL DEFAULT \'\',
				PRIMARY KEY (`id_spextraslider`,`id_lang`)) ENGINE=InnoDB default CHARSET=utf8');
		if (!$spextraslider || !$spextraslider_shop || !$spextraslider_lang)
			return false;
		$this->installFixtures();
		return true;
	}

	public function uninstall()
	{
		if (parent::uninstall () == false)
			return false;
		if (!Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spextraslider`')
			|| !Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spextraslider_shop`')
			|| !Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spextraslider_lang`'))
			return false;
		$this->clearCacheItemForHook ();
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
				'id_spextraslider' => 1,
				'moduleclass_sfx' => 'left-product',
				'display_title_module' => 1,
				'title_module' => 'Up-sell Product',
				'active' => 1,
				'hook' => Hook::getIdByName('displayLeftColumn'),
				'nb_column1' => 1,
				'nb_column2' => 1,
				'nb_column3' => 1,
				'nb_column4' => 1,
				'nb_column1_p' => 1,
				'nb_column2_p' => 1,
				'nb_column3_p' => 1,
				'nb_column4_p' => 1,
				'target' => '_self',
				'layout' => 'style1',
				'nb_rows' => 5,
				'button_page' => 'top',
				'is_deal' => 0,

				'catids' => 'all',
				'products_ordering' => 'position',
				'ordering_direction' => 'DESC',
				'count_number' => 9,

				'image_size' => $this->_getImageSize('cart_default') ,
				'display_name' => 1,
				'name_maxlength' => 50,
				'display_description' => 0,
				'description_maxlength' => 50,
				'display_price' => 1,
				//'display_wishlist' => 0,
				//'display_compare' => 0,
				'display_addtocart' => 0,
				'display_detail' => 0,

				'display_quickview' => 0,
				'display_availability' => 0,
				'display_variant' => 0,
				'display_new' => 0,
				'display_sale' => 0,

				'margin' => 0,
				'slideBy' => 1,
				'autoplay' => 0,
				'autoplay_timeout' => 0,
				'autoplay_hover_pause' => 0,
				'autoplaySpeed' => 0,
				'smartSpeed' => 0,
				'startPosition' => 0,
				'mouseDrag' => 0,
				'touchDrag' => 0,
				'pullDrag' => 0,
				'dots' => 0,
				'dotsSpeed' => 1000,
				'nav' => 0,
				'navspeed' => 1000,
				'effect' => 'none',
				'duration' => 0,
				'delay' => 1000
			),

			array(
				'id_spextraslider' => 2,
				'moduleclass_sfx' => 'sp-extra-1 special',
				'display_title_module' => 1,
				'title_module' => 'Special Items',
				'active' => 1,
				'hook' => Hook::getIdByName('displayExtraSlider'),
				'nb_column1' => 1,
				'nb_column2' => 1,
				'nb_column3' => 1,
				'nb_column4' => 1,
				'nb_column1_p' => 1,
				'nb_column2_p' => 1,
				'nb_column3_p' => 1,
				'nb_column4_p' => 1,
				'target' => '_self',
				'layout' => 'style1',
				'nb_rows' => 5,
				'button_page' => 'top',
				'is_deal' => 0,

				'catids' => 'all',
				'products_ordering' => 'name',
				'ordering_direction' => 'ASC',
				'count_number' => 12,

				'image_size' => $this->_getImageSize('cart_default') ,
				'display_name' => 1,
				'name_maxlength' => 50,
				'display_description' => 0,
				'description_maxlength' => 25,
				'display_price' => 1,
				//'display_wishlist' => 0,
				//'display_compare' => 0,
				'display_addtocart' => 0,
				'display_detail' => 0,

				'display_quickview' => 0,
				'display_availability' => 0,
				'display_variant' => 0,
				'display_new' => 0,
				'display_sale' => 0,

				'margin' => 30,
				'slideBy' => 1,
				'autoplay' => 0,
				'autoplay_timeout' => 0,
				'autoplay_hover_pause' => 0,
				'autoplaySpeed' => 0,
				'smartSpeed' => 0,
				'startPosition' => 0,
				'mouseDrag' => 0,
				'touchDrag' => 0,
				'pullDrag' => 0,
				'dots' => 0,
				'dotsSpeed' => 1000,
				'nav' => 0,
				'navspeed' => 1000,
				'effect' => 'none',
				'duration' => 0,
				'delay' => 1000
			),

			array(
				'id_spextraslider' => 3,
				'moduleclass_sfx' => 'sp-extra-2 clearfix',
				'display_title_module' => 1,
				'title_module' => 'Ending Soon',
				'active' => 1,
				'hook' => Hook::getIdByName('displayExtraSlider2'),
				'nb_column1' => 4,
				'nb_column2' => 3,
				'nb_column3' => 3,
				'nb_column4' => 2,
				'nb_column1_p' => 4,
				'nb_column2_p' => 3,
				'nb_column3_p' => 3,
				'nb_column4_p' => 2,
				'target' => '_self',
				'layout' => 'style1',
				'nb_rows' => 2,
				'button_page' => 'top',
				'is_deal' => 0,

				'catids' => 'all',
				'products_ordering' => 'name',
				'ordering_direction' => 'DESC',
				'count_number' => 12,

				'image_size' => $this->_getImageSize('medium_default') ,
				'display_name' => 1,
				'name_maxlength' => 50,
				'display_description' => 0,
				'description_maxlength' => 25,
				'display_price' => 1,
				//'display_wishlist' => 0,
				//'display_compare' => 0,
				'display_addtocart' => 1,
				'display_detail' => 0,

				'display_quickview' => 1,
				'display_availability' => 0,
				'display_variant' => 0,
				'display_new' => 0,
				'display_sale' => 0,

				'margin' => 0,
				'slideBy' => 1,
				'autoplay' => 0,
				'autoplay_timeout' => 0,
				'autoplay_hover_pause' => 0,
				'autoplaySpeed' => 0,
				'smartSpeed' => 0,
				'startPosition' => 0,
				'mouseDrag' => 0,
				'touchDrag' => 0,
				'pullDrag' => 0,
				'dots' => 0,
				'dotsSpeed' => 1000,
				'nav' => 1,
				'navspeed' => 1000,
				'effect' => 'none',
				'duration' => 0,
				'delay' => 1000
			),

			array(
				'id_spextraslider' => 4,
				'moduleclass_sfx' => 'sp-extra-1 sp-extra-3',
				'display_title_module' => 1,
				'title_module' => 'Sport & Entertaiment',
				'active' => 1,
				'hook' => Hook::getIdByName('displayExtraSlider3'),
				'nb_column1' => 1,
				'nb_column2' => 1,
				'nb_column3' => 1,
				'nb_column4' => 1,
				'nb_column1_p' => 2,
				'nb_column2_p' => 2,
				'nb_column3_p' => 2,
				'nb_column4_p' => 2,
				'target' => '_self',
				'layout' => 'style1',
				'nb_rows' => 3,
				'button_page' => 'top',
				'is_deal' => 0,

				'catids' => 'all',
				'products_ordering' => 'date_add',
				'ordering_direction' => 'DESC',
				'count_number' => 9,

				'image_size' => $this->_getImageSize('small_default') ,
				'display_name' => 1,
				'name_maxlength' => 50,
				'display_description' => 0,
				'description_maxlength' => 50,
				'display_price' => 1,
				//'display_wishlist' => 0,
				//'display_compare' => 0,
				'display_addtocart' => 1,
				'display_detail' => 0,

				'display_quickview' => 1,
				'display_availability' => 0,
				'display_variant' => 0,
				'display_new' => 0,
				'display_sale' => 1,

				'margin' => 0,
				'slideBy' => 1,
				'autoplay' => 0,
				'autoplay_timeout' => 0,
				'autoplay_hover_pause' => 0,
				'autoplaySpeed' => 0,
				'smartSpeed' => 0,
				'startPosition' => 0,
				'mouseDrag' => 0,
				'touchDrag' => 0,
				'pullDrag' => 0,
				'dots' => 0,
				'dotsSpeed' => 1000,
				'nav' => 1,
				'navspeed' => 1000,
				'effect' => 'none',
				'duration' => 0,
				'delay' => 1000
			),

			array(
				'id_spextraslider' => 5,
				'moduleclass_sfx' => 'sp-extra-1 sp-extra-4',
				'display_title_module' => 1,
				'title_module' => 'Food & Restaurant',
				'active' => 1,
				'hook' => Hook::getIdByName('displayExtraSlider4'),
				'nb_column1' => 1,
				'nb_column2' => 1,
				'nb_column3' => 1,
				'nb_column4' => 1,
				'nb_column1_p' => 1,
				'nb_column2_p' => 1,
				'nb_column3_p' => 1,
				'nb_column4_p' => 1,
				'target' => '_self',
				'layout' => 'style1',
				'nb_rows' => 3,
				'button_page' => 'top',
				'is_deal' => 0,

				'catids' => 'all',
				'products_ordering' => 'sales',
				'ordering_direction' => 'DESC',
				'count_number' => 9,

				'image_size' => $this->_getImageSize('small_default') ,
				'display_name' => 1,
				'name_maxlength' => 50,
				'display_description' => 0,
				'description_maxlength' => 50,
				'display_price' => 1,
				//'display_wishlist' => 0,
				//'display_compare' => 0,
				'display_addtocart' => 1,
				'display_detail' => 0,

				'display_quickview' => 1,
				'display_availability' => 0,
				'display_variant' => 0,
				'display_new' => 0,
				'display_sale' => 1,

				'margin' => 0,
				'slideBy' => 1,
				'autoplay' => 0,
				'autoplay_timeout' => 0,
				'autoplay_hover_pause' => 0,
				'autoplaySpeed' => 0,
				'smartSpeed' => 0,
				'startPosition' => 0,
				'mouseDrag' => 0,
				'touchDrag' => 0,
				'pullDrag' => 0,
				'dots' => 0,
				'dotsSpeed' => 1000,
				'nav' => 1,
				'navspeed' => 1000,
				'effect' => 'none',
				'duration' => 0,
				'delay' => 1000
			),

			array(
				'id_spextraslider' => 6,
				'moduleclass_sfx' => 'sp-extra-1 sp-extra-5',
				'display_title_module' => 1,
				'title_module' => 'Book Stationery',
				'active' => 1,
				'hook' => Hook::getIdByName('displayExtraSlider5'),
				'nb_column1' => 1,
				'nb_column2' => 1,
				'nb_column3' => 1,
				'nb_column4' => 1,
				'nb_column1_p' => 1,
				'nb_column2_p' => 1,
				'nb_column3_p' => 1,
				'nb_column4_p' => 1,
				'target' => '_self',
				'layout' => 'style1',
				'nb_rows' => 3,
				'button_page' => 'top',
				'is_deal' => 0,

				'catids' => 'all',
				'products_ordering' => 'position',
				'ordering_direction' => 'ASC',
				'count_number' => 9,

				'image_size' => $this->_getImageSize('small_default') ,
				'display_name' => 1,
				'name_maxlength' => 50,
				'display_description' => 0,
				'description_maxlength' => 50,
				'display_price' => 1,
				//'display_wishlist' => 0,
				//'display_compare' => 0,
				'display_addtocart' => 1,
				'display_detail' => 0,

				'display_quickview' => 1,
				'display_availability' => 0,
				'display_variant' => 0,
				'display_new' => 0,
				'display_sale' => 1,

				'margin' => 0,
				'slideBy' => 1,
				'autoplay' => 0,
				'autoplay_timeout' => 0,
				'autoplay_hover_pause' => 0,
				'autoplaySpeed' => 0,
				'smartSpeed' => 0,
				'startPosition' => 0,
				'mouseDrag' => 0,
				'touchDrag' => 0,
				'pullDrag' => 0,
				'dots' => 0,
				'dotsSpeed' => 1000,
				'nav' => 1,
				'navspeed' => 1000,
				'effect' => 'none',
				'duration' => 0,
				'delay' => 1000
			),

			array(
				'id_spextraslider' => 7,
				'moduleclass_sfx' => 'sp-extra-1 sp-extra-6',
				'display_title_module' => 1,
				'title_module' => 'Special Items',
				'active' => 1,
				'hook' => Hook::getIdByName('displayExtraSlider6'),
				'nb_column1' => 1,
				'nb_column2' => 1,
				'nb_column3' => 1,
				'nb_column4' => 1,
				'nb_column1_p' => 1,
				'nb_column2_p' => 1,
				'nb_column3_p' => 1,
				'nb_column4_p' => 1,
				'target' => '_self',
				'layout' => 'style1',
				'nb_rows' => 5,
				'button_page' => 'top',
				'is_deal' => 0,

				'catids' => 'all',
				'products_ordering' => 'position',
				'ordering_direction' => 'ASC',
				'count_number' => 9,

				'image_size' => $this->_getImageSize('cart_default') ,
				'display_name' => 1,
				'name_maxlength' => 80,
				'display_description' => 0,
				'description_maxlength' => 50,
				'display_price' => 1,
				//'display_wishlist' => 0,
				//'display_compare' => 0,
				'display_addtocart' => 0,
				'display_detail' => 0,

				'display_quickview' => 0,
				'display_availability' => 0,
				'display_variant' => 0,
				'display_new' => 0,
				'display_sale' => 0,

				'margin' => 0,
				'slideBy' => 1,
				'autoplay' => 0,
				'autoplay_timeout' => 0,
				'autoplay_hover_pause' => 0,
				'autoplaySpeed' => 0,
				'smartSpeed' => 0,
				'startPosition' => 0,
				'mouseDrag' => 0,
				'touchDrag' => 0,
				'pullDrag' => 0,
				'dots' => 0,
				'dotsSpeed' => 1000,
				'nav' => 0,
				'navspeed' => 1000,
				'effect' => 'none',
				'duration' => 0,
				'delay' => 1000
			),

			array(
				'id_spextraslider' => 8,
				'moduleclass_sfx' => 'sp-extra-7',
				'display_title_module' => 1,
				'title_module' => 'Recommend Items',
				'active' => 1,
				'hook' => Hook::getIdByName('displayExtraSlider7'),
				'nb_column1' => 1,
				'nb_column2' => 1,
				'nb_column3' => 1,
				'nb_column4' => 2,
				'nb_column1_p' => 1,
				'nb_column2_p' => 1,
				'nb_column3_p' => 1,
				'nb_column4_p' => 1,
				'target' => '_self',
				'layout' => 'style1',
				'nb_rows' => 3,
				'button_page' => 'top',
				'is_deal' => 0,

				'catids' => 'all',
				'products_ordering' => 'position',
				'ordering_direction' => 'ASC',
				'count_number' => 18,

				'image_size' => $this->_getImageSize('home_default') ,
				'display_name' => 1,
				'name_maxlength' => 50,
				'display_description' => 0,
				'description_maxlength' => 50,
				'display_price' => 1,
				//'display_wishlist' => 0,
				//'display_compare' => 0,
				'display_addtocart' => 1,
				'display_detail' => 0,

				'display_quickview' => 1,
				'display_availability' => 0,
				'display_variant' => 0,
				'display_new' => 0,
				'display_sale' => 0,

				'margin' => 0,
				'slideBy' => 1,
				'autoplay' => 0,
				'autoplay_timeout' => 0,
				'autoplay_hover_pause' => 0,
				'autoplaySpeed' => 0,
				'smartSpeed' => 0,
				'startPosition' => 0,
				'mouseDrag' => 0,
				'touchDrag' => 1,
				'pullDrag' => 1,
				'dots' => 1,
				'dotsSpeed' => 1000,
				'nav' => 0,
				'navspeed' => 1000,
				'effect' => 'none',
				'duration' => 0,
				'delay' => 1000
			),

			array(
				'id_spextraslider' => 8,
				'moduleclass_sfx' => 'sp-extra-8',
				'display_title_module' => 1,
				'title_module' => 'Feature Items',
				'active' => 1,
				'hook' => Hook::getIdByName('displayExtraSlider8'),
				'nb_column1' => 6,
				'nb_column2' => 5,
				'nb_column3' => 4,
				'nb_column4' => 2,
				'nb_column1_p' => 6,
				'nb_column2_p' => 5,
				'nb_column3_p' => 4,
				'nb_column4_p' => 2,
				'target' => '_self',
				'layout' => 'style1',
				'nb_rows' => 2,
				'button_page' => 'top',
				'is_deal' => 0,

				'catids' => 'all',
				'products_ordering' => 'position',
				'ordering_direction' => 'ASC',
				'count_number' => 18,

				'image_size' => $this->_getImageSize('home_default') ,
				'display_name' => 1,
				'name_maxlength' => 50,
				'display_description' => 0,
				'description_maxlength' => 50,
				'display_price' => 1,
				//'display_wishlist' => 0,
				//'display_compare' => 0,
				'display_addtocart' => 1,
				'display_detail' => 0,

				'display_quickview' => 1,
				'display_availability' => 0,
				'display_variant' => 0,
				'display_new' => 0,
				'display_sale' => 0,

				'margin' => 0,
				'slideBy' => 1,
				'autoplay' => 0,
				'autoplay_timeout' => 0,
				'autoplay_hover_pause' => 0,
				'autoplaySpeed' => 0,
				'smartSpeed' => 0,
				'startPosition' => 0,
				'mouseDrag' => 0,
				'touchDrag' => 1,
				'pullDrag' => 1,
				'dots' => 1,
				'dotsSpeed' => 1000,
				'nav' => 0,
				'navspeed' => 1000,
				'effect' => 'none',
				'duration' => 0,
				'delay' => 1000
			)

		);

		$return = true;
		foreach ($datas as $i => $data)
		{
			$spextraslider = new SpExtraSliderClass();
			$spextraslider->hook = $data['hook'];
			$spextraslider->active = $data['active'];
			$spextraslider->ordering = $i;
			$spextraslider->params = serialize($data);
			foreach (Language::getLanguages(false) as $lang)
				$spextraslider->title_module[$lang['id_lang']] = $data['title_module'];

			$return &= $spextraslider->add();
		}

		return $return;
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
				&& $this->moduleExists((int)Tools::getValue('id_spextraslider'))) || Tools::isSubmit ('saveItem'))
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
				$associated_shop_ids = SpExtraSliderClass::getAssociatedIdsShop((int)Tools::getValue('id_spextraslider'));
				$context_shop_id = (int)Shop::getContextShopID();
				if ($associated_shop_ids === false)
					$this->html .= $this->getShopAssociationError((int)Tools::getValue('id_spextraslider'));
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

			if (Tools::isSubmit('id_spextraslider'))
			{
				if (!Validate::isInt(Tools::getValue('id_spextraslider'))
					&& !$this->moduleExists(Tools::getValue('id_spextraslider')))
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

			if (!is_numeric (Tools::getValue('margin')) || floor (Tools::getValue('margin')) < 0)
				$errors[] = $this->l('Invalid Margin');

			if (!is_numeric (Tools::getValue('slideBy')) || floor (Tools::getValue('slideBy')) < 0)
				$errors[] = $this->l('Invalid SlideBy');

			if (!is_numeric (Tools::getValue('autoplay_timeout')) || floor (Tools::getValue('autoplay_timeout')) < 0)
				$errors[] = $this->l('Invalid Autoplay Timeout');

			if (!is_numeric (Tools::getValue('autoplaySpeed')) || floor (Tools::getValue('autoplaySpeed')) < 0)
				$errors[] = $this->l('Invalid Autoplay Speed');

			if (!is_numeric (Tools::getValue('smartSpeed')) || floor (Tools::getValue('smartSpeed')) < 0)
				$errors[] = $this->l('Invalid Smart Speed');

			if (!is_numeric (Tools::getValue('dotsSpeed')) || floor (Tools::getValue('dotsSpeed')) < 0)
				$errors[] = $this->l('Invalid Pagination Speed');

			if (!is_numeric (Tools::getValue('navspeed')) || floor (Tools::getValue('navspeed')) < 0)
				$errors[] = $this->l('Invalid Navigation Speed');

			if (!is_numeric (Tools::getValue('startPosition')) || floor (Tools::getValue('startPosition')) < 0)
				$errors[] = $this->l('Invalid Start Poisition');

			if (!is_numeric (Tools::getValue('duration')) || floor (Tools::getValue('duration')) < 0)
				$errors[] = $this->l('Invalid Duration');

			if (!is_numeric (Tools::getValue('delay')) || floor (Tools::getValue('delay')) < 0)
				$errors[] = $this->l('Invalid Delay');
		}
		elseif (Tools::isSubmit('id_spextraslider') && (!Validate::isInt(Tools::getValue('id_spextraslider'))
				|| !$this->moduleExists((int)Tools::getValue('id_spextraslider'))))
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
			if (Tools::getValue('id_spextraslider'))
			{
				$extraslider = new SpExtraSliderClass((int)Tools::getValue ('id_spextraslider'));
				if (!Validate::isLoadedObject($extraslider))
				{
					$this->html .= $this->displayError($this->l('Invalid slide ID'));
					return false;
				}
			}
			else
				$extraslider = new SpExtraSliderClass();
			$extraslider = new SpExtraSliderClass(Tools::getValue ('id_spextraslider'));
			$next_ps = $this->getNextPosition();
			$extraslider->ordering = (!empty($extraslider->ordering)) ? (int)$extraslider->ordering : $next_ps;
			$extraslider->active = (Tools::getValue('active')) ? (int)Tools::getValue('active') : 0;
			$extraslider->hook	= (int)Tools::getValue('hook');
			$tmp_data = array();
			$id_spextraslider = (int)Tools::getValue ('id_spextraslider');
			$id_spextraslider = $id_spextraslider ? $id_spextraslider : $extraslider->getHigherModuleID();
			$tmp_data['id_spextraslider'] = $id_spextraslider;
			$tmp_data['display_title_module'] = (int)Tools::getValue ('display_title_module');
			$tmp_data['moduleclass_sfx'] = (string)Tools::getValue ('moduleclass_sfx');
			$tmp_data['active'] = (int)Tools::getValue ('active', 1);
			$tmp_data['hook '] = (string)Tools::getValue ('hook ', 'displayHome');
			for ($i = 1; $i < 5; $i ++)
				$tmp_data['nb_column'.$i] = (int)Tools::getValue ('nb_column'.$i);
			$tmp_data['target'] = (string)Tools::getValue ('target', '_blank');
			$tmp_data['layout'] = (string)Tools::getValue ('layout', 'style1');
			$tmp_data['nb_rows'] = (int)Tools::getValue ('nb_rows', 3);
			$tmp_data['button_page'] = (string)Tools::getValue ('button_page', 'top');

			$catids = Tools::getValue ('catids');
			$catids = ( is_array ($catids) && !empty( $catids ) )?implode (',', $catids):false;
			$tmp_data['catids'] = $catids;
			$tmp_data['ordering_direction'] = (string)Tools::getValue ('ordering_direction', 'ASC');
			$tmp_data['products_ordering'] = (string)Tools::getValue ('products_ordering', 'name');
			$tmp_data['count_number'] = (int)Tools::getValue ('count_number', 6);
			$tmp_data['is_deal'] = (int)Tools::getValue ('is_deal', 1);

			$tmp_data['image_size'] = (string)Tools::getValue ('image_size');
			$tmp_data['display_name'] = (int)Tools::getValue ('display_name', 1);
			$tmp_data['name_maxlength'] = (int)Tools::getValue ('name_maxlength', 20);
			$tmp_data['display_description'] = (int)Tools::getValue ('display_description', 0);
			$tmp_data['description_maxlength'] = (int)Tools::getValue ('description_maxlength');
			$tmp_data['display_price'] = (int)Tools::getValue ('display_price', 1);
			$tmp_data['display_addtocart'] = (int)Tools::getValue ('display_addtocart', 1);
			//$tmp_data['display_wishlist'] = (int)Tools::getValue ('display_wishlist', 1);
			//$tmp_data['display_compare'] = (int)Tools::getValue ('display_compare', 1);
			$tmp_data['display_quickview'] = (int)Tools::getValue ('display_quickview', 1);
			$tmp_data['display_new'] = (int)Tools::getValue ('display_new', 1);
			$tmp_data['display_sale'] = (int)Tools::getValue ('display_sale', 1);
			$tmp_data['display_availability'] = (int)Tools::getValue ('display_availability');
			$tmp_data['display_variant'] = (int)Tools::getValue ('display_variant');

			$tmp_data['margin'] = (int)Tools::getValue ('margin');
			$tmp_data['slideBy'] = (int)Tools::getValue ('slideBy');
			$tmp_data['autoplay'] = (int)Tools::getValue ('autoplay');
			$tmp_data['autoplay_timeout'] = (int)Tools::getValue ('autoplay_timeout');
			$tmp_data['autoplay_hover_pause'] = (int)Tools::getValue ('autoplay_hover_pause');
			$tmp_data['autoplaySpeed'] = (int)Tools::getValue ('autoplaySpeed');
			$tmp_data['smartSpeed'] = (int)Tools::getValue ('smartSpeed');
			$tmp_data['startPosition'] = (int)Tools::getValue ('startPosition');
			$tmp_data['mouseDrag'] = (int)Tools::getValue ('mouseDrag');
			$tmp_data['touchDrag'] = (int)Tools::getValue ('touchDrag');
			$tmp_data['pullDrag'] = (int)Tools::getValue ('pullDrag');
			$tmp_data['dots'] = (int)Tools::getValue ('dots');
			$tmp_data['dotsSpeed'] = (int)Tools::getValue ('dotsSpeed');
			$tmp_data['nav'] = (int)Tools::getValue ('nav');
			$tmp_data['navspeed'] = (int)Tools::getValue ('navspeed');
			$tmp_data['effect'] = (string)Tools::getValue ('effect', 'flip');
			$tmp_data['duration'] = (int)Tools::getValue ('duration', 600);
			$tmp_data['delay'] = (int)Tools::getValue ('delay', 300);

			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
				$extraslider->title_module[$language['id_lang']] = Tools::getValue('title_module_'.$language['id_lang']);
			$extraslider->params = serialize($tmp_data);
			$get_id = Tools::getValue ('id_spextraslider');
			($get_id && $this->moduleExists($get_id) )? $extraslider->update() : $extraslider->add ();
			$this->clearCacheItemForHook ();
			if (Tools::isSubmit ('saveAndStay'))
			{
				$id_spextraslider = Tools::getValue ('id_spextraslider')?
					(int)Tools::getValue ('id_spextraslider'):(int)$extraslider->getHigherModuleID ();

				Tools::redirectAdmin ($currentIndex.'&configure='
					.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spextraslider='
					.$id_spextraslider.'&updateItemConfirmation');
			}
			else
				Tools::redirectAdmin ($currentIndex.'&configure='
					.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules').'&saveItemConfirmation');
		}
		elseif (Tools::isSubmit ('changeStatusItem') && Tools::getValue ('id_spextraslider'))
		{
			$extraslider = new SpExtraSliderClass((int)Tools::getValue ('id_spextraslider'));
			if ($extraslider->active == 0)
				$extraslider->active = 1;
			else
				$extraslider->active = 0;
			$extraslider->update();
			$this->clearCacheItemForHook ();
			Tools::redirectAdmin ($currentIndex.'&configure='.$this->name
				.'&token='.Tools::getAdminTokenLite ('AdminModules'));
		}
		elseif (Tools::isSubmit ('deleteItem') && Tools::getValue ('id_spextraslider'))
		{
			$extraslider = new SpExtraSliderClass(Tools::getValue ('id_spextraslider'));
			$extraslider->delete ();
			$this->clearCacheItemForHook ();
			Tools::redirectAdmin ($currentIndex.'&configure='.$this->name.
			'&token='.Tools::getAdminTokenLite ('AdminModules').'&deleteItemConfirmation');
		}
		elseif (Tools::isSubmit ('duplicateItem') && Tools::getValue ('id_spextraslider'))
		{
			$extraslider = new SpExtraSliderClass(Tools::getValue ('id_spextraslider'));
			foreach (Language::getLanguages (false) as $lang)
				$extraslider->title_module[(int)$lang['id_lang']] = $extraslider->title_module[(int)$lang['id_lang']].$this->l(' (Copy)');
			$extraslider->duplicate ();
			$this->clearCacheItemForHook ();
			Tools::redirectAdmin ($currentIndex.'&configure='.$this->name.
												'&token='.Tools::getAdminTokenLite ('AdminModules').'&duplicateItemConfirmation');
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
		$req = 'SELECT cs.`id_spextraslider`
				FROM `'._DB_PREFIX_.'spextraslider` cs
				WHERE cs.`id_spextraslider` = '.(int)$id_module;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);
		return ($row);
	}
	public function getNextPosition()
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT MAX(cs.`ordering`) AS `next_position`
			FROM `'._DB_PREFIX_.'spextraslider` cs, `'._DB_PREFIX_.'spextraslider_shop` css
			WHERE css.`id_spextraslider` = cs.`id_spextraslider`
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
			SELECT b.`id_spextraslider`, b.`hook`, b.`ordering`, bs.`active`, bl.`title_module`
			FROM `'._DB_PREFIX_.'spextraslider` b
			LEFT JOIN `'._DB_PREFIX_.'spextraslider_shop` bs ON (b.`id_spextraslider` = bs.`id_spextraslider`)
			LEFT JOIN `'._DB_PREFIX_.'spextraslider_lang` bl ON (b.`id_spextraslider` = bl.`id_spextraslider`'
			.( $id_shop?'AND bs.`id_shop` = '.$id_shop:' ' ).')
			WHERE bl.`id_lang` = '.(int)$id_lang.( $id_shop?' AND bs.`id_shop` = '.$id_shop:' ' ).'
			ORDER BY b.`ordering`'))
			return false;
		return $result;
	}

	private function getHookTitle($id_hook, $name = false)
	{
		if (!$result = Db::getInstance()->getRow('SELECT `name`,`title` FROM `'._DB_PREFIX_.'hook` WHERE `id_hook` = '.(int)$id_hook))
			return false;
		return (($result['title'] != '' && $name) ? $result['title'] : $result['name']);
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
					$associated_shop_ids = SpExtraSliderClass::getAssociatedIdsShop((int)$mod['id_spextraslider']);
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
				<tr id="item_'.$mod['id_spextraslider'].'" class=" '.( $irow ++ % 2?' ':'' ).'">
					<td class=" 	" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spextraslider='
					.$mod['id_spextraslider'].'\'">'
					.$mod['id_spextraslider'].'</td>
					<td class=" dragHandle"><div class="dragGroup"><div class="positions">'.$mod['ordering']
					.'</div></div></td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&editItem&id_spextraslider='.$mod['id_spextraslider'].'\'">'
					.$mod['title_module'].' '
					.($mod['is_shared'] ? '<span class="label color_field"
				style="background-color:#108510;color:white;margin-top:5px;">'.$this->l('Shared').'</span>' : '').'</td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&editItem&id_spextraslider='.$mod['id_spextraslider'].'\'">'
					.( Validate::isInt ($mod['hook'])?$this->getHookTitle ($mod['hook']):'' ).'</td>
					<td class="  "> <a href="'.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&changeStatusItem&id_spextraslider='
					.$mod['id_spextraslider'].'&status='
					.$mod['active'].'&hook='.$mod['hook'].'">'
					.( $mod['active']?'<i class="icon-check"></i>':'<i class="icon-remove"></i>' ).'</a> </td>
					<td class="text-right">
						<div class="btn-group-action">
							<div class="btn-group pull-right">
								<a class="btn btn-default" href="'.$currentIndex.'&configure='
					.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spextraslider='
					.$mod['id_spextraslider'].'">
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
					.Tools::getAdminTokenLite ('AdminModules').'&duplicateItem&id_spextraslider='
					.$mod['id_spextraslider'].'">
											<i class="icon-copy"></i> '.$this->l('Duplicate').'
										</a>
									</li>
									<li class="divider"></li>
									<li>
										<a title ="'.$this->l('Delete')
					.'" onclick="return confirm(\''.$this->l('Are you sure?'
						).'\');" href="'.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&deleteItem&id_spextraslider='
					.$mod['id_spextraslider'].'">
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
					'lang'     => true,
					'name'     => 'title_module',
					'hint'     => $this->l('Title of Module.'),
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
					'hint'   => $this->l('Allow show/hide module.'),
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
					'hint'    => $this->l('Allow display module in Hook.'),
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
					'hint'    => $this->l('Select Column'),
					'desc'    => $this->l('For devices have screen width from 1200px to greater.'),
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
					'hint'    => $this->l('Select Column'),
					'desc'    => $this->l('For devices have screen width from 992px up to 1199px.'),
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
					'hint'    => $this->l('Select Column'),
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
					'name'    => 'nb_column4',
					'hint'    => $this->l('Select Column'),
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
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('Select Layout'),
					'name'    => 'layout',
					'hint'    => $this->l('Choose the layout for the module here.'),
					'class'   => 'fixed-width-xl',
					'options' => array(
						'query' => array(
							array(
								'id_option' => 'style1',
								'name'      => $this->l('Layout 1')
							),
							array(
								'id_option' => 'style2',
								'name'      => $this->l('Layout 2')
							),
							array(
								'id_option' => 'style3',
								'name'      => $this->l('Layout 3')
							),
							array(
								'id_option' => 'style4',
								'name'      => $this->l('Layout 4')
							),
							array(
								'id_option' => 'style5',
								'name'      => $this->l('Layout 5')
							),
							array(
								'id_option' => 'style6',
								'name'      => $this->l('Layout 6')
							),
							array(
								'id_option' => 'style7',
								'name'      => $this->l('Layout 7')
							)
						),
						'id'    => 'id_option',
						'name'  => 'name'
					)
				),
				array(
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('# Row Item'),
					'name'    => 'nb_rows',
					'desc'    => $this->l('Number rows of items.'),
					'class'   => 'fixed-width-xl',
					'hint'    => $this->l('Select Row display.'),
					'options' => array(
						'query' => $opt_column,
						'id'    => 'id_option',
						'name'  => 'name'
					)
				),
				array(
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('Button page'),
					'name'    => 'button_page',
					'hint'    => $this->l('Choose the button page for the module here.'),
					'class'   => 'fixed-width-xl',
					'options' => array(
						'query' => array(
							array(
								'id_option' => 'top',
								'name'      => $this->l('Top')
							),
							array(
								'id_option' => 'under',
								'name'      => $this->l('Under')
							)
						),
						'id'    => 'id_option',
						'name'  => 'name'
					)
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

		$this->fields_form[1]['form'] = array(
			'legend'  => array(
				'title' => $this->l('Source Options '),
				'icon'  => 'icon-cogs'
			),
			'input'   => array(
				array(
					'type'   => 'switch',
					'label'  => $this->l('Is Deals Products'),
					'name'   => 'is_deal',
					'hint'   => $this->l('Get Only Deals Product'),
					'values' => array(
						array(
							'id'    => 'is_deal_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'is_deal_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),			
				array(
					'type' => 'categories',
					'label' => 'Select Categories',
					'name' => 'catids',
					'tree' => array(
						'id' => 'id_category',
						'use_checkbox' => true,
						'use_search'  => true,
						'name' => 'catids',
						'selected_categories' => $this->getFormValuesCat(),
						'root_category'       => Context::getContext()->shop->getCategory(),
					)
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
								'id_option' => 'position',
								'name'      => $this->l('Position')
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
					'hint'    => $this->l('Select Size image'),
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
					'hint'   => $this->l('Allow to show/hide button addtocart of product'),
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
				/*array(
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
				),*/
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display Quickview'),
					'name'   => 'display_quickview',
					'hint'   => $this->l('Allow to show/hide button Quick View'),
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

		$this->fields_form[3]['form'] = array(
			'legend'  => array(
				'title' => $this->l('Effect Options'),
				'icon'  => 'icon-cogs'
			),
			'input'   => array(
				array(
					'type'  => 'text',
					'label' => $this->l('Margin Right Item'),
					'name'  => 'margin',
					'class' => 'fixed-width-xl',
					'hint'  => 'margin-right(px) on Item.',
				),
				array(
					'type'  => 'text',
					'label' => $this->l('SlideBy Item'),
					'name'  => 'slideBy',
					'class' => 'fixed-width-xl',
					'hint'  => 'Navigation slide by x. page string can be set to slide by page.',
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
					'type'   => 'switch',
					'label'  => $this->l('Pause On Hover'),
					'name'   => 'autoplay_hover_pause',
					'hint'   => $this->l('Pause on mouse hover'),
					'values' => array(
						array(
							'id'    => 'pause_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'pause_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
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
					'type'   => 'text',
					'label'  => $this->l('Smart Speed'),
					'name'   => 'smartSpeed',
					'class'  => 'fixed-width-xl',
					'hint'   => 'Autoplay Smart Speed.',
					'suffix' => 'ms',
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
					'type'   => 'text',
					'label'  => $this->l('Pagination Speed'),
					'name'   => 'dotsSpeed',
					'class'  => 'fixed-width-xl',
					'hint'   => 'Pagination Speed.',
					'suffix' => 'ms',
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
					'label'  => $this->l('Navigation Speed'),
					'name'   => 'navspeed',
					'class'  => 'fixed-width-xl',
					'hint'   => 'Navigation Speed.',
					'suffix' => 'ms',
				),
				array(
					'type'    => 'select',
					'lang'    => true,
					'label'   => $this->l('Select Effect'),
					'name'    => 'effect',
					'hint'    => $this->l('Choose the effect for the module here.'),
					'class'   => 'fixed-width-xl',
					'options' => array(
						'query' => array(
							array(
								'id_option' => 'none',
								'name'      => $this->l('None')
							),
							array(
								'id_option' => 'fadeIn',
								'name'      => $this->l('Fade In')
							),
							array(
								'id_option' => 'zoomIn',
								'name'      => $this->l('Zoom In')
							),
							array(
								'id_option' => 'zoomOut',
								'name'      => $this->l('Zoom Out')
							),
							array(
								'id_option' => 'slideLeft',
								'name'      => $this->l('Slide Left')
							),
							array(
								'id_option' => 'slideRight',
								'name'      => $this->l('Slide Right')
							),
							array(
								'id_option' => 'slideTop',
								'name'      => $this->l('Slide Top')
							),
							array(
								'id_option' => 'slideBottom',
								'name'      => $this->l('Slide Bottom')
							),
							array(
								'id_option' => 'flip',
								'name'      => $this->l('Flip')
							),
							array(
								'id_option' => 'flipInX',
								'name'      => $this->l('Flip in horizontal')
							),
							array(
								'id_option' => 'flipInY',
								'name'      => $this->l('Flip in vertical')
							),
							array(
								'id_option' => 'bounceIn',
								'name'      => $this->l('Bounce In')
							),
							array(
								'id_option' => 'bounceInUp',
								'name'      => $this->l('Bounce In Up')
							),
							array(
								'id_option' => 'bounceInDown',
								'name'      => $this->l('Bounce In Down')
							),
							array(
								'id_option' => 'pageTop',
								'name'      => $this->l('Page Top')
							),
							array(
								'id_option' => 'pageBottom',
								'name'      => $this->l('Page Bottom')
							),
							array(
								'id_option' => 'starwars',
								'name'      => $this->l('Star Wars')
							)
						),
						'id'    => 'id_option',
						'name'  => 'name'
					)
				),

				array(
					'type'   => 'text',
					'label'  => $this->l('Duration'),
					'name'   => 'duration',
					'hint'   => $this->l('Determining how long the animation will run. Larger = Slower.'),
					'class'  => 'fixed-width-xl',
					'suffix' => 'ms',
				),
				array(
					'type'   => 'text',
					'label'  => $this->l('Delay'),
					'name'   => 'delay',
					'hint'   => $this->l('Sets a timer to delay the execution of the next item in the queue. Larger = Slower.'),
					'class'  => 'fixed-width-xl',
					'suffix' => 'ms',
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
		$helper->name_controller = 'spextraslider';
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
				'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
														'&token='.Tools::getAdminTokenLite ('AdminModules')
			),
			'back'          => array(
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
		$id_spextraslider = Tools::getValue ('id_spextraslider');
		if (Tools::isSubmit ('id_spextraslider') && $id_spextraslider)
		{
			$extraslider = new SpExtraSliderClass((int)$id_spextraslider);
			$this->fields_form[0]['form']['input'][] = array(
				'type' => 'hidden',
				'name' => 'id_spextraslider'
			);
			$params = unserialize($extraslider->params);
			$helper->fields_value['id_spextraslider'] = (int)Tools::getValue ('id_spextraslider',
				$extraslider->id_spextraslider);
		}
		else
		{
			$extraslider = new SpExtraSliderClass();
			$params = array();
		}
		foreach (Language::getLanguages (false) as $lang)
		{
			$extraslider_title_module = $extraslider->title_module[(int)$lang['id_lang']];
			$title_module_lang = 'title_module_'.(int)$lang['id_lang'];
			$helper->fields_value['title_module'][(int)$lang['id_lang']] = Tools::getValue($title_module_lang, $extraslider_title_module);
		}

		$helper->fields_value['hook'] = (string)Tools::getValue('hook', $extraslider->hook);
		$helper->fields_value['active'] = (int)Tools::getValue('active', $extraslider->active);
		$display_title_module = isset( $params['display_title_module'] ) ? $params['display_title_module']:1;
		$moduleclass_sfx = isset( $params['moduleclass_sfx'] ) ? $params['moduleclass_sfx']:'';
		$helper->fields_value['moduleclass_sfx'] = Tools::getValue('moduleclass_sfx', $moduleclass_sfx);
		$helper->fields_value['display_title_module'] = (int)Tools::getValue('display_title_module', $display_title_module);

		$helper->fields_value['nb_column1'] = (int)Tools::getValue('nb_column1', isset( $params['nb_column1'] )?$params['nb_column1']:6);
		$helper->fields_value['nb_column2'] = (int)Tools::getValue('nb_column2', isset( $params['nb_column2'] )?$params['nb_column2']:4);
		$helper->fields_value['nb_column3'] = (int)Tools::getValue('nb_column3', isset( $params['nb_column3'] )?$params['nb_column3']:2);
		$helper->fields_value['nb_column4'] = (int)Tools::getValue('nb_column5', isset( $params['nb_column4'] )?$params['nb_column4']:1);
		$helper->fields_value['target'] = (string)Tools::getValue('target', isset( $params['target'] )?$params['target']:'_self');
		$helper->fields_value['layout'] = (string)Tools::getValue('layout', isset( $params['layout'] )?$params['layout']:'style1');
		$helper->fields_value['nb_rows'] = (int)Tools::getValue('nb_rows', isset( $params['nb_rows'] )?$params['nb_rows']:2);
		$helper->fields_value['button_page'] = (string)Tools::getValue('button_page', isset( $params['button_page'] )?$params['button_page']:'top');

		if ($this->getCatSelect(true) != null && isset($params['catids']))
		{
			if ($params['catids'] == 'all')
				$catids = array_slice($this->getCatSelect(true), 0, 5);
			else
				$catids = $params['catids'];
		}
		else
			$catids = false;
		if (!is_array($catids))
		$catids = explode(',', $catids);
		$helper->fields_value['catids[]'] = $catids;
		$products_ordering = (isset( $params['products_ordering'])) ? $params['products_ordering'] : 'name';
		$helper->fields_value['products_ordering'] = (string)Tools::getValue('products_ordering', $products_ordering);
		$ordering_direction = (isset($params['ordering_direction'])) ? $params['ordering_direction'] : 'DESC';
		$helper->fields_value['ordering_direction'] = (string)Tools::getValue('ordering_direction', $ordering_direction);
		$helper->fields_value['count_number'] = (int)Tools::getValue('count_number', isset( $params['count_number'] )?$params['count_number']:8);
		$is_deal = isset( $params['is_deal'] ) ? $params['is_deal'] : 1;
		$helper->fields_value['is_deal'] = (int)Tools::getValue('is_deal', $is_deal);
		
		$helper->fields_value['image_size'] = Tools::getValue('image_size', ( isset( $params['image_size'] ) )?$params['image_size']:'');
		$helper->fields_value['display_name'] = (int)Tools::getValue('display_name', isset( $params['display_name'] )?$params['display_name']:1);
		$name_maxlength = isset( $params['name_maxlength'] )?$params['name_maxlength']:25;
		$helper->fields_value['name_maxlength'] = (int)Tools::getValue('name_maxlength', $name_maxlength);
		$display_description = isset( $params['display_description'] )?$params['display_description']:0;
		$helper->fields_value['display_description'] = (int)Tools::getValue('display_description', $display_description);
		$helper->fields_value['description_maxlength'] = (int)Tools::getValue ('description_maxlength',
			isset( $params['description_maxlength'] )?$params['description_maxlength']:100);
		$helper->fields_value['display_price'] = (int)Tools::getValue('display_price', isset( $params['display_price'] )?$params['display_price']:1);
		$display_addtocart = isset($params['display_addtocart']) ? $params['display_addtocart'] : 1;
		$helper->fields_value['display_addtocart'] = (int)Tools::getValue('display_addtocart', $display_addtocart);
		//$display_wishlist = isset($params['display_wishlist']) ? $params['display_wishlist']:1;
		//$helper->fields_value['display_wishlist'] = (int)Tools::getValue('display_wishlist', $display_wishlist);
		//$display_compare = isset( $params['display_compare'] ) ? $params['display_compare'] : 1;
		//$helper->fields_value['display_compare'] = (int)Tools::getValue('display_compare', $display_compare);
		$display_quickview = isset($params['display_quickview']) ? $params['display_quickview'] : 1;
		$helper->fields_value['display_quickview'] = (int)Tools::getValue('display_quickview', $display_quickview);
		$helper->fields_value['display_availability'] = (int)Tools::getValue ('display_availability',
			isset( $params['display_availability'] )?$params['display_availability']:1);
		$helper->fields_value['display_variant'] = (int)Tools::getValue ('display_variant',
			isset( $params['display_variant'] )?$params['display_variant']:1);			
		$helper->fields_value['display_new'] = (int)Tools::getValue('display_new', isset($params['display_new']) ? $params['display_new']:1);
		$helper->fields_value['display_sale'] = (int)Tools::getValue('display_sale', isset($params['display_sale']) ? $params['display_sale']:1);

		$helper->fields_value['margin'] = (int)Tools::getValue('margin', isset($params['margin']) ? $params['margin'] : 5);
		$helper->fields_value['slideBy'] = (int)Tools::getValue('slideBy', isset($params['slideBy']) ? $params['slideBy']:1);
		$helper->fields_value['autoplay'] = (int)Tools::getValue('autoplay', isset($params['autoplay']) ? $params['autoplay']:1);
		$autoplay_timeout = isset($params['autoplay_timeout']) ? $params['autoplay_timeout'] : 1000;
		$helper->fields_value['autoplay_timeout'] = (int)Tools::getValue('autoplay_timeout', $autoplay_timeout);
		$autoplay_hover_pause = isset($params['autoplay_hover_pause']) ? $params['autoplay_hover_pause'] : 1;
		$helper->fields_value['autoplay_hover_pause'] = (string)Tools::getValue('autoplay_hover_pause', $autoplay_hover_pause);
		$helper->fields_value['autoplaySpeed'] = (int)Tools::getValue('autoplaySpeed', isset( $params['autoplaySpeed'] )?$params['autoplaySpeed']:1000);
		$helper->fields_value['smartSpeed'] = (int)Tools::getValue('smartSpeed', isset( $params['smartSpeed'] )?$params['smartSpeed']:1000);
		$helper->fields_value['startPosition'] = (int)Tools::getValue('startPosition', isset( $params['startPosition'] )?$params['startPosition']:0);
		$helper->fields_value['mouseDrag'] = (int)Tools::getValue('mouseDrag', isset( $params['mouseDrag'] )?$params['mouseDrag']:1);
		$helper->fields_value['touchDrag'] = (int)Tools::getValue('touchDrag', isset( $params['touchDrag'] )?$params['touchDrag']:1);
		$helper->fields_value['pullDrag'] = (int)Tools::getValue('pullDrag', isset( $params['pullDrag'] )?$params['pullDrag']:1);
		$helper->fields_value['dots'] = (int)Tools::getValue('dots', isset( $params['dots'] )?$params['dots']:1);
		$helper->fields_value['dotsSpeed'] = (int)Tools::getValue('dotsSpeed', isset( $params['dotsSpeed'] )?$params['dotsSpeed']:100);
		$helper->fields_value['nav'] = (int)Tools::getValue('nav', isset( $params['nav'] )?$params['nav']:1);
		$helper->fields_value['navspeed'] = (int)Tools::getValue('navspeed', isset( $params['navspeed'] )?$params['dotsSpeed']:100);
		$helper->fields_value['effect'] = (string)Tools::getValue('effect', isset( $params['effect'] )?$params['effect']:'flip');
		$helper->fields_value['duration'] = (int)Tools::getValue('duration', isset( $params['duration'] )?$params['duration']:300);
		$helper->fields_value['delay'] = (int)Tools::getValue('delay', isset( $params['delay'] )?$params['delay']:300);
		$this->html .= $helper->generateForm ($this->fields_form);
	}
	private function getFormValuesCat()
	{
		$id_spextraslider = Tools::getValue ('id_spextraslider');
		if (Tools::isSubmit ('id_spextraslider') && $id_spextraslider)
		{
			$extraslider = new SpExtraSliderClass((int)$id_spextraslider);
			$params = unserialize($extraslider->params);
		}
		else
		{
			$extraslider = new SpExtraSliderClass();
			$params = array();
		}
		if ($this->getCatSelect(true) != null && isset($params['catids']) && $params['catids'])
		{
			if ($params['catids'] == 'all')
				$catids = array_slice($this->getCatSelect(true), 0, 5);
			else
				$catids = $params['catids'];
			$catids = (!empty($catids) && is_string($catids)) ? explode(',', $catids) : $catids;
			$catids = Tools::getValue ('catids', $catids);
			$catids1 = array();
			foreach ($catids as $cat)
				$catids1[] = (int)$cat;
		}
		else
			$catids1 = array();
		return $catids1;
	}

	public function getCatIds($params)
	{
		$catids = ( isset( $params['catids'] ) && $params['catids'] != '' )?explode (',', $params['catids']):'';

		if ($catids == '')
			return;
		return $catids;
	}
	private function getData($params)
	{
		if ($this->getCatSelect(true) != null && isset($params['catids']))
		{
			if ($params['catids'] == 'all')
				$catids = array_slice($this->getCatSelect(true), 0, 5);
			else
				$catids = $this->getCatIds($params);
		}
		if (empty( $catids ))
			return;
		$oder_by = $params['products_ordering'];
		$order_way = $params['ordering_direction'];
		$limit = (int)$params['count_number'];
		$products = $this->getProducts($params,(int)$this->context->language->id, 0, $limit, $oder_by, $order_way, $catids, true);
		if (empty($products))
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
	
		$list = [];
		
		foreach ($products as $product)
		{
			if(isset($params['is_deal']) && $params['is_deal']){
				$product['specific_prices'] = SpecificPriceCore::getByProductId($product['id_product']);
				if (strtotime ($product['specific_prices'][0]['from']) != false && strtotime ($product['specific_prices'][0]['to']) != false)
				{
					$current = date ('Y-m-d H:i:s');
					$start_date = date ('Y-m-d H:i:s', strtotime ($product['specific_prices'][0]['from']));
					$date_end = date ('Y-m-d H:i:s', strtotime ($product['specific_prices'][0]['to']));
					if (strtotime ($date_end) >= strtotime ($current) && strtotime ($start_date) <= strtotime ($date_end))
						$product['specialPriceToDate'] = $date_end;
					$list[] = $presenter->present(
						$presentationSettings,
						$assembler->assembleProduct($product),
						$this->context->language
					);
				}					
			}
			else{
				$list[] = $presenter->present(
					$presentationSettings,
					$assembler->assembleProduct($product),
					$this->context->language
				);				
			}	
		}
		return $list;
	}

	public function getProducts($params,$id_lang, $start, $limit, $order_by, $order_way, $id_category = false,
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
		
		if(isset($params['is_deal']) && $params['is_deal']){
			$specific_price = $this->getProductsSpecialPrice ();
			if (!empty( $specific_price ))
				$specific_price = implode (',', $specific_price);
			else
				return;
		}
		
		$ob_prefix = isset( $order_by_prefix )?(( $order_by_prefix != '' )?pSQL ($order_by_prefix).'.':'' ):'';
		$sql = 'SELECT DISTINCT  p.`id_product`, p.*, product_shop.*, pl.* , m.`name` AS manufacturer_name, s.`name` AS supplier_name,
				MAX(product_attribute_shop.id_product_attribute) id_product_attribute,  MAX(image_shop.`id_image`) id_image,  il.`legend`, 
				ps.`quantity` AS sales, cl.`link_rewrite` AS category, IFNULL(stock.quantity,0) as quantity, IFNULL(pa.minimal_quantity, 
				p.minimal_quantity) as minimal_quantity, stock.out_of_stock,
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
				LEFT JOIN `'._DB_PREFIX_.'supplier` s ON (s.`id_supplier` = p.`id_supplier`)'.
			( $id_category?' LEFT JOIN `'._DB_PREFIX_.'category_product` c ON (c.`id_product` = p.`id_product`)':'' ).'
				WHERE pl.`id_lang` = '.(int)$id_lang.
			( $id_category?' AND c.`id_category` IN ('.implode (', ', $id_category).')':'' ).
			( $front?' AND product_shop.`visibility` IN ("both", "catalog")':'' ).
			( $only_active?' AND product_shop.`active` = 1':'' ) .
			( (isset($params['is_deal']) && $params['is_deal']) ? ' AND  p.`id_product` IN ('.$specific_price.')' : '' ).'				
				GROUP BY  p.`id_product`
				ORDER BY '.$ob_prefix.( $order_by == 'rand'?' rand() ':'`'.pSQL ($order_by).'`' ).pSQL ($order_way).
			( $limit > 0?' LIMIT '.(int)$start.', '.(int)$limit:'' );
		$rq = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS ($sql);
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
			SELECT b.`id_spextraslider`
			FROM `'._DB_PREFIX_.'spextraslider` b
			LEFT JOIN `'._DB_PREFIX_.'spextraslider_shop` bs ON (b.`id_spextraslider` = bs.`id_spextraslider`)
			WHERE bs.`active` = 1 AND (bs.`id_shop` = '.$id_shop.') AND b.`hook` = '.( $id_hook ).'
			ORDER BY b.`ordering`');
			$language_site = '';
			foreach (Language::getLanguages(false) as $lang)
			{
				if ($lang['id_lang'] == $this->context->language->id)
				{
					if ($lang['is_rtl'] == 1)
						$language_site = 'true';
					else
						$language_site = 'false';
				}
			}
			foreach ($results as $row)
			{
				$temp = new SpExtraSliderClass($row['id_spextraslider']);
				$temp->params = unserialize($temp->params);
				$temp->products = $this->getData ($temp->params);
				$temp->language_site = $language_site;
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
		$this->context->controller->addCSS ($this->_path.'views/css/style.css', 'all');
		$this->context->controller->addCSS ($this->_path.'views/css/css3.css', 'all');
		//$this->context->controller->addCSS ($this->_path.'views/css/owl.carousel.css', 'all');
		if (!defined ('OWL_CAROUSEL'))
		{
			$this->context->controller->addJS ($this->_path.'views/js/owl.carousel.js');
			define( 'OWL_CAROUSEL', 1 );
		}
		return $this->display (__FILE__, 'header.tpl');
	}

	public function hookDisplayLeftColumn()
	{
		$smarty = $this->context->smarty;
		$smarty_cache_id = $this->getCacheId ('spextraslider_displayLeftColumn');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayLeftColumn');
			if (empty( $list))
				return;
			$smarty->assign (array(
				'list' => $list,
				'id_lang'	=> $this->context->language->id
			));
		//}
		return $this->fetch('module:spextraslider/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayExtraSlider()
	{
		$smarty = $this->context->smarty;
		$smarty_cache_id = $this->getCacheId ('spextraslider_displayExtraSlider');
		//if (!$this->isCached ('default4.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayExtraSlider');
			if (empty( $list))
				return;
			$smarty->assign (array(
				'list' => $list,
				'id_lang'	=> $this->context->language->id
			));
		//}
		return $this->fetch('module:spextraslider/views/templates/hook/default4.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayExtraSlider2()
	{
		$smarty = $this->context->smarty;
		$smarty_cache_id = $this->getCacheId ('spextraslider_displayExtraSlider2');
		//if (!$this->isCached ('default2.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayExtraSlider2');
			if (empty( $list))
				return;
			$smarty->assign (array(
				'list' => $list,
				'id_lang'	=> $this->context->language->id
			));
		//}
		return $this->fetch('module:spextraslider/views/templates/hook/default2.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayExtraSlider3()
	{
		$smarty = $this->context->smarty;
		$smarty_cache_id = $this->getCacheId ('spextraslider_displayExtraSlider3');
		//if (!$this->isCached ('default3.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayExtraSlider3');
			if (empty( $list))
				return;
			$smarty->assign (array(
				'list' => $list,
				'id_lang'	=> $this->context->language->id
			));
		//}
		return $this->fetch('module:spextraslider/views/templates/hook/default3.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayExtraSlider4()
	{
		$smarty = $this->context->smarty;
		$smarty_cache_id = $this->getCacheId ('spextraslider_displayExtraSlider4');
		//if (!$this->isCached ('default3.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayExtraSlider4');
			if (empty( $list))
				return;
			$smarty->assign (array(
				'list' => $list,
				'id_lang'	=> $this->context->language->id
			));
		//}
		return $this->fetch('module:spextraslider/views/templates/hook/default3.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayExtraSlider5()
	{
		$smarty = $this->context->smarty;
		$smarty_cache_id = $this->getCacheId ('spextraslider_displayExtraSlider5');
		//if (!$this->isCached ('default3.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayExtraSlider5');
			if (empty( $list))
				return;
			$smarty->assign (array(
				'list' => $list,
				'id_lang'	=> $this->context->language->id
			));
		//}
		return $this->fetch('module:spextraslider/views/templates/hook/default3.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}


	public function hookDisplayExtraSlider6()
	{
		$smarty = $this->context->smarty;
		$smarty_cache_id = $this->getCacheId ('spextraslider_displayExtraSlider6');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayExtraSlider6');
			if (empty( $list))
				return;
			$smarty->assign (array(
				'list' => $list,
				'id_lang'	=> $this->context->language->id
			));
		//}
		return $this->fetch('module:spextraslider/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayExtraSlider7()
	{
		$smarty = $this->context->smarty;
		$smarty_cache_id = $this->getCacheId ('spextraslider_displayExtraSlider7');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayExtraSlider7');
			if (empty( $list))
				return;
			$smarty->assign (array(
				'list' => $list,
				'id_lang'	=> $this->context->language->id
			));
		//}
		return $this->fetch('module:spextraslider/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayExtraSlider8()
	{
		$smarty = $this->context->smarty;
		$smarty_cache_id = $this->getCacheId ('spextraslider_displayExtraSlider8');
		//if (!$this->isCached ('default5.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayExtraSlider8');
			if (empty( $list))
				return;
			$smarty->assign (array(
				'list' => $list,
				'id_lang'	=> $this->context->language->id
			));
		//}
		return $this->fetch('module:spextraslider/views/templates/hook/default5.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	protected function getCacheId($name = null)
	{
		parent::getCacheId ($name);
		$groups = implode (',  ', Customer::getGroupsStatic ((int)$this->context->customer->id));
		$id_lang = (int)$this->context->language->id;

		return $name.'|'.(int)Tools::usingSecureMode ().'|'.$this->context->shop->id.'|'.$groups.'|'.$id_lang;
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
		INSERT IGNORE INTO `'._DB_PREFIX_.'spextraslider_shop` (`id_spextraslider`, `id_shop`)
		SELECT `id_spextraslider`, '.(int)$params['new_id_shop'].'
		FROM `'._DB_PREFIX_.'spextraslider_shop`
		WHERE `id_shop` = '.(int)$params['old_id_shop']);
	}

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
