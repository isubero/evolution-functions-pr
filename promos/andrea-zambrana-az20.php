<?php
/**
 * Promo: Promo Andrea Zambrana
 * Fecha:
 * Descripción: 20% de descuento con el cupón AZ20 más ebook de regalo
 */

/**
 * Add promo product to cart
 */ 
add_action('woocommerce_cart_updated', 'andrea_zambrana_permanent_promo', 40);

function andrea_zambrana_permanent_promo() {
    
    if ( did_action('woocommerce_cart_updated') > 10 ) {
        return;
    }

    // Ebook
    $ebook_product_id = wp_get_environment_type() == 'local' ? 2827 : 3338;
    $ebook_cart_id = WC()->cart->generate_cart_id($ebook_product_id);
    $ebook_cart_item_key = WC()->cart->find_product_in_cart($ebook_cart_id);

    if ( WC()->cart->has_discount( 'az20' ) ) {
        // If promo product is already in cart, update quantity
        if ( $ebook_cart_item_key ) {
            $cart_item = WC()->cart->get_cart_item( $ebook_cart_item_key );

            if ( $cart_item['quantity'] > 1 ) {
                WC()->cart->set_quantity( $ebook_cart_item_key, 1 );
            }
        } else {
            WC()->cart->add_to_cart( $ebook_product_id, 1 );
        }
    } else {
        if ( $ebook_cart_item_key ) {
            WC()->cart->remove_cart_item( $ebook_cart_item_key );
        }
    }
}