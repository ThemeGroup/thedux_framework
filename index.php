<?php
/*
Plugin Name: Themedeux Framework
Plugin URI: http://www.themedeux.com/thedux-framework
Description: Themedeux Framework - The Driving Force Behind Themedeux Themes
Version: 1.0.0
Author: Dzung Nova
Author URI: http://www.themedeux.com
*/	

/**
 * Plugin definitions
 */
define( 'THEDUX_FRAMEWORK_PATH', trailingslashit(plugin_dir_path(__FILE__)) );
define( 'THEDUX_FRAMEWORK_VERSION', '1.0.0');

/**
 * Styles & Scripts
 */
if(!( function_exists('thedux_framework_admin_load_scripts') )){
	function thedux_framework_admin_load_scripts(){
		wp_enqueue_style('thedux_framework_font_awesome', plugins_url( '/css/font-awesome.min.css' , __FILE__ ) );
		wp_enqueue_style('thedux_framework_admin_css', plugins_url( '/css/thedux-framework-admin.css' , __FILE__ ) );
		wp_enqueue_script('thedux_framework_admin_js', plugins_url( '/js/thedux-framework-admin.js' , __FILE__ ) );
	}
	add_action('admin_enqueue_scripts', 'thedux_framework_admin_load_scripts', 200);
}

/**
 * Some items are definitely always loaded, these are those.
 */
/**
 * Grab all custom post type functions
 */
require_once( THEDUX_FRAMEWORK_PATH . 'thedux_cpt.php' );

/**
 * Grab all generic functions
 */
require_once( THEDUX_FRAMEWORK_PATH . 'thedux_functions.php' );

/**
 * Everything else in the framework is conditionally loaded depending on theme options.
 * Let's include all of that now.
 */
require_once( THEDUX_FRAMEWORK_PATH . 'init.php' );

/**
 * thedux_ajax_import_data
 * 
 * Use this to auto import a demo-data.xml for the theme.
 * demo-data.xml must be in your active theme root folder, you should also copy this into a child theme if you supply one.
 * 
 * @author dzungnova
 * @since v1.0.0
 */
if(!( function_exists('thedux_ajax_import_data') )){
	function thedux_ajax_import_data() {				
		require_once( THEDUX_FRAMEWORK_PATH . 'wordpress-importer/demo_import.php' );
		die('thedux_import');
	}
	add_action('wp_ajax_thedux_ajax_import_data', 'thedux_ajax_import_data');
}