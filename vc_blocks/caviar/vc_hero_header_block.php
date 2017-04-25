<?php 

/**
 * The Shortcode
 */
function thedux_hero_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'image' => '',
				'layout' => 'intro-left',
				'mpfour' => '',
				'ogv' => '',
				'webm' => '',
				'button_text' => '',
				'button_url' => '',
				'shortcode' => 'None',
				'parallax' => 'parallax',
				'slider_height' => 'v__height-100',
				'overlay_opacity' => '4'
			), $atts 
		) 
	);
	
	if( 'intro-left' == $layout ) {
		
		$output = '
			<section class="'. $slider_height .' imagebg '. $parallax .'" data-overlay="'. $overlay_opacity .'">
				<div class="image-bg-wrap background-image-holder">
					'. wp_get_attachment_image( $image, 'full' ) .'
				</div>
				<div class="container vh-po-vertical-center">
					<div class="row">
						<div class="col-md-7 col-sm-8">
							'. do_shortcode(htmlspecialchars_decode($content)) .'
						</div>
					</div><!--end of row-->
				</div><!--end of container-->
			</section>
		';
		
	} elseif( 'intro-social' == $layout ){
		
		$output = '
			<section class="'. $slider_height .' imagebg cover cover-1 parallax" data-overlay="'. $overlay_opacity .'">
				<div class="image-bg-wrap background-image-holder">
					'. wp_get_attachment_image( $image, 'full' ) .'
				</div>
				<div class="container vh-po-vertical-center">
					'. do_shortcode(htmlspecialchars_decode($content)) .'
				</div>
				<div class="col-sm-12 vh-po-absolute vh-po-bottom">
					<div class="row">
						<div class="col-sm-12 text-center">
							'. thedux_header_social_items() .'
						</div>
					</div>
				</div>
			</section>
		';
		
	} elseif( 'video-social' == $layout ){
		
		$output = '
			<section class="'. $slider_height .' cover cover-13 videobg imagebg" data-overlay="'. $overlay_opacity .'">
				<video autoplay loop muted>
					<source src="'. esc_url($webm) .'" type="video/webm">
					<source src="'. esc_url($mpfour) .'" type="video/mp4">
					<source src="'. esc_url($ogv) .'" type="video/ogg">	
				</video>	
				<div class="image-bg-wrap background-image-holder">
					'. wp_get_attachment_image( $image, 'full' ) .'
				</div>
				<div class="container vh-po-vertical-center">
					<div class="row">
						<div class="col-sm-12 col-md-10 col-md-offset-1 text-center">
							'. do_shortcode(htmlspecialchars_decode($content)) .'
						</div>
					</div><!--end of row-->
					<div class="row">
						<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
							';
							
				if( !( 'None' == $shortcode ) ){
					$output .= do_shortcode('[contact-form-7 id="'. $shortcode .'"]');
				}
				
				$output .= '
						</div>
					</div><!--end of row-->
				</div><!--end of container-->
				<div class="col-sm-12 text-center vh-po-absolute vh-po-bottom">
					'. thedux_header_social_items() .'
			    </div>
			</section>
		';	
		
	} elseif( 'video-popup' == $layout ){
		
		$output = '
			<section class="cover cover-11 '. $slider_height .' imagebg '. $parallax .'" data-overlay="'. $overlay_opacity .'">
				<div class="image-bg-wrap background-image-holder background--bottom">
					'. wp_get_attachment_image( $image, 'full' ) .'
				</div>
				<div class="container vh-po-vertical-center">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							'. do_shortcode(htmlspecialchars_decode($content)) .'
						</div>
					</div><!--end row-->
				</div><!--end container-->
			</section>
		';
			
	} elseif( 'split' == $layout ){
	
		$output = '
			<section class="'. $slider_height .' cover cover-2">
				<div class="col-md-6 col-sm-5">
					<div class="image-bg-wrap background-image-holder">
						'. wp_get_attachment_image( $image, 'full' ) .'
					</div>
				</div>
				<div class="col-md-6 col-sm-7 bg--white text-center">
					<div class="vh-po-vertical-center">
						'. do_shortcode(htmlspecialchars_decode($content)) .'
					</div>
					<div class="col-sm-12 text-center vh-po-absolute vh-po-bottom">
						'. thedux_header_social_items() .'
				    </div>
				</div>
			</section>
		';
	
	} elseif( 'video-form' == $layout ){
	
		$output = '
			<section class="'. $slider_height .' imagebg cover cover-6 parallax" data-overlay="'. $overlay_opacity .'">
				<div class="image-bg-wrap background-image-holder">
					'. wp_get_attachment_image( $image, 'full' ) .'
				</div>
				<div class="container vh-po-vertical-center">
					<div class="row">
						<div class="col-sm-12">
							'. do_shortcode(htmlspecialchars_decode($content)) .'
						</div>
					</div>
				</div>
				<div class="container vh-po-bottom vh-po-absolute">
					<div class="row">';
					
		if( !( 'None' == $shortcode ) ){
			$output .= do_shortcode('[contact-form-7 id="'. $shortcode .'"]');
		}

		$output .= '
					</div>
				</div>
			</section>
		';
		
	} elseif( 'video-half' == $layout ){
	
		$output = '
			<section class="imagebg videobg '. $slider_height .' cover cover-7" data-overlay="'. $overlay_opacity .'">
				<video autoplay loop muted>
					<source src="'. esc_url($webm) .'" type="video/webm">
					<source src="'. esc_url($mpfour) .'" type="video/mp4">
					<source src="'. esc_url($ogv) .'" type="video/ogg">	
				</video>
				<div class="image-bg-wrap background-image-holder">
					'. wp_get_attachment_image( $image, 'full' ) .'
				</div>
				<div class="container vh-po-vertical-center">
					'. do_shortcode(htmlspecialchars_decode($content)) .'
				</div>
			</section>
		';
		
	} elseif( 'overlay' == $layout ){
	
		$output = '
			<section class="'. $slider_height .' imagebg bg--primary" data-overlay="'. $overlay_opacity .'">
				<div class="image-bg-wrap background-image-holder">
					'. wp_get_attachment_image( $image, 'full' ) .'
				</div>
				<div class="container vh-po-vertical-center">
					<div class="row">
						<div class="col-sm-12">
							'. do_shortcode(htmlspecialchars_decode($content)) .'
						</div>
					</div><!--end of row-->
				</div><!--end of container-->
			</section>
		';
		
	} elseif( 'half-form' == $layout ){
	
		$output = '
			<section class="cover cover-12 form--dark imagebg '. $slider_height .' parallax" data-overlay="'. $overlay_opacity .'">
				<div class="image-bg-wrap background-image-holder">
					'. wp_get_attachment_image( $image, 'full' ) .'
				</div>
				<div class="container vh-po-vertical-center text-center-xs">
					<div class="row vh-po-vertical-align-columns">
						<div class="col-md-7 col-sm-8 col-sm-offset-2">
							'. do_shortcode(htmlspecialchars_decode($content)) .'
						</div>
						<div class="col-md-5 col-sm-8 col-sm-offset-2">
		';
		
		if( !( 'None' == $shortcode ) ){
			$output .= '
				<div class="form-subscribe-1 boxed boxed--lg bg--white text-center box-shadow-wide">
					'. do_shortcode('[contact-form-7 id="'. $shortcode .'"]') .'
				</div>
			';
		}
		
		$output .= '					
						</div>
					</div><!--end row-->
				</div><!--end container-->
			</section>
		';
		
	} elseif( 'bottom-left' == $layout ){
	
		$output = '
			<section class="'. $slider_height .' imagebg cover cover-3 '. $parallax .'" data-overlay="'. $overlay_opacity .'">
				<div class="image-bg-wrap background-image-holder">
					'. wp_get_attachment_image( $image, 'full' ) .'
				</div>
				<div class="container vh-po-absolute vh-po-bottom text-center-xs">
					<div class="row">
						<div class="col-sm-6">
							'. do_shortcode(htmlspecialchars_decode($content)) .'
						</div>
					</div>
				</div>
			</section>
		';
	
	}

	return $output;
}
add_shortcode( 'caviar_hero', 'thedux_hero_shortcode' );

/**
 * The VC Functions
 */
function thedux_hero_shortcode_vc() {
	
	$icons = array('Install Themedeux Framework' => 'Install Themedeux Framework');
	
	if( function_exists('thedux_get_icons') ){
		$icons = thedux_get_icons();	
	}
	
	$args = array(
		'post_type' => 'wpcf7_contact_form',
		'posts_per_page' => -1
	);
	$form_options = get_posts( $args );
	$forms[0] = 'None';
	
	foreach( $form_options as $form_option ){
		$forms[$form_option->post_title] = $form_option->ID;
	}
	
	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
			"name" => esc_html__("Hero Header", 'caviar'),
			"base" => "caviar_hero",
			"category" => esc_html__('Caviar Theme', 'caviar'),
			'as_parent'               => array('except' => 'caviar_tabs_content'),
			'content_element'         => true,
			'show_settings_on_create' => true,
			"js_view" => 'VcColumnView',
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Hero Header Display Type", 'caviar'),
					"param_name" => "layout",
					"value" => array(
						'Fullscreen Left Align Text' => 'intro-left',
						'Fullscreen Video Background, Text, Form & Social Icons' => 'video-social',
						'Half Height Video Background, Text' => 'video-half',
						'Fullscreen Split, Image Left, Text Right & Social Icons' => 'split',
						'Video Popup, Designed for the Modal Video Element' => 'video-popup',
						'Video Popup, Designed for the Modal Video Element, Form at Bottom' => 'video-form',
						'Primary Color Overlay' => 'overlay',
						'Fullscreen Center Text, Social Icons Botom' => 'intro-social',
						'Content Left, Form Right' => 'half-form',
						'Content Bottom Left' => 'bottom-left'
					)
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Slide Image", 'caviar'),
					"param_name" => "image"
				),
				array(
					"type" => "dropdown",
					"heading" => __("Hero Height", 'caviar'),
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
					"type" => "dropdown",
					"heading" => __("Background Image Overlay Opacity (Default 40%)", 'caviar'),
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
					"type" => "textfield",
					"heading" => esc_html__("Button Text", 'caviar'),
					"param_name" => "button_text"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button URL", 'caviar'),
					"param_name" => "button_url"
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Contact Form 7 Form", 'caviar'),
					"param_name" => "shortcode",
					"description" => esc_html__('Choose a contact form 7 form if required.', 'caviar'),
					'value' => $forms
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Use Parallax Scrolling on this element?", 'caviar'),
					"param_name" => "parallax",
					"value" => array(
						'Parallax On' => 'parallax',
						'Parallax Off' => 'parallax-off'
					),
					'description' => 'Parallax scrolling works best when this element is at the top of a page, if it isn\'t, turn this off so the element displays at its best.'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Self Hosted Video Background .webm extension", 'caviar'),
					"param_name" => "webm",
					"description" => esc_html__('Please fill all extensions if using a video based header', 'caviar')
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Self Hosted Video Background .mp4 extension", 'caviar'),
					"param_name" => "mpfour",
					"description" => esc_html__('Please fill all extensions if using a video based header', 'caviar')
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Self Hosted Video Background .ogv extension", 'caviar'),
					"param_name" => "ogv",
					"description" => esc_html__('Please fill all extensions if using a video based header', 'caviar')
				),
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'thedux_hero_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_caviar_hero extends WPBakeryShortCodesContainer {}
}