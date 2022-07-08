<?php
/**
 * Promo: Promo Florencia Botta Julio 2022
 * Fecha:
 * Descripción: 10% OFF en combos + vitamina c
 */

/**
 * Add promo product to cart
 */ 
add_action('woocommerce_cart_updated', 'flor_cart_updated', 50);

function flor_cart_updated() {
    
    if ( did_action('woocommerce_cart_updated') > 10 ) {
        return;
    }

    // Vitamina C
    $vitamin_prouct_id = wp_get_environment_type() == 'local' ? 2827 : 3643;
    $vitamin_cart_id = WC()->cart->generate_cart_id($vitamin_prouct_id);
    $vitamin_cart_item_key = WC()->cart->find_product_in_cart($vitamin_cart_id);

    if ( WC()->cart->has_discount( 'flor' ) && cart_contains_category(18) ) {
        // If promo product is already in cart, update quantity
        if ( $vitamin_cart_item_key ) {
            $cart_item = WC()->cart->get_cart_item( $vitamin_cart_item_key );

            if ( $cart_item['quantity'] > 1 ) {
                WC()->cart->set_quantity( $vitamin_cart_item_key, 1 );
            }
        } else {
            WC()->cart->add_to_cart( $vitamin_prouct_id, 1 );
        }
    } else {
        if ( $vitamin_cart_item_key ) {
            WC()->cart->remove_cart_item( $vitamin_cart_item_key );
        }
    }
}