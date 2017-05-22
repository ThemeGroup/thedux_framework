<?php
/**
 *	Caviar Widget: Product Sorting List
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class THEDUX_WC_Widget_Product_Sorting extends WC_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        $this->widget_cssclass    	= 'thedux__widget thedux__widget-product-sorting';
        $this->widget_description	= __( 'Display a product sorting list.', 'thedux_framework' );
        $this->widget_id          	= 'thedux_woocommerce_widget_product_sorting';
        $this->widget_name        	= __( 'THEDUX: WooCommerce Product Sorting', 'thedux_framework' );
        $this->settings           	= array(
            'title'  => array(
                'type'  => 'text',
                'std'   => __( 'Sort By', 'thedux_framework' ),
                'label'	=> __( 'Title', 'thedux_framework' )
            )
        );

        parent::__construct();
    }

    /**
     * Widget function
     *
     * @see WP_Widget
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    public function widget( $args, $instance ) {
        global $wp_query;

        extract( $args );

        $title = ( ! empty( $instance['title'] ) ) ? $before_title . $instance['title'] . $after_title : '';

        $output = '';

        if ( 1 != $wp_query->found_posts || woocommerce_products_will_display() ) {
            $output .= '<ul id="caviar-product-sorting" class="caviar-product-sorting">';

            $orderby = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
            $orderby == ( $orderby ===  'title' ) ? 'menu_order' : $orderby;

            $catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
                'menu_order'	=> __( 'Default', 'woocommerce' ),
                'popularity' 	=> __( 'Popularity', 'woocommerce' ),
                'rating'     	=> __( 'Average rating', 'woocommerce' ),
                'date'       	=> __( 'Newness', 'woocommerce' ),
                'price'      	=> __( 'Price: Low to High', 'woocommerce' ),
                'price-desc'	=> __( 'Price: High to Low', 'woocommerce' )
            ) );

            if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
                unset( $catalog_orderby_options['rating'] );
            }


            /* Build entire current page URL (including query strings) */
            global $wp;
            $link = home_url( $wp->request ); // Base page URL

            $qs_count = count( $_GET );

            // Any query strings to add?
            if ( $qs_count > 0 ) {
                $i = 0;
                $link .= '?';

                // Build query string
                foreach ( $_GET as $key => $value ) {
                    $i++;
                    $link .= $key . '=' . $value;
                    if ( $i != $qs_count ) {
                        $link .= '&';
                    }
                }
            }


            foreach ( $catalog_orderby_options as $id => $name ) {
                if ( $orderby == $id ) {
                    $output .= '<li class="active">' . esc_attr( $name ) . '</li>';
                } else {
                    // Add 'orderby' URL query string
                    $link = add_query_arg( 'orderby', $id, $link );
                    $output .= '<li><a href="' . esc_url( $link ) . '">' . esc_attr( $name ) . '</a></li>';
                }
            }

            $output .= '</ul>';
        }

        echo $before_widget . $title . $output . $after_widget;
    }

}
