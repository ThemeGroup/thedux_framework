<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
class THEDUX_WC_Widget_Price_Filter extends WC_Widget {
    /**
     * Constructor
     */
    public function __construct() {
        $this->widget_cssclass    = 'thedux__widget thedux__widget-product-price-filter';
        $this->widget_description = __( 'Shows a price filter list in a widget which lets you narrow down the list of shown products when viewing product categories.', 'woocommerce' );
        $this->widget_id          = 'thedux_woocommerce_price_filter';
        $this->widget_name        = __( 'THEDUX: WooCommerce Price Filter', 'thedux_framework_admin' );
        $this->settings           = array(
            'title' => array(
                'type'  => 'text',
                'std'   => __( 'Filter by price', 'woocommerce' ),
                'label' => __( 'Title', 'woocommerce' )
            ),
            'price_range_size' => array(
                'type'  => 'number',
                'step'  => 1,
                'min'   => 1,
                'max'   => '',
                'std'   => 50,
                'label' => __( 'Price range size', 'thedux_framework_admin' )
            ),
            'max_price_ranges' => array(
                'type'  => 'number',
                'step'  => 1,
                'min'   => 1,
                'max'   => '',
                'std'   => 10,
                'label' => __( 'Max price ranges', 'thedux_framework_admin' )
            ),
            'hide_empty_ranges' => array(
                'type'  => 'checkbox',
                'std'   => 1,
                'label' => __( 'Hide empty price ranges', 'thedux_framework_admin' )
            )
        );

        parent::__construct();
    }
    /**
     * widget function.
     *
     * @see WP_Widget
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        global $wp, $wp_the_query,$_chosen_attributes;
        if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
            return;
        }

        if ( ! $wp_the_query->post_count ) {
            return;
        }
        $title  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

        $min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
        $max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';


        if ( get_option( 'permalink_structure' ) == '' ) {
            $link = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
        } else {
            $link = preg_replace( '%\/page/[0-9]+%', '', home_url( $wp->request ) );
        }
        if ( get_search_query() ) {
            $link = add_query_arg( 's', get_search_query(), $link );
        }

        if ( ! empty( $_GET['post_type'] ) ) {
            $link = add_query_arg( 'post_type', esc_attr( $_GET['post_type'] ), $link );
        }

        if ( ! empty ( $_GET['product_cat'] ) ) {
            $link = add_query_arg( 'product_cat', esc_attr( $_GET['product_cat'] ), $link );
        }

        if ( ! empty( $_GET['product_tag'] ) ) {
            $link = add_query_arg( 'product_tag', esc_attr( $_GET['product_tag'] ), $link );
        }

        if ( ! empty( $_GET['orderby'] ) ) {
            $link = add_query_arg( 'orderby', esc_attr( $_GET['orderby'] ), $link );
        }
        if ( $_chosen_attributes ) {
            foreach ( $_chosen_attributes as $attribute => $data ) {
                $taxonomy_filter = 'filter_' . str_replace( 'pa_', '', $attribute );
                $link = add_query_arg( esc_attr( $taxonomy_filter ), esc_attr( implode( ',', $data['terms'] ) ), $link );
                if ( 'or' == $data['query_type'] ) {
                    $link = add_query_arg( esc_attr( str_replace( 'pa_', 'query_type_', $attribute ) ), 'or', $link );
                }
            }
        }

        // Find min and max price in current result set
        $prices = $this->get_filtered_price();
        $min    = floor( $prices->min_price );
        $max    = ceil( $prices->max_price );

        if ( $min === $max ) {
            return;
        }
        $this->widget_start( $args, $instance );

        $count = 0;
        $range_size = intval( $instance['price_range_size'] );
        $max_ranges = ( intval( $instance['max_price_ranges'] ) - 1 );

        $output = '<ul class="nm-price-filter">';


        if ( strlen( $min_price ) > 0 ) {
            $output .= '<li><a class="ajax-link" href="' . esc_url( $link ) . '">' . esc_html__( 'All', 'thedux_framework' ) . '</a></li>';
        } else {
            $output .= '<li class="active">' . esc_html__( 'All', 'thedux_framework' ) . '</li>';
        }
        for ( $range_min = 0; $range_min < ( $max + $range_size ); $range_min += $range_size ) {
            $range_max = $range_min + $range_size;

            // Hide empty price ranges?
            if ( intval( $instance['hide_empty_ranges'] ) ) {
                // Are there products in this price range?
                if ( $min > $range_max || ( $max + $range_size ) < $range_max ) {
                    continue;
                }
            }

            $count++;

            $min_price_output = wc_price( $range_min );

            if ( $count == $max_ranges ) {
                $price_output = $min_price_output . '+';

                if ( $range_min != $min_price ) {
                    $url = add_query_arg( array( 'min_price' => $range_min, 'max_price' => $max ), $link );
                    $output .= '<li><a class="ajax-link" href="' . esc_url( $url ) . '">' . $price_output . '</a></li>';
                } else {
                    $output .= '<li class="current">' . $price_output . '</li>';
                }

                break; // Max price ranges limit reached, break loop
            } else {
                $price_output = $min_price_output . ' - ' . wc_price( $range_min + $range_size );

                if ( $range_min != $min_price || $range_max != $max_price ) {
                    $url = add_query_arg( array( 'min_price' => $range_min, 'max_price' => $range_max ), $link );
                    $output .= '<li><a class="ajax-link" href="' . esc_url( $url ) . '">' . $price_output . '</a></li>';
                } else {
                    $output .= '<li class="active">' . $price_output . '</li>';
                }
            }
        }
        $output . '</ul>';

        echo $output;

        $this->widget_end( $args );
    }
    /**
     * Get filtered min price for current products.
     * @return int
     */
    protected function get_filtered_price() {
        global $wpdb, $wp_the_query;

        $args       = $wp_the_query->query_vars;
        $tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
        $meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

        if ( ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
            $tax_query[] = array(
                'taxonomy' => $args['taxonomy'],
                'terms'    => array( $args['term'] ),
                'field'    => 'slug',
            );
        }

        foreach ( $meta_query + $tax_query as $key => $query ) {
            if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
                unset( $meta_query[ $key ] );
            }
        }

        $meta_query = new WP_Meta_Query( $meta_query );
        $tax_query  = new WP_Tax_Query( $tax_query );

        $meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
        $tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

        $sql  = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
        $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
        $sql .= " 	WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
					AND {$wpdb->posts}.post_status = 'publish'
					AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
					AND price_meta.meta_value > '' ";
        $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

        if ( $search = WC_Query::get_main_search_query_sql() ) {
            $sql .= ' AND ' . $search;
        }

        return $wpdb->get_row( $sql );
    }
}