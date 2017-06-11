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
			<div class="masonry">
				<div class="masonry-filter-container text-center">
					<div class="masonry-filter-holder">
						<div class="masonry__filters" data-filter-all-text="'. $text .'"></div>
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
add_shortcode( 'lugos_modal_gallery', 'thedux_modal_gallery_shortcode' );

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
			<div class="hover-element__box hover-element hover-element-1">
				<div class="hover-element__thumb">
					<div class="image-bg-wrap__">
					'. wp_get_attachment_image( $image, 'large' ) .'
					</div>
				</div>
				<div class="hover-element__overlay" data-hover-opacity="0"></div>
				<div class="hover-element__description">
				<div class="collection-thumb__title text-center" data-v-pos="" data-h-pos="">
					<h5>'. $hover_title .'</h5>
					<div class="modal-instance">
						<div class="btn-round modal-trigger">
							<span class="icon-File-HorizontalText icon lugos--icon color--primary"></span>
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
							<span class="icon-Video-5 icon lugos--icon color--primary"></span>
						</div>
						<div class="modal-container">
							<div class="modal-content bg--dark" data-width="70%" data-height="50%">
								'. wp_oembed_get($embed, array('height' => '500')) .'
							</div><!--end of modal-content-->
						</div><!--end of modal-container-->
					</div><!--end of modal instance-->
		';
	}
	
	$output .= '</div>
				</div>
			</div><!--end hover element-->
		</div><!--end item-->
	';

	return $output;
}
add_shortcode( 'lugos_modal_gallery_content', 'thedux_modal_gallery_content_shortcode' );

// Parent Element
function thedux_modal_gallery_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'                    => esc_html__( 'Modal Gallery' , 'lugos' ),
		    'base'                    => 'lugos_modal_gallery',
		    'description'             => esc_html__( 'Create a filter gallery of modal content', 'lugos' ),
		    'as_parent'               => array('only' => 'lugos_modal_gallery_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
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
add_action( 'vc_before_init', 'thedux_modal_gallery_shortcode_vc' );

// Nested Element
function thedux_modal_gallery_content_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
		    'name'            => esc_html__('Modal Gallery Content', 'lugos'),
		    'base'            => 'lugos_modal_gallery_content',
		    'description'     => esc_html__( 'Toggle Content Element', 'lugos' ),
		    "category" => esc_html__('Lugos Theme', 'lugos'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'lugos_modal_gallery'), // Use only|except attributes to limit parent (separate multiple values with comma)
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
	            array(
	            	"type" => "attach_images",
	            	"heading" => esc_html__("Carousel Images", 'lugos'),
	            	"param_name" => "images"
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Image Hover Title", 'lugos'),
	            	"param_name" => "hover_title",
	            	'holder' => 'div'
	            ),
	            array(
	            	"type" => "textfield",
	            	"heading" => esc_html__("Content Title", 'lugos'),
	            	"param_name" => "title",
	            	'holder' => 'div'
	            ),
	            array(
	            	"type" => "textarea_html",
	            	"heading" => esc_html__("Caption Content", 'lugos'),
	            	"param_name" => "content",
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
add_action( 'vc_before_init', 'thedux_modal_gallery_content_shortcode_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_lugos_modal_gallery extends WPBakeryShortCodesContainer {}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_lugos_modal_gallery_content extends WPBakeryShortCode {}
}