<?php 

/**
 * Custom blocks for visual composer in this theme.
 */
function thedux_framework_register_lugos_blocks(){
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/functions.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_accordion_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_block_title_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_blog_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_blog_posts_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_button_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_card_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_carousel_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_clients_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_feature_banner_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_feature_product_list_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_hero_header_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_hero_slider_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_hover_tile_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_icon_cards_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_image_gallery_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_image_gallery_wide_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_image_text_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_inline_video_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_instafeed_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_modal_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_modal_gallery_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_modal_gallery_wide_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_modal_video_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_portfolio_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_pricing_table_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_product_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_product_masonry_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_progress_bar_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_shop_deal_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_shop_feature_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_tabs_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_team_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_testimonial_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_twitter_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_video_background_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_video_gallery_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_video_gallery_wide_block.php');
	require_once( THEDUX_FRAMEWORK_PATH . 'vc_blocks/lugos/vc_map_block.php');
}

function thedux_framework_lugos_init(){
	if( function_exists('vc_set_as_theme') ){
		add_action('after_setup_theme', 'thedux_framework_register_lugos_blocks', 10);
	}
}

add_action('plugins_loaded', 'thedux_framework_lugos_init', 9999);