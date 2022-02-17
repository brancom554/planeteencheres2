<?php
/**
 * package SP Footer Links
 *
 * @version 1.0.1
 * @author    MagenTech http://www.magentech.com
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */


use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\ObjectPresenter;

if (!defined('_PS_VERSION_'))
	exit;

class spblockcurrency extends Module implements WidgetInterface
{
	public function __construct()
	{
		$this->name = 'spblockcurrency';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'MagenTech';
		$this->need_instance = 0;
		parent::__construct();
		$this->displayName = $this->l('Sp Currency block');
		$this->description = $this->l('Adds a block allowing customers to choose their preferred shopping currency.');
		$this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);
	}

	public function install()
	{
		if (parent::install () == false || !$this->registerHook ('displayNav') || !$this->registerHook ('displayNav_2'))
			return false;
		return true;
	}		
	
	public function getWidgetVariables($hookName, array $configuration)
	{
		$current_currency = null;
		$serializer = new ObjectPresenter;
		$currencies = array_map(
			function ($currency) use ($serializer, &$current_currency) {
				$currencyArray = $serializer->present($currency);

				// serializer doesn't see 'sign' because it is not a regular
				// ObjectModel field.
				$currencyArray['sign'] = $currency->sign;

				$url = $this->context->link->getLanguageLink(
					$this->context->language->id
				);

				$extraParams = [
					'SubmitCurrency' => 1,
					'id_currency' => $currency->id
				];

				$partialQueryString = http_build_query($extraParams);
				$separator = empty(parse_url($url)['query']) ? '?' : '&';

				$url .= $separator . $partialQueryString;

				$currencyArray['url'] = $url;

				if ($currency->id === $this->context->currency->id) {
					$currencyArray['current'] = true;
					$current_currency = $currencyArray;
				} else {
					$currencyArray['current'] = false;
				}

				return $currencyArray;
			},
			Currency::getCurrencies(true, true)
		);

		return [
			'currencies' => $currencies,
			'current_currency' => $current_currency
		];
	}

	public function renderWidget($hookName, array $configuration)
	{
		if (Configuration::isCatalogMode())
			return '';

		if (!Currency::isMultiCurrencyActivated())
			return '';

		$this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
		return $this->fetch('module:spblockcurrency/spblockcurrency.tpl');
	}
}
