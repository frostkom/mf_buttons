<?php
/*
Plugin Name: MF Buttons
Plugin URI: https://github.com/frostkom/mf_buttons
Description:
Version: 1.3.16
Licence: GPLv2 or later
Author: Martin Fors
Author URI: https://martinfors.se
Text Domain: lang_buttons
Domain Path: /lang

Depends: MF Base
GitHub Plugin URI: frostkom/mf_buttons
*/

if(!function_exists('is_plugin_active') || function_exists('is_plugin_active') && is_plugin_active("mf_base/index.php"))
{
	include_once("include/classes.php");

	$obj_buttons = new mf_buttons();

	if(!is_admin())
	{
		add_action('wp_head', array($obj_buttons, 'wp_head'), 0);
	}

	add_action('widgets_init', array($obj_buttons, 'widgets_init'));

	load_plugin_textdomain('lang_buttons', false, dirname(plugin_basename(__FILE__))."/lang/");
}