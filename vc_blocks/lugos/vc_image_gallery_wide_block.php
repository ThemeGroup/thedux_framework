<?php

/**
 * The Shortcode
 */
function thedux_image_gallery_wide_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'class' => 'Show All'
			), $atts 
		) 
	);
	
	$output = '
		<div class="wide-grid masonry masonry-videos">
			<div class="masonry-filter-container text-center">
				<div class="masonry-filter-holder">
					<div class="masonry__filters masonry__filters--outside text-center" data-filter-all-text="'. $class .'"></div>
				</div>
			</div>
			<div class="row">
				<div class="masonry__container masonry--animate">
					'. do_shortcode($content) .'
				</div><!--end masonry container-->
			</div><!--end of row-->
		</div>
	';
	
	return $output;
}
add_shortcode( 'lugos_image_gallery_wide', 'thedux_image_gallery_wide_shortcode' );

/**
 * The Shortcode
 */
function thedux_image_gallery_wide_content_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'class' => '',
				'image' => ''
			), $atts 
		) 
	);
	
	$src = wp_get_attachment_image_src( $image, 'full' );
	$caption = get_post($image)->post_excerpt;
	
	$output = '
		<div class="col-md-4 col-sm-6 col-xs-12 masonry__item" data-masonry-filter="'. $class .'">
			<a data-lightbox="gallery" href="'. $src[0] .'" data-title="'. $caption .'">
				'. wp_get_attachment_image( $image, 'large' ) .'
			</a>
		</div><!--end item-->
	';

	return $output;
}
add_shortcode( 'lugos_image_gallery_wide_content', 'thedux_image_gallery_wide_content_shortcode' );

// Parent Element
function thedux_image_gallery_wide_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'                    => esc_html__( 'Lightbox Gallery Wide' , 'lugos' ),
		    'base'                    => 'lugos_image_gallery_wide',
		    'description'             => esc_html__( 'Create a filter gallery of lightbox images', 'lugos' ),
		    'as_parent'               => array('only' => 'lugos_image_gallery_wide_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Lugos Theme', 'lugos'),
		    'params'          => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("'Show All' Text", 'lugos'),
		    		"param_name" => "class",
		    		'value' => 'Show All'
		    	),
		    )
		) 
	);
}
add_action( 'vc_before_init', 'thedux_image_gallery_wide_shortcode_vc' );

// Nested Element
function thedux_image_gallery_wide_content_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'            => esc_html__('Lightbox Gallery Content', 'lugos'),
		    'base'            => 'lugos_image_gallery_wide_content',
		    'description'     => esc_html__( 'Lightbox Gallery Content Element', 'lugos' ),
		    "category" => esc_html__('Lugos Theme', 'lugos'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'lugos_image_gallery_wide'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Filter Category (Plain Text Only)", 'lugos'),
		    		"param_name" => "class",
		    		'holder' => 'div',
		    		'description' => 'Multiple categories: Separate with comma only, no spaces. Spaces are fine in the category name. e.g: <code>Category 1,Category 2</code>'
		    	),
	            array(
	            	"type" => "attach_image",
	            	"heading" => esc_html__("Block Image", 'lugos'),
	            	"param_name" => "image"
	            ),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'thedux_image_gallery_wide_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_lugos_image_gallery_wide extends WPBakeryShortCodesContainer {}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_lugos_image_gallery_wide_content extends WPBakeryShortCode {}
}