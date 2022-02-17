<?php
/**
 * package   SP Product Comments
 *
 * @version 1.0.0
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2017 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

if (!defined('_PS_VERSION_'))
	exit;

class SPProductComment extends ObjectModel
{
	public $id;

	/** @var integer Product's id */
	public $id_product;

	/** @var integer Customer's id */
	public $id_customer;

	/** @var integer Guest's id */
	public $id_guest;

	/** @var integer Customer name */
	public $customer_name;

	/** @var string Title */
	public $title;

	/** @var string Content */
	public $content;

	/** @var integer Grade */
	public $grade;

	/** @var boolean Validate */
	public $validate = 0;

	public $deleted = 0;

	/** @var string Object creation date */
	public $date_add;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'spproduct_comment',
		'primary' => 'id_spproduct_comment',
		'fields' => array(
			'id_product' =>		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
			'id_customer' =>	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
			'id_guest' =>		array('type' => self::TYPE_INT),
			'customer_name' =>	array('type' => self::TYPE_STRING),
			'title' =>			array('type' => self::TYPE_STRING),
			'content' =>		array('type' => self::TYPE_STRING, 'validate' => 'isMessage', 'size' => 65535, 'required' => true),
			'grade' =>			array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
			'validate' =>		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'deleted' =>		array('type' => self::TYPE_BOOL),
			'date_add' =>		array('type' => self::TYPE_DATE),
		)
	);

	/**
	 * Get comments by IdProduct
	 *
	 * @return array Comments
	 */
	public static function getByProduct($id_product, $p = 1, $n = null, $id_customer = null)
	{
		if (!Validate::isUnsignedId($id_product))
			return false;
		$validate = Configuration::get('SPPRODUCT_COMMENTS_MODERATE');
		$p = (int)$p;
		$n = (int)$n;
		if ($p <= 1)
			$p = 1;
		if ($n != null && $n <= 0)
			$n = 5;

		$cache_id = 'SPProductComment::getByProduct_'.(int)$id_product.'-'.(int)$p.'-'.(int)$n.'-'.(int)$id_customer.'-'.(bool)$validate;
		if (!Cache::isStored($cache_id))
		{
			$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT pc.`id_spproduct_comment`,
			(SELECT count(*) FROM `'._DB_PREFIX_.'spproduct_comment_usefulness` pcu WHERE pcu.`id_spproduct_comment` = pc.`id_spproduct_comment` AND pcu.`usefulness` = 1) as total_useful,
			(SELECT count(*) FROM `'._DB_PREFIX_.'spproduct_comment_usefulness` pcu WHERE pcu.`id_spproduct_comment` = pc.`id_spproduct_comment`) as total_advice, '.
			((int)$id_customer ? '(SELECT count(*) FROM `'._DB_PREFIX_.'spproduct_comment_usefulness` pcuc WHERE pcuc.`id_spproduct_comment` = pc.`id_spproduct_comment` AND pcuc.id_customer = '.(int)$id_customer.') as customer_advice, ' : '').
			((int)$id_customer ? '(SELECT count(*) FROM `'._DB_PREFIX_.'spproduct_comment_report` pcrc WHERE pcrc.`id_spproduct_comment` = pc.`id_spproduct_comment` AND pcrc.id_customer = '.(int)$id_customer.') as customer_report, ' : '').'
			IF(c.id_customer, CONCAT(c.`firstname`, \' \',  LEFT(c.`lastname`, 1)), pc.customer_name) customer_name, pc.`content`, pc.`grade`, pc.`date_add`, pc.title
			  FROM `'._DB_PREFIX_.'spproduct_comment` pc
			LEFT JOIN `'._DB_PREFIX_.'customer` c ON c.`id_customer` = pc.`id_customer`
			WHERE pc.`id_product` = '.(int)($id_product).($validate == '1' ? ' AND pc.`validate` = 1' : '').'
			ORDER BY pc.`date_add` DESC
			'.($n ? 'LIMIT '.(int)(($p - 1) * $n).', '.(int)($n) : ''));
			Cache::store($cache_id, $result);
		}
		return Cache::retrieve($cache_id);
	}

	/**
	 * Return customer's comment
	 *
	 * @return arrayComments
	 */
	public static function getByCustomer($id_product, $id_customer, $get_last = false, $id_guest = false)
	{
		$cache_id = 'SPProductComment::getByCustomer_'.(int)$id_product.'-'.(int)$id_customer.'-'.(bool)$get_last.'-'.(int)$id_guest;
		if (!Cache::isStored($cache_id))
		{
			$results = Db::getInstance()->executeS('
				SELECT *
				FROM `'._DB_PREFIX_.'spproduct_comment` pc
				WHERE pc.`id_product` = '.(int)$id_product.'
				AND '.(!$id_guest ? 'pc.`id_customer` = '.(int)$id_customer : 'pc.`id_guest` = '.(int)$id_guest).'
				ORDER BY pc.`date_add` DESC '
				.($get_last ? 'LIMIT 1' : '')
			);

			if ($get_last && count($results))
				$results = array_shift($results);

			Cache::store($cache_id, $results);
		}
		return Cache::retrieve($cache_id);
	}

	/**
	 * Get Grade By product
	 *
	 * @return array Grades
	 */
	public static function getGradeByProduct($id_product, $id_lang)
	{
		if (!Validate::isUnsignedId($id_product) ||
			!Validate::isUnsignedId($id_lang))
			return false;
		$validate = Configuration::get('SPPRODUCT_COMMENTS_MODERATE');


		return (Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT pc.`id_spproduct_comment`, pcg.`grade`, pccl.`name`, pcc.`id_spproduct_comment_criterion`
		FROM `'._DB_PREFIX_.'spproduct_comment` pc
		LEFT JOIN `'._DB_PREFIX_.'spproduct_comment_grade` pcg ON (pcg.`id_spproduct_comment` = pc.`id_spproduct_comment`)
		LEFT JOIN `'._DB_PREFIX_.'spproduct_comment_criterion` pcc ON (pcc.`id_spproduct_comment_criterion` = pcg.`id_spproduct_comment_criterion`)
		LEFT JOIN `'._DB_PREFIX_.'spproduct_comment_criterion_lang` pccl ON (pccl.`id_spproduct_comment_criterion` = pcg.`id_spproduct_comment_criterion`)
		WHERE pc.`id_product` = '.(int)$id_product.'
		AND pccl.`id_lang` = '.(int)$id_lang.
		($validate == '1' ? ' AND pc.`validate` = 1' : '')));
	}

	public static function getRatings($id_product)
	{
		$validate = Configuration::get('SPPRODUCT_COMMENTS_MODERATE');

		$sql = 'SELECT (SUM(pc.`grade`) / COUNT(pc.`grade`)) AS avg,
				MIN(pc.`grade`) AS min,
				MAX(pc.`grade`) AS max
			FROM `'._DB_PREFIX_.'spproduct_comment` pc
			WHERE pc.`id_product` = '.(int)$id_product.'
			AND pc.`deleted` = 0'.
			($validate == '1' ? ' AND pc.`validate` = 1' : '');


		return Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);

	}

	public static function getAverageGrade($id_product)
	{
		$validate = Configuration::get('SPPRODUCT_COMMENTS_MODERATE');

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT (SUM(pc.`grade`) / COUNT(pc.`grade`)) AS grade
		FROM `'._DB_PREFIX_.'spproduct_comment` pc
		WHERE pc.`id_product` = '.(int)$id_product.'
		AND pc.`deleted` = 0'.
		($validate == '1' ? ' AND pc.`validate` = 1' : ''));
	}

	public static function getAveragesByProduct($id_product, $id_lang)
	{
		/* Get all grades */
		$grades = SPProductComment::getGradeByProduct((int)$id_product, (int)$id_lang);
		$total = SPProductComment::getGradedCommentNumber((int)$id_product);
		if (!count($grades) || (!$total))
			return array();

		/* Addition grades for each criterion */
		$criterionsGradeTotal = array();
		$count_grades = count($grades);
		for ($i = 0; $i < $count_grades; ++$i)
			if (array_key_exists($grades[$i]['id_spproduct_comment_criterion'], $criterionsGradeTotal) === false)
				$criterionsGradeTotal[$grades[$i]['id_spproduct_comment_criterion']] = (int)($grades[$i]['grade']);
			else
				$criterionsGradeTotal[$grades[$i]['id_spproduct_comment_criterion']] += (int)($grades[$i]['grade']);

		/* Finally compute the averages */
		$averages = array();
		foreach ($criterionsGradeTotal as $key => $criterionGradeTotal)
			$averages[(int)($key)] = (int)($total) ? ((int)($criterionGradeTotal) / (int)($total)) : 0;
		return $averages;
	}

	/**
	 * Return number of comments and average grade by products
	 *
	 * @return array Info
	 */
	public static function getCommentNumber($id_product)
	{
		if (!Validate::isUnsignedId($id_product))
			return false;
		$validate = (int)Configuration::get('SPPRODUCT_COMMENTS_MODERATE');
		$cache_id = 'SPProductComment::getCommentNumber_'.(int)$id_product.'-'.$validate;
		if (!Cache::isStored($cache_id))
		{
			$result = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT COUNT(`id_spproduct_comment`) AS "nbr"
			FROM `'._DB_PREFIX_.'spproduct_comment` pc
			WHERE `id_product` = '.(int)($id_product).($validate == '1' ? ' AND `validate` = 1' : ''));
			Cache::store($cache_id, $result);
		}
		return Cache::retrieve($cache_id);
	}

	/**
	 * Return number of comments and average grade by products
	 *
	 * @return array Info
	 */
	public static function getGradedCommentNumber($id_product)
	{
		if (!Validate::isUnsignedId($id_product))
			return false;
		$validate = (int)Configuration::get('SPPRODUCT_COMMENTS_MODERATE');

		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT COUNT(pc.`id_product`) AS nbr
		FROM `'._DB_PREFIX_.'spproduct_comment` pc
		WHERE `id_product` = '.(int)($id_product).($validate == '1' ? ' AND `validate` = 1' : '').'
		AND `grade` > 0');
		return (int)($result['nbr']);
	}

	/**
	 * Get comments by Validation
	 *
	 * @return array Comments
	 */
	public static function getByValidate($validate = '0', $deleted = false)
	{
		$sql  = '
			SELECT pc.`id_spproduct_comment`, pc.`id_product`, IF(c.id_customer, CONCAT(c.`firstname`, \' \',  c.`lastname`), pc.customer_name) customer_name, pc.`title`, pc.`content`, pc.`grade`, pc.`date_add`, pl.`name`
			FROM `'._DB_PREFIX_.'spproduct_comment` pc
			LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = pc.`id_customer`)
			LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (pl.`id_product` = pc.`id_product` AND pl.`id_lang` = '.(int)Context::getContext()->language->id.Shop::addSqlRestrictionOnLang('pl').')
			WHERE pc.`validate` = '.(int)$validate;

		$sql .= ' ORDER BY pc.`date_add` DESC';
		return (Db::getInstance()->executeS($sql));
	}

	/**
	 * Get all comments
	 *
	 * @return array Comments
	 */
	public static function getAll()
	{
		return (Db::getInstance()->executeS('
		SELECT pc.`id_spproduct_comment`, pc.`id_product`, IF(c.id_customer, CONCAT(c.`firstname`, \' \',  c.`lastname`), pc.customer_name) customer_name, pc.`content`, pc.`grade`, pc.`date_add`, pl.`name`
		FROM `'._DB_PREFIX_.'spproduct_comment` pc
		LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = pc.`id_customer`)
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (pl.`id_product` = pc.`id_product` AND pl.`id_lang` = '.(int)Context::getContext()->language->id.Shop::addSqlRestrictionOnLang('pl').')
		ORDER BY pc.`date_add` DESC'));
	}

	/**
	 * Validate a comment
	 *
	 * @return boolean succeed
	 */
	public function validate($validate = '1')
	{
		if (!Validate::isUnsignedId($this->id))
			return false;

		$success = (Db::getInstance()->execute('
		UPDATE `'._DB_PREFIX_.'spproduct_comment` SET
		`validate` = '.(int)$validate.'
		WHERE `id_spproduct_comment` = '.(int)$this->id));

		Hook::exec('actionObjectSPProductCommentValidateAfter', array('object' => $this));
		return $success;
	}

	/**
	 * Delete a comment, grade and report data
	 *
	 * @return boolean succeed
	 */
	public function delete()
	{
		parent::delete();
		SPProductComment::deleteGrades($this->id);
		SPProductComment::deleteReports($this->id);
		SPProductComment::deleteUsefulness($this->id);
	}

	/**
	 * Delete Grades
	 *
	 * @return boolean succeed
	 */
	public static function deleteGrades($id_spproduct_comment)
	{
		if (!Validate::isUnsignedId($id_spproduct_comment))
			return false;
		return (Db::getInstance()->execute('
		DELETE FROM `'._DB_PREFIX_.'spproduct_comment_grade`
		WHERE `id_spproduct_comment` = '.(int)$id_spproduct_comment));
	}

	/**
	 * Delete Reports
	 *
	 * @return boolean succeed
	 */
	public static function deleteReports($id_spproduct_comment)
	{
		if (!Validate::isUnsignedId($id_spproduct_comment))
			return false;
		return (Db::getInstance()->execute('
		DELETE FROM `'._DB_PREFIX_.'spproduct_comment_report`
		WHERE `id_spproduct_comment` = '.(int)$id_spproduct_comment));
	}

	/**
	 * Delete usefulness
	 *
	 * @return boolean succeed
	 */
	public static function deleteUsefulness($id_spproduct_comment)
	{
		if (!Validate::isUnsignedId($id_spproduct_comment))
			return false;

		return (Db::getInstance()->execute('
		DELETE FROM `'._DB_PREFIX_.'spproduct_comment_usefulness`
		WHERE `id_spproduct_comment` = '.(int)$id_spproduct_comment));
	}

	/**
	 * Report comment
	 *
	 * @return boolean
	 */
	public static function reportComment($id_spproduct_comment, $id_customer)
	{
		return (Db::getInstance()->execute('
			INSERT INTO `'._DB_PREFIX_.'spproduct_comment_report` (`id_spproduct_comment`, `id_customer`)
			VALUES ('.(int)$id_spproduct_comment.', '.(int)$id_customer.')'));
	}

	/**
	 * Comment already report
	 *
	 * @return boolean
	 */
	public static function isAlreadyReport($id_spproduct_comment, $id_customer)
	{
		return (bool)Db::getInstance()->getValue('
			SELECT COUNT(*)
			FROM `'._DB_PREFIX_.'spproduct_comment_report`
			WHERE `id_customer` = '.(int)$id_customer.'
			AND `id_spproduct_comment` = '.(int)$id_spproduct_comment);
	}

	/**
	 * Set comment usefulness
	 *
	 * @return boolean
	 */
	public static function setCommentUsefulness($id_spproduct_comment, $usefulness, $id_customer)
	{
		return (Db::getInstance()->execute('
			INSERT INTO `'._DB_PREFIX_.'spproduct_comment_usefulness` (`id_spproduct_comment`, `usefulness`, `id_customer`)
			VALUES ('.(int)$id_spproduct_comment.', '.(int)$usefulness.', '.(int)$id_customer.')'));
	}

	/**
	 * Usefulness already set
	 *
	 * @return boolean
	 */
	public static function isAlreadyUsefulness($id_spproduct_comment, $id_customer)
	{
		return (bool)Db::getInstance()->getValue('
			SELECT COUNT(*)
			FROM `'._DB_PREFIX_.'spproduct_comment_usefulness`
			WHERE `id_customer` = '.(int)$id_customer.'
			AND `id_spproduct_comment` = '.(int)$id_spproduct_comment);
	}

	/**
	 * Get reported comments
	 *
	 * @return array Comments
	 */
	public static function getReportedComments()
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT DISTINCT(pc.`id_spproduct_comment`), pc.`id_product`, IF(c.id_customer, CONCAT(c.`firstname`, \' \',  c.`lastname`), pc.customer_name) customer_name, pc.`content`, pc.`grade`, pc.`date_add`, pl.`name`, pc.`title`
		FROM `'._DB_PREFIX_.'spproduct_comment_report` pcr
		LEFT JOIN `'._DB_PREFIX_.'spproduct_comment` pc
			ON pcr.id_spproduct_comment = pc.id_spproduct_comment
		LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = pc.`id_customer`)
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (pl.`id_product` = pc.`id_product` AND pl.`id_lang` = '.(int)Context::getContext()->language->id.' AND pl.`id_lang` = '.(int)Context::getContext()->language->id.Shop::addSqlRestrictionOnLang('pl').')
		ORDER BY pc.`date_add` DESC');
	}

};
