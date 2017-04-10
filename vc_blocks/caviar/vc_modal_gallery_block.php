<?php

/**
 * The Shortcode
 */
function thedux_modal_gallery_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'text' => 'Show All'
			), $atts 
		) 
	);
	
	$output = '
		<div class="masonry-contained">
			<div class="row">
				<div class="masonry">
					<div class="masonry__filters" data-filter-all-text="'. $text .'"></div>
					<div class="masonry__container masonry--animate">
						'. do_shortcode($content) .'
					</div><!--end masonry container-->
				</div>
			</div><!--end of row-->
		</div><!--end of container-->
	';
	
	return $output;
}
add_shortcode( 'caviar_modal_gallery', 'thedux_modal_gallery_shortcode' );

/**
 * The Shortcode
 */
function thedux_modal_gallery_content_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'class' => '',
				'image' => '',
				'embed' => '',
				'title' => '',
				'images' => '',
				'hover_title' => ''
			), $atts 
		) 
	);
	
	$images = explode(',', $images);
	
	$output = '
		<div class="col-sm-6 col-xs-12 masonry__item" data-masonry-filter="'. $class .'">
			<div class="hover-element hover-element-1" data-title-position="center,center">
				<h5>'. $hover_title .'</h5>
				<div class="hover-element__initial">
					'. wp_get_attachment_image( $image, 'large' ) .'
				</div>
				<div class="hover-element__reveal" data-overlay="9">
					<div class="modal-instance">
						<div class="btn-round modal-trigger">
							<i class="icon-File-HorizontalText caviar--icon color--primary"></i>
						</div>
						<div class="modal-container">
							<div class="modal-content height--natural">
								<div class="card card-1">
									<div class="card__image">
										<div class="slider" data-paging="true">
											<ul class="slides">
	';
	
	if( is_array($images) ){
		foreach ($images as $id){
			$output .= '
				<li>
					'. wp_get_attachment_image($id, 'large') .'
				</li>
			';
		}
	}
												
	$output .= '
											</ul>
										</div>
									</div>
									<div class="card__body boxed bg--white">
										<div class="card__title">
											<h5>'. $title .'</h5>
										</div>
										'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
									</div>
								</div>
							</div><!--end of modal-content-->
						</div><!--end of modal-container-->
					</div><!--end of modal instance-->
	';
	
	if( $embed ){
		$output .= '
					<div class="modal-instance">
						<div class="btn-round modal-trigger">
							<i class="icon-Video-5 caviar--icon color--primary"></i>
						</div>
						<div class="modal-container">
							<div class="modal-content bg--dark" data-width="70%" data-height="50%">
								'. wp_oembed_get($embed, array('height' => '500')) .'
							</div><!--end of modal-content-->
						</div><!--end of modal-container-->
					</div><!--end of modal instance-->
		';
	}
	
	$output .= '
				</div>
			</div><!--end hover element-->
		</div><!--end item-->
	';

	return $output;
}
add_shortcode( 'caviar_modal_gallery_content', 'thedux_modal_gallery_content_shortcode' );

// Parent Element
function thedux_modal_gallery_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
		    'name'                    => esc_html__( 'Modal Gallery' , 'caviar' ),
		    'base'                    => 'caviar_modal_gallery',
		    'description'             => esc_html__( 'Create a filter gallery of modal content', 'caviar' ),
		    'as_parent'               => array('only' => 'caviar_modal_gallery_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
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
add_action( 'vc_before_init', 'thedux_modal_gallery_shortcode_vc' );

// Nested Element
function thedux_modal_gallery_content_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
		    'name'            => esc_html__('Modal Gallery Content', 'caviar'),
		    'base'            => 'caviar_modal_gallery_content',
		    'description'     => esc_html__( 'Toggle Content Element', 'caviar' ),
		    "category" => esc_html__('Caviar Theme', 'caviar'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'caviar_modal_gallery'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Filter Category (Plain Text Only)", 'caviar'),
		    		"param_name" => "class",
		    		'holder' => 'div',
		    		'description' => 'Multiple categories: Separate with comma only, no spaces. Spaces are fine in the category name. e.g: <code>Category 1,Category 2</code>'
		    	),
	            array(
	            	"type" => "attach_image",
	            	"heading" => esc_html__("Block Image", 'caviar'),
	            	"param_name" => "image"
	            ),
	            array(
	            	"type" => "attach_images",
	            	"heading" => esc_html__("Carousel Images", 'caviar'),
	            	"param_name" => "images"
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Image Hover Title", 'caviar'),
	            	"param_name" => "hover_title",
	            	'holder' => 'div'
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Content Title", 'caviar'),
	            	"param_name" => "title",
	            	'holder' => 'div'
	            ),
	            array(
	            	"type" => "textarea_html",
	            	"heading" => esc_html__("Caption Content", 'caviar'),
	            	"param_name" => "content",
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
add_action( 'vc_before_init', 'thedux_modal_gallery_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_caviar_modal_gallery extends WPBakeryShortCodesContainer {}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_caviar_modal_gallery_content extends WPBakeryShortCode {}
}