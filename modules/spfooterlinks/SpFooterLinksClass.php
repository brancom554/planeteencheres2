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

class SpFooterLinksClass extends ObjectModel
{
	public $id_spfooterlinks;
	public $title_module;
	public $active;
	public $hook;
	public $params;
	public $ordering;
	public $postext;
	public $content;		
	public $id_shop = array();
	public static $definition = array(
	'table' => 'spfooterlinks',
	'primary' => 'id_spfooterlinks',
	'multilang' => true,
	'fields' => array( 'hook' => array( 'type' => self::TYPE_INT, 'validate' => 'isunsignedInt' ),
		'title_module' => array( 'type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 255 ),
		'active' => array( 'type' => self::TYPE_INT, 'shop' => true,  'validate' => 'isunsignedInt' ),
		'params' => array( 'type' => self::TYPE_HTML,  'validate' => 'isString'),
		'content' => array( 'type' => self::TYPE_HTML,  'validate' => 'isString'),
		'ordering' => array( 'type' => self::TYPE_INT, 'validate' => 'isInt' )
	) );

	public function __construct($id_spfooterlinks = null, $id_lang = null, $id_shop = null)
	{
		Shop::addTableAssociation ('spfooterlinks', array('type' => 'shop'));
		parent::__construct ($id_spfooterlinks, $id_lang, $id_shop);
	}

	public function add($autodate = true, $null_values = false)
	{
		$this->ordering = $this->getHigherPosition () + 1;
		$res = parent::add($autodate, $null_values);
		return $res;
	}

	public function getHigherModuleID()
	{
		$sql = 'SELECT MAX(`id_spfooterlinks`)
				FROM `'._DB_PREFIX_.'spfooterlinks`';
		$id_spfooterlinks = DB::getInstance ()->getValue($sql);
		return ( is_numeric ($id_spfooterlinks) )?$id_spfooterlinks:1;
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
		$sql = 'SELECT `id_spfooterlinks`, `ordering` FROM `'._DB_PREFIX_.'spfooterlinks` ORDER BY `ordering` ASC';
		$db = Db::getInstance ();
		$values = $db->executeS ($sql);
		if (!empty( $values ))
		{
			foreach ($values as $position => $value)
			{
				$sql1 = 'UPDATE `'._DB_PREFIX_.'spfooterlinks` SET `ordering` = '.(int)$position
					.' WHERE `id_spfooterlinks` = '.(int)$value['id_spfooterlinks'];
				Db::getInstance ()->execute ($sql1);
			}
		}
	}

	public function getHigherPosition()
	{
		$sql = 'SELECT MAX(`ordering`)
				FROM `'._DB_PREFIX_.'spfooterlinks`';
		$ordering = DB::getInstance ()->getValue ($sql);
		return ( is_numeric ($ordering) )? $ordering : 0;
	}

	public static function getAssociatedIdsShop($id_spfooterlinks)
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT css.`id_shop`
			FROM `'._DB_PREFIX_.'spfooterlinks` cs
			LEFT JOIN `'._DB_PREFIX_.'spfooterlinks_shop` css ON (css.`id_spfooterlinks` = cs.`id_spfooterlinks`)
			WHERE cs.`id_spfooterlinks` = '.(int)$id_spfooterlinks
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
		$id_spfooterlinks = $this->id;
		$context = Context::getContext();
		$id_shop = $context->shop->id;

		$max = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT MAX(cs.`ordering`) as ordering
			FROM `'._DB_PREFIX_.'spfooterlinks` cs, `'._DB_PREFIX_.'spfooterlinks_shop` css
			WHERE css.`id_spfooterlinks` = cs.`id_spfooterlinks` AND css.`id_shop` = '.(int)$id_shop
		);

		if ((int)$max == (int)$id_spfooterlinks)
			return true;

		$rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT cs.`ordering` as ordering, cs.`id_spfooterlinks` as id_spfooterlinks
			FROM `'._DB_PREFIX_.'spfooterlinks` cs
			LEFT JOIN `'._DB_PREFIX_.'spfooterlinks_shop` css ON (css.`id_spfooterlinks` = cs.`id_spfooterlinks`)
			WHERE css.`id_shop` = '.(int)$id_shop.' AND cs.`ordering` > '.(int)$this->ordering
		);

		foreach ($rows as $row)
		{
			$customs = new SpFooterLinksClass($row['id_spfooterlinks']);
			--$customs->ordering;
			$customs->update();
			unset($customs);
		}

		return true;
	}
}
