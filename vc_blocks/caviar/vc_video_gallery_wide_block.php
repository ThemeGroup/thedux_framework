<?php

/**
 * The Shortcode
 */
function thedux_video_gallery_wide_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'text' => 'Show All'
			), $atts 
		) 
	);
	
	$output = '
		<section class="wide-grid masonry masonry-videos bg--dark">
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
		</section>
	';
	
	return $output;
}
add_shortcode( 'caviar_video_gallery_wide', 'thedux_video_gallery_wide_shortcode' );

/**
 * The Shortcode
 */
function thedux_video_gallery_wide_content_shortcode( $atts, $content = null ) {
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
		<div class="col-md-4 col-sm-6 col-xs-12 masonry__item" data-masonry-filter="'. $class .'">
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
add_shortcode( 'caviar_video_gallery_wide_content', 'thedux_video_gallery_wide_content_shortcode' );

// Parent Element
function thedux_video_gallery_wide_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
		    'name'                    => esc_html__( 'Video Gallery' , 'caviar' ),
		    'base'                    => 'caviar_video_gallery_wide',
		    'description'             => esc_html__( 'Create a filter gallery of lightbox images', 'caviar' ),
		    'as_parent'               => array('only' => 'caviar_video_gallery_wide_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('Caviar Theme', 'caviar'),
		    'params'          => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("'Show All' Text", 'caviar'),
		    		"param_name" => "class",
		    		'value' => 'Show All'
		    	),
		    )
		) 
	);
}
add_action( 'vc_before_init', 'thedux_video_gallery_wide_shortcode_vc' );

// Nested Element
function thedux_video_gallery_wide_content_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
		    'name'            => esc_html__('Video Gallery Content', 'caviar'),
		    'base'            => 'caviar_video_gallery_wide_content',
		    'description'     => esc_html__( 'Toggle Content Element', 'caviar' ),
		    "category" => esc_html__('Caviar Theme', 'caviar'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'caviar_video_gallery_wide'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Filter Category (Plain Text Only)", 'caviar'),
		    		"param_name" => "class",
		    		'holder' => 'div'
		    	),
	            array(
	            	"type" => "attach_image",
	            	"heading" => esc_html__("Block Image", 'caviar'),
	            	"param_name" => "image"
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Content Title", 'caviar'),
	            	"param_name" => "title",
	            	'holder' => 'div'
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Video Embed", 'caviar'),
	            	"param_name" => "embed",
	            	'description' => 'Enter link to video <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F">(Note: read more about available formats at WordPress codex page).</a>'
	            ),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'thedux_video_gallery_wide_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_caviar_video_gallery_wide extends WPBakeryShortCodesContainer {}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_caviar_video_gallery_wide_content extends WPBakeryShortCode {}
}