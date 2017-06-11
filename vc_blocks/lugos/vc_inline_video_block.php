<?php 

/**
 * The Shortcode
 */
function thedux_video_inline_shortcode( $atts ) {
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
			<div class="video-cover">
				<div class="image-bg-wrap background-image-holder">
					'. wp_get_attachment_image( $image, 'full' ) .'
				</div>
				<div class="video-play-icon"></div>
				<video controls>
					<source src="'. esc_url($webm) .'" type="video/webm">
					<source src="'. esc_url($mpfour) .'" type="video/mp4">
					<source src="'. esc_url($ogv) .'" type="video/ogg">	
				</video>
			</div>
		';
		
	} elseif( 'embed' == $layout ){
		
		$output = '
			<div class="video-cover">
				<div class="image-bg-wrap background-image-holder">
					'. wp_get_attachment_image( $image, 'full' ) .'
				</div>
				<div class="video-play-icon "></div>
				'. wp_oembed_get($embed, array('height' => '300')) .'
			</div>
		';
		
	}
	
	return $output;
}
add_shortcode( 'lugos_video_inline', 'thedux_video_inline_shortcode' );

/**
 * The VC Functions
 */
function thedux_video_inline_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
			"name" => esc_html__("Video Inline Embeds", 'lugos'),
			"base" => "lugos_video_inline",
			"category" => esc_html__('Lugos Theme', 'lugos'),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Video Display Type", 'lugos'),
					"param_name" => "layout",
					"value" => array(
						'Local Video' => 'local',
						'Embedded Video (Youtube etc.)' => 'embed'
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
					"heading" => esc_html__("Video Embed", 'lugos'),
					"param_name" => "embed",
					'description' => 'Enter link to video <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F">(Note: read more about available formats at WordPress codex page).</a>'
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'thedux_video_inline_shortcode_vc' );