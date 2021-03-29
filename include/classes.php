<?php

class mf_buttons
{
	function __construct(){}

	function wp_head()
	{
		if(!is_plugin_active("mf_widget_logic_select/index.php") || apply_filters('get_widget_search', 'buttons-widget') > 0)
		{
			$plugin_include_url = plugin_dir_url(__FILE__);
			$plugin_version = get_plugin_version(__FILE__);

			mf_enqueue_style('style_buttons', $plugin_include_url."style.css", $plugin_version);
		}
	}

	function widgets_init()
	{
		register_widget('widget_buttons');
	}
}

class widget_buttons extends WP_Widget
{
	function __construct()
	{
		$this->widget_ops = array(
			'classname' => 'buttons',
			'description' => __("Display a button", 'lang_buttons')
		);

		$this->arr_default = array(
			'button_image' => '',
			'button_text' => '',
			'button_text_color' => '#ffffff',
			'button_background' => '',
			'button_page' => 0,
			'button_link' => '',
		);

		parent::__construct(str_replace("_", "-", $this->widget_ops['classname']).'-widget', __("Button", 'lang_buttons'), $this->widget_ops);
	}

	function widget($args, $instance)
	{
		extract($args);
		$instance = wp_parse_args((array)$instance, $this->arr_default);

		if($instance['button_image'] != '' || $instance['button_text'] != '')
		{
			if($instance['button_image'] != '')
			{
				$button_content = render_image_tag(array('src' => $instance['button_image']));
			}

			else if($instance['button_text'] != '')
			{
				$button_text_length = strlen($instance['button_text']);

				$class_temp = "";

				if($button_text_length > 30){		$class_temp = "length_30";}
				else if($button_text_length > 15){	$class_temp = "length_15";}

				$button_content = "<p"
					.($class_temp != '' ? " class='".$class_temp."'" : "")
					.($instance['button_text_color'] != '' ? " style='color: ".$instance['button_text_color']."'" : "")
				.">"
					.$instance['button_text']
				."</p>";
			}

			if($instance['button_page'] > 0){			$button_link = get_permalink($instance['button_page']);}
			else if($instance['button_link'] != ''){	$button_link = $instance['button_link'];}
			else{										$button_link = "#";}

			echo $before_widget
				."<a href='".$button_link."'"
					.($instance['button_background'] != '' ? " style='background: ".$instance['button_background']."'" : "")
				.">"
					.$button_content
				."</a>"
			.$after_widget;
		}
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$new_instance = wp_parse_args((array)$new_instance, $this->arr_default);

		$instance['button_image'] = sanitize_text_field($new_instance['button_image']);
		$instance['button_text'] = sanitize_text_field($new_instance['button_text']);
		$instance['button_text_color'] = sanitize_text_field($new_instance['button_text_color']);
		$instance['button_background'] = sanitize_text_field($new_instance['button_background']);
		$instance['button_page'] = sanitize_text_field($new_instance['button_page']);
		$instance['button_link'] = esc_url_raw($new_instance['button_link']);

		return $instance;
	}

	function form($instance)
	{
		$instance = wp_parse_args((array)$instance, $this->arr_default);

		echo "<div class='mf_form'>";

			if($instance['button_image'] == '')
			{
				echo show_textfield(array('name' => $this->get_field_name('button_text'), 'text' => __("Text", 'lang_buttons'), 'value' => $instance['button_text']))
				.show_textfield(array('type' => 'color', 'name' => $this->get_field_name('button_text_color'), 'text' => __("Text Color", 'lang_buttons'), 'value' => $instance['button_text_color']))
				.show_textfield(array('type' => 'color', 'name' => $this->get_field_name('button_background'), 'text' => __("Background Color", 'lang_buttons'), 'value' => $instance['button_background']));
			}

			if($instance['button_text'] == '' || $instance['button_image'] != '')
			{
				echo get_media_library(array('type' => 'image', 'name' => $this->get_field_name('button_image'), 'value' => $instance['button_image']));
			}

			if($instance['button_link'] == '')
			{
				$arr_data = array();
				get_post_children(array('add_choose_here' => true), $arr_data);

				echo show_select(array('data' => $arr_data, 'name' => $this->get_field_name('button_page'), 'text' => __("Page", 'lang_buttons'), 'value' => $instance['button_page']));
			}

			if(!($instance['button_page'] > 0))
			{
				echo show_textfield(array('type' => 'url', 'name' => $this->get_field_name('button_link'), 'text' => __("Link", 'lang_buttons'), 'value' => $instance['button_link']));
			}

		echo "</div>";
	}
}