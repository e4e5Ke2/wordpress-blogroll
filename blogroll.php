<?php

/**
 * @package Blogroll
 * @version 1.0.1
 */
/*
Plugin Name: Blogroll
Description: A plugin that aggregates multiple feeds to display their most recent entries.
Text Domain: blogroll
Domain Path: /languages
Author: Alexander Bach
Version: 1.0.1
*/

require 'shared/FeedHelper.php';
require 'shared/RssFeed.php';
require 'shared/RssParser.php';
require 'shared/RssFilter.php';
require 'shared/Translations.php';
require 'Admin.php';
require 'Params.php';
require 'WordpressTranslations.php';

use My\Module\Blogroll\Site\Helper\FeedHelper;

class Blogroll_Widget extends WP_Widget
{
	public function __construct()
	{
		parent::__construct(
			'blogroll_widget', // Base ID
			'Blogroll_Widget', // Name
			array('description' => __('MOD_BLOGROLL_XML_DESCRIPTION', 'blogroll')) // Args
		);
	}

	public function widget($args, $instance)
	{
		if (array_key_exists('rssurl_list', $instance)) {
			extract($args);
			$title = apply_filters('widget_title', $instance['title']);
			echo $before_widget;

			// Visual header
			if (!empty($title)) {
				echo $before_title . $title . $after_title;
			}

			$translations = new WordpressTranslations();

			$feedHelper = new FeedHelper();
			$params = new Params($instance);
			$feeds = $feedHelper->getFeeds($params, $translations);

			include 'WidgetRenderer.php';

			echo $after_widget;
		}
	}

	public function form($instance)
	{
		$translations = new WordpressTranslations();
		presentForm($this, $instance, $translations);
	}

	public function update($new_instance, $old_instance)
	{
		$instance = updateForm($new_instance, $old_instance);
		return $instance;
	}

}

add_action('plugins_loaded', 'blogroll_load_textdomain');

function blogroll_load_textdomain()
{
	load_plugin_textdomain('blogroll', false, dirname(plugin_basename(__FILE__)) . '/languages');
}


add_action('widgets_init', 'register_blogroll');
function register_blogroll()
{
	register_widget('Blogroll_Widget');
}

add_action('wp_enqueue_scripts', 'blogroll_enqueue_styles');
function blogroll_enqueue_styles()
{
	wp_enqueue_style('blogroll-css', plugin_dir_url(__FILE__) . 'media/blogroll_style.css', array(), '1.0.0', 'all');
	wp_enqueue_script('blogroll-js', plugin_dir_url(__FILE__) . 'media/show-all.js', array(), null, 'all');

	$blogroll_js_vars = [
		'show_more' => __('MOD_BLOGROLL_SHOW_MORE', 'blogroll'),
		'show_less' => __('MOD_BLOGROLL_SHOW_LESS', 'blogroll'),
	];

	wp_localize_script('blogroll-js', 'blogroll_js_vars', $blogroll_js_vars);
}
