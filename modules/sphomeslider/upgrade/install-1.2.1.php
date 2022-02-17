<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_2_1($object)
{
	return Db::getInstance()->execute('
	UPDATE '._DB_PREFIX_.'sphomeslider_slides_lang SET
		'.sphomeslider_stripslashes_field('title').',
		'.sphomeslider_stripslashes_field('description').',
		'.sphomeslider_stripslashes_field('legend').',
		'.sphomeslider_stripslashes_field('url')
	);
}

function sphomeslider_stripslashes_field($field)
{
	$quotes = array('"\\\'"', '"\'"');
	$dquotes = array('\'\\\\"\'', '\'"\'');
	$backslashes = array('"\\\\\\\\"', '"\\\\"');

	return '`'.bqSQL($field).'` = replace(replace(replace(`'.bqSQL($field).'`, '.$quotes[0].', '.$quotes[1].'), '.$dquotes[0].', '.$dquotes[1].'), '.$backslashes[0].', '.$backslashes[1].')';
}