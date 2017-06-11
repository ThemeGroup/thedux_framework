<?php

/**
 * The Shortcode
 */
function thedux_tabs_shortcode( $atts, $content = null ) {
	
	global $thedux_tabs_layout;
	$thedux_tabs_layout = false;
	
	extract( 
		shortcode_atts( 
			array(
				'layout' => 'tabs-1 text-center'
			), $atts 
		) 
	);
	
	$thedux_tabs_layout = $layout;
	
	$output = '<div class="tabs-container '. esc_attr($layout) .'"><ul class="tabs">'. do_shortcode($content) .'</ul></div>';
	
	return $output;
}
add_shortcode( 'lugos_tabs', 'thedux_tabs_shortcode' );

/**
 * The Shortcode
 */
function thedux_tabs_content_shortcode( $atts, $content = null ) {
	
	global $thedux_tabs_layout;
	
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'icon' => 'none'
			), $atts 
		) 
	);
	
	if( $thedux_tabs_layout == 'tabs-2 text-center lugos-icon-tabs' ){
		
		$title_html = '
			<div class="tab__title">
				<i class="'. esc_attr($icon) .' icon--lg"></i>
			</div>
		';
		
	} elseif(!( $thedux_tabs_layout == 'tabs-2 text-center' )){
		
		$title_html = '
			<div class="tab__title btn">
				<span class="btn__text">'. htmlspecialchars_decode($title) .'</span>
			</div>
		';
		
	} else {
		
		$title_html = '
			<div class="tab__title">
				<h5>'. htmlspecialchars_decode($title) .'</h5>
			</div>
		';
		
	}
	
	$output = '
		<li>
			'. $title_html .'
			<div class="tab__content">
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'	
			</div>
		</li>
	';

	return $output;
}
add_shortcode( 'lugos_tabs_content', 'thedux_tabs_content_shortcode' );

// Parent Element
function thedux_tabs_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'                    => esc_html__( 'Tabs' , 'lugos' ),
		    'base'                    => 'lugos_tabs',
		    'description'             => esc_html__( 'Create tabs Content', 'lugos' ),
		    'as_parent'               => array('only' => 'lugos_tabs_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Lugos Theme', 'lugos'),
		    'params'          => array(
		    	array(
		    		"type" => "dropdown",
		    		"heading" => esc_html__("Display Type", 'lugos'),
		    		"param_name" => "layout",
		    		"value" => array(
		    			'Hollow Button Tabs' => 'tabs-1 text-center',
		    			'Pill Layout' => 'tabs-4 text-center',
		    			'Text Tabs' => 'tabs-2 text-center',
		    			'Icon Tabs' => 'tabs-2 text-center lugos-icon-tabs'
		    		)
		    	),
		    )
		) 
	);
}
add_action( 'vc_before_init', 'thedux_tabs_shortcode_vc' );

// Nested Element
function thedux_tabs_content_shortcode_vc() {
	
	$icons = array('Install Themedeux Framework' => 'Install Themedeux Framework');
	
	if( function_exists('thedux_get_icons') ){
		$icons = thedux_get_icons();	
	}
	
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'            => esc_html__('Tabs Content', 'lugos'),
		    'base'            => 'lugos_tabs_content',
		    'description'     => esc_html__( 'Toggle Content Element', 'lugos' ),
		    "category" => esc_html__('Lugos Theme', 'lugos'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'lugos_tabs'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Title", 'lugos'),
		    		"param_name" => "title",
		    		'holder' => 'div'
		    	),
	            array(
	            	"type" => "textarea_html",
	            	"heading" => esc_html__("Block Content", 'lugos'),
	            	"param_name" => "content"
	            ),
	            array(
	            	"type" => "thedux_icons",
	            	"heading" => esc_html__("Click an Icon to choose (Icon tabs only)", 'lugos'),
	            	"param_name" => "icon",
	            	"value" => $icons,
	            	'description' => 'Type "none" or leave blank to hide icons.'
	            ),
		    ),
		) 
	);
	
}
add_action( 'vc_before_init', 'thedux_tabs_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_lugos_tabs extends WPBakeryShortCodesContainer {}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_lugos_tabs_content extends WPBakeryShortCode {}
}