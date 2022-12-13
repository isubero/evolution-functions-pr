<?php
/**
 * Promo: Chritmas 2022
 * Fecha: del 13 al 31 de diciembre de 2021
 * Descripción: 10% de descuento en todos los productos y regalos extras en compras superiores a $120
 */

 /**
  * Programmatically add 15% discount to all products in the store
  */
add_action( 'woocommerce_product_get_price', 'christmas_simple_product_discount', 20, 2 );

function christmas_simple_product_discount( $price, $product ) {
    $price = $price * 0.9;
    return $price;
}

add_action( 'woocommerce_product_variation_get_price', 'christmas_variation_product_discount', 20, 2 );

function christmas_variation_product_discount( $price, $product ) {
    $price = $price * 0.9;
    return $price;
}

/**
 * If cart total is greater than $120, add a free ebook to cart
 */
add_action('woocommerce_cart_updated', 'christmas_promo', 40);

function christmas_promo() {
    if ( did_action('woocommerce_cart_updated') > 20 ) {
        return;
    }

    // Christmas product
    $xmas_product_id = wp_get_environment_type() == 'local' ? 2868 : 4505;
    $xmas_cart_id = WC()->cart->generate_cart_id($xmas_product_id);
    $xmas_cart_item_key = WC()->cart->find_product_in_cart($xmas_cart_id);

    if ( WC()->cart->get_cart_contents_total() >= 120 ) {
        // If promo product is already in cart, update quantity
        if ( $xmas_cart_item_key ) {
            $cart_item = WC()->cart->get_cart_item( $xmas_cart_item_key );

            if ( $cart_item['quantity'] > 1 ) {
                WC()->cart->set_quantity( $xmas_cart_item_key, 1 );
            }
        } else {
            WC()->cart->add_to_cart( $xmas_product_id, 1 );
        }
    } else {
        if ( $xmas_cart_item_key ) {
            WC()->cart->remove_cart_item( $xmas_cart_item_key );
        }
    }

    // Check if Vitamin C is in stock
    $vitamin_c_product_id = wp_get_environment_type() == 'local' ? 2866 : 4503;
    $vitamin_c = wc_get_product( $vitamin_c_product_id );

    if ( ! $vitamin_c->is_in_stock() ) {
        return;
    }

    // If Vitamin C is in stock, add it to cart
    $vitamin_c_cart_id = WC()->cart->generate_cart_id($vitamin_c_product_id);
    $vitamin_c_cart_item_key = WC()->cart->find_product_in_cart($vitamin_c_cart_id);

    if ( WC()->cart->get_cart_contents_total() >= 120 ) {
        // If promo product is already in cart, update quantity

        if ( $vitamin_c_cart_item_key ) {
            $cart_item = WC()->cart->get_cart_item( $vitamin_c_cart_item_key );

            if ( $cart_item['quantity'] > 1 ) {
                WC()->cart->set_quantity( $vitamin_c_cart_item_key, 1 );
            }
        } else {
            WC()->cart->add_to_cart( $vitamin_c_product_id, 1 );
        }
    } else {
        if ( $xmas_cart_item_key ) {
            WC()->cart->remove_cart_item( $vitamin_c_cart_item_key );
        }
    }
}