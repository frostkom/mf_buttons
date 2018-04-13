<?php
/*
Plugin Name: MF Buttons
Plugin URI: https://github.com/frostkom/mf_buttons
Description: 
Version: 1.2.5
Licence: GPLv2 or later
Author: Martin Fors
Author URI: http://frostkom.se
Text Domain: lang_buttons
Domain Path: /lang

Depends: MF Base
GitHub Plugin URI: frostkom/mf_buttons
*/

include_once("include/classes.php");
include_once("include/functions.php");

$obj_buttons = new mf_buttons();

add_action('init', 'init_buttons');
add_action('widgets_init', 'widgets_buttons');

if(is_admin())
{

}

else
{
	add_action('wp_head', array($obj_buttons, 'wp_head'), 0);
}

load_plugin_textdomain('lang_buttons', false, dirname(plugin_basename(__FILE__)).'/lang/');