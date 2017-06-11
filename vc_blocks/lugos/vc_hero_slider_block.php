<?php

/**
 * The Shortcode
 */
function thedux_slider_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'type' => 'standard',
				'parallax' => 'parallax',
				'slider_height' => 'v__height-100',
				'arrows' => 'true',
				'paging' => 'true',
				'timing' => 5000
			), $atts 
		) 
	);
	
	$output = '
		<section class="slider slider--animate '. $slider_height .' cover cover-5" data-animation="fade" data-arrows="'. $arrows .'" data-paging="'. $paging .'" data-timing="'. $timing .'">
			<ul class="slides">
				'. do_shortcode($content) .'
			</ul>
		</section>
	';
	
	return $output;
}
add_shortcode( 'lugos_slider', 'thedux_slider_shortcode' );

/**
 * The Shortcode
 */
function thedux_slider_content_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'overlay_opacity' => '4'
			), $atts 
		) 
	);
	
	$output = '
		<li class="" data-overlay="'. $overlay_opacity .'">
			<div class="image-bg-wrap">
				'. wp_get_attachment_image( $image, 'full' ) .'
			</div>
			<div class="container slider-content vh-po-vertical-center">
				<div class="row">
					<div class="col-sm-12">
						'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
					</div>
				</div>
			</div>
		</li>
	';
	
	return $output;
}
add_shortcode( 'lugos_slider_content', 'thedux_slider_content_shortcode' );

// Parent Element
function thedux_slider_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'                    => esc_html__( 'Hero Slider' , 'lugos' ),
		    'base'                    => 'lugos_slider',
		    'description'             => esc_html__( 'Adds an Image Slider', 'lugos' ),
		    'as_parent'               => array('only' => 'lugos_slider_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Lugos Theme', 'lugos'),
		    'params'          => array(
				array(
		    		"type" => "dropdown",
		    		"heading" => __("Sider Height", 'lugos'),
		    		"param_name" => "slider_height",
		    		"value" => array(
		    			'100vh' => 'v__height-100',
		    			'90vh' => 'v__height-90',
		    			'80vh' => 'v__height-80',
		    			'70vh' => 'v__height-70',
		    			'60vh' => 'v__height-60',
		    			'50vh' => 'v__height-50',
		    		)
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Autoplay Timer (ms)", 'lugos'),
		    		"param_name" => "timing",
		    		'value' => '5000'
		    	),
		    	array(
		    		"type" => "dropdown",
		    		"heading" => __("Show Arrows", 'lugos'),
		    		"param_name" => "arrows",
		    		"value" => array(
		    			'Yes' => 'true',
		    			'No' => 'false' 
		    		)
		    	),
		    	array(
		    		"type" => "dropdown",
		    		"heading" => __("Show Paging", 'lugos'),
		    		"param_name" => "paging",
		    		"value" => array(
		    			'Yes' => 'true',
		    			'No' => 'false' 
		    		)
		    	),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'thedux_slider_shortcode_vc' );

// Nested Element
function thedux_slider_content_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'            => esc_html__('Hero Slider Slide', 'lugos'),
		    'base'            => 'lugos_slider_content',
		    'description'     => esc_html__( 'A slide for the image slider.', 'lugos' ),
		    "category" => esc_html__('Lugos Theme', 'lugos'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'lugos_slider'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
	            array(
	            	"type" => "attach_image",
	            	"heading" => esc_html__("Slide Background Image", 'lugos'),
	            	"param_name" => "image"
	            ),
	            array(
		    		"type" => "dropdown",
		    		"heading" => __("Slide Background Image Overlay Opacity (Default 40%)", 'lugos'),
		    		"param_name" => "overlay_opacity",
		    		"value" => array(
		    			'40%' => '4',
		    			'90%' => '9',
		    			'80%' => '8',
		    			'70%' => '7',
		    			'60%' => '6',
		    			'50%' => '5',
		    			'30%' => '3',
		    			'20%' => '2',
		    			'10%' => '1',
		    			'0%' => '0',
		    		)
		    	),
	            array(
	            	"type" => "textarea_html",
	            	"heading" => esc_html__("Slide Content", 'lugos'),
	            	"param_name" => "content",
	            	'holder' => 'div'
	            ),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'thedux_slider_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_lugos_slider extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_lugos_slider_content extends WPBakeryShortCode {

    }
}