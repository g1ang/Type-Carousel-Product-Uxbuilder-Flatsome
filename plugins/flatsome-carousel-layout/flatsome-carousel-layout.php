<?php
/**
 * Plugin Name: Flatsome UX Builder Product Carousel Layout
 * Description: Adds a carousel layout option to the Flatsome UX Builder product element.
 * Version: 1.0.0
 * Author: AI Assistant
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register the "Carousel" layout option in the UX Builder product element.
 */
add_filter( 'ux_builder_element_product', function ( $element ) {
    if ( empty( $element['options']['layout']['options'] ) ) {
        return $element;
    }

    $element['options']['layout']['options']['carousel'] = [
        'value' => 'carousel',
        'label' => __( 'Carousel', 'flatsome-carousel-layout' ),
        'help'  => __( 'Display the selected products inside a responsive carousel.', 'flatsome-carousel-layout' ),
    ];

    return $element;
} );

/**
 * Provide a default value for the new layout option.
 */
add_filter( 'ux_builder_element_product_defaults', function ( $defaults ) {
    if ( empty( $defaults['layout'] ) ) {
        $defaults['layout'] = 'carousel';
    }

    return $defaults;
} );

/**
 * Render the carousel layout on the front end by wrapping the products in a slider container.
 */
add_filter( 'shortcode_atts_ux_products', function ( $atts ) {
    if ( isset( $atts['layout'] ) && 'carousel' === $atts['layout'] ) {
        $atts['type']      = 'slider';
        $atts['slider_nav'] = isset( $atts['slider_nav'] ) ? $atts['slider_nav'] : 'true';
        $atts['slider_bullets'] = isset( $atts['slider_bullets'] ) ? $atts['slider_bullets'] : 'true';
    }

    return $atts;
} );

/**
 * Append a CSS class so the layout can be targeted if further styling is needed.
 */
add_filter( 'flatsome_products_shortcode_wrapper_classes', function ( $classes, $atts ) {
    if ( isset( $atts['layout'] ) && 'carousel' === $atts['layout'] ) {
        $classes[] = 'uxb-product-carousel';
    }

    return $classes;
}, 10, 2 );
