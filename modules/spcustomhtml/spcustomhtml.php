<?php
/**
 * package SP Custom Html
 *
 * @version 1.0.1
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

if (!defined ('_PS_VERSION_'))
	exit;
include_once ( dirname (__FILE__).'/SpCustomHtmlClass.php' );

class SpCustomHtml extends Module
{
	protected $error = false;
	private $html;
	private $default_hook = array( 
		'displayCustomhtml1',
		'displayCustomhtml2',
		'displayCustomhtml3',
		'displayCustomhtml4',
		'displayCustomhtml5',
		'displayCustomhtml6',
		'displayCustomhtml7',
		'displayCustomhtml8',
		'displayCustomhtml9',
		'displayCustomhtml10',
		'displayCustomhtml11',
		'displayCustomhtml12',
		'displayCustomhtml13',
		'displayCustomhtml14',
		'displayCustomhtml15',
		'displayCustomhtml16',
		'displayCustomhtml17',
		'displayCustomhtml18',
		'displayCustomhtml19',
		'displayCustomhtml20',
		'displayFooter',
		'displayLeftColumn',
		'displayFooterMiddle',
		'displayFooterBottom',
		'displayCustomProduct');

	public function __construct()
	{
		$this->name = 'spcustomhtml';
		$this->tab = 'front_office_features';
		$this->version = '1.1.0';
		$this->author = 'MagenTech';
		$this->secure_key = Tools::encrypt ($this->name);
		$this->bootstrap = true;
		parent::__construct ();
		$this->displayName = $this->l('SP Custom Html');
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
		$spcustomhtml = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spcustomhtml`')
			&& Db::getInstance ()->Execute ('CREATE TABLE `'._DB_PREFIX_.'spcustomhtml` (`id_spcustomhtml` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`hook` int(10) unsigned, 
			`params` text NOT NULL DEFAULT \'\' ,
			`active` tinyint(1) NOT NULL DEFAULT \'1\',
			`ordering` int(10) unsigned NOT NULL,
			PRIMARY KEY (`id_spcustomhtml`)) ENGINE=InnoDB default CHARSET=utf8');
		$spcustomhtml_shop = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spcustomhtml_shop`')
			&& Db::getInstance ()->Execute ('CREATE TABLE `'._DB_PREFIX_.'spcustomhtml_shop` (`id_spcustomhtml` int(10) unsigned NOT NULL,
			`id_shop` int(10) unsigned NOT NULL, 
			`active` tinyint(1) NOT NULL DEFAULT \'1\',
			PRIMARY KEY (`id_spcustomhtml`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8');
		$spcustomhtml_lang = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spcustomhtml_lang`')
			&& Db::getInstance ()->Execute ('CREATE TABLE '._DB_PREFIX_.'spcustomhtml_lang (`id_spcustomhtml` int(10) unsigned NOT NULL,
			`id_lang` int(10) unsigned NOT NULL,
			`title_module` varchar(255) NOT NULL DEFAULT \'\',
			`content` text,
			PRIMARY KEY (`id_spcustomhtml`,`id_lang`)) ENGINE=InnoDB default CHARSET=utf8');
		if (!$spcustomhtml || !$spcustomhtml_shop || !$spcustomhtml_lang)
			return false;

		$this->installFixtures();

		return true;
	}

	public function uninstall()
	{
		if (parent::uninstall () == false)
			return false;
		if (!Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spcustomhtml`')
			|| !Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spcustomhtml_shop`')
			|| !Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spcustomhtml_lang`'))
			return false;
		$this->clearCacheItemForHook ();
		return true;
	}
	public function installFixtures()
	{
		$ps_root_dir=str_replace("\\","/",__PS_BASE_URI__);
		$datas = array(
			array(
				'active' => 1,
				'id_spcustomhtml' => 1,
				'hook' => Hook::getIdByName('displayCustomhtml1'),
				'title_module' => 'Coupon Code',
				'content' => '
					<div class="coupon-code">
						<p class="phone">[ SPECIAL DEAL ]  Sale Off 75% All iPhone 4 In All Store - Coupon Code NY2017</p>
					</div>
				',
				'moduleclass_sfx' => '',
				'display_title_module' => 0
			),
			array(
				'active' => 1,
				'id_spcustomhtml' => 2,
				'hook' => Hook::getIdByName('displayCustomhtml2'),
				'title_module' => 'Contact Html',
				'content' => '
								<div class="contact-html clearfix">
									<span class="email">Marketing@topdeal.com</span>
									<span class="add">Manhattan St, Amarillo, US</span>
								</div>
							',
				'moduleclass_sfx' => '',
				'display_title_module' => 0
			),
			array(
				'active' => 1,
				'id_spcustomhtml' => 3,
				'hook' => Hook::getIdByName('displayCustomhtml3'),
				'title_module' => 'Call Us',
				'content' => '
								<div class="call-us hidden-sm-down">
									<div class="icon"></div>
									<div class="text">
										<p class="text">Free Call Us</p>
										<p class="phone">(+123) 456 7890</p>
									</div>
								</div>
							',
				'moduleclass_sfx' => '',
				'display_title_module' => 0
			),
			array(
				'active' => 1,
				'id_spcustomhtml' => 4,
				'hook' => Hook::getIdByName('displayCustomhtml4'),
				'title_module' => 'Hashtags',
				'content' => '
									<div class="hashtags clearfix">
									<h3 class="title_block">Hashtags</h3>
									<ul class="clearfix">
									<li class="item col-md-2 col-sm-4 col-xs-4">
									<div class="item-image"><a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/tag-1.jpg" width="178" height="109" alt="#" /></a></div>
									<div class="item-content">
									<h4><a href="#">#Menfashion</a></h4>
									</div>
									</li>
									<li class="item col-md-2 col-sm-4 col-xs-4">
									<div class="item-image"><a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/tag-2.jpg" width="178" height="109" alt="#" /></a></div>
									<div class="item-content">
									<h4><a href="#">#Macbook</a></h4>
									</div>
									</li>
									<li class="item col-md-2 col-sm-4 col-xs-4">
									<div class="item-image"><a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/tag-3.jpg" width="178" height="109" alt="#" /></a></div>
									<div class="item-content">
									<h4><a href="#">#Kiddresses</a></h4>
									</div>
									</li>
									<li class="item col-md-2 hidden-sm-down">
									<div class="item-image"><a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/tag-4.jpg" width="178" height="109" alt="#" /></a></div>
									<div class="item-content">
									<h4><a href="#">#Cosmetics</a></h4>
									</div>
									</li>
									<li class="item col-sm-2 hidden-sm-down">
									<div class="item-image"><a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/tag-5.jpg" width="178" height="109" alt="#" /></a></div>
									<div class="item-content">
									<h4><a href="#">#Shoes</a></h4>
									</div>
									</li>
									<li class="item col-sm-2 hidden-sm-down">
									<div class="item-image"><a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/tag-6.jpg" width="178" height="109" alt="#" /></a></div>
									<div class="item-content">
									<h4><a href="#">#Women Fahion</a></h4>
									</div>
									</li>
									</ul>
									<div class="more"><a href="#"> View All </a></div>
									</div>
							',
				'moduleclass_sfx' => '',
				'display_title_module' => 0
			),
			array(
				'active' => 1,
				'id_spcustomhtml' => 5,
				'hook' => Hook::getIdByName('displayCustomhtml5'),
				'title_module' => 'Trending Search',
				'content' => '
								<div class="trending clearfix">
									<div class="text col-md-2 col-sm-3 col-xs-4">
										<h3 class="title-block"><span>Trending</span> Search</h3>
									</div>

									<div class="item col-md-10 col-sm-9 col-xs-8 clearfix">
										<ul class="out-content owl-carousel">
											<li class="item item-1">
												<div class="item-content">
													<h4><a href="#">Men Fahion</a></h4>
												</div>
												<div class="item-image"><a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/home-image-1-1.jpg" width="130" height="130" alt="#" /></a></div>
											</li>
											<li class="item item-2">
												<div class="item-content">
													<h4><a href="#">Iphone 6</a></h4>
												</div>
												<div class="item-image">
													<a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/home-image-1-2.jpg" width="130" height="130" alt="#" /></a>
												</div>
											</li>
											<li class="item item-3">
												<div class="item-content">
													<h4><a href="#">Women Shoes</a></h4>
												</div>
												<div class="item-image">
													<a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/home-image-1-3.jpg" width="130" height="130" alt="#" /></a>
												</div>
											</li>
											<li class="item  item-4">
												<div class="item-content">
													<h4><a href="#">Kid Dress</a></h4>
												</div>
												<div class="item-image">
													<a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/home-image-1-4.jpg" width="130" height="130" alt="#" /></a>
												</div>
											</li>
											<li class="item  item-4">
												<div class="item-content">
													<h4><a href="#">Jean</a></h4>
												</div>
												<div class="item-image">
													<a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/home-image-1-5.jpg" width="130" height="130" alt="#" /></a>
												</div>
											</li>
											<li class="item  item-4">
												<div class="item-content">
													<h4><a href="#">Watches</a></h4>
												</div>
												<div class="item-image">
													<a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/home-image-1-6.jpg" width="130" height="130" alt="#" /></a>
												</div>
											</li>
										</ul>
									</div>
								</div>
							',
				'moduleclass_sfx' => '',
				'display_title_module' => 0
			),

			array(
				'active' => 1,
				'id_spcustomhtml' => 6,
				'hook' => Hook::getIdByName('displayCustomhtml6'),
				'title_module' => 'Bonus Menu',
				'content' => '
								<div class="clearfix bonus-menu">
									<ul>
										<li class="item free col-md-3">
											<div class="icon">
												<img alt="#" src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/icon/icon-ship.png">
											</div>
											<div class="text">
												<h5><a href="#">Free shipping</a></h5>
												<p>Free shipping on oder over $100</p>
											</div>
										</li>
										<li class="item secure col-md-3">
											<div class="icon">
												<img alt="#" src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/icon/icon-sec.png">
											</div>
											<div class="text">
												<h5><a href="#">Secure Payment</a></h5>
												<p>We value your security</p>
											</div>
										</li>
										<li class="item support col-md-3">
											<div class="icon">
												<img alt="#" src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/icon/icon-support.png">
											</div>
											<div class="text">
												<h5><a href="#">Online support</a></h5>
												<p>We have support 24/7</p>
											</div>
										</li>
										<li class="item payment col-md-3">
											<div class="icon">
												<img alt="#" src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/icon/icon-pay.png">
											</div>
											<div class="text">
												<h5><a href="#">Payment on Delivery</a></h5>
												<p>Cash on delivery option</p>
											</div>
										</li>
									</ul>
								</div>
							',
				'moduleclass_sfx' => '',
				'display_title_module' => 0
			),

			array(
				'active' => 1,
				'id_spcustomhtml' => 7,
				'hook' => Hook::getIdByName('displayCustomhtml7'),
				'title_module' => 'App Store',
				'content' => '
								<div>
									<a class="app-1" href="#">google store</a> 
									<a class="app-2" href="#">apple store</a>
									<a class="app-3" href="#">window store</a>
								</div>
							',
				'moduleclass_sfx' => 'app-store',
				'display_title_module' => 0
			),
			array(
				'active' => 1,
				'id_spcustomhtml' => 8,
				'hook' => Hook::getIdByName('displayCustomhtml8'),
				'title_module' => 'Footer Top Links',
				'content' => '
								<div class="footer-toplinks">
								<div class="links"><label>Mobiles:</label>
								<ul>
								<li><a href="#">HTC Mobiles</a></li>
								<li><a href="#">iPhones</a></li>
								<li><a href="#">Gionee Mobiles</a></li>
								<li><a href="#">LG Mobiles</a></li>
								<li><a href="#">Karbonn Mobiles</a></li>
								<li><a href="#">Vivo Mobiles</a></li>
								<li><a href="#">Intex Mobiles</a></li>
								<li><a href="#">Micromax Mobiles</a></li>
								<li><a href="#">Asus Mobiles</a></li>
								<li><a href="#">Samsung Mobiles</a></li>
								<li><a href="#">Lenovo Mobiles</a></li>
								</ul>
								</div>
								<div class="links"><label>Tablets:</label>
								<ul>
								<li><a href="#">Apple iPads</a></li>
								<li><a href="#">Samsung Tablets</a></li>
								<li><a href="#">Windows Tablets</a></li>
								<li><a href="#">Calling Tablets</a></li>
								<li><a href="#">Micromax Tablets</a></li>
								<li><a href="#">Lenovo Tablets</a></li>
								<li><a href="#">Asus Tablets</a></li>
								<li><a href="#">iBall Tablets</a></li>
								<li><a href="#">Swipe Tablets</a></li>
								</ul>
								</div>
								<div class="links"><label>TVs, Audio & Video:</label>
								<ul>
								<li><a href="#">Televisions</a></li>
								<li><a href="#">LED TVs</a></li>
								<li><a href="#">Smart Televisions</a></li>
								<li><a href="#">Speakers</a></li>
								<li><a href="#">Headphones</a></li>
								<li><a href="#">Earphones</a></li>
								<li><a href="#">Samsung Televisions</a></li>
								<li><a href="#">Micromax Televisions</a></li>
								<li><a href="#">LG Televisions</a></li>
								</ul>
								</div>
								<div class="links"><label>Mobiles Accessories:</label>
								<ul>
								<li><a href="#">Mobile Covers</a></li>
								<li><a href="#">Power Banks</a></li>
								<li><a href="#">Samsung Power Banks</a></li>
								<li><a href="#">Ambrane Power Banks</a></li>
								<li><a href="#">Intex Power Banks</a></li>
								<li><a href="#">Sony Power Banks</a></li>
								<li><a href="#">Lenovo Power Banks</a></li>
								<li><a href="#">PNY Power Banks</a></li>
								</ul>
								</div>
								<div class="links"><label>Computers:</label>
								<ul>
								<li><a href="#">Lenovo Laptops</a></li>
								<li><a href="#">Acer Laptops</a></li>
								<li><a href="#">Apple Macbooks</a></li>
								<li><a href="#">Notebook</a></li>
								<li><a href="#">Laptops</a></li>
								<li><a href="#">External Hard Disks</a></li>
								<li><a href="#">Dell Laptops</a></li>
								<li><a href="#">HP Laptops</a></li>
								</ul>
								</div>
								<div class="links"><label>Camera:</label>
								<ul>
								<li><a href="#">DSLR Cameras</a></li>
								<li><a href="#">Canon Cameras</a></li>
								<li><a href="#">Nikon Coolpix</a></li>
								<li><a href="#">Nikon DSLR Cameras</a></li>
								<li><a href="#">Sony Cameras</a></li>
								<li><a href="#">Digital Cameras</a></li>
								<li><a href="#">Panasonic Cameras</a></li>
								<li><a href="#">Samsung Cameras</a></li>
								</ul>
								</div>
								<div class="links"><label>Watches:</label>
								<ul>
								<li><a href="#">Men Watches</a></li>
								<li><a href="#">Women Watches</a></li>
								<li><a href="#">Casio Watches</a></li>
								<li><a href="#">Titan Watches</a></li>
								<li><a href="#">Fastrack Watches</a></li>
								<li><a href="#">Fossil watches</a></li>
								<li><a href="#">Casio Edifice</a></li>
								<li><a href="#">Tissot Watches</a></li>
								</ul>
								</div>
								<div class="links"><label>Fashion:</label>
								<ul>
								<li><a href="#">Sarees</a></li>
								<li><a href="#">Silk sarees</a></li>
								<li><a href="#">Salwar Suits</a></li>
								<li><a href="#">Lehengas</a></li>
								<li><a href="#">Biba</a></li>
								<li><a href="#">Jewellery</a></li>
								<li><a href="#">Rings</a></li>
								<li><a href="#">Earrings</a></li>
								<li><a href="#">Diamond Rings</a></li>
								<li><a href="#">Loose Diamond</a></li>
								<li><a href="#">Shoes / Boots </a></li>
								</ul>
								</div>
								</div>
							',
				'moduleclass_sfx' => '',
				'display_title_module' => 0
			),
			array(
				'active' => 1,
				'id_spcustomhtml' => 9,
				'hook' => Hook::getIdByName('displayCustomhtml9'),
				'title_module' => 'Category Customer',
				'content' => '
								<div class="clearfix bonus-menu-2">	
										<ul>
											<li class="col-md-4 item home">
												<div class="icon"> </div>
												<div class="text">
													<a>100 S Manhattan St, Amarillo,<a>
													<p>TX 79104, North America</p>
												</div>
											</li>
											<li class="col-md-4 item mail">
												<div class="icon"> </div>
												<div class="text">
													<a class="name" href="#">Sales@MagenTech.Com</a>
													<p>( +123 ) 456 7890</p>
												</div>
											</li>
											<li class="col-md-4 item delivery">
												<div class="icon"> </div>
												<div class="text">
													<a class="name" href="#">Free Delivery</a>
													<p>On order over $89.00</p>
												</div>
											</li>
										</ul>				
								</div>
							',
				'moduleclass_sfx' => '',
				'display_title_module' => 0
			),
			array(
				'active' => 1,
				'id_spcustomhtml' => 10,
				'hook' => Hook::getIdByName('displayCustomhtml10'),
				'title_module' => 'Scoll category',
				'content' => '
								<div class="scoll-cate list_diemneo">
									<ul>
										<li class="neo1">Hotdeal</li>
										<li class="neo2">Spa</li>
										<li class="neo3">Fashion</li>
										<li class="neo4">Travel</li>
										<li class="neo5">Digital</li>
									</ul>
								</div>
							',
				'moduleclass_sfx' => '',
				'display_title_module' => 0
			),
			array(
				'active' => 1,
				'id_spcustomhtml' => 11,
				'hook' => Hook::getIdByName('displayCustomhtml11'),
				'title_module' => 'Bonus Menu 3',
				'content' => '
								<div class="clearfix bonus-menu bonus-menu-3">
									<ul>
										<li class="item free col-md-3">
											<div class="icon">
												<img alt="#" src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/icon/icon-ship-2.png">
											</div>
											<div class="text">
												<h5><a href="#">Free shipping</a></h5>
												<p>Free shipping on oder over $100</p>
											</div>
										</li>
										<li class="item secure col-md-3">
											<div class="icon">
												<img alt="#" src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/icon/icon-sec-2.png">
											</div>
											<div class="text">
												<h5><a href="#">Secure Payment</a></h5>
												<p>We value your security</p>
											</div>
										</li>
										<li class="item support col-md-3">
											<div class="icon">
												<img alt="#" src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/icon/icon-support-2.png">
											</div>
											<div class="text">
												<h5><a href="#">Online support</a></h5>
												<p>We have support 24/7</p>
											</div>
										</li>
										<li class="item payment col-md-3">
											<div class="icon">
												<img alt="#" src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/icon/icon-pay-2.png">
											</div>
											<div class="text">
												<h5><a href="#">Payment on Delivery</a></h5>
												<p>Cash on delivery option</p>
											</div>
										</li>
									</ul>
								</div>
							',
				'moduleclass_sfx' => '',
				'display_title_module' => 0
			),
			array(
				'active' => 1,
				'id_spcustomhtml' => 12,
				'hook' => Hook::getIdByName('displayCustomhtml12'),
				'title_module' => 'Text Html',
				'content' => '
								<div class="text-html">
									<p>Get an extra 10% off on select hotels with Member Pricing. Join now!</p>
								</div>
							',
				'moduleclass_sfx' => '',
				'display_title_module' => 0
			),

			array(
				'active' => 1,
				'id_spcustomhtml' => 13,
				'hook' => Hook::getIdByName('displayCustomhtml13'),
				'title_module' => 'Category',
				'content' => '
								<div class="cate-html">
									<ul class="cate-html-item clearfix">
									<li class="item">
										<div class="item-image"><a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/cate-1.jpg" alt="#" /></a></div>
										<div class="item-content">
										<h4><a href="#">Food & Restaurant</a></h4>
										</div>
									</li>
									<li class="item">
										<div class="item-image"><a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/cate-2.jpg" alt="#" /></a></div>
										<div class="item-content">
										<h4><a href="#">SPA & Massage</a></h4>
										</div>
									</li>
									<li class="item">
										<div class="item-image"><a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/cate-3.jpg" alt="#" /></a></div>
										<div class="item-content">
										<h4><a href="#">Travel</a></h4>
										</div>
									</li>
									<li class="item">
										<div class="item-image"><a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/cate-4.jpg" alt="#" /></a></div>
										<div class="item-content">
										<h4><a href="#">Health Care</a></h4>
										</div>
									</li>
									<li class="item">
										<div class="item-image"><a href="#"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/cate-5.jpg" alt="#" /></a></div>
										<div class="item-content">
										<h4><a href="#">Fashion</a></h4>
										</div>
									</li>
								</ul>
								</div>
							',
				'moduleclass_sfx' => '',
				'display_title_module' => 0
			),


			array(
				'active' => 1,
				'id_spcustomhtml' => 14,
				'hook' => Hook::getIdByName('displayCustomhtml14'),
				'title_module' => 'Trending Search',
				'content' => '
								<a href="#">Letv</a>
								<a href="#">Formal Shoes</a>
								<a href="#">Vivo Mobiles</a>
								<a href="#">Reebook</a>
								<a href="#">Micromax</a>
								<a href="#">Travel Vacation</a>
								<a href="#">Hotel</a>
								<a href="#">Restaurant</a>
							',
				'moduleclass_sfx' => 'trending-search',
				'display_title_module' => 1
			),

			array(
				'active' => 1,
				'id_spcustomhtml' => 15,
				'hook' => Hook::getIdByName('displayCustomhtml15'),
				'title_module' => 'Testimonials',
				'content' => '
							<div class="testimonial-items">
							<div class="item">
							<div class="text">
								<div class="t">
									Lorem Khaled Ipsum is a major key to success. It’s on you how you want to live your life. Everyone has a choice. I pick my choice, squeaky clean
								</div>
							</div>
							<div class="img"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/cus.jpg" alt="#" /></div>
							<div class="name">David Beckham</div>
							<div class="job">CE0 - Magentech</div>
							</div>
							<div class="item">
							<div class="text">
								<div class="t">
									Lorem Khaled Ipsum is a major key to success. It’s on you how you want to live your life. Everyone has a choice. I pick my choice, squeaky clean.
								</div>
							</div>
							<div class="img"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/cus.jpg" alt="#" /></div>
							<div class="name">Johny Walker</div>
							<div class="job">Manager - United</div>
							</div>
							<div class="item">
							<div class="text">
							<div class="t">Lorem Khaled Ipsum is a major key to success. It’s on you how you want to live your life. Everyone has a choice. I pick my choice, squeaky clean.</div>
							</div>
							<div class="img"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/cus.jpg" alt="#" /></div>
							<div class="name">Sharon Stone</div>
							<div class="job">Acc - Hollywood</div>
							</div>
							</div>
							',
				'moduleclass_sfx' => 'testimonials',
				'display_title_module' => 0
			),

			array(
				'active' => 1,
				'id_spcustomhtml' => 16,
				'hook' => Hook::getIdByName('displayCustomhtml16'),
				'title_module' => 'Bonus Menu 4',
				'content' => '
								<div class="clearfix bonus-menu bonus-menu-4">
									<ul>
										<li class="item secure col-md-3">
											<div class="icon">
											</div>
											<div class="text">
												<h5><a href="#">100% Secure Payments</a></h5>
												<p>All major credit & debit</p>
												<p> cards accepted</p>
											</div>
										</li>
										<li class="item help col-md-3">
											<div class="icon">
											</div>
											<div class="text">
												<h5><a href="#">Help Center</a></h5>
												<p>Got a question? Look no further. </p>
												<p> Browse our FAQs or submit your here.</p>
											</div>
										</li>
										<li class="item trustpay col-md-3">
											<div class="icon">
											</div>
											<div class="text">
												<h5><a href="#">TrustPay</a></h5>
												<p>100% Payment Protection. Easy</p>
												<p> Return Policy </p>
											</div>
										</li>
										<li class="item delivery col-md-3">
											<div class="icon">
											</div>
											<div class="text">
												<h5><a href="#">Worldwide Delivery</a></h5>
												<p>With sites in 5 languages, we ship to </p>
												<p>over 200 countries & regions.</p>
											</div>
										</li>
										<li class="item value col-md-3">
											<div class="icon">
											</div>
											<div class="text">
												<h5><a href="#">Great Value</a></h5>
												<p>We offer competitive prices on our 100</p>
												<p>million plus product range.</p>
											</div>
										</li>
									</ul>
								</div>
							',
				'moduleclass_sfx' => '',
				'display_title_module' => 0
			),
			
			array(
				'active' => 1,
				'id_spcustomhtml' => 17,
				'hook' => Hook::getIdByName('displayCustomhtml17'),
				'title_module' => 'Gallery',
				'content' => 	'
									<ul class="group-1">
										<li class="item"><a class="fancybox banner" href="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/1.jpg" data-fancybox-group="gallery" title="Etiam quis mi eu elit temp"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/1-s.jpg" alt="" /></a></li>
										<li class="item"><a class="fancybox banner" href="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/2.jpg" data-fancybox-group="gallery" title="Sed vel sapien vel sem uno"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/2-s.jpg" alt="" /></a></li>
										<li class="item"><a class="fancybox banner" href="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/3.jpg" data-fancybox-group="gallery" title="Etiam quis mi eu elit temp"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/3-s.jpg" alt="" /></a></li>
									</ul>
									<ul class="group-2">
										<li class="item"><a class="fancybox banner" href="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/4.jpg" data-fancybox-group="gallery" title="Cras neque mi, semper leon"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/4-s.jpg" alt="" /></a></li>
										<li class="item"><a class="fancybox banner" href="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/5.jpg" data-fancybox-group="gallery" title="Lorem ipsum dolor sit amet"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/5-s.jpg" alt="" /></a></li>
										<li class="item"><a class="fancybox banner" href="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/6.jpg" data-fancybox-group="gallery" title="Cras neque mi, semper leon"><img src="'.$ps_root_dir.'themes/sp_topdeals/assets/img/cms/6-s.jpg" alt="" /></a></li>
									</ul>
				',
				'moduleclass_sfx' => 'gallery',
				'display_title_module' =>  1
			),
		);
		$return = true;
		foreach ($datas as $i => $data)
		{
			$customs = new SpCustomHtmlClass();
			$customs->hook = $data['hook'];
			$customs->active = $data['active'];
			$customs->ordering = $i;
			$customs->params = serialize($data);
			foreach (Language::getLanguages(false) as $lang)
			{
				$customs->content[$lang['id_lang']] = $data['content'];
				$customs->title_module[$lang['id_lang']] = $data['title_module'];
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
				&& $this->moduleExists((int)Tools::getValue('id_spcustomhtml'))) || Tools::isSubmit ('saveItem'))
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
				$associated_shop_ids = SpCustomHtmlClass::getAssociatedIdsShop((int)Tools::getValue('id_spcustomhtml'));
				$context_shop_id = (int)Shop::getContextShopID();

				if ($associated_shop_ids === false)
					$this->html .= $this->getShopAssociationError((int)Tools::getValue('id_spcustomhtml'));
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
			if (Tools::isSubmit('id_spcustomhtml'))
			{
				if (!Validate::isInt(Tools::getValue('id_spcustomhtml'))
					&& !$this->moduleExists(Tools::getValue('id_spcustomhtml')))
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
			if (Tools::strlen(Tools::getValue('content_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The content is not set.');
			if (Tools::strlen(Tools::getValue('moduleclass_sfx')) > 255)
				$errors[] = $this->l('The Module Class Suffix  is too long.');
		}elseif (Tools::isSubmit('id_spcustomhtml')
			&& (!Validate::isInt(Tools::getValue('id_spcustomhtml'))
				|| !$this->moduleExists((int)Tools::getValue('id_spcustomhtml'))))
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
			if (Tools::getValue('id_spcustomhtml'))
			{
				$customhtml = new SpCustomHtmlClass((int)Tools::getValue ('id_spcustomhtml'));
				if (!Validate::isLoadedObject($customhtml))
				{
					$this->html .= $this->displayError($this->l('Invalid slide ID'));
					return false;
				}
			}
			else
				$customhtml = new SpCustomHtmlClass();
			$next_ps = $this->getNextPosition();
			$customhtml->ordering = (!empty($customhtml->ordering)) ? (int)$customhtml->ordering : $next_ps;
			$customhtml->active = (Tools::getValue('active')) ? (int)Tools::getValue('active') : 0;
			$customhtml->hook	= (int)Tools::getValue('hook');
			$tmp_data = array();
			$id_spcustomhtml = (int)Tools::getValue ('id_spcustomhtml');
			$id_spcustomhtml = $id_spcustomhtml ? $id_spcustomhtml : (int)$customhtml->getHigherModuleID();
			$tmp_data['id_spcustomhtml'] = $id_spcustomhtml;

			$tmp_data['active'] = (int)Tools::getValue ('active', 1);
			$tmp_data['moduleclass_sfx'] = Tools::getValue ('moduleclass_sfx');
			$tmp_data['display_title_module'] = Tools::getValue ('display_title_module');
			$tmp_data['hook '] = Tools::getValue('hook');
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				$customhtml->title_module[$language['id_lang']] = Tools::getValue('title_module_'.$language['id_lang']);
				$customhtml->content[(int)$language['id_lang']] = Tools::getValue ('content_'.$language['id_lang']);
			}
			$customhtml->params = serialize($tmp_data);
			(Tools::getValue ('id_spcustomhtml')
		&& $this->moduleExists((int)Tools::getValue ('id_spcustomhtml')) )? $customhtml->update() : $customhtml->add ();
			$this->clearCacheItemForHook ();
			if (Tools::isSubmit ('saveAndStay'))
			{
				$tool_id_spcustomhtml = Tools::getValue ('id_spcustomhtml');
				$higher_module = $customhtml->getHigherModuleID();
				$id_spcustomhtml = $tool_id_spcustomhtml?(int)$tool_id_spcustomhtml:(int)$higher_module;
				Tools::redirectAdmin ($currentIndex.'&configure='
				.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spcustomhtml='
					.$id_spcustomhtml.'&updateItemConfirmation');
			}
			else
				Tools::redirectAdmin ($currentIndex.'&configure='.$this->name
					.'&token='.Tools::getAdminTokenLite ('AdminModules').'&saveItemConfirmation');
		}
		elseif (Tools::isSubmit('changeStatusItem') && Tools::getValue ('id_spcustomhtml'))
		{
			$customhtml = new SpCustomHtmlClass((int)Tools::getValue ('id_spcustomhtml'));
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
		elseif (Tools::isSubmit ('deleteItem') && Tools::getValue ('id_spcustomhtml'))
		{
			$customhtml = new SpCustomHtmlClass((int)Tools::getValue ('id_spcustomhtml'));
			$customhtml->delete ();
			$this->clearCacheItemForHook ();
			Tools::redirectAdmin ($currentIndex.'&configure='.$this->name.'&token='
				.Tools::getAdminTokenLite ('AdminModules').'&deleteItemConfirmation');
		}
		elseif (Tools::isSubmit ('duplicateItem') && Tools::getValue ('id_spcustomhtml'))
		{
			$customhtml = new SpCustomHtmlClass(Tools::getValue ('id_spcustomhtml'));
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
	public function moduleExists($id_spcustomhtml)
	{
		$req = 'SELECT cs.`id_spcustomhtml` 
				FROM `'._DB_PREFIX_.'spcustomhtml` cs
				WHERE cs.`id_spcustomhtml` = '.(int)$id_spcustomhtml;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}
	public function getNextPosition()
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT MAX(cs.`ordering`) AS `next_position`
			FROM `'._DB_PREFIX_.'spcustomhtml` cs, `'._DB_PREFIX_.'spcustomhtml_shop` css
			WHERE css.`id_spcustomhtml` = cs.`id_spcustomhtml` AND css.`id_shop` = '.(int)$this->context->shop->id
		);

		return (++$row['next_position']);
	}

	private function getGridItems()
	{
		$this->context = Context::getContext ();
		$id_lang = $this->context->language->id;
		$id_shop = $this->context->shop->id;
		$sql = 'SELECT b.`id_spcustomhtml`,  b.`hook`, b.`ordering`, bs.`active`, bl.`title_module`, bl.`content`
			FROM `'._DB_PREFIX_.'spcustomhtml` b
			LEFT JOIN `'._DB_PREFIX_.'spcustomhtml_shop` bs ON (b.`id_spcustomhtml` = bs.`id_spcustomhtml` )
			LEFT JOIN `'._DB_PREFIX_.'spcustomhtml_lang` bl ON (b.`id_spcustomhtml` = bl.`id_spcustomhtml`)
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
					$associated_shop_ids = SpCustomHtmlClass::getAssociatedIdsShop((int)$mod['id_spcustomhtml']);
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
				<tr id="item_'.$customhtml['id_spcustomhtml'].'" class=" '.( $irow ++ % 2?' ':'' ).'">
					<td class=" 	" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spcustomhtml='
					.$customhtml['id_spcustomhtml'].'\'">'
					.$customhtml['id_spcustomhtml'].'</td>
					<td class=" dragHandle"><div class="dragGroup"><div class="positions">'.$customhtml['ordering']
					.'</div></div></td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&editItem&id_spcustomhtml='.$customhtml['id_spcustomhtml'].'\'">'.$customhtml['title_module']
					.' '.($customhtml['is_shared'] ? '<span class="label color_field"
		style="background-color:#108510;color:white;margin-top:5px;">'.$this->l('Shared').'</span>' : '').'</td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name
					.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spcustomhtml='
					.$customhtml['id_spcustomhtml'].'\'">'
					.( Validate::isInt ($customhtml['hook'])?$this->getHookTitle ($customhtml['hook']):'' ).'</td>
					<td class="  "> <a href="'.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&changeStatusItem&id_spcustomhtml='.$customhtml['id_spcustomhtml'].'&status='
					.$customhtml['active'].'&hook='.$customhtml['hook'].'">'.( $customhtml['active']?'
					<i class="icon-check"></i>':'<i class="icon-remove"></i>' ).'</a> </td>
					<td class="text-right">
						<div class="btn-group-action">
							<div class="btn-group pull-right">
								<a class="btn btn-default" href="'.$currentIndex.'&configure='.$this->name.'&token='
		.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spcustomhtml='.$customhtml['id_spcustomhtml'].'">
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
					.Tools::getAdminTokenLite ('AdminModules').'&duplicateItem&id_spcustomhtml='
					.$customhtml['id_spcustomhtml'].'">
											<i class="icon-copy"></i> '.$this->l('Duplicate').'
										</a>								
									</li>
									<li class="divider"></li>
									<li>
										<a title ="'.$this->l('Delete').'" onclick="return confirm(\''
					.$this->l('Are you sure?').'\');" href="'.$currentIndex
					.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&deleteItem&id_spcustomhtml='
					.$customhtml['id_spcustomhtml'].'">
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
					'type'         => 'textarea',
					'label'        => $this->l('Content'),
					'name'         => 'content',
					'hint'         => $this->l('Show Content Of Module'),
					'lang'         => true,
					'autoload_rte' => true,
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
		$helper->name_controller = 'spcustomhtml';
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
		$id_spcustomhtml = (int)Tools::getValue ('id_spcustomhtml');

		if (Tools::isSubmit ('id_spcustomhtml') && $id_spcustomhtml)
		{
			$customhtml = new SpCustomHtmlClass((int)$id_spcustomhtml);
			$params = unserialize($customhtml->params);
			$this->fields_form[0]['form']['input'][] = array(
				'type' => 'hidden',
				'name' => 'id_spcustomhtml' );
		$helper->fields_value['id_spcustomhtml'] = Tools::getValue ('id_spcustomhtml', $customhtml->id_spcustomhtml);
		}
		else
		{
			$customhtml = new SpCustomHtmlClass();
			$params = array();
		}
		foreach (Language::getLanguages (false) as $lang)
		{
			$helper->fields_value['title_module'][(int)$lang['id_lang']] = Tools::getValue ('title_module_'
				.(int)$lang['id_lang'],
				$customhtml->title_module[(int)$lang['id_lang']]);
			$helper->fields_value['content'][(int)$lang['id_lang']] = Tools::getValue ('content_'.(int)$lang['id_lang'],
				$customhtml->content[(int)$lang['id_lang']]);
		}
		$helper->fields_value['hook'] = Tools::getValue ('hook', $customhtml->hook);
		$helper->fields_value['active'] = (int)Tools::getValue('active', $customhtml->active);
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
			$sql = 'SELECT * FROM `'._DB_PREFIX_.'spcustomhtml` b
			LEFT JOIN `'._DB_PREFIX_.'spcustomhtml_shop` bs ON (b.`id_spcustomhtml` = bs.`id_spcustomhtml`)
			LEFT JOIN `'._DB_PREFIX_.'spcustomhtml_lang` bl ON (b.`id_spcustomhtml` = bl.`id_spcustomhtml`)
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

	public function hookDisplayCustomhtml1()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml1');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml1');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayCustomhtml2()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml2');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml2');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayCustomhtml3()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml3');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml3');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayCustomhtml4()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml4');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml4');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayCustomhtml5()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml5');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml5');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayCustomhtml6()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml6');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml6');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayCustomhtml7()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml7');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml7');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayCustomhtml8()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml8');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml8');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayCustomhtml9()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml9');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml9');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayCustomhtml10()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml10');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml10');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	public function hookDisplayCustomhtml11()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml11');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml11');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayCustomhtml12()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml12');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml12');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayCustomhtml13()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml13');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml13');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	public function hookDisplayCustomhtml14()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml14');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml14');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	public function hookDisplayCustomhtml15()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml15');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml15');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	public function hookDisplayCustomhtml16()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml16');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml16');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	public function hookDisplayCustomhtml17()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml17');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml17');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	public function hookDisplayCustomhtml18()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml18');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml18');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	public function hookDisplayCustomhtml19()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomhtml19');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayCustomhtml19');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayFooter()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayFooter');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooter');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayLeftColumn()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayLeftColumn');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayLeftColumn');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}

	public function hookDisplayFooterBottom()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayFooterBottom');
		//if (!$this->isCached ('default.tpl', $smarty_cache_id)){
			$list = $this->getItemInHook ('displayFooterBottom');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		//}
		return $this->fetch('module:spcustomhtml/views/templates/hook/default.tpl');
		//return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayFooterMiddle()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayFooterMiddle');
		if (!$this->isCached ('default.tpl', $smarty_cache_id))
		{
			$list = $this->getItemInHook ('displayFooterMiddle');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		}
		return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	}
	
	public function hookDisplayCustomProduct()
	{
		$smarty_cache_id = $this->getCacheId ('spcustomhtml_displayCustomProduct');
		if (!$this->isCached ('default.tpl', $smarty_cache_id))
		{
			$list = $this->getItemInHook ('displayCustomProduct');
			if (empty($list))
				return;
			$this->context->smarty->assign (array(
				'list' => $list
			));
		}
		return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
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
		INSERT IGNORE INTO `'._DB_PREFIX_.'spcustomhtml_shop` (`id_spcustomhtml`, `id_shop`)
		SELECT `id_spcustomhtml`, '.(int)$params['new_id_shop'].'
		FROM `'._DB_PREFIX_.'spcustomhtml_shop`
		WHERE `id_shop` = '.(int)$params['old_id_shop']);
	}
}
