<?php
/**
 * Include main ATH Movil Payment Gateway Class
 */

add_action( 'plugins_loaded', 'init_ath_movil_payment_class' );

function init_ath_movil_payment_class() {
    require_once 'class-ath-movil-payment-gateway.php';
}

/**
 * Register ATH Movil Payment Gateway Class on WooCommerce
 */
add_filter( 'woocommerce_payment_gateways', 'add_ath_movil_payment_method' );

function add_ath_movil_payment_method( $methods ) {
    $methods[] = 'WC_Gateway_ATH_Movil_Payment_Gateway';
    return $methods;
}