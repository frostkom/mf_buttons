<?php
/*
Plugin Name: MF Buttons
Plugin URI: https://github.com/frostkom/mf_buttons
Description: 
Version: 1.2.1
Author: Martin Fors
Author URI: http://frostkom.se
Text Domain: lang_buttons
Domain Path: /lang

GitHub Plugin URI: frostkom/mf_buttons
*/

include_once("include/classes.php");
include_once("include/functions.php");

add_action('init', 'init_buttons');
add_action('widgets_init', 'widgets_buttons');

load_plugin_textdomain('lang_buttons', false, dirname(plugin_basename(__FILE__)).'/lang/');