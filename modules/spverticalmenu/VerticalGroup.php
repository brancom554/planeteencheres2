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

class VerticalGroup extends ObjectModel
{
	public $title;
	public $status;
	public $position;
	public $id_shop;
	public $hook;
	public $params;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'spverticalmenu_group',
		'primary' => 'id_spverticalmenu_group',
		'multilang' => true,
		'fields' => array(
			'status' 	=>			array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
			'position' 	=>		array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
			'hook' 	=>		array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
			'params' 	=> array( 'type' => self::TYPE_HTML,  'validate' => 'isString'),
			// Lang fields
			'title' 	=>			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 255),
		)
	);

	public	function __construct($id_spverticalmenu_group = null, $id_lang = null, $id_shop = null, Context $context = null)
	{
		parent::__construct($id_spverticalmenu_group, $id_lang, $id_shop);
	}

	public function add($autodate = true, $null_values = false)
	{
		$context = Context::getContext();
		$id_shop = $context->shop->id;

		$res = parent::add($autodate, $null_values);
		$res &= Db::getInstance()->execute('
			INSERT INTO `'._DB_PREFIX_.'spverticalmenu_group_shop` (`id_shop`, `id_spverticalmenu_group`)
			VALUES('.(int)$id_shop.', '.(int)$this->id.')'
		);
		return $res;
	}

	public function delete()
	{
		$res = true;
		$res &= parent::delete();
		return $res;
	}

	public function reOrderPositions()
	{
		$id_spverticalmenu_group = $this->id;
		$context = Context::getContext();
		$id_shop = $context->shop->id;

		$max = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT MAX(hss.`position`) as position
			FROM `'._DB_PREFIX_.'spverticalmenu_group` hss, `'._DB_PREFIX_.'spverticalmenu_group_shop` hs
			WHERE hss.`id_spverticalmenu_group` = hs.`id_spverticalmenu_group` AND hs.`id_shop` = '.(int)$id_shop
		);

		if ((int)$max == (int)$id_spverticalmenu_group)
			return true;

		$rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hss.`position` as position, hss.`id_spverticalmenu` as id_spverticalmenu_group
			FROM `'._DB_PREFIX_.'spverticalmenu_group_shop` hss
			LEFT JOIN `'._DB_PREFIX_.'spverticalmenu_group` hs ON (hss.`id_spverticalmenu_group` = hs.`id_spverticalmenu_group`)
			WHERE hs.`id_shop` = '.(int)$id_shop.' AND hss.`position` > '.(int)$this->position
		);

		foreach ($rows as $row)
		{
			$current_group = new VerticalGroup($row['id_spverticalmenu_group']);
			--$current_group->position;
			$current_group->update();
			unset($current_group);
		}

		return true;
	}

	public static function getAssociatedIdsShop($id_spverticalmenu_group)
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hs.`id_shop`
			FROM `'._DB_PREFIX_.'spverticalmenu_group_shop` hs
			WHERE hs.`id_spverticalmenu_group` = '.(int)$id_spverticalmenu_group
		);

		if (!is_array($result))
			return false;

		$return = array();

		foreach ($result as $id_shop)
			$return[] = (int)$id_shop['id_shop'];

		return $return;
	}

}
