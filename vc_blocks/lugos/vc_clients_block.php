<?php

/**
 * The Shortcode
 */
function thedux_clients_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'layout' => 'about-us-grid'
			), $atts 
		) 
	);
	if($layout == 'about-us-grid'):
	$output = ' <div class="lugos-gallery masonry masonry--nogap grid--border">
					<div class="masonry__container">
						'. do_shortcode($content) .'
					</div><!--end masonry container-->
				</div>
	';
	endif;

	return $output;
}
add_shortcode( 'lugos_clients', 'thedux_clients_shortcode' );

/**
 * The Shortcode
 */
function thedux_clients_content_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'title' => 'Client Name',
				'link' => ''
			), $atts 
		) 
	);

	$output = '<div class="lugos-gallery__item col-md-3 masonry__item">';
	if($link) {
		$output .= '<a alt="'.$title.'" href="'.$link.'">'. wp_get_attachment_image( $image, 'large' ) .'</a>';
	}else {
		$output .=  wp_get_attachment_image( $image, 'large' );
	}
	$output .= '</div>';

	return $output;
}
add_shortcode( 'lugos_clients_content', 'thedux_clients_content_shortcode' );

// Parent Element
function thedux_clients_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'                    => esc_html__( 'Clients Gallery' , 'lugos' ),
		    'base'                    => 'lugos_clients',
		    'as_parent'               => array('only' => 'lugos_clients_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
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
						'About Us Grid' => 'about-us-grid'
					)
				),
		    )
		) 
	);
}
add_action( 'vc_before_init', 'thedux_clients_shortcode_vc' );

// Nested Element
function thedux_clients_content_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'            => esc_html__('Client Content', 'lugos'),
		    'base'            => 'lugos_clients_content',
		    'description'     => esc_html__( 'Toggle Content Element', 'lugos' ),
		    "category" => esc_html__('Lugos Theme', 'lugos'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'lugos_clients'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
	            array(
	            	"type" => "attach_image",
	            	"heading" => esc_html__("Client Image", 'lugos'),
	            	"param_name" => "image"
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Client Name", 'lugos'),
	            	"param_name" => "title",
					'value' => 'Client Name',
	            	'holder' => 'div'
	            ),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Client Link", 'lugos'),
					"param_name" => "link",
					'holder' => 'div'
				)
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'thedux_clients_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_lugos_clients extends WPBakeryShortCodesContainer {}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_lugos_clients_content extends WPBakeryShortCode {}
}