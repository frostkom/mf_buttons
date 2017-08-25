<?php

function init_buttons()
{
	if(!is_admin())
	{
		mf_enqueue_style('style_buttons', plugin_dir_url(__FILE__)."style.css", get_plugin_version(__FILE__));
	}
}

function widgets_buttons()
{
	register_widget('widget_buttons');
}