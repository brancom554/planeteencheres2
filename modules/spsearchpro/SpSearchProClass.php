<?php
/**
 * package SP Search Pro
 *
 * @version 1.1.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2015 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

if (!defined ('_PS_VERSION_'))
	exit;

class SpSearchProClass extends ObjectModel
{
	public $id_spsearchpro;
	public $title_module;
	public $short_desc;
	public $identifier_block;
	public $active = 1;
	public $hook;
	public $params;
	public $ordering;
	public static $definition = array(
		'table' => 'spsearchpro',
		'primary' => 'id_spsearchpro',
		'multilang' => true,
		'fields' => array( 'hook' => array( 'type' => self::TYPE_INT, 'validate' => 'isunsignedInt' ),
			'title_module' => array( 'type' => self::TYPE_STRING, 'lang' => true, 'required' => true,'validate' => 'isCleanHtml',
				'size' => 255 ), 'active' => array( 'type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isunsignedInt' ),
			'params' => array( 'type' => self::TYPE_HTML, 'validate' => 'isString' ),
			'ordering' => array( 'type' => self::TYPE_INT, 'validate' => 'isInt' ) ) );

	public function __construct($id_tab = null, $id_lang = null, $id_shop = null)
	{
		Shop::addTableAssociation ('spsearchpro', array('type' => 'shop'));
		parent::__construct ($id_tab, $id_lang, $id_shop);
	}

	public function add($autodate = true, $null_values = false)
	{
		$this->ordering = $this->getHigherPosition () + 1;
		$res = parent::add($autodate, $null_values);
		return $res;
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

	public function getHigherPosition()
	{
		$sql = 'SELECT MAX(`ordering`)
				FROM `'._DB_PREFIX_.'spsearchpro`';
		$ordering = DB::getInstance ()->getValue ($sql);
		return ( is_numeric ($ordering) )?$ordering:0;
	}

	public function getHigherModuleID()
	{
		$sql = 'SELECT MAX(`id_spsearchpro`)
				FROM `'._DB_PREFIX_.'spsearchpro`';
		$id_spsearchpro = DB::getInstance ()->getValue ($sql);
		return ( is_numeric ($id_spsearchpro) )?$id_spsearchpro:1;
	}

	public static function getAssociatedIdsShop($id_module)
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT css.`id_shop`
			FROM `'._DB_PREFIX_.'spsearchpro` cs
			LEFT JOIN `'._DB_PREFIX_.'spsearchpro_shop` css ON (css.`id_spsearchpro` = cs.`id_spsearchpro`)
			WHERE cs.`id_spsearchpro` = '.(int)$id_module
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
		$id_spsearchpro = $this->id;
		$context = Context::getContext();
		$id_shop = $context->shop->id;

		$max = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT MAX(cs.`ordering`) as ordering
			FROM `'._DB_PREFIX_.'spsearchpro` cs, `'._DB_PREFIX_.'spsearchpro_shop` css
			WHERE css.`id_spsearchpro` = cs.`id_spsearchpro` AND css.`id_shop` = '.(int)$id_shop
		);

		if ((int)$max == (int)$id_spsearchpro)
			return true;
		$rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT cs.`ordering` as ordering, cs.`id_spsearchpro` as id_spsearchpro
			FROM `'._DB_PREFIX_.'spsearchpro` cs
			LEFT JOIN `'._DB_PREFIX_.'spsearchpro_shop` css ON (css.`id_spsearchpro` = cs.`id_spsearchpro`)
			WHERE css.`id_shop` = '.(int)$id_shop.' AND cs.`ordering` > '.(int)$this->ordering
		);

		foreach ($rows as $row)
		{
			$customs = new spsearchproClass($row['id_spsearchpro']);
			--$customs->ordering;
			$customs->update();
			unset($customs);
		}

		return true;
	}
}
