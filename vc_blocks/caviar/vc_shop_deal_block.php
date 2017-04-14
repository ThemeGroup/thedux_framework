<?php 

/**
 * The Shortcode
 */
function thedux_shop_deal_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => ''
			), $atts 
		) 
	);
	
	$output = '
		<div class="shortcode__shop-deal slider" data-arrows="true">
			<ul class="slides">
			'. do_shortcode($content) .'
			</ul>
		</div>
	';

	return $output;	
}
add_shortcode( 'caviar_shop_deal', 'thedux_shop_deal_shortcode' );

/**
 * The Shortcode
 */
function thedux_shop_deal_content_shortcode( $atts ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'title' => '',
				'subtitle' => '',
				'countdown_date' => '',
				'button_text' => '',
				'link' => '#',
			), $atts 
		) 
	);
	
	$output = '
		<li class="imageblock image--light">
			<div class="image-bg-wrap background--top">
				'. wp_get_attachment_image( $image, 'large' ) .'
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-5">
						<div class="shop-deal-desc">
							<h4 class="type--uppercase">'. htmlspecialchars_decode($subtitle) .'</h4>
							<h2>'. htmlspecialchars_decode($title) .'</h2>
							<div class="countdown" data-date="'.$countdown_date.'"></div>
							'. ( ($button_text != '') ? '<p>'.do_shortcode('[caviar_button button_text="'.$button_text.'" link="'.$link.'"]').'</p>' : '' ) .'
						</div>
					</div>
				</div>
				<!--end of row-->
			</div>
			<!--end of container-->
		</li>
	';
	
	return $output;
}
add_shortcode( 'caviar_shop_deal_content', 'thedux_shop_deal_content_shortcode' );

// Parent Element
function thedux_shop_deal_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
		    'name'                    => esc_html__( 'Shop Deal' , 'caviar' ),
		    'base'                    => 'caviar_shop_deal',
		    'as_parent'               => array('only' => 'caviar_shop_deal_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => false,
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
add_action( 'vc_before_init', 'thedux_shop_deal_shortcode_vc' );

// Nested Element
function thedux_shop_deal_content_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
		    'name'            => esc_html__('Shop Deal Content', 'caviar'),
		    'base'            => 'caviar_shop_deal_content',
		    "category" => esc_html__('Caviar Theme', 'caviar'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'caviar_shop_deal'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Block Image", 'caviar'),
					"param_name" => "image"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Subtitle", 'caviar'),
					"param_name" => "subtitle",
					"value" => ""
				),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Title", 'caviar'),
		    		"param_name" => "title",
		    		'holder' => 'div'
		    	),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Countdown date", 'caviar'),
					"description" => 'Enter the date in MM/DD/YYYY format.',
	            	"param_name" => "countdown_date",
	            ),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Button Text", 'caviar'),
					"param_name" => "button_text",
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("URL for button", 'caviar'),
					"param_name" => "link"
				),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'thedux_shop_deal_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_caviar_shop_deal extends WPBakeryShortCodesContainer {}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_caviar_shop_deal_content extends WPBakeryShortCode {}
}
