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

class SpBannerClass extends ObjectModel
{
	public $id_spbanner;
	public $title_module;
	public $image;
	public $banner_link;
	public $banner_effect;
	public $content;
	public $active;
	public $hook;
	public $params;
	public $ordering;
	public $postext;
	public $id_shop = array();
	public static $definition = array(
	'table' => 'spbanner',
	'primary' => 'id_spbanner',
	'multilang' => true,
	'fields' => array( 'hook' => array( 'type' => self::TYPE_INT, 'validate' => 'isunsignedInt' ),
		'title_module' => array( 'type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 255 ),
		'image' => array( 'type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => false, 'size' => 255 ),
		'banner_link' => array( 'type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => false, 'size' => 255 ),
		'banner_effect' => array( 'type' => self::TYPE_HTML,  'validate' => 'isString'),
		'content' => array( 'type' => self::TYPE_HTML, 'lang' => true),
		'active' => array( 'type' => self::TYPE_INT, 'shop' => true,  'validate' => 'isunsignedInt' ),
		'params' => array( 'type' => self::TYPE_HTML,  'validate' => 'isString'),
		'ordering' => array( 'type' => self::TYPE_INT, 'validate' => 'isInt' )
	) );

	public function __construct($id_spbanner = null, $id_lang = null, $id_shop = null)
	{
		Shop::addTableAssociation ('spbanner', array('type' => 'shop'));
		parent::__construct ($id_spbanner, $id_lang, $id_shop);
	}

	public function add($autodate = true, $null_values = false)
	{
		$this->ordering = $this->getHigherPosition () + 1;
		$res = parent::add($autodate, $null_values);
		return $res;
	}

	public function getHigherModuleID()
	{
		$sql = 'SELECT MAX(`id_spbanner`)
				FROM `'._DB_PREFIX_.'spbanner`';
		$id_spbanner = DB::getInstance ()->getValue($sql);
		return ( is_numeric ($id_spbanner) )?$id_spbanner:1;
	}
	public function duplicate($autodate = true)
	{
		$this->ordering = $this->getHigherPosition () + 1;
		$return = parent::add ($autodate, true);
		return $return;
	}

	public function delete()
	{
		$res = true;
		$res &= $this->reOrderPositions();
		$res &= parent::delete();
		return $res;
	}

	public static function cleanPositions()
	{
		$sql = 'SELECT `id_spbanner`, `ordering` FROM `'._DB_PREFIX_.'spbanner` ORDER BY `ordering` ASC';
		$db = Db::getInstance ();
		$values = $db->executeS ($sql);
		if (!empty( $values ))
		{
			foreach ($values as $position => $value)
			{
				$sql1 = 'UPDATE `'._DB_PREFIX_.'spbanner` SET `ordering` = '.(int)$position
					.' WHERE `id_spbanner` = '.(int)$value['id_spbanner'];
				Db::getInstance ()->execute ($sql1);
			}
		}
	}

	public function getHigherPosition()
	{
		$sql = 'SELECT MAX(`ordering`)
				FROM `'._DB_PREFIX_.'spbanner`';
		$ordering = DB::getInstance ()->getValue ($sql);
		return ( is_numeric ($ordering) )? $ordering : 0;
	}

	public static function getAssociatedIdsShop($id_spbanner)
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT css.`id_shop`
			FROM `'._DB_PREFIX_.'spbanner` cs
			LEFT JOIN `'._DB_PREFIX_.'spbanner_shop` css ON (css.`id_spbanner` = cs.`id_spbanner`)
			WHERE cs.`id_spbanner` = '.(int)$id_spbanner
		);

		if (!is_array($result))
			return false;

		$return = array();

		foreach ($result as $id_shop)
			$return[] = (int)$id_shop['id_shop'];
		return $return;
	}
	public function reOrderPositions()
	{
		$id_spbanner = $this->id;
		$context = Context::getContext();
		$id_shop = $context->shop->id;

		$max = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT MAX(cs.`ordering`) as ordering
			FROM `'._DB_PREFIX_.'spbanner` cs, `'._DB_PREFIX_.'spbanner_shop` css
			WHERE css.`id_spbanner` = cs.`id_spbanner` AND css.`id_shop` = '.(int)$id_shop
		);

		if ((int)$max == (int)$id_spbanner)
			return true;

		$rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT cs.`ordering` as ordering, cs.`id_spbanner` as id_spbanner
			FROM `'._DB_PREFIX_.'spbanner` cs
			LEFT JOIN `'._DB_PREFIX_.'spbanner_shop` css ON (css.`id_spbanner` = cs.`id_spbanner`)
			WHERE css.`id_shop` = '.(int)$id_shop.' AND cs.`ordering` > '.(int)$this->ordering
		);

		foreach ($rows as $row)
		{
			$customs = new SpBannerClass($row['id_spbanner']);
			--$customs->ordering;
			$customs->update();
			unset($customs);
		}

		return true;
	}
}
