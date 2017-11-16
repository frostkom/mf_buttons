<?php

class widget_buttons extends WP_Widget
{
	function __construct()
	{
		$widget_ops = array(
			'classname' => 'buttons',
			'description' => __("Display a button", 'lang_buttons')
		);

		$this->arr_default = array(
			'button_image' => "",
			'button_text' => "",
			'button_background' => "",
			'button_page' => 0,
			'button_link' => "",
		);

		parent::__construct('buttons-widget', __("Button", 'lang_buttons'), $widget_ops);
	}

	function widget($args, $instance)
	{
		extract($args);

		$instance = wp_parse_args((array)$instance, $this->arr_default);

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

		$new_instance = wp_parse_args((array)$new_instance, $this->arr_default);

		$instance['button_image'] = strip_tags($new_instance['button_image']);
		$instance['button_text'] = strip_tags($new_instance['button_text']);
		$instance['button_background'] = strip_tags($new_instance['button_background']);
		$instance['button_page'] = strip_tags($new_instance['button_page']);
		$instance['button_link'] = strip_tags($new_instance['button_link']);

		return $instance;
	}

	function form($instance)
	{
		$instance = wp_parse_args((array)$instance, $this->arr_default);

		$arr_data = array();
		get_post_children(array('add_choose_here' => true), $arr_data);

		echo "<div class='mf_form'>";

			if($instance['button_text'] == '')
			{
				echo get_file_button(array('name' => $this->get_field_name('button_image'), 'value' => $instance['button_image']));
			}

			if($instance['button_image'] == '')
			{
				echo show_textfield(array('name' => $this->get_field_name('button_text'), 'text' => __("Text", 'lang_buttons'), 'value' => $instance['button_text']))
				.show_textfield(array('type' => 'color', 'name' => $this->get_field_name('button_background'), 'text' => __("Background Color", 'lang_buttons'), 'value' => $instance['button_background']));
			}

			if($instance['button_link'] == '')
			{
				echo show_select(array('data' => $arr_data, 'name' => $this->get_field_name('button_page'), 'text' => __("Page", 'lang_buttons'), 'value' => $instance['button_page']));
			}

			if(!($instance['button_page'] > 0))
			{
				echo show_textfield(array('type' => 'url', 'name' => $this->get_field_name('button_link'), 'text' => __("Link", 'lang_buttons'), 'value' => $instance['button_link']));
			}

		echo "</div>";
	}
}