<?php 

/**
 * The Shortcode
 */
function thedux_video_background_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'layout' => 'local',
				'image' => '',
				'video' => '',
				'mpfour' => '',
				'ogv' => '',
				'webm' => '',
				'embed' => ''
			), $atts 
		) 
	);
	
	if( 'local' == $layout ){
		
		$output = '
			<section class="imagebg videobg height-100" data-overlay="4">
				<video autoplay loop muted>
					<source src="'. esc_url($webm) .'" type="video/webm">
					<source src="'. esc_url($mpfour) .'" type="video/mp4">
					<source src="'. esc_url($ogv) .'" type="video/ogg">	
				</video>
				<div class="image-bg-wrap background-image-holder">
					'. wp_get_attachment_image( $image, 'full' ) .'
				</div>
				<div class="container pos-vertical-center">
					<div class="row">
						'. do_shortcode(htmlspecialchars_decode($content)) .'
					</div>
				</div>
			</section>
		';
		
	} elseif( 'embed' == $layout ){
		
		$output = '
			<section class="imagebg videobg height-100" data-overlay="4">
				<div class="youtube-background" data-video-url="'. esc_attr($embed) .'" data-start-at="0"></div>
				<div class="image-bg-wrap background-image-holder">
					'. wp_get_attachment_image( $image, 'full' ) .'
				</div>
				<div class="container pos-vertical-center">
					<div class="row">
						'. do_shortcode(htmlspecialchars_decode($content)) .'
					</div>
				</div>
			</section>
		';
		
	}
	
	return $output;
}
add_shortcode( 'lugos_video_background', 'thedux_video_background_shortcode' );

/**
 * The VC Functions
 */
function thedux_video_background_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
			"name" => esc_html__("Video Background", 'lugos'),
			"base" => "lugos_video_background",
			"category" => esc_html__('Lugos Theme', 'lugos'),
			'as_parent'               => array('except' => 'lugos_tabs_content'),
			'content_element'         => true,
			'show_settings_on_create' => true,
			"js_view" => 'VcColumnView',
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Video Display Type", 'lugos'),
					"param_name" => "layout",
					"value" => array(
						'Local Video' => 'local',
						'Embedded Video (Youtube)' => 'embed'
					)
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Video Placeholder Image", 'lugos'),
					"param_name" => "image"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Self Hosted Video .webm extension", 'lugos'),
					"param_name" => "webm",
					"description" => esc_html__('Please fill all extensions', 'lugos')
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Self Hosted Video .mp4 extension", 'lugos'),
					"param_name" => "mpfour",
					"description" => esc_html__('Please fill all extensions', 'lugos')
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Self Hosted Video .ogv extension", 'lugos'),
					"param_name" => "ogv",
					"description" => esc_html__('Please fill all extensions', 'lugos')
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Youtube Embed", 'lugos'),
					"param_name" => "embed",
					'description' => 'Enter ID of YouTube video, e.g: 9d8wWcJLnFI'
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'thedux_video_background_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_lugos_video_background extends WPBakeryShortCodesContainer {}
}