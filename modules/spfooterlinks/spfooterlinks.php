<?php
/**
 * package SP Footer Links
 *
 * @version 1.0.1
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

if (!defined ('_PS_VERSION_'))
	exit;
include_once ( dirname (__FILE__).'/SpFooterLinksClass.php' );

class SpFooterLinks extends Module
{
	protected $error = false;
	private $html;
	private $default_hook = array(
		'displayFooter',
		'displayFooterLinks',
		'displayFooterLinks2',
		'displayFooterLinks3',
		'displayFooterLinks4',
		'displayFooterLinks5',
		'displayFooterLinks6',
		'displayFooterLinks7',
		'displayFooterLinks8',
		'displayFooterLinks9',
		'displayFooterLinks10',
		'displayFooterLinks11',
		'displayFooterLinks12',
		'displayFooterLinks13',
		'displayFooterLinks14',
		'displayFooterLinks15',
		'displayFooterLinks16',
		'displayFooterLinks17'
		)
	;

	public function __construct()
	{
		$this->name = 'spfooterlinks';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'MagenTech';
		$this->secure_key = Tools::encrypt ($this->name);
		$this->bootstrap = true;
		parent::__construct ();
		$this->displayName = $this->l('SP Footer Links');
		$this->description = $this->l('This Module allows creat footer Links.');
		$this->confirmUninstall = $this->l('Are you sure?');
		$this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);
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
		$spfooterlinks = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spfooterlinks`')
			&& Db::getInstance ()->Execute ('CREATE TABLE `'._DB_PREFIX_.'spfooterlinks` (`id_spfooterlinks` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`hook` int(10) unsigned, 
			`params` text NOT NULL DEFAULT \'\' ,
			`active` tinyint(1) NOT NULL DEFAULT \'1\',
			`ordering` int(10) unsigned NOT NULL,
			`content` text NOT NULL DEFAULT \'\',
			PRIMARY KEY (`id_spfooterlinks`)) ENGINE=InnoDB default CHARSET=utf8');
		$spfooterlinks_shop = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spfooterlinks_shop`')
			&& Db::getInstance ()->Execute ('CREATE TABLE `'._DB_PREFIX_.'spfooterlinks_shop` (`id_spfooterlinks` int(10) unsigned NOT NULL,
			`id_shop` int(10) unsigned NOT NULL, 
			`active` tinyint(1) NOT NULL DEFAULT \'1\',
			PRIMARY KEY (`id_spfooterlinks`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8');
		$spfooterlinks_lang = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spfooterlinks_lang`')
			&& Db::getInstance ()->Execute ('CREATE TABLE '._DB_PREFIX_.'spfooterlinks_lang (`id_spfooterlinks` int(10) unsigned NOT NULL,
			`id_lang` int(10) unsigned NOT NULL,
			`title_module` varchar(255) NOT NULL DEFAULT \'\',
			PRIMARY KEY (`id_spfooterlinks`,`id_lang`)) ENGINE=InnoDB default CHARSET=utf8');
		if (!$spfooterlinks || !$spfooterlinks_shop || !$spfooterlinks_lang)
			return false;

		$this->installFixtures();

		return true;
	}

	public function uninstall()
	{
		if (parent::uninstall () == false)
			return false;
		if (!Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spfooterlinks`')
			|| !Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spfooterlinks_shop`')
			|| !Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spfooterlinks_lang`'))
			return false;
		$this->clearCacheItemForHook ();
		return true;
	}
	public function installFixtures()
	{
		$datas = array(
			array(
				'id_spfooterlinks' => 1,
				'title_module' => 'Information',
				'moduleclass_sfx' => 'footer-links col-lg-3 col-md-6 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks'),
				'content' => '#',
				'text' 	=> 'Our Blog, Oders History, My Wishlist, Privacy Policy, Sitemap, Terms & Conditions',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 2,
				'title_module' => 'My Account',
				'moduleclass_sfx' => 'footer-links col-lg-3 col-md-6 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks2'),
				'content' => '#',
				'text' 	=> 'My Account, Shopping Cart, Checkout, Wishlist, Newsletter, Custom Link',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 3,
				'title_module' => 'fashion & accessories',
				'moduleclass_sfx' => 'footer-links col-lg-3 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks3'),
				'content' => '#',
				'text' 	=> 'Clothing, Shoes, Jewelry, Watches, Handbags & Walletss, Accessories',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 4,
				'title_module' => 'spa & massage',
				'moduleclass_sfx' => 'footer-links col-lg-3 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks4'),
				'content' => '#',
				'text' 	=> 'Makeup, Skin Care, Hair Care, Tools & Accessories, Perfume & Cologne, More to Explore',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 5,
				'title_module' => 'travel & vacation',
				'moduleclass_sfx' => 'footer-links col-lg-3 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks5'),
				'content' => '#',
				'text' 	=> 'Top 10 Hotels, Travel Tour, Bundle Deal, Top Fights, Vacation Retals, Cruise',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 6,
				'title_module' => 'electronics',
				'moduleclass_sfx' => 'footer-links col-lg-3 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks6'),
				'content' => '#',
				'text' 	=> 'Home Audio & Theater, Camera, Photo & Video, Cell Phones, Headphones, Video Games, Bluetooth',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 7,
				'title_module' => 'sport & Entertaiment',
				'moduleclass_sfx' => 'footer-links col-lg-3 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks7'),
				'content' => '#',
				'text' 	=> 'Yoga & Fitness, Games, Cinema, Studio, Music, Shopping',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 8,
				'title_module' => 'food & restaurant',
				'moduleclass_sfx' => 'footer-links col-lg-3 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks8'),
				'content' => '#',
				'text' 	=> 'Fast Food, Buffet, Café, Drink, Cake, Restaurant',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 9,
				'title_module' => 'health & beauty',
				'moduleclass_sfx' => 'footer-links col-lg-3 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks9'),
				'content' => '#',
				'text' 	=> 'Makeup, Skin Care, Hair Care, Tools & Accessories, Perfume & Cologne, More to Explore',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 10,
				'title_module' => 'Book Stationery',
				'moduleclass_sfx' => 'footer-links col-lg-3 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks10'),
				'content' => '#',
				'text' 	=> 'Award Winners, Bargain Books, Best Books of 2016, Best Books of the Month, Books in Spanish, Children Books',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 11,
				'title_module' => 'Real house',
				'moduleclass_sfx' => 'footer-links col-lg-3 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks11'),
				'content' => '#',
				'text' 	=> 'Makeup, Skin Care, Hair Care, Tools & Accessories, Perfume & Cologne, More to Explore',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 12,
				'title_module' => 'Mom & baby care',
				'moduleclass_sfx' => 'footer-links col-lg-3 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks12'),
				'content' => '#',
				'text' 	=> 'Award Winners, Bargain Books, Best Books of 2016, Best Books of the Month, Books in Spanish, Children Books',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 13,
				'title_module' => 'Trade Services',
				'moduleclass_sfx' => 'footer-links col-lg-2 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks13'),
				'content' => '#',
				'text' 	=> 'Trade Assurance, Business Identity, Logistics Service, Secure Payment, Inspection Services, Request for Quotation',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 14,
				'title_module' => 'POLICY INFO',
				'moduleclass_sfx' => 'footer-links col-lg-2 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks14'),
				'content' => '#',
				'text' 	=> 'Privacy Policy, Terms of Sale, Terms of Use, Report Abuse, Policy, CSR Policy',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 15,
				'title_module' => 'Our BUSINESS',
				'moduleclass_sfx' => 'footer-links col-lg-2 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks15'),
				'content' => '#',
				'text' 	=> 'Advertise on TopDeals, Media Enquiries, Be an Affiliate, Deal of the Day, Diwali Offers, Snapdeal Gold',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 16,
				'title_module' => 'Our company',
				'moduleclass_sfx' => 'footer-links col-lg-2 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks16'),
				'content' => '#',
				'text' 	=> 'About Us, Core Values, Careers, Blog, Engineering, Sitemap',
				'link'	=> '#,#,#,#,#,#'
			),
			array(
				'id_spfooterlinks' => 17,
				'title_module' => 'My Account',
				'moduleclass_sfx' => 'footer-links col-lg-2 col-md-4 col-xs-12',
				'display_title_module' => 1,
				'active' => 1,
				'hook' => Hook::getIdByName('displayFooterLinks17'),
				'content' => '#',
				'text' 	=> 'My Account, Shopping Cart, Checkout, Wishlist, Newsletter, Custom Link',
				'link'	=> '#,#,#,#,#,#'
			)
		);
		$return = true;
		foreach ($datas as $i => $data)
		{
			$customs = new SpFooterLinksClass();
			$customs->hook = $data['hook'];
			$customs->active = $data['active'];
			$customs->ordering = $i;
			$customs->params = serialize($data);
			$customs->active = $data['active'];
			$content = array();
			$text = explode(',',$data['text']);
			$link = explode(',',$data['link']);
			foreach (Language::getLanguages(false) as $key=>$lang)
			{
				$customs->title_module[$lang['id_lang']] = $data['title_module'];
				$content['text'][$lang['id_lang']] = $text;
				$content['link'][$lang['id_lang']] = $link;
			}
			$customs->content = json_encode($content,JSON_UNESCAPED_UNICODE);
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
				&& $this->moduleExists((int)Tools::getValue('id_spfooterlinks'))) || Tools::isSubmit ('saveItem'))
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
				$associated_shop_ids = SpFooterLinksClass::getAssociatedIdsShop((int)Tools::getValue('id_spfooterlinks'));
				$context_shop_id = (int)Shop::getContextShopID();

				if ($associated_shop_ids === false)
					$this->html .= $this->getShopAssociationError((int)Tools::getValue('id_spfooterlinks'));
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
			if (Tools::isSubmit('id_spfooterlinks'))
			{
				if (!Validate::isInt(Tools::getValue('id_spfooterlinks'))
					&& !$this->moduleExists(Tools::getValue('id_spfooterlinks')))
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
		}elseif (Tools::isSubmit('id_spfooterlinks')
			&& (!Validate::isInt(Tools::getValue('id_spfooterlinks'))
				|| !$this->moduleExists((int)Tools::getValue('id_spfooterlinks'))))
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
			if (Tools::getValue('id_spfooterlinks'))
			{
				$customhtml = new SpFooterLinksClass((int)Tools::getValue ('id_spfooterlinks'));
				if (!Validate::isLoadedObject($customhtml))
				{
					$this->html .= $this->displayError($this->l('Invalid slide ID'));
					return false;
				}
			}
			else
				$customhtml = new SpFooterLinksClass();
			$next_ps = $this->getNextPosition();
			
			$customhtml->ordering = (!empty($customhtml->ordering)) ? (int)$customhtml->ordering : $next_ps;
			$customhtml->active = (Tools::getValue('active')) ? (int)Tools::getValue('active') : 0;
			$customhtml->hook	= (int)Tools::getValue('hook');
			$customhtml->content  = json_encode(Tools::getValue('content'),JSON_UNESCAPED_UNICODE);	
			$tmp_data = array();
			$id_spfooterlinks = (int)Tools::getValue ('id_spfooterlinks');
			$id_spfooterlinks = $id_spfooterlinks ? $id_spfooterlinks : (int)$customhtml->getHigherModuleID();
			$tmp_data['id_spfooterlinks'] = $id_spfooterlinks;

			$tmp_data['active'] = (int)Tools::getValue ('active', 1);
			$tmp_data['moduleclass_sfx'] = Tools::getValue ('moduleclass_sfx');
			$tmp_data['display_title_module'] = Tools::getValue ('display_title_module');
			$tmp_data['hook '] = Tools::getValue('hook');
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				$customhtml->title_module[$language['id_lang']] = Tools::getValue('title_module_'.$language['id_lang']);
			}
			$customhtml->params = serialize($tmp_data);
			(Tools::getValue ('id_spfooterlinks')
		&& $this->moduleExists((int)Tools::getValue ('id_spfooterlinks')) )? $customhtml->update() : $customhtml->add ();
			$this->clearCacheItemForHook ();
			if (Tools::isSubmit ('saveAndStay'))
			{
				$tool_id_spfooterlinks = Tools::getValue ('id_spfooterlinks');
				$higher_module = $customhtml->getHigherModuleID();
				$id_spfooterlinks = $tool_id_spfooterlinks?(int)$tool_id_spfooterlinks:(int)$higher_module;
				Tools::redirectAdmin ($currentIndex.'&configure='
				.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spfooterlinks='
					.$id_spfooterlinks.'&updateItemConfirmation');
			}
			else
				Tools::redirectAdmin ($currentIndex.'&configure='.$this->name
					.'&token='.Tools::getAdminTokenLite ('AdminModules').'&saveItemConfirmation');
		}
		elseif (Tools::isSubmit('changeStatusItem') && Tools::getValue ('id_spfooterlinks'))
		{
			$customhtml = new SpFooterLinksClass((int)Tools::getValue ('id_spfooterlinks'));
			if ($customhtml->active == 0)
				$customhtml->active = 1;
			else
				$customhtml->active = 0;
			//$customhtml->updateStatus (Tools::getValue ('active'));
			$customhtml->update();
			$this->clearCacheItemForHook ();
			Tools::redirectAdmin ($currentIndex.'&configure='.$this->name
				.'&token='.Tools::getAdminTokenLite ('AdminModules'));
		}
		elseif (Tools::isSubmit ('deleteItem') && Tools::getValue ('id_spfooterlinks'))
		{
			$customhtml = new SpFooterLinksClass((int)Tools::getValue ('id_spfooterlinks'));
			$customhtml->delete ();
			$this->clearCacheItemForHook ();
			Tools::redirectAdmin ($currentIndex.'&configure='.$this->name.'&token='
				.Tools::getAdminTokenLite ('AdminModules').'&deleteItemConfirmation');
		}
		elseif (Tools::isSubmit ('duplicateItem') && Tools::getValue ('id_spfooterlinks'))
		{
			$customhtml = new SpFooterLinksClass(Tools::getValue ('id_spfooterlinks'));
			foreach (Language::getLanguages (false) as $lang)
				$customhtml->title_module[(int)$lang['id_lang']] = $customhtml->title_module[(int)$lang['id_lang']]
					.$this->l(' (Copy)');
			$customhtml->duplicate();
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
	public function moduleExists($id_spfooterlinks)
	{
		$req = 'SELECT cs.`id_spfooterlinks` 
				FROM `'._DB_PREFIX_.'spfooterlinks` cs
				WHERE cs.`id_spfooterlinks` = '.(int)$id_spfooterlinks;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}
	public function getNextPosition()
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT MAX(cs.`ordering`) AS `next_position`
			FROM `'._DB_PREFIX_.'spfooterlinks` cs, `'._DB_PREFIX_.'spfooterlinks_shop` css
			WHERE css.`id_spfooterlinks` = cs.`id_spfooterlinks` AND css.`id_shop` = '.(int)$this->context->shop->id
		);

		return (++$row['next_position']);
	}

	private function getGridItems()
	{
		$this->context = Context::getContext ();
		$id_lang = $this->context->language->id;
		$id_shop = $this->context->shop->id;
		$sql = 'SELECT b.`id_spfooterlinks`,  b.`hook`, b.`ordering`, bs.`active`, bl.`title_module`
			FROM `'._DB_PREFIX_.'spfooterlinks` b
			LEFT JOIN `'._DB_PREFIX_.'spfooterlinks_shop` bs ON (b.`id_spfooterlinks` = bs.`id_spfooterlinks` )
			LEFT JOIN `'._DB_PREFIX_.'spfooterlinks_lang` bl ON (b.`id_spfooterlinks` = bl.`id_spfooterlinks`)
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
					$associated_shop_ids = SpFooterLinksClass::getAssociatedIdsShop((int)$mod['id_spfooterlinks']);
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
			foreach ($modules as $customhtml)
			{
				$this->html .= '
				<tr id="item_'.$customhtml['id_spfooterlinks'].'" class=" '.( $irow ++ % 2?' ':'' ).'">
					<td class=" 	" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spfooterlinks='
					.$customhtml['id_spfooterlinks'].'\'">'
					.$customhtml['id_spfooterlinks'].'</td>
					<td class=" dragHandle"><div class="dragGroup"><div class="positions">'.$customhtml['ordering']
					.'</div></div></td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&editItem&id_spfooterlinks='.$customhtml['id_spfooterlinks'].'\'">'.$customhtml['title_module']
					.' '.($customhtml['is_shared'] ? '<span class="label color_field"
		style="background-color:#108510;color:white;margin-top:5px;">'.$this->l('Shared').'</span>' : '').'</td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name
					.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spfooterlinks='
					.$customhtml['id_spfooterlinks'].'\'">'
					.( Validate::isInt ($customhtml['hook'])?$this->getHookTitle ($customhtml['hook']):'' ).'</td>
					<td class="  "> <a href="'.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&changeStatusItem&id_spfooterlinks='.$customhtml['id_spfooterlinks'].'&status='
					.$customhtml['active'].'&hook='.$customhtml['hook'].'">'.( $customhtml['active']?'
					<i class="icon-check"></i>':'<i class="icon-remove"></i>' ).'</a> </td>
					<td class="text-right">
						<div class="btn-group-action">
							<div class="btn-group pull-right">
								<a class="btn btn-default" href="'.$currentIndex.'&configure='.$this->name.'&token='
		.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spfooterlinks='.$customhtml['id_spfooterlinks'].'">
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
					.Tools::getAdminTokenLite ('AdminModules').'&duplicateItem&id_spfooterlinks='
					.$customhtml['id_spfooterlinks'].'">
											<i class="icon-copy"></i> '.$this->l('Duplicate').'
										</a>								
									</li>
									<li class="divider"></li>
									<li>
										<a title ="'.$this->l('Delete').'" onclick="return confirm(\''
					.$this->l('Are you sure?').'\');" href="'.$currentIndex
					.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&deleteItem&id_spfooterlinks='
					.$customhtml['id_spfooterlinks'].'">
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
					'type'         => 'file_lang',
					'name'         => 'content',
					'lang'         => true,
					'cols'         => 40,
					'rows'         => 10
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
		$helper->name_controller = 'spfooterlinks';
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
		$id_spfooterlinks = (int)Tools::getValue ('id_spfooterlinks');

		if (Tools::isSubmit ('id_spfooterlinks') && $id_spfooterlinks)
		{
			$customhtml = new SpFooterLinksClass((int)$id_spfooterlinks);
			$params = unserialize($customhtml->params);
			$this->fields_form[0]['form']['input'][] = array(
				'type' => 'hidden',
				'name' => 'id_spfooterlinks' );
		$helper->fields_value['id_spfooterlinks'] = Tools::getValue ('id_spfooterlinks', $customhtml->id_spfooterlinks);
		}
		else
		{
			$customhtml = new SpFooterLinksClass();
			$params = array();
		}
		foreach (Language::getLanguages (false) as $lang)
		{
			$helper->fields_value['title_module'][(int)$lang['id_lang']] = Tools::getValue ('title_module_'
				.(int)$lang['id_lang'],
				$customhtml->title_module[(int)$lang['id_lang']]);			
		}
		$helper->fields_value['hook'] = Tools::getValue ('hook', $customhtml->hook);
		$helper->fields_value['active'] = (int)Tools::getValue('active', $customhtml->active);
		$content = json_decode(Tools::getValue('content', $customhtml->content),JSON_UNESCAPED_UNICODE);
		//echo "<pre>".print_r($content,1);die();
		$helper->fields_value['content'] = $content;
		$display_title_module = isset( $params['display_title_module'] ) ? $params['display_title_module'] : 1;
		$helper->fields_value['display_title_module'] = Tools::getValue ('display_title_module', $display_title_module);
		$helper->fields_value['moduleclass_sfx'] = Tools::getValue ('moduleclass_sfx',
			isset($params['moduleclass_sfx']) ? $params['moduleclass_sfx'] : '' );	
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
			$sql = 'SELECT * FROM `'._DB_PREFIX_.'spfooterlinks` b
			LEFT JOIN `'._DB_PREFIX_.'spfooterlinks_shop` bs ON (b.`id_spfooterlinks` = bs.`id_spfooterlinks`)
			LEFT JOIN `'._DB_PREFIX_.'spfooterlinks_lang` bl ON (b.`id_spfooterlinks` = bl.`id_spfooterlinks`)
			WHERE bs.`active` = 1 AND (bs.`id_shop` = '.$id_shop.')
			AND (bl.`id_lang` = '.$id_lang.')
			AND b.`hook` = '.( $id_hook ).' ORDER BY b.`ordering`';
			$results = Db::getInstance ()->ExecuteS ($sql);
			foreach ($results as &$row)
			{
				$row['params'] = unserialize($row['params']);
				$row['content'] = json_decode($row['content'],JSON_UNESCAPED_UNICODE);
			}
		}
		return $results;
	}

	public function hookHeader()
	{
		$this->context->controller->addCSS ($this->_path.'views/css/style.css', 'all');
	}

	public function hookDisplayTop()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayTop');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayTop');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayHome()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayHome');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayHome');
			if (empty($list))
				return;
			
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookdisplayLeftColumn()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayLeftColumn');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayLeftColumn');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookdisplayRightColumn()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayRightColumn');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayRightColumn');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooter()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooter');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooter');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks2()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks2');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks2');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks3()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks3');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks3');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks4()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks4');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks4');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks5()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks5');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks5');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks6()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks6');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks6');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks7()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks7');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks7');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks8()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks8');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks8');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks9()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks9');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks9');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks10()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks10');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks10');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks11()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks11');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks11');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks12()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks12');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks12');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks13()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks13');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks13');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks14()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks14');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks14');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks15()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks15');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks15');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks16()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks16');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks16');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterLinks17()
	{
		$smarty_cache_id = $this->getCacheId ('spfooterlinks_displayFooterLinks17');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterLinks17');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list,
				'id_lang'	=> Context::getContext()->language->id
			));
		//}
		return $this->fetch('module:spfooterlinks/views/templates/hook/default.tpl');
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

	private function getShopAssociationError($id_customhtml)
	{
		return '<p class="alert alert-danger">'.
			sprintf($this->l('Unable to get module shop association information (id_module: %d)'), (int)$id_customhtml).
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
		INSERT IGNORE INTO `'._DB_PREFIX_.'spfooterlinks_shop` (`id_spfooterlinks`, `id_shop`)
		SELECT `id_spfooterlinks`, '.(int)$params['new_id_shop'].'
		FROM `'._DB_PREFIX_.'spfooterlinks_shop`
		WHERE `id_shop` = '.(int)$params['old_id_shop']);
	}
}
