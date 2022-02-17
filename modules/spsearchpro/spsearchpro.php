<?php
/**
 * package   SP Search Pro
 *
 * @version 1.1.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2015 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

if (!defined ('_PS_VERSION_'))
	exit;

include_once ( dirname (__FILE__).'/SpSearchProClass.php' );

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class SpSearchPro extends Module implements WidgetInterface
{

	protected $categories = array();
	protected $error = false;
	private $html;
	private $default_hook = array(
		'displayHome',
		'displaySearchPro',
		'displaySearchPro2'
		);
	public function __construct()
	{
		$this->name = 'spsearchpro';
		$this->tab = 'front_office_features';
		$this->version = '1.0.1';
		$this->author = 'MagenTech';
		$this->secure_key = Tools::encrypt ($this->name);
		$this->bootstrap = true;
		parent::__construct ();
		$this->displayName = $this->l('SP Search Pro');
		$this->description = $this->l('Display products in each tabs categories with listing view.');
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
		$spsearchpro = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spsearchpro`')
			&& Db::getInstance ()->Execute ('CREATE TABLE '._DB_PREFIX_.'spsearchpro (
				`id_spsearchpro` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`hook` int(10) unsigned,
				`params` text NOT NULL DEFAULT \'\' ,
				`active` tinyint(1) NOT NULL DEFAULT \'1\',
				`ordering` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_spsearchpro`)) ENGINE=InnoDB default CHARSET=utf8');
		$spsearchpro_shop = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spsearchpro_shop`')
			&& Db::getInstance ()->Execute ('
				CREATE TABLE '._DB_PREFIX_.'spsearchpro_shop (
				`id_spsearchpro` int(10) unsigned NOT NULL,
				`id_shop` int(10) unsigned NOT NULL,
				`active` tinyint(1) NOT NULL DEFAULT \'1\',
				 PRIMARY KEY (`id_spsearchpro`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8');
		$spsearchpro_lang = Db::getInstance ()->Execute ('DROP TABLE IF EXISTS `'._DB_PREFIX_.'spsearchpro_lang`')
			&& Db::getInstance ()->Execute ('CREATE TABLE '._DB_PREFIX_.'spsearchpro_lang (
				`id_spsearchpro` int(10) unsigned NOT NULL,
				`id_lang` int(10) unsigned NOT NULL,
				`title_module` varchar(255) NOT NULL DEFAULT \'\',
				PRIMARY KEY (`id_spsearchpro`,`id_lang`)) ENGINE=InnoDB default CHARSET=utf8');
		if (!$spsearchpro || !$spsearchpro_shop || !$spsearchpro_lang)
			return false;
		$this->installFixtures();
		return true;
	}

	public function uninstall()
	{
		if (parent::uninstall () == false)
			return false;
		if (!Db::getInstance ()->Execute ('DROP TABLE `'._DB_PREFIX_.'spsearchpro`')
			|| !Db::getInstance ()->Execute ('DROP TABLE `'._DB_PREFIX_.'spsearchpro_shop`')
			|| !Db::getInstance ()->Execute ('DROP TABLE `'._DB_PREFIX_.'spsearchpro_lang`'))
			return false;
			$this->clearCacheItemForHook ();
		return true;
	}

	public function installFixtures()
	{
		$datas = array(
			array(
				'id_spsearchpro' => 1,
				'title_module' => 'Sp Search Pro',
				'display_title_module' => 0,
				'moduleclass_sfx' => '',
				'active' => 1,
				'hook' => Hook::getIdByName('displaySearchPro'),
				'target' => 'self',
				'display_box_select' => 1,
			),
			array(
				'id_spsearchpro' => 2,
				'title_module' => 'Sp Search Pro Layout 2',
				'display_title_module' => 0,
				'moduleclass_sfx' => '',
				'active' => 1,
				'hook' => Hook::getIdByName('displaySearchPro2'),
				'target' => 'self',
				'display_box_select' => 0,
			)
		);

		$return = true;
		foreach ($datas as $i => $data)
		{
			$spsearchpro = new SpSearchProClass();
			$spsearchpro->hook = $data['hook'];
			$spsearchpro->active = $data['active'];
			$spsearchpro->ordering = $i;
			$spsearchpro->params = serialize($data);
			foreach (Language::getLanguages(false) as $lang)
				$spsearchpro->title_module[$lang['id_lang']] = $data['title_module'];
			$return &= $spsearchpro->add();
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
				&& $this->moduleExists((int)Tools::getValue('id_spsearchpro'))) || Tools::isSubmit ('saveItem'))
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
				$associated_shop_ids = SpSearchProClass::getAssociatedIdsShop((int)Tools::getValue('id_spsearchpro'));
				$context_shop_id = (int)Shop::getContextShopID();
				if ($associated_shop_ids === false)
					$this->html .= $this->getShopAssociationError((int)Tools::getValue('id_spsearchpro'));
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

			if (Tools::isSubmit('id_spsearchpro'))
			{
				if (!Validate::isInt(Tools::getValue('id_spsearchpro'))
					&& !$this->moduleExists(Tools::getValue('id_spsearchpro')))
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
		}
		elseif (Tools::isSubmit('id_spsearchpro') && (!Validate::isInt(Tools::getValue('id_spsearchpro'))
				|| !$this->moduleExists((int)Tools::getValue('id_spsearchpro'))))
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
			if (Tools::getValue('id_spsearchpro'))
			{
				$searchpro = new SpSearchProClass((int)Tools::getValue ('id_spsearchpro'));
				if (!Validate::isLoadedObject($searchpro))
				{
					$this->html .= $this->displayError($this->l('Invalid slide ID'));
					return false;
				}
			}
			else
				$searchpro = new SpSearchProClass();
			$next_ps = $this->getNextPosition();
			$searchpro->ordering = (!empty($searchpro->ordering)) ? (int)$searchpro->ordering : $next_ps;
			$searchpro->active = (Tools::getValue('active')) ? (int)Tools::getValue('active') : 0;
			$searchpro->hook	= (int)Tools::getValue('hook');

			$tmp_data = array();
			$id_spsearchpro = (int)Tools::getValue ('id_spsearchpro');
			$id_spsearchpro = $id_spsearchpro ? $id_spsearchpro : $searchpro->getHigherModuleID();
			$tmp_data['id_spsearchpro'] = $id_spsearchpro;
			// general options
			$id_spsearchpro = (int)Tools::getValue ('id_spsearchpro');
			$id_spsearchpro = $id_spsearchpro ? $id_spsearchpro : (int)$searchpro->getHigherID ();
			$tmp_data['id_spsearchpro'] = (int)$id_spsearchpro;
			$tmp_data['display_title_module'] = (int)Tools::getValue ('display_title_module');
			$tmp_data['moduleclass_sfx'] = (string)Tools::getValue ('moduleclass_sfx');
			$tmp_data['active'] = (int)Tools::getValue ('active');
			$tmp_data['hook'] = (int)Tools::getValue ('hook');
			$tmp_data['target'] = (string)Tools::getValue ('target');
			$tmp_data['display_box_select'] = (int)Tools::getValue ('display_box_select');
			// source option
			// tab options

			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
				$searchpro->title_module[$language['id_lang']] = Tools::getValue('title_module_'.$language['id_lang']);
			$searchpro->params = serialize($tmp_data);
			$get_id = Tools::getValue ('id_spsearchpro');
			($get_id && $this->moduleExists($get_id))? $searchpro->update() : $searchpro->add ();
			$this->clearCacheItemForHook ();
				if (Tools::isSubmit ('saveAndStay'))
				{
					$id_spsearchpro = Tools::getValue ('id_spsearchpro')?
						(int)Tools::getValue ('id_spsearchpro'):(int)$searchpro->getHigherModuleID ();
					Tools::redirectAdmin ($currentIndex.'&configure='
						.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spsearchpro='
						.$id_spsearchpro.'&updateItemConfirmation');
				}
				else
					Tools::redirectAdmin ($currentIndex.'&configure='
						.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules').'&saveItemConfirmation');
		}
		elseif (Tools::isSubmit ('changeStatusItem') && (int)Tools::getValue ('id_spsearchpro'))
		{
			$searchpro = new SpSearchProClass((int)Tools::getValue ('id_spsearchpro'));
			if ($searchpro->active == 0)
				$searchpro->active = 1;
			else
				$searchpro->active = 0;
			$searchpro->update();
			$this->clearCacheItemForHook ();
			Tools::redirectAdmin ($currentIndex.'&configure='.$this->name
				.'&token='.Tools::getAdminTokenLite ('AdminModules'));
		}
		elseif (Tools::isSubmit ('deleteItem') && (int)Tools::getValue ('id_spsearchpro'))
		{
			$searchpro = new SpSearchProClass(Tools::getValue ('id_spsearchpro'));
			$searchpro->delete ();
			$this->clearCacheItemForHook ();
			Tools::redirectAdmin ($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules')
				.'&deleteItemConfirmation');
		}
		elseif (Tools::isSubmit ('duplicateItem') && (int)Tools::getValue ('id_spsearchpro'))
		{
			$searchpro = new SpSearchProClass(Tools::getValue ('id_spsearchpro'));
			foreach (Language::getLanguages (false) as $lang)
				$searchpro->title_module[(int)$lang['id_lang']] = $searchpro->title_module[(int)$lang['id_lang']]
					.$this->l(' (Copy)');
			$searchpro->duplicate ();
			$this->clearCacheItemForHook ();
			Tools::redirectAdmin ($currentIndex.'&configure='.$this->name.'&token='
				.Tools::getAdminTokenLite ('AdminModules')
				.'&duplicateItemConfirmation');
		}
		elseif (Tools::isSubmit ('saveItemConfirmation'))
			$this->html = $this->displayConfirmation ($this->l('Module created successfully!'));
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
		$req = 'SELECT cs.`id_spsearchpro`
				FROM `'._DB_PREFIX_.'spsearchpro` cs
				WHERE cs.`id_spsearchpro` = '.(int)$id_module;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);
		return ($row);
	}
	public function getNextPosition()
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT MAX(cs.`ordering`) AS `next_position`
			FROM `'._DB_PREFIX_.'spsearchpro` cs, `'._DB_PREFIX_.'spsearchpro_shop` css
			WHERE css.`id_spsearchpro` = cs.`id_spsearchpro`
			AND css.`id_shop` = '.(int)$this->context->shop->id
		);
		return (++$row['next_position']);
	}

	
	
	private function getFormValuesCat()
	{
		$id_spsearchpro = Tools::getValue ('id_spsearchpro');
		if (Tools::isSubmit ('id_spsearchpro') && $id_spsearchpro)
		{
			$searchpro = new SpSearchProClass((int)$id_spsearchpro);
			$params = unserialize($searchpro->params);
		}
		else
		{
			$searchpro = new SpSearchProClass();
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
		}
		else
			$catids = array();
		return $catids;
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
		INSERT IGNORE INTO `'._DB_PREFIX_.'spsearchpro_shop` (`id_spsearchpro`, `id_shop`)
		SELECT `id_spsearchpro`, '.(int)$params['new_id_shop'].'
		FROM `'._DB_PREFIX_.'spsearchpro_shop`
		WHERE `id_shop` = '.(int)$params['old_id_shop']);
	}

	private function getHookName($id_hook)
	{
		if (!$result = Db::getInstance ()->getRow ('SELECT `name`,`title` FROM `'._DB_PREFIX_.'hook`
		WHERE `id_hook` = '.( $id_hook )))
			return false;
		return $result['name'];
	}

	private function getGridItems()
	{
		$this->context = Context::getContext ();
		$id_lang = $this->context->language->id;
		$id_shop = $this->context->shop->id;
		$sql = '
			SELECT b.`id_spsearchpro`, b.`hook`, b.`ordering`, bs.`active`, bl.`title_module`
			FROM `'._DB_PREFIX_.'spsearchpro` b
			LEFT JOIN `'._DB_PREFIX_.'spsearchpro_shop` bs ON (b.`id_spsearchpro` = bs.`id_spsearchpro`)
			LEFT JOIN `'._DB_PREFIX_.'spsearchpro_lang` bl ON (b.`id_spsearchpro` = bl.`id_spsearchpro`'
			.( $id_shop?'AND bs.`id_shop` = '.$id_shop:' ' ).')
			WHERE bl.`id_lang` = '.(int)$id_lang.( $id_shop?' AND bs.`id_shop` = '.$id_shop:' ' ).'
			ORDER BY b.`ordering`';
		$result = Db::getInstance ()->ExecuteS ($sql);
		if (!$result)
			return false;
		return $result;
	}

	private function getHookTitle($id_hook, $name = false)
	{
		if (!$result = Db::getInstance ()->getRow ('
			SELECT `name`,`title` FROM `'._DB_PREFIX_.'hook` WHERE `id_hook` = '.( $id_hook )))
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
					$associated_shop_ids = SpSearchProClass::getAssociatedIdsShop((int)$mod['id_spsearchpro']);
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
				<tr id="item_'.$mod['id_spsearchpro'].'" class=" '.( $irow ++ % 2?' ':'' ).'">
					<td class=" 	" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spsearchpro='
					.$mod['id_spsearchpro'].'\'">'
					.$mod['id_spsearchpro'].'</td>
					<td class=" dragHandle"><div class="dragGroup"><div class="positions">'.$mod['ordering']
					.'</div></div></td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&editItem&id_spsearchpro='.$mod['id_spsearchpro'].'\'">'
					.$mod['title_module'].' '
					.($mod['is_shared'] ? '<span class="label color_field"
				style="background-color:#108510;color:white;margin-top:5px;">'.$this->l('Shared').'</span>' : '').'</td>
					<td class="  " onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules')
					.'&editItem&id_spsearchpro='.$mod['id_spsearchpro'].'\'">'
					.( Validate::isInt ($mod['hook'])?$this->getHookTitle ($mod['hook']):'' ).'</td>
					<td class="  "> <a href="'.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&changeStatusItem&id_spsearchpro='
					.$mod['id_spsearchpro'].'&status='
					.$mod['active'].'&hook='.$mod['hook'].'">'
					.( $mod['active']?'<i class="icon-check"></i>':'<i class="icon-remove"></i>' ).'</a> </td>
					<td class="text-right">
						<div class="btn-group-action">
							<div class="btn-group pull-right">
								<a class="btn btn-default" href="'.$currentIndex.'&configure='
					.$this->name.'&token='.Tools::getAdminTokenLite ('AdminModules').'&editItem&id_spsearchpro='
					.$mod['id_spsearchpro'].'">
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
					.Tools::getAdminTokenLite ('AdminModules').'&duplicateItem&id_spsearchpro='
					.$mod['id_spsearchpro'].'">
											<i class="icon-copy"></i> '.$this->l('Duplicate').'
										</a>
									</li>
									<li class="divider"></li>
									<li>
										<a title ="'.$this->l('Delete')
					.'" onclick="return confirm(\''.$this->l('Are you sure?'
						).'\');" href="'.$currentIndex.'&configure='.$this->name.'&token='
					.Tools::getAdminTokenLite ('AdminModules').'&deleteItem&id_spsearchpro='
					.$mod['id_spsearchpro'].'">
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
	
	protected function generateCategoriesOption($categories, $current = null, $id_selected = 1, $prefix = '')
	{
		foreach ($categories as $category)
		{
			//if ($category['level_depth'] > 1) {
				$this->categories[$category['id_category']] = str_repeat($prefix, $category['level_depth'] * 1)
				.Tools::stripslashes($category['name']);
			//}
			//else{
				//$this->categories[$category['id_category']] = Tools::stripslashes($category['name']);
			//}
			if (isset($category['children']) && !empty($category['children']))
			{
				$current = $category['id_category'];
				$this->generateCategoriesOption($category['children'], $current, $id_selected, ' - ');
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
				'.($sql_sort != '' ? $sql_sort : ' ORDER BY c.`level_depth` ASC').'
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

	public function getCatSelect($default = false)
	{
		$shops_to_get = Shop::getContextListShopID();
		foreach ($shops_to_get as $shop_id)
			$this->generateCategoriesOption($this->customGetNestedCategories($shop_id, null, (int)$this->context->language->id, true));

		$catopt = array();
		if (!empty( $this->categories ))
		{
			foreach ($this->categories as $key => $cat)
			{	if ($default)
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
		return $catopt;
	}

	public function initForm()
	{
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
					'hint'     => $this->l('Title'),
					'lang'     => true,
					'name'     => 'title_module',
					'class'    => 'fixed-width-xl'
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Display Title Module'),
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
					'hint'  => $this->l('A suffix to be applied to the CSS class of the module. This allows for individual module styling.'),
					'class' => 'fixed-width-xl'
				),
				array(
					'type'    => 'select',
					'label'   => $this->l('Hook into'),
					'hint'    => $this->l('Hook into'),
					'name'    => 'hook',
					'options' => array(
						'query' => $hooks,
						'id'    => 'key',
						'name'  => 'name'
					)
				),
				array(
					'type'   => 'switch',
					'label'  => $this->l('Status'),
					'hint'   => $this->l('Status'),
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
					'type'   => 'switch',
					'label'  => $this->l('Display Box All Category'),
					'name'   => 'display_box_select',
					'hint'   => $this->l('Allow show/hide box select id category of module.'),
					'values' => array(
						array(
							'id'    => 'box_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id'    => 'box_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
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

		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = 'spsearchpro';
		$helper->identifier = $this->identifier;
		$helper->token = Tools::getAdminTokenLite ('AdminModules');
		$helper->show_cancel_button = true;
		$helper->back_url = AdminController::$currentIndex.'&configure='.$this->name.'&token='
			.Tools::getAdminTokenLite ('AdminModules');
		$default_lang = (int)Configuration::get ('PS_LANG_DEFAULT');
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

		$id_spsearchpro = (int)Tools::getValue ('id_spsearchpro');
		if (Tools::isSubmit ('id_spsearchpro') && $id_spsearchpro)
		{
			$searchpro = new SpSearchProClass((int)$id_spsearchpro);
			$this->fields_form[0]['form']['input'][] = array(
				'type' => 'hidden',
				'name' => 'id_spsearchpro'
			);
			$params = unserialize($searchpro->params);
		$helper->fields_value['id_spsearchpro'] = (int)Tools::getValue ('id_spsearchpro', $searchpro->id_spsearchpro);
		}
		else
		{
			$searchpro = new SpSearchProClass();
			$params = array();
		}

		foreach (Language::getLanguages (false) as $lang)
		{
			$title_module_lang = 'title_module_'.(int)$lang['id_lang'];
			$helper->fields_value['title_module'][(int)$lang['id_lang']] = (string)Tools::getValue($title_module_lang,
				$searchpro->title_module[(int)$lang['id_lang']]);
		}
		// general options
		$helper->fields_value['display_title_module'] = Tools::getValue ('display_title_module',
			isset( $params['display_title_module'] )?$params['display_title_module']:1);
		$helper->fields_value['moduleclass_sfx'] = (string)Tools::getValue ('moduleclass_sfx',
			isset( $params['moduleclass_sfx'] )?$params['moduleclass_sfx']:'');
		
		$helper->fields_value['hook'] = Tools::getValue ('hook', $searchpro->hook);
		$helper->fields_value['active'] = Tools::getValue ('active', $searchpro->active);
		$helper->fields_value['target'] = (string)Tools::getValue ('target', isset( $params['target'] )?$params['target']:'_self');
		$helper->fields_value['display_box_select'] = Tools::getValue ('display_box_select',
			isset( $params['display_box_select'] )?$params['display_box_select']:1);
		
		$this->html .= $helper->generateForm ($this->fields_form);
	}

	public function getList($params)
	{
		$sortedCats = [0=>['id_category' => 'all' , 'name' => $this->l('All Categories'), 'level' => 0] ];
		$top_cat = Category::getTopCategory();
		$this->rekurseCats($top_cat->id,0, true, $sortedCats);
		$html = '<select class="spr_select" name="cat_id">';
		foreach($sortedCats as $cat){
			$html .= '<option value="'.$cat['id_category'].'">';
			$html .= ($cat['level'] > 0 ? str_repeat('- -', $cat['level'] - 1) : '').$cat['name'] ;
			$html .= '</option>';
		}
		$html .= '</select>';
		return $html;
	}
	
	public function rekurseCats($category_id, $level, $onlyPublished = true,&$sortedCats,$deep=0){
		$level++;
		$idLang = $this->context->language->id;
		if(($deep===0 or $level <= $deep) and $childs = Category::hasChildren($category_id, $idLang )){
			$childCats = Category::getChildren($category_id , $idLang , true);
			if(!empty($childCats)){
				$siblingCount = count($childCats);
				foreach ($childCats as $key => $category) {
					$category['level'] = $level;
					$sortedCats[] = $category;
					$this->rekurseCats($category['id_category'],$level,true,$sortedCats,$deep);
				}
			}
		}
	}

	private function getItemInHook($hook_name)
	{
		$list = array();
		$this->context = Context::getContext ();
		$id_shop = $this->context->shop->id;
		$id_hook = Hook::getIdByName ($hook_name);
		if ($id_hook)
		{
			$results = Db::getInstance ()->ExecuteS ('SELECT b.`id_spsearchpro` FROM `'._DB_PREFIX_.'spsearchpro` b
			LEFT JOIN `'._DB_PREFIX_.'spsearchpro_shop` bs ON (b.`id_spsearchpro` = bs.`id_spsearchpro`)
			WHERE bs.`active` = 1 AND (bs.id_shop = '.$id_shop.') AND b.`hook` = '.$id_hook.' ORDER BY b.`ordering`');
			foreach ($results as $row)
			{
				$temp = new SpSearchProClass($row['id_spsearchpro']);
				$temp->params = unserialize($temp->params);
				$temp->category = $this->getList ($temp->params);
				$list[] = $temp;
			}
		}
		if (empty( $list ))
			return;
		return $list;
	}

	public function hookHeader()
	{
	
		$this->context->controller->addCSS ($this->_path.'views/css/style.css', 'all');
		$this->context->controller->addJqueryUI('ui.autocomplete');
		$this->context->controller->registerJavascript('modules-spsearchpro', 'modules/'.$this->name.'/views/js/spsearchpro.js', ['position' => 'bottom', 'priority' => 150]);
	}
	
	public function renderWidget($hookName = null, array $configuration = [])
    {
		if ($hookName == 'displaySearchPro3'){
			$templateFile = 'module:spsearchpro/views/templates/hook/default2.tpl';
		}else{
			$templateFile = 'module:spsearchpro/views/templates/hook/default.tpl';
		}
        if (!$this->isCached($templateFile, $this->getCacheId())) {
			$variables = $this->getWidgetVariables($hookName, $configuration);
			$this->smarty->assign($variables);
        }

        return $this->fetch($templateFile, $this->getCacheId());
    }
	
	
	 public function getWidgetVariables($hookName = null, array $configuration = [])
    {
			$list = $this->getItemInHook ($hookName);
			$templateVar = $this->context->smarty->getTemplateVars();
			 return array(
				'list' => $list,
				'id_lang' => $this->context->language->id,
				'baseDir' => __PS_BASE_URI__,
				'search_controller_url' => $this->context->link->getPageLink('search', null, null, null, false, null, true),
				'search_string' => (!array_key_exists('search_string', $templateVar)) ? '' : $templateVar['search_string']
			);
    }

	// public function hookDisplayNav($hook = 'displayNav')
	// {
		// $smarty = $this->context->smarty;
		// //var_dump($hook);die;
		// $smarty_cache_id = $this->getCacheId ('spsearchpro_displayNav');
		// if (!$this->isCached ('default.tpl', $smarty_cache_id))
		// {
			// $list = $this->getItemInHook ($hook);
			// $templateVar = $this->context->smarty->getTemplateVars();
			// $smarty->assign (array(
				// 'list' => $list,
				// 'id_lang' => $this->context->language->id,
				// 'baseDir' => __PS_BASE_URI__,
				// 'search_controller_url' => $this->context->link->getPageLink('search', null, null, null, false, null, true),
				// 'search_string' => (!array_key_exists('search_string', $templateVar)) ? '' : $templateVar['search_string']
			// ));
		// }
		// return $this->display (__FILE__, 'default.tpl', $smarty_cache_id);
	// }

	// public function hookdisplaySearchPro3()
	// {
		// $smarty = $this->context->smarty;
		// $smarty_cache_id = $this->getCacheId ('spsearchpro_displaySearchPro3');
		// if (!$this->isCached ('default2.tpl', $smarty_cache_id))
		// {
			// $list = $this->getItemInHook ('displaySearchPro3');
			// $templateVar = $this->context->smarty->getTemplateVars();
			// $smarty->assign (array(
				// 'list' => $list,
				// 'id_lang' => $this->context->language->id,
				// 'baseDir' => __PS_BASE_URI__,
				// 'search_controller_url' => $this->context->link->getPageLink('search'),
				// 'search_controller_url' => $this->context->link->getPageLink('search', null, null, null, false, null, true),
				// 'search_string' => (!array_key_exists('search_string', $templateVar)) ? '' : $templateVar['search_string']
			// ));
		// }
		// return $this->display (__FILE__, 'default2.tpl', $smarty_cache_id);
	// }

	
	
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
}
