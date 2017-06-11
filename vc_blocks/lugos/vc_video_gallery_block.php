<?php

/**
 * The Shortcode
 */
function thedux_video_gallery_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'text' => 'Show All'
			), $atts 
		) 
	);
	
	$output = '
		<div class="masonry-contained">
			<div class="masonry">
				<div class="masonry-filter-container text-center">
					<div class="masonry-filter-holder">
						<div class="masonry__filters masonry__filters--outside text-center" data-filter-all-text="'. $text .'"></div>
					</div>
				</div>
				<div class="row">
					<div class="masonry__container masonry--animate">
						'. do_shortcode($content) .'
					</div><!--end masonry container-->
				</div><!--end of row-->
			</div>
		</div><!--end of container-->
	';
	
	return $output;
}
add_shortcode( 'lugos_video_gallery', 'thedux_video_gallery_shortcode' );

/**
 * The Shortcode
 */
function thedux_video_gallery_content_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'class' => '',
				'image' => '',
				'title' => '',
				'embed' => ''
			), $atts 
		) 
	);
	
	$src = wp_get_attachment_image_src( $image, 'full' );
	
	$output = '
		<div class="col-sm-6 col-xs-12 masonry__item" data-masonry-filter="'. $class .'">
			<div class="portfolio-item portfolio-item-2 video-cover" data-scrim-bottom="9">
				<div class="image-bg-wrap background-image-holder">
					'. wp_get_attachment_image( $image, 'large' ) .'
				</div>
				<div class="portfolio-item__title">
					<h5>'. $title .'</h5>
				</div>
				<div class="video-play-icon video-play-icon--sm"></div>
				'. wp_oembed_get($embed, array('height' => '400')) .'
			</div>
		</div><!--end item-->
	';

	return $output;
}
add_shortcode( 'lugos_video_gallery_content', 'thedux_video_gallery_content_shortcode' );

// Parent Element
function thedux_video_gallery_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'                    => esc_html__( 'Video Gallery' , 'lugos' ),
		    'base'                    => 'lugos_video_gallery',
		    'description'             => esc_html__( 'Create a filter gallery of lightbox images', 'lugos' ),
		    'as_parent'               => array('only' => 'lugos_video_gallery_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
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
add_action( 'vc_before_init', 'thedux_video_gallery_shortcode_vc' );

// Nested Element
function thedux_video_gallery_content_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'            => esc_html__('Video Gallery Content', 'lugos'),
		    'base'            => 'lugos_video_gallery_content',
		    'description'     => esc_html__( 'Toggle Content Element', 'lugos' ),
		    "category" => esc_html__('Lugos Theme', 'lugos'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'lugos_video_gallery'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Filter Category (Plain Text Only)", 'lugos'),
		    		"param_name" => "class",
		    		'holder' => 'div'
		    	),
	            array(
	            	"type" => "attach_image",
	            	"heading" => esc_html__("Block Image", 'lugos'),
	            	"param_name" => "image"
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Content Title", 'lugos'),
	            	"param_name" => "title",
	            	'holder' => 'div'
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Video Embed", 'lugos'),
	            	"param_name" => "embed",
	            	'description' => 'Enter link to video <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F">(Note: read more about available formats at WordPress codex page).</a>'
	            ),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'thedux_video_gallery_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_lugos_video_gallery extends WPBakeryShortCodesContainer {}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_lugos_video_gallery_content extends WPBakeryShortCode {}
}