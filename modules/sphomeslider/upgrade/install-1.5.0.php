<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_5_0($module)
{
	/* Get existing values as default */
	$default_width = (int)Configuration::get('SPHOMESLIDER_WIDTH');
	$default_speed = (int)Configuration::get('SPHOMESLIDER_SPEED');
	$default_pause = (int)Configuration::get('SPHOMESLIDER_PAUSE');
	$default_loop = (int)Configuration::get('SPHOMESLIDER_LOOP');
	$res = true;

	// Clean existing
	Configuration::deleteByName('SPHOMESLIDER_WIDTH');
	Configuration::deleteByName('SPHOMESLIDER_SPEED');
	Configuration::deleteByName('SPHOMESLIDER_PAUSE');
	Configuration::deleteByName('SPHOMESLIDER_LOOP');

	$shops = Shop::getContextListShopID();
	$shop_groups_list = array();

	/* Setup each shop */
	foreach ($shops as $shop_id)
	{
		$shop_group_id = (int)Shop::getGroupFromShop($shop_id, true);

		if (!in_array($shop_group_id, $shop_groups_list))
			$shop_groups_list[] = $shop_group_id;

		/* Sets up configuration */
		$res = Configuration::updateValue('SPHOMESLIDER_WIDTH', $default_width, false, $shop_group_id, $shop_id);
		$res &= Configuration::updateValue('SPHOMESLIDER_SPEED', $default_speed, false, $shop_group_id, $shop_id);
		$res &= Configuration::updateValue('SPHOMESLIDER_PAUSE', $default_pause, false, $shop_group_id, $shop_id);
		$res &= Configuration::updateValue('SPHOMESLIDER_LOOP', $default_loop, false, $shop_group_id, $shop_id);
	}

	/* Sets up Shop Group configuration */
	if (count($shop_groups_list))
	{
		foreach ($shop_groups_list as $shop_group_id)
		{
			$res = Configuration::updateValue('SPHOMESLIDER_WIDTH', $default_width, false, $shop_group_id);
			$res &= Configuration::updateValue('SPHOMESLIDER_SPEED', $default_speed, false, $shop_group_id);
			$res &= Configuration::updateValue('SPHOMESLIDER_PAUSE', $default_pause, false, $shop_group_id);
			$res &= Configuration::updateValue('SPHOMESLIDER_LOOP', $default_loop, false, $shop_group_id);
		}
	}

	/* Sets up Global configuration */
	$res = Configuration::updateValue('SPHOMESLIDER_WIDTH', $default_width);
	$res &= Configuration::updateValue('SPHOMESLIDER_SPEED', $default_speed);
	$res &= Configuration::updateValue('SPHOMESLIDER_PAUSE', $default_pause);
	$res &= Configuration::updateValue('SPHOMESLIDER_LOOP', $default_loop);


	return $res;
}

