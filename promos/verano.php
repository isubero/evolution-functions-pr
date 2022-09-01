<?php
/**
 * Promo: Promo verano 2022
 * Fecha:
 * Descripción: 30% OFF en todos los productos + 2 ebook gratis
 */

/**
 * Add promo product to cart
 */ 
add_action('woocommerce_cart_updated', 'verano_promo', 40);

function verano_promo() {
    
    if ( did_action('woocommerce_cart_updated') > 10 ) {
        return;
    }

    // Ebook 30 días de ejercicios
    $ebook_1_product_id = 4061;
    $ebook_1_cart_id = WC()->cart->generate_cart_id($ebook_1_product_id);
    $ebook_1_cart_item_key = WC()->cart->find_product_in_cart($ebook_1_cart_id);

    if ( WC()->cart->has_discount( 'veranoplus' ) ) {
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

    if ( WC()->cart->has_discount( 'verano' ) ) {
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