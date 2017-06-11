<?php

/**
 * The Shortcode
 */
function thedux_accordion_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => ''
			), $atts 
		) 
	);
	
	$output = '<h2 class="mb--1">'.esc_attr($title).'</h2>'. do_shortcode($content);

	return $output;
}
add_shortcode( 'lugos_accordion', 'thedux_accordion_shortcode' );

/**
 * The Shortcode
 */
function thedux_accordion_content_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => ''
			), $atts 
		) 
	);
	
	$output = '
		<div class="lugos__accordion">
			<div class="accordion__heading">
				<span class="accordion__icon">
                     <i class="lugos-icon-arrow-right-1"></i>
                </span>
				<span class="accordion__title">'. htmlspecialchars_decode($title) .'</span>
			</div>
			<div class="accordion__content">
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
			</div>
		</div>
	';

	return $output;
}
add_shortcode( 'lugos_accordion_content', 'thedux_accordion_content_shortcode' );

// Parent Element
function thedux_accordion_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'                    => esc_html__( 'Accordion' , 'lugos' ),
		    'base'                    => 'lugos_accordion',
		    'description'             => esc_html__( 'Create Accordion Content', 'lugos' ),
		    'as_parent'               => array('only' => 'lugos_accordion_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Lugos Theme', 'lugos'),
		    'params'          => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'lugos'),
					"param_name" => "title",
					'holder' => 'div'
				),
		    )
		) 
	);
}
add_action( 'vc_before_init', 'thedux_accordion_shortcode_vc' );

// Nested Element
function thedux_accordion_content_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'            => esc_html__('Accordion Content', 'lugos'),
		    'base'            => 'lugos_accordion_content',
		    'description'     => esc_html__( 'Toggle Content Element', 'lugos' ),
		    "category" => esc_html__('Lugos Theme', 'lugos'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'lugos_accordion'), // Use only|except attributes to limit parent (separate multiple values with comma)
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
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'thedux_accordion_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_lugos_accordion extends WPBakeryShortCodesContainer {}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_lugos_accordion_content extends WPBakeryShortCode {}
}