<?php

class widget_buttons extends WP_Widget
{
	function __construct()
	{
		$widget_ops = array(
			'classname' => 'buttons',
			'description' => __("Display a button", 'lang_buttons')
		);

		$control_ops = array('id_base' => 'buttons-widget');

		parent::__construct('buttons-widget', __("Button", 'lang_buttons'), $widget_ops, $control_ops);

		wp_enqueue_style('style_buttons', plugin_dir_url(__FILE__)."style.css");
	}

	function widget($args, $instance)
	{
		global $wpdb;

		extract($args);

		if($instance['button_image'] != '' || $instance['button_text'] != '')
		{
			if($instance['button_image'] != ''){		$button_content = "<img src='".$instance['button_image']."'>";}
			else if($instance['button_text'] != ''){	$button_content = "<p>".$instance['button_text']."</p>";}

			if($instance['button_page'] > 0){			$button_link = get_permalink($instance['button_page']);}
			else if($instance['button_link'] != ''){	$button_link = $instance['button_link'];}
			else{										$button_link = "#";}

			echo $before_widget
				."<a href='".$button_link."'".($instance['button_background'] != '' ? " style='background: ".$instance['button_background']."'" : "").">"
					.$button_content
				."</a>"
			.$after_widget;
		}
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['button_image'] = strip_tags($new_instance['button_image']);
		$instance['button_text'] = strip_tags($new_instance['button_text']);
		$instance['button_background'] = strip_tags($new_instance['button_background']);
		$instance['button_page'] = strip_tags($new_instance['button_page']);
		$instance['button_link'] = strip_tags($new_instance['button_link']);

		return $instance;
	}

	function form($instance)
	{
		global $wpdb;

		$defaults = array(
			'button_image' => "",
			'button_text' => "",
			'button_background' => "",
			'button_page' => 0,
			'button_link' => "",
		);
		$instance = wp_parse_args((array)$instance, $defaults);

		$arr_data = array();
		get_post_children(array('add_choose_here' => true, 'output_array' => true), $arr_data);

		if($instance['button_text'] == '')
		{
			echo "<p>"
				.get_file_button(array('name' => $this->get_field_name('button_image'), 'value' => $instance['button_image']))
			."</p>";
		}

		if($instance['button_image'] == '')
		{
			echo "<p>"
				.show_textfield(array('name' => $this->get_field_name('button_text'), 'text' => __("Text", 'lang_buttons'), 'value' => $instance['button_text'], 'xtra' => " class='widefat'"))
			."</p>
			<p>"
				.show_textfield(array('type' => 'color', 'name' => $this->get_field_name('button_background'), 'text' => __("Background Color", 'lang_buttons'), 'value' => $instance['button_background']))
			."</p>";
		}

		if($instance['button_link'] == '')
		{
			echo "<p>"
				.show_select(array('data' => $arr_data, 'name' => $this->get_field_name('button_page'), 'text' => __("Page", 'lang_buttons'), 'value' => $instance['button_page'], 'xtra' => " class='widefat'"))
			."</p>";
		}

		if(!($instance['button_page'] > 0))
		{
			echo "<p>"
				.show_textfield(array('name' => $this->get_field_name('button_link'), 'text' => __("Link", 'lang_buttons'), 'value' => $instance['button_link'], 'xtra' => " class='widefat'"))
			."</p>";
		}
	}
}