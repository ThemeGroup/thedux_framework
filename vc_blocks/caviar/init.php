<?php 

/**
 * Custom blocks for visual composer in this theme.
 */
function thedux_framework_register_caviar_blocks(){
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/functions.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_hero_header_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_hero_slider_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_accordion_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_tabs_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_icon_cards_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_pricing_table_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_card_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_testimonial_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_portfolio_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_team_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_blog_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_product_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_twitter_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_hover_tile_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_progress_bar_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_image_text_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_inline_video_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_clients_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_modal_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_video_background_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_carousel_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_image_gallery_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_image_gallery_wide_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_modal_gallery_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_modal_gallery_wide_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_video_gallery_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/caviar/vc_video_gallery_wide_block.php');
}

function thedux_framework_caviar_init(){
	if( function_exists('vc_set_as_theme') ){
		add_action('after_setup_theme', 'thedux_framework_register_caviar_blocks', 10);
	}
}

add_action('plugins_loaded', 'thedux_framework_caviar_init', 9999);