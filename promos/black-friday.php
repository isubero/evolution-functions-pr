<?php
/**
 * Promo: Promo Black Friday 2022
 * Fecha: Hasta el 30 de noviembre de 2022
 * Descripción: Con la compra de cualquier combo: 2 ebooks de regalo, 
 * libro físico de Andrea Zambrana, 30% de descuento en programas de Andrea Zambrana
 * y 15% de descuento en todos los combos de Evolution Advance
 */

/**
 * Add promo product to cart
 */ 
add_action('woocommerce_cart_updated', 'black_friday_promo', 40);

function black_friday_promo() {
    
    if ( did_action('woocommerce_cart_updated') > 10 ) {
        return;
    }

    // Black friday product
    $bf_product_id = wp_get_environment_type() == 'local' ? 2857 : 4438;
    $bf_cart_id = WC()->cart->generate_cart_id($bf_product_id);
    $bf_cart_item_key = WC()->cart->find_product_in_cart($bf_cart_id);

    if ( cart_contains_category(18) ) {
        // If promo product is already in cart, update quantity
        if ( $bf_cart_item_key ) {
            $cart_item = WC()->cart->get_cart_item( $bf_cart_item_key );

            if ( $cart_item['quantity'] > 1 ) {
                WC()->cart->set_quantity( $bf_cart_item_key, 1 );
            }
        } else {
            WC()->cart->add_to_cart( $bf_product_id, 1 );
        }
    } else {
        if ( $bf_cart_item_key ) {
            WC()->cart->remove_cart_item( $bf_cart_item_key );
        }
    }
}

/**
 * Programmatically add 15% discount to all products in "stacks" category
 */
add_action( 'woocommerce_product_get_price', 'black_friday_simple_product_discount', 20, 2 );

function black_friday_simple_product_discount( $price, $product ) {
    if ( has_term( 'stacks', 'product_cat', $product->get_id() ) ) {
        $price = $price * 0.85;
    }
    return $price;
}

add_action( 'woocommerce_product_variation_get_price', 'black_friday_variation_product_discount', 20, 2 );

function black_friday_variation_product_discount( $price, $product ) {
    if ( has_term( 'stacks', 'product_cat', $product->get_parent_id() ) ) {
        $price = $price * 0.85;
    }
    return $price;
}