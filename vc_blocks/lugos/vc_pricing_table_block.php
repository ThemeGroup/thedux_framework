<?php 

/**
 * The Shortcode
 */
function thedux_pricing_table_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'icon' => '',
				'price' => '',
				'currency' => '',
				'button_url' => '',
				'button_text' => '',
				'layout' => 'standard',
				'image' => ''
			), $atts 
		) 
	);
	
	if( 'standard' == $layout ){
		
		$output = '
			<div class="pricing pricing-1 text-center">
				<h6>'. htmlspecialchars_decode($title) .'</h6>
				<div class="pricing__price">
					<span class="pricing__dollar h5">'. htmlspecialchars_decode($currency) .'</span>
					<span class="h1">'. htmlspecialchars_decode($price) .'</span>
				</div>
				<hr>
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
				<a class="btn btn--primary" href="'. esc_url($button_url) .'">
					<span class="btn__text">
						'. htmlspecialchars_decode($button_text) .'
					</span>
				</a>
			</div><!--end pricing-->
		';
	
	} elseif( 'blank' == $layout ){
		
		$output = '
			<div class="pricing pricing-2 text-center">
				<h6>'. htmlspecialchars_decode($title) .'</h6>
				<div class="pricing__price">
					<span class="pricing__dollar h5">'. htmlspecialchars_decode($currency) .'</span>
					<span class="h1">'. htmlspecialchars_decode($price) .'</span>
				</div>
				<hr>
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
				<a class="btn btn--primary" href="'. esc_url($button_url) .'">
					<span class="btn__text">
						'. htmlspecialchars_decode($button_text) .'
					</span>
				</a>
			</div><!--end pricing-->
		';
			
	} elseif( 'emphasise' == $layout ){
		
		$output = '
			<div class="pricing pricing-2 pricing--emphasise text-center">
				<h6>'. htmlspecialchars_decode($title) .'</h6>
				<div class="pricing__price">
					<span class="pricing__dollar h5">'. htmlspecialchars_decode($currency) .'</span>
					<span class="h1">'. htmlspecialchars_decode($price) .'</span>
				</div>
				<hr>
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
				<a class="btn btn--primary" href="'. esc_url($button_url) .'">
					<span class="btn__text">
						'. htmlspecialchars_decode($button_text) .'
					</span>
				</a>
			</div><!--end pricing-->
		';
			
	} elseif( 'image' == $layout ){
		
		$output = '
			<div class="pricing pricing-3 text-center">
				'. wp_get_attachment_image( $image, 'full' ) .'
				<div class="pricing__body">
					<a class="btn btn--primary" href="'. esc_url($button_url) .'">
						<span class="btn__text">
							'. htmlspecialchars_decode($button_text) .'
						</span>
					</a>
					<h5>'. htmlspecialchars_decode($title) .'</h5>
					<div class="pricing__price">
						<span class="pricing__dollar h5">'. htmlspecialchars_decode($currency) .'</span>
						<span class="h1">'. htmlspecialchars_decode($price) .'</span>
					</div>
					<hr>
					'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
				</div>
			</div><!--end pricing-->
		';
			
	} elseif( 'icon' == $layout ){
		
		$output = '
			<div class="pricing pricing-1 text-center">
				<i class="icon--lugos icon--lg '. esc_attr($icon) .'"></i>
				<h6>'. htmlspecialchars_decode($title) .'</h6>
				<div class="pricing__price">
					<span class="pricing__dollar h5">'. htmlspecialchars_decode($currency) .'</span>
					<span class="h1">'. htmlspecialchars_decode($price) .'</span>
				</div>
				<hr>
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
				<a class="btn btn--primary" href="'. esc_url($button_url) .'">
					<span class="btn__text">
						'. htmlspecialchars_decode($button_text) .'
					</span>
				</a>
			</div><!--end pricing-->
		';
			
	} elseif( 'minimal' == $layout ){
		
		$output = '
			<div class="pricing pricing-4">
				<div class="pricing__price">
					<span class="pricing__dollar h5">'. htmlspecialchars_decode($currency) .'</span>
					<span class="h1">'. htmlspecialchars_decode($price) .'</span>
				</div>
				<h6>'. htmlspecialchars_decode($title) .'</h6>
				<hr>
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
				<a class="btn" href="'. esc_url($button_url) .'">
					<span class="btn__text">
						'. htmlspecialchars_decode($button_text) .'
					</span>
				</a>
			</div><!--end pricing-->
		';
			
	}
		
	return $output;
}
add_shortcode( 'lugos_pricing_table', 'thedux_pricing_table_shortcode' );

/**
 * The VC Functions
 */
function thedux_pricing_table_shortcode_vc() {
	
	$icons = array('Install Themedeux Framework' => 'Install Themedeux Framework');
	
	if( function_exists('thedux_get_icons') ){
		$icons = thedux_get_icons();	
	}
	
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
			"name" => esc_html__("Pricing Table", 'lugos'),
			"base" => "lugos_pricing_table",
			"category" => esc_html__('Lugos Theme', 'lugos'),
			"params" => array(
				array(
					"type" => "thedux_icons",
					"heading" => esc_html__("Click an Icon to choose", 'lugos'),
					"param_name" => "icon",
					"value" => $icons,
					'description' => 'Type "none" or leave blank to hide icons.'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'lugos'),
					"param_name" => "title",
					'holder' => 'div',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Currency", 'lugos'),
					"param_name" => "currency"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Price", 'lugos'),
					"param_name" => "price"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button Text", 'lugos'),
					"param_name" => "button_text"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button URL", 'lugos'),
					"param_name" => "button_url"
				),
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Block Content", 'lugos'),
					"param_name" => "content",
					'holder' => 'div'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Pricing Table Display Type", 'lugos'),
					"param_name" => "layout",
					"value" => array(
						'Standard' => 'standard',
						'Blank Background' => 'blank',
						'Emphasise' => 'emphasise',
						'Image' => 'image',
						'Icon' => 'icon',
						'Minimal' => 'minimal'
					)
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Block Image", 'lugos'),
					"param_name" => "image"
				),
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'thedux_pricing_table_shortcode_vc' );