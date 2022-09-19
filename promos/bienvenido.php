<?php
/**
 * Promo: Promo Bienvenido Newsletter
 * Fecha:
 * Descripción: 20% OFF + Ebook
 */

/**
 * Add promo product to cart
 */ 
add_action('woocommerce_cart_updated', 'welcome_cart_updated', 50);

function welcome_cart_updated() {
    
    if ( did_action('woocommerce_cart_updated') > 10 ) {
        return;
    }

    // Ebook 5 consejos para mejorar tu estilo de vida saludable
    $ebook_product_id = wp_get_environment_type() == 'local' ? 2827 : 4013;
    $ebook_cart_id = WC()->cart->generate_cart_id($ebook_product_id);
    $ebook_cart_item_key = WC()->cart->find_product_in_cart($ebook_cart_id);

    if ( WC()->cart->has_discount( 'bienvenido20' ) ) {
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

    // Ebook 30 días de ejercicios
    $ebook_1_product_id = 4061;
    $ebook_1_cart_id = WC()->cart->generate_cart_id($ebook_1_product_id);
    $ebook_1_cart_item_key = WC()->cart->find_product_in_cart($ebook_1_cart_id);

    if ( WC()->cart->has_discount( 'bienvenido20' ) ) {
        // If promo product is already in cart, update quantity
        if ( $ebook_1_cart_item_key ) {
            $cart_item = WC()->cart->get_cart_item( $ebook_1_cart_item_key );

            if ( $cart_item['quantity'] > 1 ) {
                WC()->cart->set_quantity( $ebook_1_cart_item_key, 1 );
            }
        } else {
            WC()->cart->add_to_cart( $ebook_1_product_id, 1 );
        }
    } else {
        if ( $ebook_1_cart_item_key ) {
            WC()->cart->remove_cart_item( $ebook_1_cart_item_key );
        }
    }

    // Ebook Lista de mercado saludble
    $ebook_2_product_id = 4066;
    $ebook_2_cart_id = WC()->cart->generate_cart_id($ebook_2_product_id);
    $ebook_2_cart_item_key = WC()->cart->find_product_in_cart($ebook_2_cart_id);

    if ( WC()->cart->has_discount( 'bienvenido20' ) ) {
        // If promo product is already in cart, update quantity
        if ( $ebook_2_cart_item_key ) {
            $cart_item = WC()->cart->get_cart_item( $ebook_2_cart_item_key );

            if ( $cart_item['quantity'] > 1 ) {
                WC()->cart->set_quantity( $ebook_2_cart_item_key, 1 );
            }
        } else {
            WC()->cart->add_to_cart( $ebook_2_product_id, 1 );
        }
    } else {
        if ( $ebook_2_cart_item_key ) {
            WC()->cart->remove_cart_item( $ebook_2_cart_item_key );
        }
    }
}