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
add_shortcode( 'caviar_accordion', 'thedux_accordion_shortcode' );

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
		<div class="caviar__accordion">
			<div class="accordion__heading">
				<span class="accordion__icon">
                     <i class="caviar-icon-arrow-right-1"></i>
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
add_shortcode( 'caviar_accordion_content', 'thedux_accordion_content_shortcode' );

// Parent Element
function thedux_accordion_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
		    'name'                    => esc_html__( 'Accordion' , 'caviar' ),
		    'base'                    => 'caviar_accordion',
		    'description'             => esc_html__( 'Create Accordion Content', 'caviar' ),
		    'as_parent'               => array('only' => 'caviar_accordion_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Caviar Theme', 'caviar'),
		    'params'          => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'caviar'),
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
			"icon" => 'caviar-vc-block',
		    'name'            => esc_html__('Accordion Content', 'caviar'),
		    'base'            => 'caviar_accordion_content',
		    'description'     => esc_html__( 'Toggle Content Element', 'caviar' ),
		    "category" => esc_html__('Caviar Theme', 'caviar'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'caviar_accordion'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Title", 'caviar'),
		    		"param_name" => "title",
		    		'holder' => 'div'
		    	),
	            array(
	            	"type" => "textarea_html",
	            	"heading" => esc_html__("Block Content", 'caviar'),
	            	"param_name" => "content"
	            ),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'thedux_accordion_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_caviar_accordion extends WPBakeryShortCodesContainer {}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_caviar_accordion_content extends WPBakeryShortCode {}
}